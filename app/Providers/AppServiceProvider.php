<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // ── Contacto: header, footer y sección contacto ──
        View::composer(
            [
                'partials.header',
                'partials.footer',
                'sections.contact',
            ],
            function ($view) {
                $contacto = DB::table('contacto')
                    ->where('id_pagina', 8)
                    ->first();

                $view->with('contacto', $contacto ?? (object)[
                    'email_contacto'     => '',
                    'telefono_contacto'  => '',
                    'direccion_contacto' => '',
                    'horario_contacto'   => '',
                    'mapa_embed'         => '',
                    'facebook_url'       => '',
                    'instagram_url'      => '',
                    'linkedin_url'       => '',
                ]);
            }
        );

        // ── Directiva: sección team ──
        View::composer('sections.team', function ($view) {
            // Título y subtítulo del primer registro (orden_directiva = 1)
            $config = DB::table('directiva')
                ->where('id_pagina', 6)
                ->orderBy('orden_directiva', 'asc')
                ->first();

            // Todos los miembros ordenados
            $miembros = DB::table('directiva')
                ->where('id_pagina', 6)
                ->orderBy('orden_directiva', 'asc')
                ->get();

            $view->with('directivaConfig', $config ?? (object)[
                'titulo_directiva'    => 'Directiva',
                'subtitulo_directiva' => 'Comité Directivo',
            ]);

            $view->with('directiva', $miembros);
        });
    }
}