<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class ReportsController extends Controller
{
    // =============================================
    // Listar informes (vista calendario + historial)
    // =============================================
    public function index()
    {
        $reports = Report::withCount('beneficiaries')
            ->latest('fecha')
            ->get();

        // Agrupar eventos por fecha para el calendario JS
        $events = $reports->mapWithKeys(function ($report) {
            return [
                $report->fecha => [
                    'id'    => $report->id_informe,
                    'title' => $report->evento,
                    'lugar' => $report->lugar,
                ]
            ];
        });

        return view('admin.reports', compact('reports', 'events'));
    }

    // =============================================
    // Guardar nuevo informe + beneficiarios
    // =============================================
    public function store(Request $request)
    {
        $request->validate([
            'nombre_organizacion'      => 'required|string|max:150',
            'evento'                   => 'required|string|max:150',
            'lugar'                    => 'required|string|max:150',
            'fecha'                    => 'required|date',
            'numero_telefonico'        => 'nullable|string|max:50',
            'beneficiarios'            => 'required|array|min:1',
            'beneficiarios.*.nombre'   => 'required|string|max:150',
            'beneficiarios.*.curp'     => 'required|string|max:30',
        ], [
            'beneficiarios.required'         => 'Debes agregar al menos un beneficiario.',
            'beneficiarios.*.nombre.required' => 'El nombre del beneficiario es obligatorio.',
            'beneficiarios.*.curp.required'   => 'El CURP del beneficiario es obligatorio.',
        ]);

        // Crear el informe
        $report = Report::create($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
            'numero_telefonico',
        ]));

        // Crear beneficiarios, filtrando filas vacías
        $beneficiarios = collect($request->beneficiarios)
            ->filter(fn($b) => !empty(trim($b['nombre'])) && !empty(trim($b['curp'])));

        foreach ($beneficiarios as $beneficiario) {
            $report->beneficiaries()->create([
                'nombre' => trim($beneficiario['nombre']),
                'curp'   => strtoupper(trim($beneficiario['curp'])),
            ]);
        }

        return redirect()->route('admin.reports')
            ->with('success', 'Informe creado correctamente.');
    }

    // =============================================
    // Ver detalle de un informe
    // =============================================
    public function show($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);
        return view('admin.reports-show', compact('report'));
    }

    // =============================================
    // Mostrar formulario de edición
    // =============================================
    public function edit($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);
        return view('admin.reports-edit', compact('report'));
    }

    // =============================================
    // Actualizar informe + beneficiarios
    // =============================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_organizacion'      => 'required|string|max:150',
            'evento'                   => 'required|string|max:150',
            'lugar'                    => 'required|string|max:150',
            'fecha'                    => 'required|date',
            'numero_telefonico'        => 'nullable|string|max:50',
            'beneficiarios'            => 'required|array|min:1',
            'beneficiarios.*.nombre'   => 'required|string|max:150',
            'beneficiarios.*.curp'     => 'required|string|max:30',
        ]);

        $report = Report::findOrFail($id);
        $report->update($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
            'numero_telefonico',
        ]));

        // Reemplazar beneficiarios (eliminar los anteriores y crear los nuevos)
        $report->beneficiaries()->delete();

        $beneficiarios = collect($request->beneficiarios)
            ->filter(fn($b) => !empty(trim($b['nombre'])) && !empty(trim($b['curp'])));

        foreach ($beneficiarios as $beneficiario) {
            $report->beneficiaries()->create([
                'nombre' => trim($beneficiario['nombre']),
                'curp'   => strtoupper(trim($beneficiario['curp'])),
            ]);
        }

        return redirect()->route('admin.reports')
            ->with('success', 'Informe actualizado correctamente.');
    }

    // =============================================
    // Eliminar informe (cascade borra beneficiarios)
    // =============================================
    public function destroy($id)
    {
        Report::findOrFail($id)->delete();

        return redirect()->route('admin.reports')
            ->with('success', 'Informe eliminado correctamente.');
    }

    // =============================================
    // Generar y descargar PDF
    // =============================================
    public function pdf($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);

        $html = view('admin.reports-pdf', compact('report'))->render();

        $mpdf = new Mpdf([
            'mode'        => 'utf-8',
            'format'      => 'A4',
            'margin_top'  => 15,
            'margin_bottom' => 15,
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $mpdf->SetTitle('Informe - ' . $report->evento);
        $mpdf->WriteHTML($html);

        return response(
            $mpdf->Output('informe_' . $report->id_informe . '.pdf', 'S'),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="informe_' . $report->id_informe . '.pdf"',
            ]
        );
    }

    // =============================================
    // Devolver datos de un informe como JSON (para AJAX)
    // =============================================
    public function apiShow($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);
        return response()->json($report);
    }
}