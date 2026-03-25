<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validación con mensajes personalizados
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingrese un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
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
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->withInput($request->only('email')); // conserva el correo en el campo
        }

        // Guardar sesión
        session()->put([
            'user_id' => $usuario->id_usuario,
            'nombre'  => $usuario->nombre_usuario,
            'email'   => $usuario->correo_usuario,
            'rol'     => $usuario->cargo_usuario,
        ]);

        // Redirige al loader
        return redirect()->route('loading');
    }
}