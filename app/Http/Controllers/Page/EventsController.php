<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ProyectoAno;
use App\Models\ProyectoImagen;

class EventsController extends Controller
{
    public function show($year)
    {
        $ano = ProyectoAno::where('id_pagina', 5)
                        ->where('ano', $year)
                        ->where('visible', true)
                        ->firstOrFail();

        $imagenes = ProyectoImagen::where('id_ano', $ano->id_ano)
                    ->with('categoria')
                    ->orderBy('event_date', 'desc')
                    ->get();

        $anosVisibles = ProyectoAno::where('id_pagina', 5)
                        ->where('visible', true)
                        ->whereHas('imagenes')
                        ->orderBy('ano')
                        ->get();

        // $anos es lo que usa el header para el dropdown
        $anos = $anosVisibles;

        return view('events.show', compact('ano', 'imagenes', 'anosVisibles', 'anos'));
    }
}