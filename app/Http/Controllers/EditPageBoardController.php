<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditPageBoardController extends Controller
{
    /**
     * Muestra el formulario con los datos actuales de BD.
     * Tabla: directiva, id_pagina = 6
     */
    public function index()
    {
        $miembros = DB::table('directiva')
            ->where('id_pagina', 6)
            ->orderBy('orden_directiva', 'asc')
            ->get();

        $config = $miembros->first();

        return view('admin.pages.board_edit', compact('miembros', 'config'));
    }

    /**
     * Guarda los cambios: título, subtítulo, miembros y fotos.
     */
    public function update(Request $request)
    {
        $request->validate([
            'titulo_seccion' => 'required|string|max:100',
            'subtitulo'      => 'nullable|string|max:100',
        ], [
            'titulo_seccion.required' => 'El título de la sección es obligatorio.',
        ]);

        try {
            // Determinar cuántos miembros vienen en el request
            $totalMiembros = 0;
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^miembro_nombre_(\d+)$/', $key, $m)) {
                    $totalMiembros = max($totalMiembros, (int)$m[1]);
                }
            }

            // Eliminar todos los miembros actuales y reinsertar
            DB::table('directiva')->where('id_pagina', 6)->delete();

            for ($i = 1; $i <= $totalMiembros; $i++) {
                $nombre = trim($request->input("miembro_nombre_{$i}", ''));
                $cargo  = trim($request->input("miembro_cargo_{$i}", ''));

                // Saltar filas completamente vacías
                if ($nombre === '' && $cargo === '') continue;

                // Manejar foto
                $fotoNombre = null;

                // Mantener foto existente si no se sube una nueva
                if ($request->filled("foto_existente_{$i}")) {
                    $fotoNombre = $request->input("foto_existente_{$i}");
                }

                // Si viene archivo nuevo lo sobreescribe
                if ($request->hasFile("foto_{$i}") && $request->file("foto_{$i}")->isValid()) {
                    $archivo    = $request->file("foto_{$i}");
                    $extension  = $archivo->getClientOriginalExtension();
                    $fotoNombre = 'directiva_' . $i . '_' . time() . '.' . $extension;
                    $archivo->move(public_path('assets/img/team'), $fotoNombre);
                }

                DB::table('directiva')->insert([
                    'id_pagina'           => 6,
                    'titulo_directiva'    => $i === 1 ? $request->input('titulo_seccion') : null,
                    'subtitulo_directiva' => $i === 1 ? $request->input('subtitulo')      : null,
                    'nombre_directiva'    => $nombre,
                    'cargo_directiva'     => $cargo,
                    'foto_directiva'      => $fotoNombre,
                    'orden_directiva'     => $i,
                ]);
            }

            Log::info('Directiva actualizada', ['user_id' => session('user_id')]);

            return response()->json([
                'success' => true,
                'message' => 'Directiva guardada correctamente.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al guardar directiva', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar. Intenta de nuevo.',
            ], 500);
        }
    }
}