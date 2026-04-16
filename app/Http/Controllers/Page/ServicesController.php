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
        $actividades = DB::table('actividades')
            ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->where('actividad_anos.ano', $ano)
            ->where('actividad_anos.visible', 1)
            ->where('actividades.visible', 1)
            ->orderBy('actividades.orden_actividad')
            ->select('actividades.*')
            ->get();

        return response()->json([
            'success'     => true,
            'actividades' => $actividades,
            'ano'         => $ano,
        ]);
    }
}