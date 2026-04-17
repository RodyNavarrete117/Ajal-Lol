<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    private const ID_PAGINA = 4;

    /* ── Actividades por año — ruta pública AJAX ── */
    public function actividadesByAno(int $ano)
    {
        // Verificar que el año existe y es visible
        $anoRecord = DB::table('actividad_anos')
            ->where('id_pagina', self::ID_PAGINA)
            ->where('ano', $ano)
            ->where('visible', 1)
            ->first();

        if (!$anoRecord) {
            return response()->json([
                'success'     => false,
                'actividades' => [],
                'ano'         => $ano,
            ], 404);
        }

        $actividades = DB::table('actividades')
            ->where('id_ano', $anoRecord->id_ano)
            ->where('visible', 1)
            ->orderBy('orden_actividad')
            ->select('actividades.*')
            ->get();

        return response()->json([
            'success'     => true,
            'actividades' => $actividades,
            'ano'         => $ano,
        ]);
    }
}