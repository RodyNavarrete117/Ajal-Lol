<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditPageBoardController extends Controller
{
    /**
     * Mostrar datos actuales
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
     * Guardar cambios
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
            // 🔢 Detectar número de miembros
            $totalMiembros = 0;
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^miembro_nombre_(\d+)$/', $key, $m)) {
                    $totalMiembros = max($totalMiembros, (int)$m[1]);
                }
            }

            // 🔥 Obtener imágenes actuales ANTES de borrar
            $imagenesActuales = DB::table('directiva')
                ->where('id_pagina', 6)
                ->pluck('foto_directiva')
                ->toArray();

            // 🗑️ Borrar registros actuales
            DB::table('directiva')->where('id_pagina', 6)->delete();

            $imagenesUsadas = [];

            for ($i = 1; $i <= $totalMiembros; $i++) {

                $nombre = trim($request->input("miembro_nombre_{$i}", ''));
                $cargo  = trim($request->input("miembro_cargo_{$i}", ''));

                // 🚫 Saltar vacíos
                if ($nombre === '' && $cargo === '') continue;

                $fotoNombre = null;

                // Foto existente
                if ($request->filled("foto_existente_{$i}")) {
                    $fotoNombre = $request->input("foto_existente_{$i}");
                    $imagenesUsadas[] = $fotoNombre;
                }

                // Nueva imagen
                if ($request->hasFile("foto_{$i}") && $request->file("foto_{$i}")->isValid()) {

                    // eliminar anterior si existe
                    if (!empty($fotoNombre)) {
                        Storage::disk('public')->delete($fotoNombre);
                    }

                    // guardar nueva
                    $path = $request->file("foto_{$i}")
                        ->store('directiva', 'public');

                    $fotoNombre = $path;
                    $imagenesUsadas[] = $fotoNombre;
                }

                // Insertar en BD
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

            // 🧹 Eliminar imágenes que ya no se usan
            foreach ($imagenesActuales as $img) {
                if (!in_array($img, $imagenesUsadas) && !empty($img)) {
                    Storage::disk('public')->delete($img);
                }
            }

            Log::info('Directiva actualizada', ['user_id' => session('user_id')]);

            return response()->json([
                'success' => true,
                'message' => 'Directiva guardada correctamente.',
            ]);

        } catch (\Exception $e) {

            Log::error('Error al guardar directiva', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar. Intenta de nuevo.',
            ], 500);
        }
    }
}