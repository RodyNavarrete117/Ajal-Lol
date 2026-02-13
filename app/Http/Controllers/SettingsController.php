<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    /**
     * Mostrar la vista de ajustes con datos del usuario
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        $userId = session('user_id');

        // Obtener datos del usuario
        $usuario = DB::table('usuario')
            ->leftJoin('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                'rol_usuario.cargo_usuario'
            )
            ->where('usuario.id_usuario', $userId)
            ->first();

        if (!$usuario) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Usuario no encontrado');
        }

        return view('admin.settings', compact('usuario'));
    }

    /*Cambiar contraseña del usuario*/
    public function changePassword(Request $request)
    {
        // Verificar autenticación
        if (!session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesión expirada. Por favor inicia sesión nuevamente.'
            ], 401);
        }

        // Validar datos
        $request->validate([
            'contraseña_actual' => 'required|min:6',
            'contraseña_nueva' => 'required|min:6|different:contraseña_actual',
            'contraseña_confirmacion' => 'required|same:contraseña_nueva'
        ], [
            'contraseña_actual.required' => 'Debe ingresar su contraseña actual',
            'contraseña_actual.min' => 'La contraseña debe tener al menos 6 caracteres',
            'contraseña_nueva.required' => 'Debe ingresar una nueva contraseña',
            'contraseña_nueva.min' => 'La nueva contraseña debe tener al menos 6 caracteres',
            'contraseña_nueva.different' => 'La nueva contraseña debe ser diferente a la actual',
            'contraseña_confirmacion.required' => 'Debe confirmar su nueva contraseña',
            'contraseña_confirmacion.same' => 'Las contraseñas no coinciden'
        ]);

        try {
            $userId = session('user_id');

            // Obtener usuario
            $usuario = DB::table('usuario')
                ->where('id_usuario', $userId)
                ->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Verificar contraseña actual
            $contraseñaActualHash = hash('sha256', $request->contraseña_actual);
            
            if ($contraseñaActualHash !== $usuario->contraseña_usuario) {
                Log::warning('Intento fallido de cambio de contraseña', [
                    'user_id' => $userId,
                    'ip' => $request->ip(),
                    'timestamp' => now()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 422);
            }

            // Actualizar contraseña
            $nuevaContraseñaHash = hash('sha256', $request->contraseña_nueva);

            DB::table('usuario')
                ->where('id_usuario', $userId)
                ->update([
                    'contraseña_usuario' => $nuevaContraseñaHash
                ]);

            // Log exitoso
            Log::info('Contraseña cambiada exitosamente', [
                'user_id' => $userId,
                'user_email' => $usuario->correo_usuario,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            // Si no quiere mantener la sesión
            if (!$request->mantener_sesion) {
                Session::flush();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Contraseña actualizada exitosamente. Redirigiendo al login...',
                    'redirect' => route('login')
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar contraseña', [
                'user_id' => session('user_id'),
                'error' => $e->getMessage(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la contraseña. Por favor intente nuevamente.'
            ], 500);
        }
    }

    /* Actualizar información personal del usuario*/
    public function updateProfile(Request $request)
    {
        // Verificar autenticación
        if (!session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesión expirada. Por favor inicia sesión nuevamente.'
            ], 401);
        }

        $userId = session('user_id');

        // Validar datos
        $request->validate([
            'nombre_usuario' => 'required|string|max:150',
            'correo_usuario' => 'required|email|max:100|unique:usuario,correo_usuario,' . $userId . ',id_usuario'
        ], [
            'nombre_usuario.required' => 'El nombre es obligatorio',
            'nombre_usuario.max' => 'El nombre no puede exceder 150 caracteres',
            'correo_usuario.required' => 'El correo es obligatorio',
            'correo_usuario.email' => 'El correo debe ser válido',
            'correo_usuario.unique' => 'Este correo ya está registrado por otro usuario'
        ]);

        try {
            // Verificar que el usuario existe
            $usuarioExiste = DB::table('usuario')
                ->where('id_usuario', $userId)
                ->exists();

            if (!$usuarioExiste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Actualizar datos del usuario
            DB::table('usuario')
                ->where('id_usuario', $userId)
                ->update([
                    'nombre_usuario' => $request->nombre_usuario,
                    'correo_usuario' => $request->correo_usuario
                ]);

            // Actualizar datos en la sesión
            Session::put('user_name', $request->nombre_usuario);
            Session::put('user_email', $request->correo_usuario);

            // Log exitoso
            Log::info('Perfil actualizado', [
                'user_id' => $userId,
                'changes' => [
                    'nombre' => $request->nombre_usuario,
                    'correo' => $request->correo_usuario
                ],
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => [
                    'nombre_usuario' => $request->nombre_usuario,
                    'correo_usuario' => $request->correo_usuario
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error al actualizar perfil', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el perfil. Por favor intente nuevamente.'
            ], 500);
        }
    }
}