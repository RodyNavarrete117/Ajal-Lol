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

        $hash        = $usuario->contraseña_usuario;
        $autenticado = false;

        // 1. bcrypt (usuarios ya migrados o que resetearon contraseña)
        try {
            if (Hash::check($request->password, $hash)) {
                $autenticado = true;
            }
        } catch (\RuntimeException $e) {
            // Hash no es bcrypt, continuar al fallback SHA-256
        }

        // 2. SHA-256 legacy → migrar silenciosamente a bcrypt
        if (!$autenticado && hash('sha256', $request->password) === $hash) {
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

        // Si NO marcó remember_me, la sesión expira en 30 minutos
        if (!$request->boolean('remember_me')) {
            session()->put('expires_at', now()->addMinutes(30)->timestamp);
        }

        $mantener = $request->boolean('remember_me');

        if ($mantener) {
            session()->put('remember_me', true);
            cookie()->queue(cookie(
                'remember_user',
                encrypt($usuario->id_usuario),
                60 * 24 * 30
            ));
        }

        return redirect()->route('loading');
    }

    public function logout(Request $request)
    {
        session()->flush(); // borra toda la sesión
        cookie()->queue(cookie()->forget('remember_user'));
        return redirect()->route('login');
    }
}