<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ProyectoAno;
use App\Models\ProyectoCategoria;
use App\Models\ProyectoImagen;
use Illuminate\Support\Facades\DB;

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

    private function getStatsData(): array
    {
        $rows = DB::table('inicio_estadisticas')
            ->where('id_pagina', 1)
            ->get();

        $totBen  = 0;
        $totProy = 0;
        $totHrs  = 0;
        $totVol  = 0;

        foreach ($rows as $row) {
            // Sumar datos manuales
            $totBen  += (int) $row->beneficiarios;
            $totProy += (int) $row->proyectos;
            $totHrs  += (int) $row->horas_apoyo;
            $totVol  += (int) $row->voluntarios;

            // Si bd_include está activo, sumar datos de la BD
            if ($row->bd_include) {
                $totBen += DB::table('reportebeneficiarios as rb')
                    ->join('informe as i', 'rb.id_informe', '=', 'i.id_informe')
                    ->whereRaw('YEAR(i.fecha) = ?', [$row->ano])
                    ->count();

                $totBen += DB::table('asistenciabeneficiarios as ab')
                    ->join('informe as i', 'ab.id_informe', '=', 'i.id_informe')
                    ->whereRaw('YEAR(i.fecha) = ?', [$row->ano])
                    ->count();

                $totProy += DB::table('informe')
                    ->whereRaw('YEAR(fecha) = ?', [$row->ano])
                    ->count();
            }
        }

        return compact('totBen', 'totProy', 'totHrs', 'totVol');
    }

    public function home()
    {
        $data = array_merge(
            $this->getProyectosData(),
            $this->getStatsData()
        );

        return view('index', $data);
    }

    public function index()
    {
        return view('visualpage', $this->getProyectosData());
    }
}