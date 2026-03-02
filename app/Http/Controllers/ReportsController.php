<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ReportPdfService;
use App\Services\BlankPdfService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct(
        protected ReportPdfService $pdfService,
        protected BlankPdfService  $blankService,
    ) {}

    // =============================================
    // LISTADO (Calendario + Historial)
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
    // CREAR INFORME (solo guarda — botón Guardar)
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
        ]);

        $report = Report::create($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
            'numero_telefonico',
        ]));

        collect($request->beneficiarios)
            ->filter(fn ($b) =>
                !empty(trim($b['nombre'])) &&
                !empty(trim($b['curp']))
            )
            ->each(fn ($b) =>
                $report->beneficiaries()->create([
                    'nombre' => trim($b['nombre']),
                    'curp'   => strtoupper(trim($b['curp'])),
                ])
            );

        return redirect()
            ->route('admin.reports')
            ->with('success', 'Informe creado correctamente.');
    }

    // =============================================
    // PREVIEW PDF SIN GUARDAR (Exportar / Imprimir)
    // =============================================
    public function previewPdf(Request $request)
    {
        $request->validate([
            'nombre_organizacion'    => 'required|string|max:150',
            'evento'                 => 'required|string|max:150',
            'lugar'                  => 'required|string|max:150',
            'fecha'                  => 'required|date',
            'numero_telefonico'      => 'nullable|string|max:50',
            'beneficiarios'          => 'nullable|array',
            'beneficiarios.*.nombre' => 'nullable|string|max:150',
            'beneficiarios.*.curp'   => 'nullable|string|max:30',
        ]);

        // Objeto temporal, nunca se persiste en BD
        $report = new Report($request->only([
            'nombre_organizacion', 'evento', 'lugar', 'fecha', 'numero_telefonico',
        ]));
        $report->id_informe = 0;

        $beneficiarios = collect($request->beneficiarios ?? [])
            ->filter(fn($b) => !empty(trim($b['nombre'] ?? '')) && !empty(trim($b['curp'] ?? '')))
            ->map(fn($b) => (object)[
                'nombre' => trim($b['nombre']),
                'curp'   => strtoupper(trim($b['curp'])),
            ]);

        $report->setRelation('beneficiaries', $beneficiarios);

        $disposition = $request->input('_action') === 'pdf_download' ? 'attachment' : 'inline';

        $content = $this->pdfService->generate($report);

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="informe_preview.pdf"',
        ]);
    }

    // =============================================
    // ACTUALIZAR INFORME
    // =============================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_organizacion'      => 'required|string|max:150',
            'evento'                   => 'required|string|max:150',
            'lugar'                    => 'required|string|max:150',
            'fecha'                    => 'required|date',
            'beneficiarios'            => 'required|array|min:1',
        ]);

        $report = Report::findOrFail($id);

        $report->update($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
            'numero_telefonico',
        ]));

        $report->beneficiaries()->delete();

        collect($request->beneficiarios)
            ->each(fn ($b) =>
                $report->beneficiaries()->create([
                    'nombre' => trim($b['nombre']),
                    'curp'   => strtoupper(trim($b['curp'])),
                ])
            );

        return redirect()
            ->route('admin.reports')
            ->with('success', 'Informe actualizado correctamente.');
    }

    // =============================================
    // ELIMINAR INFORME
    // =============================================
    public function destroy($id)
    {
        Report::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    // =============================================
    // PDF DESDE HISTORIAL
    // =============================================
    public function pdf($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);

        $content = $this->pdfService->generate($report);

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="informe_' . $report->id_informe . '.pdf"',
        ]);
    }

    // =============================================
    // FORMATO EN BLANCO
    // =============================================
    public function blankPdf()
    {
        $content = $this->blankService->generate();

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="formato_informe_ajal_lol.pdf"',
        ]);
    }

    // =============================================
    // API JSON (MODAL CALENDARIO)
    // =============================================
    public function apiShow($id)
    {
        $report = Report::with('beneficiaries')->findOrFail($id);

        return response()->json($report);
    }
}