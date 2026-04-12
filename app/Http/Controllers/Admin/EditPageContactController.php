<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EditPageContactController extends Controller
{
    /**
     * Muestra el formulario de edición con los datos actuales de BD.
     * Tabla: contacto, id_pagina = 8
     */
    public function index()
    {
        $contacto = DB::table('contacto')
            ->where('id_pagina', 8)
            ->first();

        return view('admin.pages.contact_edit', compact('contacto'));
    }

    /**
     * Guarda los cambios en la tabla contacto.
     * Maneja los 3 panels del blade: info, redes y mapa.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'correo'      => 'required|email|max:100',
            'telefono'    => 'required|string|max:50',
            'direccion'   => 'nullable|string|max:255',
            'horario'     => 'nullable|string|max:100',
            'mapa_embed'  => 'nullable|string',
            'facebook'    => 'nullable|url|max:255',
            'instagram'   => 'nullable|url|max:255',
            'linkedin'    => 'nullable|url|max:255',
        ], [
            'correo.required'   => 'El correo electrónico es obligatorio.',
            'correo.email'      => 'Ingresa un correo electrónico válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'facebook.url'      => 'El enlace de Facebook debe ser una URL válida.',
            'instagram.url'     => 'El enlace de Instagram debe ser una URL válida.',
            'linkedin.url'      => 'El enlace de LinkedIn debe ser una URL válida.',
        ]);

        try {
            $existe = DB::table('contacto')
                ->where('id_pagina', 8)
                ->exists();

            $datos = [
                'email_contacto'     => $validated['correo'],
                'telefono_contacto'  => $validated['telefono'],
                'direccion_contacto' => $validated['direccion'] ?? null,
                'horario_contacto'   => $validated['horario']   ?? null,
                'mapa_embed'         => $validated['mapa_embed'] ?? null,
                'facebook_url'       => $validated['facebook']  ?? null,
                'instagram_url'      => $validated['instagram'] ?? null,
                'linkedin_url'       => $validated['linkedin']  ?? null,
            ];

            if ($existe) {
                DB::table('contacto')
                    ->where('id_pagina', 8)
                    ->update($datos);
            } else {
                DB::table('contacto')->insert(
                    array_merge($datos, ['id_pagina' => 8, 'activo' => 1])
                );
            }

            Log::info('Contacto actualizado', ['user_id' => session('user_id')]);

            return response()->json([
                'success' => true,
                'message' => 'Cambios guardados correctamente.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al guardar contacto', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar. Intenta de nuevo.',
            ], 500);
        }
    }
}