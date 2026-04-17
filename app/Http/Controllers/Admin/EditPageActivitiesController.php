<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditPageActivitiesController extends Controller
{
    private const ID_PAGINA = 4;

    /* ══════════════════════════════════════════════════════
       VISTA PRINCIPAL
    ══════════════════════════════════════════════════════ */
    public function index()
    {
        $anoActivo = request('ano',
            DB::table('actividad_anos')
                ->where('id_pagina', self::ID_PAGINA)
                ->where('visible', 1)
                ->orderBy('ano', 'desc')
                ->value('ano') ?? date('Y')
        );

        $anos = DB::table('actividad_anos')
            ->where('id_pagina', self::ID_PAGINA)
            ->orderBy('ano', 'desc')
            ->get()
            ->map(function ($ano) {
                $ano->total_actividades = DB::table('actividades')
                    ->where('id_ano', $ano->id_ano)
                    ->count();
                return $ano;
            });

        $actividades = DB::table('actividades')
            ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->where('actividad_anos.ano', $anoActivo)
            ->orderBy('actividades.orden_actividad')
            ->select('actividades.*')
            ->get();

        return view('admin.pages.activities_edit', compact(
            'anos',
            'actividades',
            'anoActivo'
        ));
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA ACTIVIDADES — obtener tarjetas por año (AJAX)
    ══════════════════════════════════════════════════════ */
    public function getByAno(int $ano)
    {
        $anoRecord = DB::table('actividad_anos')
            ->where('id_pagina', self::ID_PAGINA)
            ->where('ano', $ano)
            ->first();

        if (!$anoRecord) {
            return response()->json([
                'success'     => false,
                'actividades' => [],
            ], 404);
        }

        $actividades = DB::table('actividades')
            ->where('id_ano', $anoRecord->id_ano)
            ->orderBy('orden_actividad')
            ->select('actividades.*')
            ->get();

        return response()->json([
            'success'     => true,
            'actividades' => $actividades,
        ]);
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA ACTIVIDADES — guardar tarjetas del año
    ══════════════════════════════════════════════════════ */
    public function updateActividades(Request $request)
    {
        $request->validate([
            'ano'                       => 'required|integer|min:2000|max:2099',
            'actividades'               => 'required|array|min:1',
            'actividades.*.titulo'      => 'required|string|max:150',
            'actividades.*.icono'       => 'required|string|max:100',
            'actividades.*.descripcion' => 'nullable|string',
        ]);

        $anoRecord = DB::table('actividad_anos')
            ->where('id_pagina', self::ID_PAGINA)
            ->where('ano', $request->ano)
            ->first();

        if (!$anoRecord) {
            $idAno = DB::table('actividad_anos')->insertGetId([
                'id_pagina'  => self::ID_PAGINA,
                'ano'        => $request->ano,
                'visible'    => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $idAno = $anoRecord->id_ano;
        }

        DB::table('actividades')->where('id_ano', $idAno)->delete();

        foreach ($request->actividades as $orden => $act) {
            DB::table('actividades')->insert([
                'id_ano'           => $idAno,
                'titulo_actividad' => $act['titulo'],
                'icono_actividad'  => $act['icono'],
                'texto_actividad'  => $act['descripcion'] ?? null,
                'orden_actividad'  => $orden + 1,
                'visible'          => 1,
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Actividades guardadas correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA AÑOS — toggle visible/oculto
    ══════════════════════════════════════════════════════ */
    public function toggleAno(int $id)
    {
        $ano = DB::table('actividad_anos')
            ->where('id_ano', $id)
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        if (!$ano) {
            return response()->json([
                'success' => false,
                'message' => 'Año no encontrado.',
            ], 404);
        }

        $nuevoEstado = $ano->visible ? 0 : 1;

        DB::table('actividad_anos')
            ->where('id_ano', $id)
            ->update(['visible' => $nuevoEstado, 'updated_at' => now()]);

        return response()->json([
            'success' => true,
            'visible' => $nuevoEstado,
            'message' => $nuevoEstado
                ? 'Año visible en la página pública.'
                : 'Año ocultado de la página pública.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA AÑOS — eliminar año y sus actividades
    ══════════════════════════════════════════════════════ */
    public function destroyAno(int $id)
    {
        $ano = DB::table('actividad_anos')
            ->where('id_ano', $id)
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        if (!$ano) {
            return response()->json([
                'success' => false,
                'message' => 'Año no encontrado.',
            ], 404);
        }

        // ON DELETE CASCADE lo maneja automáticamente
        // pero lo dejamos explícito por claridad
        DB::table('actividades')->where('id_ano', $id)->delete();
        DB::table('actividad_anos')->where('id_ano', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => "Año {$ano->ano} eliminado correctamente.",
        ]);
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA AÑOS — agregar nuevo año
    ══════════════════════════════════════════════════════ */
    public function storeAno(Request $request)
    {
        $request->validate([
            'ano' => 'required|integer|min:2000|max:2099',
        ]);

        $existe = DB::table('actividad_anos')
            ->where('id_pagina', self::ID_PAGINA)
            ->where('ano', $request->ano)
            ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => "El año {$request->ano} ya está registrado.",
            ], 422);
        }

        $id = DB::table('actividad_anos')->insertGetId([
            'id_pagina'  => self::ID_PAGINA,
            'ano'        => $request->ano,
            'visible'    => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'id_ano'  => $id,
            'ano'     => $request->ano,
            'message' => "Año {$request->ano} agregado correctamente.",
        ]);
    }
}