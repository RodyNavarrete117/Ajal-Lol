<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditPageActivitiesController extends Controller
{
    private const ID_PAGINA = 4;

    /* ══════════════════════════════════════════════════════
       VISTA PRINCIPAL — carga las 3 pestañas
    ══════════════════════════════════════════════════════ */
    public function index()
    {
        // Año activo para el filtro (el más reciente visible)
        $anoActivo = request('ano', optional(
            DB::table('actividad_anos')
                ->where('id_pagina', self::ID_PAGINA)
                ->where('visible', 1)
                ->orderBy('ano', 'desc')
                ->first()
        )->ano ?? date('Y'));

        // Encabezado — llega a pagina via actividad_anos
        $encabezado = DB::table('actividades_encabezado')
            ->join('actividad_anos', 'actividades_encabezado.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->select('actividades_encabezado.*')
            ->first();

        // Años registrados con conteo de actividades
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

        // Actividades del año activo
        $actividades = DB::table('actividades')
            ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->where('actividad_anos.ano', $anoActivo)
            ->orderBy('actividades.orden_actividad')
            ->select('actividades.*')
            ->get();

        return view('admin.pages.activities_edit', compact(
            'encabezado',
            'anos',
            'actividades',
            'anoActivo'
        ));
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA ENCABEZADO — guardar título, subtítulo y año
    ══════════════════════════════════════════════════════ */
    public function updateEncabezado(Request $request)
    {
        $validated = $request->validate([
            'titulo_actividad'    => 'required|string|max:150',
            'subtitulo_actividad' => 'nullable|string|max:255',
            'ano_visible'         => 'nullable|integer|min:2000|max:2099',
        ]);

        // Obtener el id_ano del año visible para relacionar el encabezado
        $anoRecord = null;
        if (!empty($validated['ano_visible'])) {
            $anoRecord = DB::table('actividad_anos')
                ->where('id_pagina', self::ID_PAGINA)
                ->where('ano', $validated['ano_visible'])
                ->first();
        }

        // Buscar encabezado existente via join
        $encabezadoExistente = DB::table('actividades_encabezado')
            ->join('actividad_anos', 'actividades_encabezado.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->select('actividades_encabezado.id_encabezado')
            ->first();

        $data = [
            'titulo_actividad'    => $validated['titulo_actividad'],
            'subtitulo_actividad' => $validated['subtitulo_actividad'] ?? null,
            'ano_visible'         => $validated['ano_visible'] ?? null,
            'id_ano'              => $anoRecord?->id_ano ?? null,
            'updated_at'          => now(),
        ];

        if ($encabezadoExistente) {
            DB::table('actividades_encabezado')
                ->where('id_encabezado', $encabezadoExistente->id_encabezado)
                ->update($data);
        } else {
            DB::table('actividades_encabezado')
                ->insert(array_merge($data, ['created_at' => now()]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Encabezado guardado correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       PESTAÑA ACTIVIDADES — obtener tarjetas por año (AJAX)
    ══════════════════════════════════════════════════════ */
    public function getByAno(int $ano)
    {
        $actividades = DB::table('actividades')
            ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
            ->where('actividad_anos.id_pagina', self::ID_PAGINA)
            ->where('actividad_anos.ano', $ano)
            ->orderBy('actividades.orden_actividad')
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
            'actividades.*.icono'       => 'required|string|max:50',
            'actividades.*.descripcion' => 'nullable|string',
            'actividades.*.visible'     => 'nullable|boolean',
        ]);

        // Obtener o crear el año
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

        // Eliminar actividades anteriores del año y reinsertar
        DB::table('actividades')
            ->where('id_ano', $idAno)
            ->delete();

        foreach ($request->actividades as $orden => $act) {
            DB::table('actividades')->insert([
                'id_ano'           => $idAno,
                'titulo_actividad' => $act['titulo'],
                'icono_actividad'  => $act['icono'],
                'texto_actividad'  => $act['descripcion'] ?? null,
                'orden_actividad'  => $orden + 1,
                'visible'          => $act['visible'] ?? 1,
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
            ->update([
                'visible'    => $nuevoEstado,
                'updated_at' => now(),
            ]);

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

        // Eliminar actividades del año explícitamente
        DB::table('actividades')
            ->where('id_ano', $id)
            ->delete();

        // Eliminar encabezado asociado si existe
        DB::table('actividades_encabezado')
            ->where('id_ano', $id)
            ->delete();

        // Eliminar el año
        DB::table('actividad_anos')
            ->where('id_ano', $id)
            ->delete();

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