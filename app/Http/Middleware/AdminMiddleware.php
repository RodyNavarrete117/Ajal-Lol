<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('user_id')) {
            // Verificar si la sesión temporal expiró
            if (session()->has('expires_at')) {
                if (now()->timestamp > session('expires_at')) {
                    session()->flush();
                    return redirect()->route('login')
                        ->with('error', 'Tu sesión ha expirado.');
                }
            }
            return $next($request);
        }

        // Si no hay sesión pero hay cookie remember_me
        if ($request->cookie('remember_user')) {
            try {
                $userId = decrypt($request->cookie('remember_user'));

                $usuario = DB::table('usuario')
                    ->join('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
                    ->where('usuario.id_usuario', $userId)
                    ->select(
                        'usuario.id_usuario',
                        'usuario.nombre_usuario',
                        'usuario.correo_usuario',
                        'rol_usuario.cargo_usuario'
                    )
                    ->first();

                if ($usuario) {
                    // Restaurar sesión desde la cookie
                    session()->put([
                        'user_id' => $usuario->id_usuario,
                        'nombre'  => $usuario->nombre_usuario,
                        'email'   => $usuario->correo_usuario,
                        'rol'     => $usuario->cargo_usuario,
                    ]);

                    return $next($request);
                }
            } catch (\Exception $e) {
                // Cookie inválida o manipulada, ignorar
            }
        }

        // Sin sesión ni cookie válida → login
        return redirect()->route('login')
            ->with('error', 'Debes iniciar sesión para acceder.');
    }
}
