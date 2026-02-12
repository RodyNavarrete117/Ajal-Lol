<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Mostrar la vista de ajustes
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        return view('admin.settings');
    }

    /**
     * Cambiar la contraseña del usuario
     */
    public function changePassword(Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!session()->has('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Sesión expirada. Por favor inicia sesión nuevamente.'
            ], 401);
        }

        // Validar datos
        $request->validate([
            'contraseña_actual' => 'required|min:6',
            'contraseña_nueva' => 'required|min:6',
            'contraseña_confirmacion' => 'required|same:contraseña_nueva'
        ], [
            'contraseña_actual.required' => 'Debe ingresar su contraseña actual',
            'contraseña_actual.min' => 'La contraseña debe tener al menos 6 caracteres',
            'contraseña_nueva.required' => 'Debe ingresar una nueva contraseña',
            'contraseña_nueva.min' => 'La nueva contraseña debe tener al menos 6 caracteres',
            'contraseña_confirmacion.required' => 'Debe confirmar su nueva contraseña',
            'contraseña_confirmacion.same' => 'Las contraseñas no coinciden'
        ]);

        try {
            $userId = session('user_id');

            // Obtener el usuario de la base de datos
            $usuario = DB::table('usuario')
                ->where('id_usuario', $userId)
                ->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Verificar que la contraseña actual sea correcta
            $contraseñaActualHash = hash('sha256', $request->contraseña_actual);
            
            if ($contraseñaActualHash !== $usuario->contraseña_usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'La contraseña actual es incorrecta'
                ], 400);
            }

            // Actualizar la contraseña
            $nuevaContraseñaHash = hash('sha256', $request->contraseña_nueva);

            DB::table('usuario')
                ->where('id_usuario', $userId)
                ->update([
                    'contraseña_usuario' => $nuevaContraseñaHash
                ]);

            // Si no quiere mantener la sesión, cerrarla después del cambio
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
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la contraseña: ' . $e->getMessage()
            ], 500);
        }
    }
}