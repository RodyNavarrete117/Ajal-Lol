<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 1. MOSTRAR LISTA DE USUARIOS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $usuarios = DB::table('usuario')
            ->leftJoin('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                DB::raw('LOWER(rol_usuario.cargo_usuario) as cargo_usuario')
            )
            ->get();

        // Conteos seguros
        $totalUsuarios = $usuarios->count();
        $totalAdmins = $usuarios->where('cargo_usuario', 'administrador')->count();
        $totalEditores = $usuarios->where('cargo_usuario', 'editor')->count();

        return view('admin.users', compact(
            'usuarios',
            'totalUsuarios',
            'totalAdmins',
            'totalEditores'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | 2. CREAR NUEVO USUARIO
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:150',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario',
            'contraseña_usuario' => 'required|min:6',
            'cargo_usuario' => 'required|in:administrador,editor'
        ]);

        DB::beginTransaction();

        try {

            // Insertar usuario
            $userId = DB::table('usuario')->insertGetId([
                'nombre_usuario' => $request->nombre_usuario,
                'correo_usuario' => $request->correo_usuario,
                'contraseña_usuario' => Hash::make($request->contraseña_usuario)
            ]);

            // Insertar rol
            DB::table('rol_usuario')->insert([
                'id_usuario' => $userId,
                'cargo_usuario' => strtolower($request->cargo_usuario)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado exitosamente'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al crear el usuario'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 3. OBTENER USUARIO (EDITAR)
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $usuario = DB::table('usuario')
            ->leftJoin('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                DB::raw('LOWER(rol_usuario.cargo_usuario) as cargo_usuario')
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
    }

    /*
    |--------------------------------------------------------------------------
    | 4. ACTUALIZAR USUARIO
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:150',
            'correo_usuario' => 'required|email|unique:usuario,correo_usuario,' . $id . ',id_usuario',
            'cargo_usuario' => 'required|in:administrador,editor',
            'contraseña_usuario' => 'nullable|min:6'
        ]);

        DB::beginTransaction();

        try {

            $usuarioExiste = DB::table('usuario')
                ->where('id_usuario', $id)
                ->exists();

            if (!$usuarioExiste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            $updateData = [
                'nombre_usuario' => $request->nombre_usuario,
                'correo_usuario' => $request->correo_usuario
            ];

            if ($request->filled('contraseña_usuario')) {
                $updateData['contraseña_usuario'] = Hash::make($request->contraseña_usuario);
            }

            DB::table('usuario')
                ->where('id_usuario', $id)
                ->update($updateData);

            // Verificar si el rol existe
            $rolExiste = DB::table('rol_usuario')
                ->where('id_usuario', $id)
                ->exists();

            if ($rolExiste) {
                DB::table('rol_usuario')
                    ->where('id_usuario', $id)
                    ->update([
                        'cargo_usuario' => strtolower($request->cargo_usuario)
                    ]);
            } else {
                DB::table('rol_usuario')
                    ->insert([
                        'id_usuario' => $id,
                        'cargo_usuario' => strtolower($request->cargo_usuario)
                    ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | 5. ELIMINAR USUARIO
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $usuarioExiste = DB::table('usuario')
                ->where('id_usuario', $id)
                ->exists();

            if (!$usuarioExiste) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            DB::table('rol_usuario')
                ->where('id_usuario', $id)
                ->delete();

            DB::table('usuario')
                ->where('id_usuario', $id)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ], 500);
        }
    }
}