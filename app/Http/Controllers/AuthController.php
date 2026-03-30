<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Ingrese un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Buscar usuario + rol (sin comparar contraseña en el query)
        $usuario = DB::table('usuario')
            ->join('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->where('usuario.correo_usuario', $request->email)
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                'usuario.contraseña_usuario',
                'rol_usuario.cargo_usuario'
            )
            ->first();

        if (! $usuario) {
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->withInput($request->only('email'));
        }

        $hash            = $usuario->contraseña_usuario;
        $autenticado     = false;

        // 1. bcrypt (usuarios ya migrados o que resetearon contraseña)
        if (Hash::check($request->password, $hash)) {
            $autenticado = true;
        }
        // 2. SHA-256 legacy → migrar silenciosamente a bcrypt
        elseif (hash('sha256', $request->password) === $hash) {
            $autenticado = true;

            DB::table('usuario')
                ->where('id_usuario', $usuario->id_usuario)
                ->update([
                    'contraseña_usuario' => Hash::make($request->password),
                ]);
        }

        if (! $autenticado) {
            return back()
                ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
                ->withInput($request->only('email'));
        }

        // Guardar sesión — mismas claves que tenías
        session()->put([
            'user_id' => $usuario->id_usuario,
            'nombre'  => $usuario->nombre_usuario,
            'email'   => $usuario->correo_usuario,
            'rol'     => $usuario->cargo_usuario,
        ]);

        return redirect()->route('loading');
    }
}