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
            $config = DB::table('directiva')
                ->where('id_pagina', 6)
                ->orderBy('orden_directiva', 'asc')
                ->first();

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

        // ── FAQ: sección pública ──
        View::composer('sections.faq', function ($view) {
            $preguntas = DB::table('preguntas_frecuentes')
                ->where('id_pagina', 7)
                ->orderBy('id_preguntasfrecuentes', 'asc')
                ->get();

            $view->with('preguntas', $preguntas);
        });

        // ── Aliados: sección clients ──
        View::composer('sections.clients', function ($view) {
            $aliados_config = DB::table('aliados')
                ->where('id_pagina', 3)
                ->first();

            $aliados = collect();
            if ($aliados_config) {
                $aliados = DB::table('aliados_imagenes')
                    ->where('id_aliados', $aliados_config->id_aliados)
                    ->whereNotNull('img_path')
                    ->where('img_path', '!=', '')
                    ->orderBy('id_imagen', 'asc')
                    ->get();
            }

            $view->with('aliados_config', $aliados_config ?? (object)[
                'titulo_seccion' => '',
                'descripcion'    => '',
            ]);

            $view->with('aliados', $aliados);
        });
    }
}