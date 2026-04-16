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
            ['partials.header', 'partials.footer', 'sections.contact'],
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

        // ── Actividades: sección services (página pública) ──
        View::composer('sections.services', function ($view) {

            // Encabezado — título, subtítulo y año visible
            $encabezado = DB::table('actividades_encabezado')
                ->join('actividad_anos', 'actividades_encabezado.id_ano', '=', 'actividad_anos.id_ano')
                ->where('actividad_anos.id_pagina', 4)
                ->select('actividades_encabezado.*')
                ->first();

            // Año activo a mostrar por defecto
            $anoVisible = $encabezado->ano_visible ?? null;

            // Si no hay año guardado, usar el más reciente visible
            if (!$anoVisible) {
                $anoVisible = DB::table('actividad_anos')
                    ->where('id_pagina', 4)
                    ->where('visible', 1)
                    ->orderBy('ano', 'desc')
                    ->value('ano') ?? date('Y');
            }

            // Años visibles para el selector público
            $anosVisibles = DB::table('actividad_anos')
                ->where('id_pagina', 4)
                ->where('visible', 1)
                ->orderBy('ano', 'asc')
                ->get();

            // Actividades del año activo
            $actividades = DB::table('actividades')
                ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
                ->where('actividad_anos.id_pagina', 4)
                ->where('actividad_anos.ano', $anoVisible)
                ->where('actividades.visible', 1)
                ->orderBy('actividades.orden_actividad')
                ->select('actividades.*')
                ->get();

            $view->with('act_encabezado',  $encabezado ?? (object)[
                'titulo_actividad'    => 'Actividades',
                'subtitulo_actividad' => 'Nuestras Actividades',
                'ano_visible'         => date('Y'),
            ]);
            $view->with('act_anos',        $anosVisibles);
            $view->with('act_actividades', $actividades);
            $view->with('act_ano_activo',  $anoVisible);
        });
    }
}