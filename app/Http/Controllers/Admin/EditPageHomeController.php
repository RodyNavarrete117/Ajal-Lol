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
        // ── 1. Estadísticas manuales ──
        $statsData = DB::table('inicio_estadisticas')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->orderBy('ano', 'desc')
            ->get()
            ->keyBy('ano')
            ->map(fn($row) => [
                'ben'  => (int) $row->beneficiarios,
                'proy' => (int) $row->proyectos,
                'hrs'  => (int) $row->horas_apoyo,
                'vol'  => (int) $row->voluntarios,
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

        // Unir ambas sumando por año
        $beneficiariosPorAno = [];
        $anosConBen = array_unique(array_merge(
            array_keys($reporteBenPorAno),
            array_keys($asistenciaBenPorAno)
        ));
        foreach ($anosConBen as $ano) {
            $beneficiariosPorAno[$ano] =
                ($reporteBenPorAno[$ano]   ?? 0) +
                ($asistenciaBenPorAno[$ano] ?? 0);
        }

        // ── 3. Proyectos/Informes por año ──
        $proyectosPorAno = DB::table('informe')
            ->selectRaw('YEAR(fecha) as ano, COUNT(id_informe) as total')
            ->groupByRaw('YEAR(fecha)')
            ->pluck('total', 'ano')
            ->toArray();

        // ── 4. Estado del toggle bd_include por año ──
        $bdIncludesPorAno = DB::table('inicio_estadisticas')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->pluck('bd_include', 'ano')
            ->toArray();

        // ── 5. Unir todos los años con datos en BD ──
        $anosEnBd = array_unique(array_merge(
            array_keys($beneficiariosPorAno),
            array_keys($proyectosPorAno)
        ));
        rsort($anosEnBd);

        $bdStats = [];
        foreach ($anosEnBd as $ano) {
            $bdStats[$ano] = [
                'beneficiarios' => (int) ($beneficiariosPorAno[$ano] ?? 0),
                'proyectos'     => (int) ($proyectosPorAno[$ano]     ?? 0),
                'include'       => (bool) ($bdIncludesPorAno[$ano]   ?? false),
            ];
        }

        return view('admin.pages.home_edit', compact('statsData', 'bdStats'));
    }

    /* ─────────────────────────────────────────
       POST /admin/pages/home/update
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
                    $bdInclude = !empty($values['_bdInclude']) ? 1 : 0;

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

                // Eliminar años borrados desde el front
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