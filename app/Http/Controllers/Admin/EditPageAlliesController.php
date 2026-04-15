<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditPageAlliesController extends Controller
{
    private const ID_PAGINA = 3;

    /* ────────────────────────────────────────────
     |  GET  admin/pages/allies/edit
     |
     |  Estructura BD:
     |    aliados          → 1 registro (titulo_seccion, descripcion)
     |    aliados_imagenes → N registros de logos (img_path)
     * ─────────────────────────────────────────── */
    public function index()
    {
        // Config: el único registro de aliados para esta página
        $config = DB::table('aliados')
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        // Logos: todos los registros de aliados_imagenes
        $logos = collect();
        if ($config) {
            $logos = DB::table('aliados_imagenes')
                ->where('id_aliados', $config->id_aliados)
                ->orderBy('id_imagen', 'asc')
                ->get();
        }

        return view('admin.pages.allies_edit', [
            'config'    => $config,
            'logos'     => $logos,
            'id_pagina' => self::ID_PAGINA,
        ]);
    }

    /* ────────────────────────────────────────────
     |  PUT  admin/pages/allies/update
     |
     |  Flujo:
     |  1. UPDATE titulo_seccion y descripcion en aliados
     |  2. Por cada slot:
     |     - id > 0 + nueva imagen  → UPDATE + reemplazar archivo
     |     - id > 0 + eliminar=1   → borrar imagen del disco
     |     - id = 0 + nueva imagen → INSERT en aliados_imagenes
     |     - id > 0 sin cambios    → mantener
     |  3. DELETE imagenes que ya no vienen
     * ─────────────────────────────────────────── */
    public function update(Request $request)
    {
        $request->validate([
            'titulo_aliados' => 'required|string|max:150',
        ]);

        $total    = (int) $request->input('total_logos', 0);
        $idConfig = (int) $request->input('id_config', 0);
        $idsImagenes = [];

        DB::beginTransaction();

        try {
            /* ── 1. Upsert config ── */
            if ($idConfig > 0) {
                DB::table('aliados')
                    ->where('id_aliados', $idConfig)
                    ->where('id_pagina', self::ID_PAGINA)
                    ->update([
                        'titulo_seccion' => $request->input('titulo_aliados'),
                        'descripcion'    => $request->input('descripcion_aliados'),
                    ]);
            } else {
                $idConfig = DB::table('aliados')->insertGetId([
                    'id_pagina'      => self::ID_PAGINA,
                    'titulo_seccion' => $request->input('titulo_aliados'),
                    'descripcion'    => $request->input('descripcion_aliados'),
                ]);
            }

            /* ── 2. Procesar slots de logos ── */
            for ($n = 1; $n <= $total; $n++) {
                $idImagen    = (int) $request->input("id_logo_{$n}", 0);
                $eliminar    = (int) $request->input("eliminar_logo_{$n}", 0);
                $tieneArchivo = $request->hasFile("logo_{$n}") &&
                                $request->file("logo_{$n}")->isValid();

                if ($idImagen > 0) {
                    $registro = DB::table('aliados_imagenes')
                        ->where('id_imagen', $idImagen)
                        ->where('id_aliados', $idConfig)
                        ->first();

                    if (!$registro) continue;

                    if ($tieneArchivo) {
                        // Reemplazar imagen
                        if ($registro->img_path) {
                            Storage::disk('public')->delete($registro->img_path);
                        }
                        $path = $request->file("logo_{$n}")->store('aliados', 'public');
                        DB::table('aliados_imagenes')
                            ->where('id_imagen', $idImagen)
                            ->update(['img_path' => $path]);

                    } elseif ($eliminar === 1) {
                        // Solo borrar imagen, mantener registro
                        if ($registro->img_path) {
                            Storage::disk('public')->delete($registro->img_path);
                        }
                        DB::table('aliados_imagenes')
                            ->where('id_imagen', $idImagen)
                            ->update(['img_path' => null]);
                    }

                    $idsImagenes[] = $idImagen;

                } elseif ($tieneArchivo) {
                    // INSERT nuevo logo
                    $path    = $request->file("logo_{$n}")->store('aliados', 'public');
                    $nuevoId = DB::table('aliados_imagenes')->insertGetId([
                        'id_aliados' => $idConfig,
                        'img_path'   => $path,
                    ]);
                    $idsImagenes[] = $nuevoId;
                }
            }

            /* ── 3. Eliminar imagenes que ya no vienen ── */
            $aEliminar = DB::table('aliados_imagenes')
                ->where('id_aliados', $idConfig)
                ->when(!empty($idsImagenes), fn($q) => $q->whereNotIn('id_imagen', $idsImagenes))
                ->get();

            foreach ($aEliminar as $img) {
                if ($img->img_path) {
                    Storage::disk('public')->delete($img->img_path);
                }
            }

            if ($aEliminar->isNotEmpty()) {
                DB::table('aliados_imagenes')
                    ->where('id_aliados', $idConfig)
                    ->when(!empty($idsImagenes), fn($q) => $q->whereNotIn('id_imagen', $idsImagenes))
                    ->delete();
            }

            DB::commit();

            return redirect()
                ->route('admin.pages.allies.edit')
                ->with('success', 'Aliados actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.pages.allies.edit')
                ->with('error', 'Error al guardar: ' . $e->getMessage())
                ->withInput();
        }
    }
}