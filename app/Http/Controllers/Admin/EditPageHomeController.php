<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditPageHomeController extends Controller
{
    const PAGINA_INICIO = 1;

    /* ─────────────────────────────────────────
       GET  /admin/pages/home/edit
    ───────────────────────────────────────── */
    public function index()
    {
        // ── Hero ──
        $hero = DB::table('inicio')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->first();

        // ── Videos ──
        $videos = $hero
            ? DB::table('inicio_videos')
                ->where('id_inicio', $hero->id_inicio)
                ->orderBy('orden')
                ->get()
            : collect();

        // ── Estadísticas manuales ──
        $statsData = DB::table('inicio_estadisticas')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->orderBy('ano', 'desc')
            ->get()
            ->keyBy('ano')
            ->map(fn($row) => [
                'ben'        => (int)  $row->beneficiarios,
                'proy'       => (int)  $row->proyectos,
                'hrs'        => (int)  $row->horas_apoyo,
                'vol'        => (int)  $row->voluntarios,
                '_bdInclude' => (bool) $row->bd_include,
            ])
            ->toArray();

        $reporteBenPorAno = DB::table('reportebeneficiarios as rb')
            ->join('informe as i', 'rb.id_informe', '=', 'i.id_informe')
            ->selectRaw('YEAR(i.fecha) as ano, COUNT(rb.id_reportebeneficiario) as total')
            ->groupByRaw('YEAR(i.fecha)')
            ->pluck('total', 'ano')
            ->toArray();

        $asistenciaBenPorAno = DB::table('asistenciabeneficiarios as ab')
            ->join('informe as i', 'ab.id_informe', '=', 'i.id_informe')
            ->selectRaw('YEAR(i.fecha) as ano, COUNT(ab.id_asistenciabeneficiario) as total')
            ->groupByRaw('YEAR(i.fecha)')
            ->pluck('total', 'ano')
            ->toArray();

        $beneficiariosPorAno = [];
        $anosConBen = array_unique(array_merge(
            array_keys($reporteBenPorAno),
            array_keys($asistenciaBenPorAno)
        ));
        foreach ($anosConBen as $ano) {
            $beneficiariosPorAno[$ano] =
                ($reporteBenPorAno[$ano]  ?? 0) +
                ($asistenciaBenPorAno[$ano] ?? 0);
        }

        $proyectosPorAno = DB::table('informe')
            ->selectRaw('YEAR(fecha) as ano, COUNT(id_informe) as total')
            ->groupByRaw('YEAR(fecha)')
            ->pluck('total', 'ano')
            ->toArray();

        $bdIncludesPorAno = DB::table('inicio_estadisticas')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->pluck('bd_include', 'ano')
            ->toArray();

        $anosEnBd = array_unique(array_merge(
            array_keys($beneficiariosPorAno),
            array_keys($proyectosPorAno)
        ));
        rsort($anosEnBd);

        $bdStats = [];
        foreach ($anosEnBd as $ano) {
            $bdStats[$ano] = [
                'beneficiarios' => (int)  ($beneficiariosPorAno[$ano] ?? 0),
                'proyectos'     => (int)  ($proyectosPorAno[$ano]     ?? 0),
                'include'       => (bool) ($bdIncludesPorAno[$ano]    ?? false),
            ];
        }

        return view('admin.pages.home_edit', compact(
            'hero',
            'videos',
            'statsData',
            'bdStats'
        ));
    }

    /* ─────────────────────────────────────────
       POST /admin/pages/home/hero
    ───────────────────────────────────────── */
    public function updateHero(Request $request)
    {
        $request->validate([
            'titulo_principal' => 'required|string|max:150',
            'descripcion'      => 'required|string',
            'eyebrow'          => 'nullable|string|max:150',
            'titulo_em'        => 'nullable|string|max:150',
        ]);

        $data = [
            'eyebrow'          => $request->eyebrow,
            'titulo_principal' => $request->titulo_principal,
            'titulo_em'        => $request->titulo_em,
            'descripcion'      => $request->descripcion,
            'updated_at'       => now(),
        ];

        $existe = DB::table('inicio')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->exists();

        if ($existe) {
            DB::table('inicio')
                ->where('id_pagina', self::PAGINA_INICIO)
                ->update($data);
        } else {
            DB::table('inicio')->insert(array_merge($data, [
                'id_pagina'  => self::PAGINA_INICIO,
                'created_at' => now(),
            ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero guardado correctamente.',
        ]);
    }

    /* ─────────────────────────────────────────
       POST /admin/pages/home/videos
    ───────────────────────────────────────── */
    public function updateVideos(Request $request)
    {
        $request->validate([
            'videos'            => 'required|array|min:1|max:10',
            'videos.*.titulo'   => 'nullable|string|max:150',
            'videos.*.url'      => 'required|string|max:255',
        ]);

        // Obtener o crear registro raíz en inicio
        $inicio = DB::table('inicio')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->first();

        if (!$inicio) {
            $idInicio = DB::table('inicio')->insertGetId([
                'id_pagina'  => self::PAGINA_INICIO,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $idInicio = $inicio->id_inicio;
        }

        // Eliminar videos anteriores y reinsertar
        DB::table('inicio_videos')->where('id_inicio', $idInicio)->delete();

        foreach ($request->videos as $orden => $video) {
            DB::table('inicio_videos')->insert([
                'id_inicio'   => $idInicio,
                'titulo'      => $video['titulo'] ?? null,
                'youtube_url' => $video['url'],
                'orden'       => $orden + 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Videos guardados correctamente.',
        ]);
    }

    /* ─────────────────────────────────────────
       POST /admin/pages/home/update (estadísticas)
    ───────────────────────────────────────── */
    public function update(Request $request)
    {
        $rawStats = $request->input('stats_data');

        if ($rawStats) {
            $stats = json_decode($rawStats, true);

            if (is_array($stats)) {
                $anosEnviados = [];

                foreach ($stats as $ano => $values) {
                    $ano            = (int) $ano;
                    $anosEnviados[] = $ano;
                    $bdInclude      = !empty($values['_bdInclude']) ? 1 : 0;

                    DB::table('inicio_estadisticas')->updateOrInsert(
                        [
                            'id_pagina' => self::PAGINA_INICIO,
                            'ano'       => $ano,
                        ],
                        [
                            'beneficiarios' => (int) ($values['ben']  ?? 0),
                            'proyectos'     => (int) ($values['proy'] ?? 0),
                            'horas_apoyo'   => (int) ($values['hrs']  ?? 0),
                            'voluntarios'   => (int) ($values['vol']  ?? 0),
                            'bd_include'    => $bdInclude,
                            'updated_at'    => now(),
                        ]
                    );
                }

                DB::table('inicio_estadisticas')
                    ->where('id_pagina', self::PAGINA_INICIO)
                    ->whereNotIn('ano', $anosEnviados)
                    ->delete();
            }
        }

        if ($request->hasHeader('X-Requested-With') || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()
            ->route('admin.pages.home.edit')
            ->with('success', 'Cambios guardados correctamente.');
    }
}