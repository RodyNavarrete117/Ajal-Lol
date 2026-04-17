<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ProyectoAno;
use App\Models\ProyectoCategoria;
use App\Models\ProyectoImagen;

class PublicPageController extends Controller
{
    private function getProyectosData(): array
    {
        $anos = ProyectoAno::where('id_pagina', 5)
                           ->where('visible', true)
                           ->whereHas('imagenes') 
                           ->orderBy('ano')
                           ->get();

        $categorias = ProyectoCategoria::orderBy('orden')->get();

        $imagenes = ProyectoImagen::whereHas('ano', fn($q) =>
                        $q->where('id_pagina', 5)->where('visible', true))
                    ->with(['ano', 'categoria'])
                    ->orderBy('event_date', 'desc')
                    ->get();

        return compact('anos', 'categorias', 'imagenes');
    }

    public function home()
    {
        return view('index', $this->getProyectosData());
    }

    public function index()
    {
        return view('visualpage', $this->getProyectosData());
    }
}