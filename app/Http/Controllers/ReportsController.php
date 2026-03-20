<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ReportPdfService;
use App\Services\AttendancePdfService;
use App\Services\BlankReportPdfService;
use App\Services\BlankAttendancePdfService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function __construct(
        protected ReportPdfService         $pdfService,
        protected AttendancePdfService     $attendancePdfService,
        protected BlankReportPdfService    $blankReportService,
        protected BlankAttendancePdfService $blankAttendanceService,
    ) {}

    // =============================================
    // LISTADO (Calendario + Historial)
    // =============================================
    public function index()
    {
        // Traemos ambos conteos para poder mostrar el total real en el modal
        $reports = Report::withCount(['beneficiaries', 'attendances'])
            ->latest('fecha')
            ->get();

        $events = $reports->mapWithKeys(function ($report) {
            // El total visible es el que aplique según el tipo guardado
            $total = $report->beneficiaries_count > 0
                ? $report->beneficiaries_count
                : $report->attendances_count;

            return [
                $report->fecha => [
                    'id'                  => $report->id_informe,
                    'title'               => $report->evento,
                    'lugar'               => $report->lugar,
                    'beneficiaries_count' => $total,
                ]
            ];
        });

        return view('admin.reports', compact('reports', 'events'));
    }

    // =============================================
    // CREAR INFORME (botón Guardar)
    // =============================================
    public function store(Request $request)
    {
        $tipo = $request->input('tipo_informe', 'asistencia');

        // ── Validación base (siempre requerida) ──────────────────────────────
        $request->validate([
            'nombre_organizacion' => 'required|string|max:150',
            'evento'              => 'required|string|max:150',
            'lugar'               => 'required|string|max:150',
            'fecha'               => 'required|date',
        ]);

        // ── Validación específica según tipo ─────────────────────────────────
        if ($tipo === 'reporte') {
            $request->validate([
                'beneficiarios'                                 => 'required|array|min:1',
                'beneficiarios.*.reportenombrebeneficiario'     => 'required|string|max:150',
                'beneficiarios.*.reportecurpbeneficiario'       => 'required|string|max:18',
                'beneficiarios.*.reporteedadbeneficiario'       => 'nullable|integer|min:0|max:120',
            ]);
        } else {
            $request->validate([
                'asistencias'                                   => 'required|array|min:1',
                'asistencias.*.asistencianombrebeneficiario'    => 'required|string|max:150',
                'asistencias.*.asistenciaedadbeneficiario'      => 'nullable|integer|min:0|max:120',
            ]);
        }

        // ── Crear informe ─────────────────────────────────────────────────────
        $report = Report::create($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
        ]));

        // ── Guardar personas según tipo ───────────────────────────────────────
        if ($tipo === 'reporte') {
            collect($request->beneficiarios)
                ->filter(fn ($b) =>
                    !empty(trim($b['reportenombrebeneficiario'] ?? '')) &&
                    !empty(trim($b['reportecurpbeneficiario']   ?? ''))
                )
                ->each(fn ($b) =>
                    $report->beneficiaries()->create([
                        'reportenombrebeneficiario' => trim($b['reportenombrebeneficiario']),
                        'reportecurpbeneficiario'   => strtoupper(trim($b['reportecurpbeneficiario'])),
                        'reporteedadbeneficiario'   => $b['reporteedadbeneficiario'] ?? null,
                    ])
                );
        } else {
            collect($request->asistencias)
                ->filter(fn ($a) =>
                    !empty(trim($a['asistencianombrebeneficiario'] ?? ''))
                )
                ->each(fn ($a) =>
                    $report->attendances()->create([
                        'asistencianombrebeneficiario' => trim($a['asistencianombrebeneficiario']),
                        'asistenciaedadbeneficiario'   => $a['asistenciaedadbeneficiario'] ?? null,
                    ])
                );
        }

        return redirect()
            ->route('admin.reports')
            ->with('success', 'Informe creado correctamente.')
            ->with('toast_type', 'success');
    }

    // =============================================
    // PREVIEW PDF SIN GUARDAR (Exportar / Imprimir)
    // =============================================
    public function previewPdf(Request $request)
    {
        $tipo = $request->input('tipo_informe', 'asistencia');

        // ── Validación base ───────────────────────────────────────────────────
        $request->validate([
            'nombre_organizacion' => 'required|string|max:150',
            'evento'              => 'nullable|string|max:150',
            'lugar'               => 'nullable|string|max:150',
            'fecha'               => 'required|date',
        ]);

        // ── Objeto temporal (nunca se persiste) ───────────────────────────────
        $report = new Report($request->only([
            'nombre_organizacion', 'evento', 'lugar', 'fecha',
        ]));
        $report->id_informe = 0;

        // ── Acción: Solo formato (tabla vacía con metadatos) ──────────────────
        if ($request->input('_action') === 'blank_pdf') {
            if ($tipo === 'reporte') {
                $report->setRelation('beneficiaries', collect());
                $content  = $this->blankReportService->generateWithMeta($report);
                $filename = 'formato_reporte.pdf';
            } else {
                $report->setRelation('attendances', collect());
                $content  = $this->blankAttendanceService->generateWithMeta($report);
                $filename = 'formato_asistencia.pdf';
            }
            return response($content, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        $disposition = $request->input('_action') === 'pdf_download' ? 'attachment' : 'inline';

        if ($tipo === 'reporte') {
            $request->validate([
                'beneficiarios'                                 => 'nullable|array',
                'beneficiarios.*.reportenombrebeneficiario'     => 'nullable|string|max:150',
                'beneficiarios.*.reportecurpbeneficiario'       => 'nullable|string|max:18',
                'beneficiarios.*.reporteedadbeneficiario'       => 'nullable|integer|min:0|max:120',
            ]);

            $personas = collect($request->beneficiarios ?? [])
                ->filter(fn ($b) =>
                    !empty(trim($b['reportenombrebeneficiario'] ?? '')) &&
                    !empty(trim($b['reportecurpbeneficiario']   ?? ''))
                )
                ->map(fn ($b) => (object) [
                    'reportenombrebeneficiario' => trim($b['reportenombrebeneficiario']),
                    'reportecurpbeneficiario'   => strtoupper(trim($b['reportecurpbeneficiario'])),
                    'reporteedadbeneficiario'   => $b['reporteedadbeneficiario'] ?? null,
                ]);

            $report->setRelation('beneficiaries', $personas);
            $content  = $this->pdfService->generate($report);
            $filename = 'reporte_preview.pdf';

        } else {
            $request->validate([
                'asistencias'                                   => 'nullable|array',
                'asistencias.*.asistencianombrebeneficiario'    => 'nullable|string|max:150',
                'asistencias.*.asistenciaedadbeneficiario'      => 'nullable|integer|min:0|max:120',
            ]);

            $personas = collect($request->asistencias ?? [])
                ->filter(fn ($a) =>
                    !empty(trim($a['asistencianombrebeneficiario'] ?? ''))
                )
                ->map(fn ($a) => (object) [
                    'asistencianombrebeneficiario' => trim($a['asistencianombrebeneficiario']),
                    'asistenciaedadbeneficiario'   => $a['asistenciaedadbeneficiario'] ?? null,
                ]);

            $report->setRelation('attendances', $personas);
            $content  = $this->attendancePdfService->generate($report);
            $filename = 'asistencia_preview.pdf';
        }

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $filename . '"',
        ]);
    }

    // =============================================
    // ACTUALIZAR INFORME
    // =============================================
    public function update(Request $request, $id)
    {
        $tipo = $request->input('tipo_informe', 'asistencia');

        // ── Validación base ───────────────────────────────────────────────────
        $request->validate([
            'nombre_organizacion' => 'required|string|max:150',
            'evento'              => 'required|string|max:150',
            'lugar'               => 'required|string|max:150',
            'fecha'               => 'required|date',
        ]);

        // ── Validación específica ─────────────────────────────────────────────
        if ($tipo === 'reporte') {
            $request->validate([
                'beneficiarios'                                 => 'required|array|min:1',
                'beneficiarios.*.reportenombrebeneficiario'     => 'required|string|max:150',
                'beneficiarios.*.reportecurpbeneficiario'       => 'required|string|max:18',
                'beneficiarios.*.reporteedadbeneficiario'       => 'nullable|integer|min:0|max:120',
            ]);
        } else {
            $request->validate([
                'asistencias'                                   => 'required|array|min:1',
                'asistencias.*.asistencianombrebeneficiario'    => 'required|string|max:150',
                'asistencias.*.asistenciaedadbeneficiario'      => 'nullable|integer|min:0|max:120',
            ]);
        }

        $report = Report::findOrFail($id);

        $report->update($request->only([
            'nombre_organizacion',
            'evento',
            'lugar',
            'fecha',
        ]));

        // ── Reemplazar personas según tipo ────────────────────────────────────
        if ($tipo === 'reporte') {
            // Limpiar asistencias anteriores si las hubiera y guardar beneficiarios
            $report->attendances()->delete();
            $report->beneficiaries()->delete();

            collect($request->beneficiarios)
                ->filter(fn ($b) =>
                    !empty(trim($b['reportenombrebeneficiario'] ?? '')) &&
                    !empty(trim($b['reportecurpbeneficiario']   ?? ''))
                )
                ->each(fn ($b) =>
                    $report->beneficiaries()->create([
                        'reportenombrebeneficiario' => trim($b['reportenombrebeneficiario']),
                        'reportecurpbeneficiario'   => strtoupper(trim($b['reportecurpbeneficiario'])),
                        'reporteedadbeneficiario'   => $b['reporteedadbeneficiario'] ?? null,
                    ])
                );
        } else {
            // Limpiar beneficiarios anteriores si los hubiera y guardar asistencias
            $report->beneficiaries()->delete();
            $report->attendances()->delete();

            collect($request->asistencias)
                ->filter(fn ($a) =>
                    !empty(trim($a['asistencianombrebeneficiario'] ?? ''))
                )
                ->each(fn ($a) =>
                    $report->attendances()->create([
                        'asistencianombrebeneficiario' => trim($a['asistencianombrebeneficiario']),
                        'asistenciaedadbeneficiario'   => $a['asistenciaedadbeneficiario'] ?? null,
                    ])
                );
        }

        $from = $request->input('_from', 'calendar');

        if ($from === 'history') {
            return redirect()
                ->route('admin.reports')
                ->with('success', 'Informe actualizado correctamente.')
                ->with('toast_type', 'edit')
                ->with('view', 'history');
        }

        return redirect()
            ->route('admin.reports')
            ->with('success', 'Informe actualizado correctamente.')
            ->with('toast_type', 'edit');
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
    // Detecta el tipo por qué tabla tiene datos
    // =============================================
    public function pdf($id)
    {
        $report = Report::with(['beneficiaries', 'attendances'])->findOrFail($id);

        if ($report->beneficiaries->isNotEmpty()) {
            $content  = $this->pdfService->generate($report);
            $filename = 'reporte_' . $report->id_informe . '.pdf';
        } else {
            $content  = $this->attendancePdfService->generate($report);
            $filename = 'asistencia_' . $report->id_informe . '.pdf';
        }

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    // =============================================
    // FORMATO EN BLANCO — REPORTE (con CURP)
    // =============================================
    public function blankReportPdf()
    {
        $content = $this->blankReportService->generate();

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="formato_informe_ajal_lol.pdf"',
        ]);
    }

    // =============================================
    // FORMATO EN BLANCO — ASISTENCIA (sin CURP)
    // =============================================
    public function blankAttendancePdf()
    {
        $content = $this->blankAttendanceService->generate();

        return response($content, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="formato_asistencia_ajal_lol.pdf"',
        ]);
    }

    // =============================================
    // API JSON (MODAL CALENDARIO)
    // =============================================
    public function apiShow($id)
    {
        $report = Report::with(['beneficiaries', 'attendances'])->findOrFail($id);

        return response()->json($report);
    }
}