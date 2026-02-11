<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 1. MOSTRAR LISTA DE USUARIOS
    public function index()
    {
        $usuarios = DB::table('usuario')
            ->leftJoin('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                'rol_usuario.cargo_usuario'
            )
            ->get();

        // DEBUG: Agregar esto temporalmente para ver qué datos vienen
        // dd($usuarios); // Descomenta esta línea para ver los datos

        // Calcular estadísticas (case-insensitive)
        $totalUsuarios = $usuarios->count();
        $totalAdmins = $usuarios->filter(function($user) {
            return $user->cargo_usuario && strtolower(trim($user->cargo_usuario)) === 'administrador';
        })->count();
        
        $totalEditores = $usuarios->filter(function($user) {
            return $user->cargo_usuario && strtolower(trim($user->cargo_usuario)) === 'editor';
        })->count();

        return view('admin.users', compact(
            'usuarios',
            'totalUsuarios',
            'totalAdmins',
            'totalEditores'
        ));
    }

    // 2. CREAR NUEVO USUARIO
    public function store(Request $request)
    {
        try {
            // Validar datos
            $request->validate([
                'nombre_usuario' => 'required|string|max:150',
                'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
                'contraseña_usuario' => 'required|min:6',
                'cargo_usuario' => 'required|in:administrador,editor'
            ], [
                'nombre_usuario.required' => 'El nombre es obligatorio',
                'correo_usuario.required' => 'El correo es obligatorio',
                'correo_usuario.email' => 'El correo debe ser válido',
                'correo_usuario.unique' => 'Este correo ya está registrado',
                'contraseña_usuario.required' => 'La contraseña es obligatoria',
                'contraseña_usuario.min' => 'La contraseña debe tener mínimo 6 caracteres',
                'cargo_usuario.required' => 'Debe seleccionar un rol'
            ]);

            // Insertar en tabla usuario
            $userId = DB::table('usuario')->insertGetId([
                'nombre_usuario' => $request->nombre_usuario,
                'correo_usuario' => $request->correo_usuario,
                'contraseña_usuario' => hash('sha256', $request->contraseña_usuario)
            ]);

            // Insertar en tabla rol_usuario
            DB::table('rol_usuario')->insert([
                'id_usuario' => $userId,
                'cargo_usuario' => $request->cargo_usuario
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    // 3. OBTENER DATOS DE UN USUARIO (para editar)
    public function show($id)
    {
        try {
            $usuario = DB::table('usuario')
                ->leftJoin('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
                ->select(
                    'usuario.id_usuario',
                    'usuario.nombre_usuario',
                    'usuario.correo_usuario',
                    'rol_usuario.cargo_usuario'
                )
                ->where('usuario.id_usuario', $id)
                ->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $usuario
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    // 4. ACTUALIZAR USUARIO
    public function update(Request $request, $id)
    {
        try {
            // Validar datos
            $request->validate([
                'nombre_usuario' => 'required|string|max:150',
                'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $id . ',id_usuario',
                'cargo_usuario' => 'required|in:administrador,editor',
                'contraseña_usuario' => 'nullable|min:6'
            ], [
                'nombre_usuario.required' => 'El nombre es obligatorio',
                'correo_usuario.required' => 'El correo es obligatorio',
                'correo_usuario.email' => 'El correo debe ser válido',
                'correo_usuario.unique' => 'Este correo ya está registrado',
                'contraseña_usuario.min' => 'La contraseña debe tener mínimo 6 caracteres',
                'cargo_usuario.required' => 'Debe seleccionar un rol'
            ]);

            // Verificar que el usuario existe
            $usuarioExiste = DB::table('usuario')->where('id_usuario', $id)->exists();
            if (!$usuarioExiste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Actualizar tabla usuario
            $updateData = [
                'nombre_usuario' => $request->nombre_usuario,
                'correo_usuario' => $request->correo_usuario
            ];

            // Si hay nueva contraseña, agregarla
            if ($request->filled('contraseña_usuario')) {
                $updateData['contraseña_usuario'] = hash('sha256', $request->contraseña_usuario);
            }

            DB::table('usuario')
                ->where('id_usuario', $id)
                ->update($updateData);

            // Actualizar o crear rol
            $rolExiste = DB::table('rol_usuario')->where('id_usuario', $id)->exists();
            
            if ($rolExiste) {
                DB::table('rol_usuario')
                    ->where('id_usuario', $id)
                    ->update([
                        'cargo_usuario' => $request->cargo_usuario
                    ]);
            } else {
                DB::table('rol_usuario')->insert([
                    'id_usuario' => $id,
                    'cargo_usuario' => $request->cargo_usuario
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    // 5. ELIMINAR USUARIO
    public function destroy($id)
    {
        try {
            // Verificar que el usuario existe
            $usuarioExiste = DB::table('usuario')->where('id_usuario', $id)->exists();
            if (!$usuarioExiste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            // Eliminar rol primero (por la llave foránea)
            DB::table('rol_usuario')->where('id_usuario', $id)->delete();
            
            // Luego eliminar usuario
            DB::table('usuario')->where('id_usuario', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}