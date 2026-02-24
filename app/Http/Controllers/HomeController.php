<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // Muestra el dashboard principal
    public function index()
    {
        // Verifica que el usuario tenga sesión activa
        if (!session()->has('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión');
        }

        // Cuenta el total de usuarios registrados
        $totalUsers = DB::table('usuario')->count();

        // Total de páginas (pendiente de implementación)
        $totalPages = 0;

        // Cuenta el total de mensajes del formulario de contacto
        $totalForms = DB::table('formulario_contacto')->count();

        // Retorna la vista con las estadísticas
        return view('admin.home', compact(
            'totalUsers',
            'totalPages',
            'totalForms'
        ));
    }
}