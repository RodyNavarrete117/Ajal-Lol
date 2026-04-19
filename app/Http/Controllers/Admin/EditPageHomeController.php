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
            ])
            ->toArray();

        // ── 2. Beneficiarios por año desde reportebeneficiarios + informe ──
        $beneficiariosPorAno = DB::table('reportebeneficiarios as rb')
            ->join('informe as i', 'rb.id_informe', '=', 'i.id_informe')
            ->selectRaw('YEAR(i.fecha) as ano, COUNT(rb.id_reportebeneficiario) as total')
            ->groupByRaw('YEAR(i.fecha)')
            ->pluck('total', 'ano')
            ->toArray();

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
                    $bdInclude      = $request->has("bd_include.{$ano}") ? 1 : 0;

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

        // Guardar bd_include para años que solo existen en BD (sin manuales)
        $bdIncludeAll = $request->input('bd_include', []);
        foreach ($bdIncludeAll as $ano => $val) {
            $ano = (int) $ano;
            DB::table('inicio_estadisticas')->updateOrInsert(
                [
                    'id_pagina' => self::PAGINA_INICIO,
                    'ano'       => $ano,
                ],
                [
                    'bd_include' => 1,
                    'updated_at' => now(),
                ]
            );
        }

        // Poner bd_include = 0 en años cuyo checkbox NO vino en el request
        $anosConToggle = array_map('intval', array_keys($bdIncludeAll));
        DB::table('inicio_estadisticas')
            ->where('id_pagina', self::PAGINA_INICIO)
            ->whereNotIn('ano', $anosConToggle)
            ->update(['bd_include' => 0, 'updated_at' => now()]);

        return redirect()
            ->route('admin.pages.home.edit')
            ->with('success', 'Cambios guardados correctamente.');
    }
}