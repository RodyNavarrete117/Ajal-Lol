<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ReportPdfService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct(protected ReportPdfService $pdfService) {}

    // =============================================
    // Listar informes (vista calendario + historial)
    // =============================================
    public function index()
    {
        $reports = Report::withCount('beneficiaries')
            ->latest('fecha')
            ->get();

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
    // Si se envía con action=pdf, guarda y descarga
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
            'beneficiarios.required'          => 'Debes agregar al menos un beneficiario.',
            'beneficiarios.*.nombre.required' => 'El nombre del beneficiario es obligatorio.',
            'beneficiarios.*.curp.required'   => 'El CURP del beneficiario es obligatorio.',
        ]);

        $report = Report::create($request->only([
            'nombre_organizacion', 'evento', 'lugar', 'fecha', 'numero_telefonico',
        ]));

        collect($request->beneficiarios)
            ->filter(fn($b) => !empty(trim($b['nombre'])) && !empty(trim($b['curp'])))
            ->each(fn($b) => $report->beneficiaries()->create([
                'nombre' => trim($b['nombre']),
                'curp'   => strtoupper(trim($b['curp'])),
            ]));

        // Si el botón fue "Exportar" o "Imprimir", generar PDF directamente
        $action = $request->input('_action');

        if ($action === 'pdf_download' || $action === 'pdf_print') {
            $report->load('beneficiaries');
            $content     = $this->pdfService->generate($report);
            $disposition = $action === 'pdf_print' ? 'inline' : 'attachment';

            return response($content, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => $disposition . '; filename="informe_' . $report->id_informe . '.pdf"',
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
            'nombre_organizacion', 'evento', 'lugar', 'fecha', 'numero_telefonico',
        ]));

        $report->beneficiaries()->delete();

        collect($request->beneficiarios)
            ->filter(fn($b) => !empty(trim($b['nombre'])) && !empty(trim($b['curp'])))
            ->each(fn($b) => $report->beneficiaries()->create([
                'nombre' => trim($b['nombre']),
                'curp'   => strtoupper(trim($b['curp'])),
            ]));

        return redirect()->route('admin.reports')
            ->with('success', 'Informe actualizado correctamente.');
    }

    // =============================================
    // Eliminar informe
    // =============================================
    public function destroy($id)
    {
        Report::findOrFail($id)->delete();

        return redirect()->route('admin.reports')
            ->with('success', 'Informe eliminado correctamente.');
    }

    // =============================================
    // Generar PDF de informe existente (historial)
    // =============================================
    public function pdf($id)
    {
        $report  = Report::with('beneficiaries')->findOrFail($id);
        $content = $this->pdfService->generate($report);

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="informe_' . $report->id_informe . '.pdf"',
        ]);
    }

    // =============================================
    // JSON para AJAX (modal del calendario)
    // =============================================
    public function apiShow($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);
        return response()->json($report);
    }
}