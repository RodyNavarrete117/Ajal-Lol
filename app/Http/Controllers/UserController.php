<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = DB::table('usuario')
            ->join('rol_usuario', 'usuario.id_usuario', '=', 'rol_usuario.id_usuario')
            ->select(
                'usuario.id_usuario',
                'usuario.nombre_usuario',
                'usuario.correo_usuario',
                'rol_usuario.cargo_usuario'
            )
            ->get();

        return view('admin.users', compact('usuarios'));
    }
}