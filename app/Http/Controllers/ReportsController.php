<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    // Listar reportes
    public function index()
    {
        $reports = Report::withCount('beneficiaries')
            ->latest()
            ->get();

        return view('reports.index', compact('reports'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('reports.create');
    }

    // Guardar reporte y beneficiarios
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

        // Crear reporte
        $report = Report::create([
            'nombre_organizacion' => $request->nombre_organizacion,
            'evento' => $request->evento,
            'lugar' => $request->lugar,
            'fecha' => $request->fecha,
            'numero_telefonico' => $request->numero_telefonico,
        ]);

        // Crear beneficiarios asociados
        foreach ($request->beneficiarios as $beneficiario) {
            $report->beneficiaries()->create([
                'nombre' => $beneficiario['nombre'],
                'curp' => $beneficiario['curp'],
            ]);
        }

        return redirect()->route('reports.index')
            ->with('success', 'Reporte creado correctamente');
    }

    // Mostrar detalle
    public function show($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);

        return view('reports.show', compact('report'));
    }

    // Eliminar reporte
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')
            ->with('success', 'Reporte eliminado correctamente');
    }

    // Generar PDF
    public function pdf($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);

        $pdf = Pdf::loadView('reports.pdf', compact('report'));

        return $pdf->download('report_'.$report->id_informe.'.pdf');
    }
}