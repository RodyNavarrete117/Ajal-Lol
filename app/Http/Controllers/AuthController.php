<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validación mínima
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Buscar usuario + rol
        $usuario = DB::table('usuario')
            ->join('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->where('usuario.correo_usuario', $request->email)
            ->where(
                'usuario.contraseña_usuario',
                hash('sha256', $request->password)
            )
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                'rol_usuario.cargo_usuario'
            )
            ->first();

        if (!$usuario) {
            return back()->withErrors([
                'email' => 'Credenciales incorrectas'
            ]);
        }

        // Guardar sesión
        session()->put([
            'user_id' => $usuario->id_usuario,
            'nombre'  => $usuario->nombre_usuario,
            'email'   => $usuario->correo_usuario,
            'rol'     => $usuario->cargo_usuario
        ]);

        // Redirige al loader
        return redirect()->route('loading');
    }
}