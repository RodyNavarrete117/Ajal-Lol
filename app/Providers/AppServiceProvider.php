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
        // Comparte $contacto con los 3 blades públicos que lo necesitan
        // Se ejecuta automáticamente cada vez que se renderiza cualquiera de estas vistas
        View::composer(
            [
                'partials.header',
                'partials.footer',
                'sections.contact',
            ],
            function ($view) {
                // Consulta una sola vez la fila de contacto ligada a id_pagina = 8
                $contacto = DB::table('contacto')
                    ->where('id_pagina', 8)
                    ->first();

                // Si no existe aún el registro en BD, pasa un objeto vacío
                // para que los blades no fallen con "Undefined property"
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
    }
}