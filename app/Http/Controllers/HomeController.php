<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Mostrar el dashboard principal con estadísticas
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }

        // Obtener total de usuarios
        $totalUsers = DB::table('usuario')->count();

        // Total de páginas (dejar en 0 por ahora)
        $totalPages = 0;

        // Total de formularios (dejar en 0 por ahora)
        $totalForms = 0;

        // Obtener nombre del usuario desde la sesión
        $userName = session('user_name', 'Usuario');

        return view('admin.home', compact(
            'totalUsers',
            'totalPages',
            'totalForms'
        ));
    }
}