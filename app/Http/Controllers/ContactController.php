<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        /* ── Honeypot ── */
        if (!empty($request->input('website'))) {
            return response()->json([
                'success' => true,
                'message' => '¡Mensaje enviado! Nos pondremos en contacto pronto.',
            ]);
        }

        /* ── Validación con mensajes en español ── */
        $validated = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'required|email|max:150',
            'phone'   => ['nullable', 'string', 'max:17', 'regex:/^[\d\s\-\+\(\)]+$/'],
            'subject' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ], [
            'name.required'    => 'El nombre es obligatorio.',
            'name.max'         => 'El nombre no puede superar 150 caracteres.',
            'email.required'   => 'El correo electrónico es obligatorio.',
            'email.email'      => 'Ingresa un correo electrónico válido.',
            'email.max'        => 'El correo no puede superar 150 caracteres.',
            'phone.max'        => 'El teléfono no puede superar 17 caracteres.',
            'phone.regex'      => 'El teléfono solo puede contener números, espacios, guiones y paréntesis.',
            'subject.required' => 'El asunto es obligatorio.',
            'subject.max'      => 'El asunto no puede superar 150 caracteres.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max'      => 'El mensaje no puede superar 2000 caracteres.',
        ]);

        try {
            DB::table('formulario_contacto')->insert([
                'nombre_completo'   => $validated['name'],
                'correo'            => $validated['email'],
                'numero_telefonico' => !empty($validated['phone']) ? $validated['phone'] : null,
                'asunto'            => $validated['subject'],
                'mensaje'           => $validated['message'],
            ]);

            Log::info('Formulario de contacto recibido', [
                'correo' => $validated['email'],
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Mensaje enviado! Nos pondremos en contacto pronto.',
            ]);

        } catch (\Exception $e) {
            Log::error('Error al guardar formulario de contacto', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al enviar. Intenta de nuevo.',
            ], 500);
        }
    }
}