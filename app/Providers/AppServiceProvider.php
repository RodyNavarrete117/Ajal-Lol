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
                'titulo_directiva'    => '',
                'subtitulo_directiva' => '',
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

        // ── Actividades: sección services ──
        View::composer('sections.services', function ($view) {

            $anoVisible = DB::table('actividad_anos')
                ->where('id_pagina', 4)
                ->where('visible', 1)
                ->orderBy('ano', 'desc')
                ->value('ano') ?? date('Y');

            $anosVisibles = DB::table('actividad_anos')
                ->where('id_pagina', 4)
                ->where('visible', 1)
                ->orderBy('ano', 'asc')
                ->get();

            $actividades = DB::table('actividades')
                ->join('actividad_anos', 'actividades.id_ano', '=', 'actividad_anos.id_ano')
                ->where('actividad_anos.id_pagina', 4)
                ->where('actividad_anos.ano', $anoVisible)
                ->where('actividades.visible', 1)
                ->orderBy('actividades.orden_actividad')
                ->select('actividades.*')
                ->get();

            $view->with('act_anos',        $anosVisibles);
            $view->with('act_actividades', $actividades);
            $view->with('act_ano_activo',  $anoVisible);
        });

        // ── Nosotros: sección about ──
        View::composer('sections.about', function ($view) {

            $nosotros = DB::table('nosotros')
                ->where('id_pagina', 2)
                ->first();

            $idNosotros = $nosotros?->id_nosotros;

            $encabezado = $idNosotros
                ? DB::table('nosotros_encabezado')
                    ->where('id_nosotros', $idNosotros)
                    ->first()
                : null;

            $historia = $idNosotros
                ? DB::table('nosotros_historia')
                    ->where('id_nosotros', $idNosotros)
                    ->first()
                : null;

            $general = $idNosotros
                ? DB::table('nosotros_general')
                    ->where('id_nosotros', $idNosotros)
                    ->first()
                : null;

            $view->with('about_encabezado', $encabezado ?? (object)[
                'titulo'    => '',
                'subtitulo' => '',
            ]);

            $view->with('about_historia', $historia ?? (object)[
                'imagen'            => null,
                'badge_texto'       => '',
                'etiqueta_superior' => '',
                'titulo_bloque'     => '',
                'texto_destacado'   => '',
                'texto_descriptivo' => '',
            ]);

            $view->with('about_general', $general ?? (object)[
                'ano_fundacion' => null,
                'beneficiarios' => null,
                'ubicacion'     => null,
            ]);
        });

        // ── Identidad: sección identity ──
        View::composer('sections.identity', function ($view) {

            $nosotros = DB::table('nosotros')
                ->where('id_pagina', 2)
                ->first();

            $idNosotros = $nosotros?->id_nosotros;

            $identidad = $idNosotros
                ? DB::table('nosotros_identidad')
                    ->where('id_nosotros', $idNosotros)
                    ->first()
                : null;

            $items = $identidad
                ? DB::table('nosotros_identidad_items')
                    ->where('id_identidad', $identidad->id_identidad)
                    ->orderBy('orden')
                    ->get()
                    ->keyBy('tipo')
                : collect();

            $view->with('identity_encabezado', $identidad ?? (object)[
                'titulo'    => '',
                'subtitulo' => '',
            ]);

            $view->with('identity_items', $items);
        });

        // ── Hero: sección inicio ──
        View::composer('sections.hero', function ($view) {

            $hero = DB::table('inicio')
                ->where('id_pagina', 1)
                ->first();

            $videos = $hero
                ? DB::table('inicio_videos')
                    ->where('id_inicio', $hero->id_inicio)
                    ->orderBy('orden')
                    ->get()
                : collect();

            $view->with('hero_data', $hero ?? (object)[
                'eyebrow'          => '',
                'titulo_principal' => '',
                'titulo_em'        => '',
                'descripcion'      => '',
            ]);

            $view->with('hero_videos', $videos);
        });
    }
}