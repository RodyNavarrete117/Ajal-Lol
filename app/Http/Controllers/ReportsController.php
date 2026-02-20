<?php

/*
namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\Beneficiario;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    /**
     * Mostrar listado de informes
     */
/*
    public function index()
    {
        $informes = Informe::withCount('beneficiarios')
            ->latest()
            ->get();

        return view('reports.index', compact('informes'));
    }
*/

    /**
     * Mostrar formulario de creación
     */
/*
    public function create()
    {
        return view('reports.create');
    }
*/

    /**
     * Guardar nuevo informe con beneficiarios
     */
/*
    public function store(Request $request)
    {
        $request->validate([
            'nombre_organizacion' => 'required|string|max:150',
            'evento' => 'required|string|max:150',
            'lugar' => 'required|string|max:150',
            'fecha' => 'required|date',
            'numero_telefonico' => 'nullable|string|max:50',
            'beneficiarios.*.nombre' => 'required|string|max:150',
            'beneficiarios.*.curp' => 'required|string|max:30',
        ]);

        $informe = Informe::create([
            'nombre_organizacion' => $request->nombre_organizacion,
            'evento' => $request->evento,
            'lugar' => $request->lugar,
            'fecha' => $request->fecha,
            'numero_telefonico' => $request->numero_telefonico,
        ]);

        foreach ($request->beneficiarios as $beneficiario) {
            $informe->beneficiarios()->create([
                'nombre' => $beneficiario['nombre'],
                'curp' => $beneficiario['curp'],
            ]);
        }

        return redirect()->route('reports.index')
            ->with('success', 'Informe creado correctamente');
    }
*/

    /**
     * Mostrar detalle
     */
/*
    public function show($id)
    {
        $informe = Informe::with('beneficiarios')->findOrFail($id);

        return view('reports.show', compact('informe'));
    }
*/

    /**
     * Eliminar informe
     */
/*
    public function destroy($id)
    {
        $informe = Informe::findOrFail($id);
        $informe->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Informe eliminado correctamente');
    }
*/

    /**
     * Generar PDF
     */
/*
    public function pdf($id)
    {
        $informe = Informe::with('beneficiarios')->findOrFail($id);

        $pdf = Pdf::loadView('reports.pdf', compact('informe'));

        return $pdf->download('informe_'.$informe->id_informe.'.pdf');
    }
}
*/