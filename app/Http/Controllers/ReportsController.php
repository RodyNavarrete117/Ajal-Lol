<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Services\ReportPdfService;
use App\Services\AttendancePdfService;
use App\Services\BlankReportPdfService;
use App\Services\BlankAttendancePdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ReportsController extends Controller
{
    public function __construct(
        protected ReportPdfService          $pdfService,
        protected AttendancePdfService      $attendancePdfService,
        protected BlankReportPdfService     $blankReportService,
        protected BlankAttendancePdfService $blankAttendanceService,
    ) {}

    // =============================================
    // MENSAJES DE VALIDACIÓN REUTILIZABLES
    // =============================================
    private function baseMessages(): array
    {
        return [
            'nombre_organizacion.required' => 'El nombre de la organización es obligatorio.',
            'nombre_organizacion.max'      => 'El nombre de la organización no debe superar los 150 caracteres.',
            'evento.required'              => 'El nombre del evento es obligatorio.',
            'evento.max'                   => 'El nombre del evento no debe superar los 150 caracteres.',
            'lugar.required'               => 'El lugar del evento es obligatorio.',
            'lugar.max'                    => 'El lugar no debe superar los 150 caracteres.',
            'fecha.required'               => 'La fecha del evento es obligatoria.',
            'fecha.date'                   => 'La fecha ingresada no tiene un formato válido.',
        ];
    }

    /**
     * Valida el array de personas y colapsa todos los errores de filas
     * en UN solo mensaje general para no repetir por cada índice.
     */
    private function validarPersonasReporte(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'beneficiarios'                                 => 'required|array|min:1',
            'beneficiarios.*.reportenombrebeneficiario'     => 'required|string|max:150',
            'beneficiarios.*.reportecurpbeneficiario'       => 'required|string|max:18',
            'beneficiarios.*.reporteedadbeneficiario'       => 'nullable|integer|min:0|max:120',
        ]);

        if ($validator->fails()) {
            $errores  = $validator->errors();
            $mensajes = [];

            // Mensaje general si el array está vacío
            if ($errores->has('beneficiarios')) {
                $mensajes['beneficiarios'] = 'Debe agregar al menos un beneficiario.';
            }

            // Un solo mensaje por tipo de campo (nombre, CURP, edad)
            // sin importar cuántas filas fallen
            $hayNombre = collect($errores->keys())
                ->filter(fn ($k) => str_contains($k, 'reportenombrebeneficiario'))
                ->isNotEmpty();

            $hayCurp = collect($errores->keys())
                ->filter(fn ($k) => str_contains($k, 'reportecurpbeneficiario'))
                ->isNotEmpty();

            $hayEdad = collect($errores->keys())
                ->filter(fn ($k) => str_contains($k, 'reporteedadbeneficiario'))
                ->isNotEmpty();

            if ($hayNombre) {
                $mensajes['beneficiarios_nombre'] = 'Hay beneficiarios sin nombre. Por favor, complétalos.';
            }
            if ($hayCurp) {
                $mensajes['beneficiarios_curp'] = 'Hay beneficiarios sin CURP. Por favor, complétalos.';
            }
            if ($hayEdad) {
                $mensajes['beneficiarios_edad'] = 'Alguna edad ingresada no es válida.';
            }

            throw ValidationException::withMessages($mensajes);
        }
    }

    private function validarPersonasAsistencia(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'asistencias'                                   => 'required|array|min:1',
            'asistencias.*.asistencianombrebeneficiario'    => 'required|string|max:150',
            'asistencias.*.asistenciaedadbeneficiario'      => 'nullable|integer|min:0|max:120',
        ]);

        if ($validator->fails()) {
            $errores  = $validator->errors();
            $mensajes = [];

            if ($errores->has('asistencias')) {
                $mensajes['asistencias'] = 'Debe agregar al menos un asistente.';
            }

            $hayNombre = collect($errores->keys())
                ->filter(fn ($k) => str_contains($k, 'asistencianombrebeneficiario'))
                ->isNotEmpty();

            $hayEdad = collect($errores->keys())
                ->filter(fn ($k) => str_contains($k, 'asistenciaedadbeneficiario'))
                ->isNotEmpty();

            if ($hayNombre) {
                $mensajes['asistencias_nombre'] = 'Hay asistentes sin nombre. Por favor, complétalos.';
            }
            if ($hayEdad) {
                $mensajes['asistencias_edad'] = 'Alguna edad ingresada no es válida.';
            }

            throw ValidationException::withMessages($mensajes);
        }
    }

    // =============================================
    // LISTADO (Calendario + Historial)
    // =============================================
    public function index()
    {
        $reports = Report::withCount(['beneficiaries', 'attendances'])
            ->latest('fecha')
            ->get();

        // Para el calendario (por fecha)
        $events = $reports->mapWithKeys(function ($report) {
            $total = $report->beneficiaries_count > 0
                ? $report->beneficiaries_count
                : $report->attendances_count;
            return [
                $report->fecha => [
                    'id'                  => $report->id_informe,
                    'title'               => $report->evento,
                    'lugar'               => $report->lugar,
                    'beneficiaries_count' => $total,
                    'tipo'                => $report->beneficiaries_count > 0 ? 'reporte' : 'asistencia',
                ]
            ];
        });

        // Para el modal/historial (por ID)
        $eventsById = $reports->mapWithKeys(function ($report) {
            $total = $report->beneficiaries_count > 0
                ? $report->beneficiaries_count
                : $report->attendances_count;
            return [
                $report->id_informe => [
                    'id'                  => $report->id_informe,
                    'title'               => $report->evento,
                    'lugar'               => $report->lugar,
                    'fecha'               => $report->fecha,
                    'beneficiaries_count' => $total,
                    'tipo'                => $report->beneficiaries_count > 0 ? 'reporte' : 'asistencia',
                ]
            ];
        });

        return view('admin.reports', compact('reports', 'events', 'eventsById'));
    }
    // =============================================
    // CREAR INFORME (botón Guardar)
    // =============================================
    public function store(Request $request)
    {
        $tipo = $request->input('tipo_informe', 'asistencia');

        // ── Validación base ───────────────────────────────────────────────────
        $request->validate([
            'nombre_organizacion' => 'required|string|max:150',
            'evento'              => 'required|string|max:150',
            'lugar'               => 'required|string|max:150',
            'fecha'               => 'required|date',
        ], $this->baseMessages());

        // ── Validación específica con mensaje único por campo ─────────────────
        if ($tipo === 'reporte') {
            $this->validarPersonasReporte($request);
        } else {
            $this->validarPersonasAsistencia($request);
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
        ], array_merge($this->baseMessages(), [
            'nombre_organizacion.required' => 'El nombre de la organización es obligatorio para generar el PDF.',
            'fecha.required'               => 'La fecha es obligatoria para generar el PDF.',
        ]));

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
        ], $this->baseMessages());

        // ── Validación específica con mensaje único por campo ─────────────────
        if ($tipo === 'reporte') {
            $this->validarPersonasReporte($request);
        } else {
            $this->validarPersonasAsistencia($request);
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

        $tipo = $report->beneficiaries->isNotEmpty() ? 'reporte' : 'asistencia';

        return response()->json(array_merge($report->toArray(), ['tipo' => $tipo]));
    }
}