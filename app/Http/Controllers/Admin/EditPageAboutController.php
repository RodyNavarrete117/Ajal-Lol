<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EditPageAboutController extends Controller
{
    private const ID_PAGINA = 2;

    /* ══════════════════════════════════════════════════════
       VISTA PRINCIPAL
    ══════════════════════════════════════════════════════ */
    public function index()
    {
        // Obtener registro raíz de nosotros
        $nosotros = DB::table('nosotros')
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        $idNosotros = $nosotros?->id_nosotros;

        // Encabezado
        $encabezado = $idNosotros
            ? DB::table('nosotros_encabezado')
                ->where('id_nosotros', $idNosotros)
                ->first()
            : null;

        // Historia
        $historia = $idNosotros
            ? DB::table('nosotros_historia')
                ->where('id_nosotros', $idNosotros)
                ->first()
            : null;

        // General
        $general = $idNosotros
            ? DB::table('nosotros_general')
                ->where('id_nosotros', $idNosotros)
                ->first()
            : null;

        // Identidad
        $identidad = $idNosotros
            ? DB::table('nosotros_identidad')
                ->where('id_nosotros', $idNosotros)
                ->first()
            : null;

        // Items de identidad
        $identidadItems = $identidad
            ? DB::table('nosotros_identidad_items')
                ->where('id_identidad', $identidad->id_identidad)
                ->orderBy('orden')
                ->get()
                ->keyBy('tipo')
            : collect();

        return view('admin.pages.about_edit', compact(
            'encabezado',
            'historia',
            'general',
            'identidad',
            'identidadItems'
        ));
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR ENCABEZADO
    ══════════════════════════════════════════════════════ */
    public function updateEncabezado(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:150',
            'subtitulo' => 'nullable|string|max:255',
        ]);

        $idNosotros = $this->getOrCreateNosotros();

        $existe = DB::table('nosotros_encabezado')
            ->where('id_nosotros', $idNosotros)
            ->exists();

        $data = [
            'titulo'     => $request->titulo,
            'subtitulo'  => $request->subtitulo,
            'updated_at' => now(),
        ];

        if ($existe) {
            DB::table('nosotros_encabezado')
                ->where('id_nosotros', $idNosotros)
                ->update($data);
        } else {
            DB::table('nosotros_encabezado')
                ->insert(array_merge($data, [
                    'id_nosotros' => $idNosotros,
                    'created_at'  => now(),
                ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Encabezado guardado correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR HISTORIA
    ══════════════════════════════════════════════════════ */
    public function updateHistoria(Request $request)
    {
        $request->validate([
            'imagen_historia'  => 'nullable|image|mimes:png,jpg,jpeg,webp|max:5120',
            'badge_texto'      => 'nullable|string|max:150',
            'etiqueta_superior'=> 'nullable|string|max:100',
            'titulo_bloque'    => 'required|string|max:150',
            'texto_destacado'  => 'nullable|string',
            'texto_descriptivo'=> 'nullable|string',
        ]);

        $idNosotros = $this->getOrCreateNosotros();

        $historiaExistente = DB::table('nosotros_historia')
            ->where('id_nosotros', $idNosotros)
            ->first();

        $data = [
            'badge_texto'       => $request->badge_texto,
            'etiqueta_superior' => $request->etiqueta_superior,
            'titulo_bloque'     => $request->titulo_bloque,
            'texto_destacado'   => $request->texto_destacado,
            'texto_descriptivo' => $request->texto_descriptivo,
            'updated_at'        => now(),
        ];

        // Manejar imagen
        if ($request->hasFile('imagen_historia')) {
            // Eliminar imagen anterior
            if ($historiaExistente?->imagen) {
                Storage::disk('public')->delete($historiaExistente->imagen);
            }
            $data['imagen'] = $request->file('imagen_historia')
                ->store('nosotros', 'public');
        }

        // Si se pidió quitar imagen
        if ($request->input('quitar_imagen') == '1' && $historiaExistente?->imagen) {
            Storage::disk('public')->delete($historiaExistente->imagen);
            $data['imagen'] = null;
        }

        if ($historiaExistente) {
            DB::table('nosotros_historia')
                ->where('id_nosotros', $idNosotros)
                ->update($data);
        } else {
            DB::table('nosotros_historia')
                ->insert(array_merge($data, [
                    'id_nosotros' => $idNosotros,
                    'created_at'  => now(),
                ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Historia guardada correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR GENERAL
    ══════════════════════════════════════════════════════ */
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'ano_fundacion' => 'required|integer|min:1900|max:2099',
            'beneficiarios' => 'nullable|string|max:150',
            'ubicacion'     => 'nullable|string|max:255',
        ]);

        $idNosotros = $this->getOrCreateNosotros();

        $existe = DB::table('nosotros_general')
            ->where('id_nosotros', $idNosotros)
            ->exists();

        $data = [
            'ano_fundacion' => $request->ano_fundacion,
            'beneficiarios' => $request->beneficiarios,
            'ubicacion'     => $request->ubicacion,
            'updated_at'    => now(),
        ];

        if ($existe) {
            DB::table('nosotros_general')
                ->where('id_nosotros', $idNosotros)
                ->update($data);
        } else {
            DB::table('nosotros_general')
                ->insert(array_merge($data, [
                    'id_nosotros' => $idNosotros,
                    'created_at'  => now(),
                ]));
        }

        return response()->json([
            'success' => true,
            'message' => 'Información general guardada correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR IDENTIDAD
    ══════════════════════════════════════════════════════ */
    public function updateIdentidad(Request $request)
    {
        $request->validate([
            'identidad_titulo'    => 'nullable|string|max:150',
            'identidad_subtitulo' => 'nullable|string|max:255',
            'titulo_mision'       => 'nullable|string|max:100',
            'mision'              => 'nullable|string',
            'titulo_vision'       => 'nullable|string|max:100',
            'vision'              => 'nullable|string',
            'titulo_objetivo'     => 'nullable|string|max:100',
            'objetivo_general'    => 'nullable|string',
            'titulo_valores'      => 'nullable|string|max:100',
            'valores'             => 'nullable|string',
        ]);

        $idNosotros = $this->getOrCreateNosotros();

        // Guardar encabezado de identidad
        $identidadExistente = DB::table('nosotros_identidad')
            ->where('id_nosotros', $idNosotros)
            ->first();

        $dataIdentidad = [
            'titulo'     => $request->identidad_titulo,
            'subtitulo'  => $request->identidad_subtitulo,
            'updated_at' => now(),
        ];

        if ($identidadExistente) {
            DB::table('nosotros_identidad')
                ->where('id_nosotros', $idNosotros)
                ->update($dataIdentidad);
            $idIdentidad = $identidadExistente->id_identidad;
        } else {
            $idIdentidad = DB::table('nosotros_identidad')
                ->insertGetId(array_merge($dataIdentidad, [
                    'id_nosotros' => $idNosotros,
                    'created_at'  => now(),
                ]));
        }

        // Guardar los 4 items
        $items = [
            'mision'   => ['titulo' => $request->titulo_mision,   'contenido' => $request->mision,            'orden' => 1],
            'vision'   => ['titulo' => $request->titulo_vision,   'contenido' => $request->vision,            'orden' => 2],
            'objetivo' => ['titulo' => $request->titulo_objetivo, 'contenido' => $request->objetivo_general,  'orden' => 3],
            'valores'  => ['titulo' => $request->titulo_valores,  'contenido' => $request->valores,           'orden' => 4],
        ];

        foreach ($items as $tipo => $item) {
            $existeItem = DB::table('nosotros_identidad_items')
                ->where('id_identidad', $idIdentidad)
                ->where('tipo', $tipo)
                ->exists();

            $dataItem = [
                'titulo'     => $item['titulo'],
                'contenido'  => $item['contenido'],
                'orden'      => $item['orden'],
                'updated_at' => now(),
            ];

            if ($existeItem) {
                DB::table('nosotros_identidad_items')
                    ->where('id_identidad', $idIdentidad)
                    ->where('tipo', $tipo)
                    ->update($dataItem);
            } else {
                DB::table('nosotros_identidad_items')
                    ->insert(array_merge($dataItem, [
                        'id_identidad' => $idIdentidad,
                        'tipo'         => $tipo,
                        'created_at'   => now(),
                    ]));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Identidad guardada correctamente.',
        ]);
    }

    /* ══════════════════════════════════════════════════════
       HELPER — Obtener o crear registro raíz nosotros
    ══════════════════════════════════════════════════════ */
    private function getOrCreateNosotros(): int
    {
        $nosotros = DB::table('nosotros')
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        if ($nosotros) {
            return $nosotros->id_nosotros;
        }

        return DB::table('nosotros')->insertGetId([
            'id_pagina'  => self::ID_PAGINA,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}