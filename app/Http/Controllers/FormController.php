<?php

namespace App\Http\Controllers;

use App\Services\FormPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    /**
     * Mostrar lista de formularios de contacto
     */
    public function index()
    {
        $forms = DB::table('formulario_contacto')
            ->select(
                'id_formcontacto',
                'nombre_completo',
                'correo',
                'numero_telefonico',
                'asunto',
                'mensaje',
                'fecha_envio'
            )
            ->orderBy('fecha_envio', 'desc')
            ->get();

        return view('admin.forms', compact('forms'));
    }

    /**
     * Mostrar detalles de un formulario específico (AJAX)
     */
    public function show($id)
    {
        try {
            $form = DB::table('formulario_contacto')
                ->where('id_formcontacto', $id)
                ->first();

            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'Formulario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $form
            ]);

        } catch (\Exception $e) {

            Log::error('Error al obtener formulario', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el formulario'
            ], 500);
        }
    }

    /**
     * Eliminar un formulario
     */
    public function destroy($id)
    {
        try {
            $exists = DB::table('formulario_contacto')
                ->where('id_formcontacto', $id)
                ->exists();

            if (!$exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Formulario no encontrado'
                ], 404);
            }

            DB::table('formulario_contacto')
                ->where('id_formcontacto', $id)
                ->delete();

            Log::info('Formulario eliminado', [
                'id' => $id,
                'user_id' => session('user_id'),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Formulario eliminado exitosamente'
            ]);

        } catch (\Exception $e) {

            Log::error('Error al eliminar formulario', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el formulario'
            ], 500);
        }
    }

    /**
     * Eliminar múltiples formularios
     */
    public function destroyMultiple(Request $request)
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se proporcionaron IDs'
                ], 400);
            }

            $deleted = DB::table('formulario_contacto')
                ->whereIn('id_formcontacto', $ids)
                ->delete();

            Log::info('Múltiples formularios eliminados', [
                'count' => $deleted,
                'user_id' => session('user_id'),
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => "Se eliminaron {$deleted} formularios exitosamente"
            ]);

        } catch (\Exception $e) {

            Log::error('Error al eliminar múltiples formularios', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar los formularios'
            ], 500);
        }
    }

    /**
     * Exportar formularios a CSV
     */
    public function export()
    {
        try {
            $forms = DB::table('formulario_contacto')
                ->orderBy('fecha_envio', 'desc')
                ->get();

            $filename = 'formularios_contacto_' . date('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
            ];

            $callback = function () use ($forms) {
                $file = fopen('php://output', 'w');

                fputcsv($file, [
                    'ID',
                    'Nombre Completo',
                    'Correo',
                    'Teléfono',
                    'Asunto',
                    'Mensaje',
                    'Fecha de Envío'
                ]);

                foreach ($forms as $form) {
                    fputcsv($file, [
                        $form->id_formcontacto,
                        $form->nombre_completo,
                        $form->correo,
                        $form->numero_telefonico ?? 'N/A',
                        $form->asunto,
                        $form->mensaje,
                        $form->fecha_envio
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {

            Log::error('Error al exportar CSV', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al exportar los formularios');
        }
    }

    /**
     * Exportar formularios a PDF.
     *
     * Soporta dos modos de filtrado, ambos opcionales y combinables:
     *
     *  1. IDs específicos  → GET ?ids[]=1&ids[]=3
     *     Exporta solo los registros cuyo id_formcontacto esté en la lista.
     *     Se usa cuando el usuario selecciona uno o varios registros en la tabla.
     *
     *  2. Filtro de fecha  → GET ?date_filter=today|week|month|year
     *     Exporta los registros del período indicado.
     *     Se usa con el botón "Exportar todo" cuando hay un filtro de fecha activo.
     *
     * Si no se envía ningún parámetro se exportan todos los registros.
     */
    public function exportPdf(Request $request, FormPdfService $pdfService)
    {
        $query = DB::table('formulario_contacto')
            ->orderBy('fecha_envio', 'desc');

        // ── 1. Filtrar por IDs seleccionados ─────────────────────────────
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            // Sanitizar: solo enteros
            $ids = array_filter(array_map('intval', $ids));
            if (!empty($ids)) {
                $query->whereIn('id_formcontacto', $ids);
            }
        }

        // ── 2. Filtrar por rango de fecha ────────────────────────────────
        //    Solo se aplica si NO se enviaron IDs (exportar todo con filtro)
        if (empty($ids)) {
            $dateFilter = $request->input('date_filter', '');

            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('fecha_envio', now()->toDateString());
                    break;

                case 'week':
                    // Lunes 00:00 → Domingo 23:59 de la semana actual
                    $monday = now()->startOfWeek(\Carbon\Carbon::MONDAY);
                    $sunday = now()->endOfWeek(\Carbon\Carbon::SUNDAY);
                    $query->whereBetween('fecha_envio', [$monday, $sunday]);
                    break;

                case 'month':
                    $query->whereYear('fecha_envio', now()->year)
                          ->whereMonth('fecha_envio', now()->month);
                    break;

                case 'year':
                    $query->whereYear('fecha_envio', now()->year);
                    break;

                // Sin filtro de fecha → todos los registros
                default:
                    break;
            }
        }

        $forms = $query->get();

        if ($forms->isEmpty()) {
            // Respuesta JSON para que el JS muestre el toast de error
            return response()->json([
                'success' => false,
                'message' => 'No hay formularios para exportar en el período seleccionado'
            ], 404);
        }

        // Pasar metadatos extra al servicio para que los refleje en el PDF
        $meta = $this->buildPdfMeta($request, $ids, $forms);

        $pdf = $pdfService->generate($forms, $meta);

        // 'D' = forzar descarga en el navegador
        $pdf->Output($meta['filename'], 'D');
        exit;
    }

    /**
     * Construye el array de metadatos que se inyecta en el PDF
     * (título del período, nombre del archivo, etc.)
     */
    private function buildPdfMeta(Request $request, array $ids, $forms): array
    {
        // ── Nombre de archivo y etiqueta de período ──────────────────────
        if (!empty($ids)) {
            $count    = count($ids);
            $label    = $count === 1
                ? 'Ficha individual de contacto'
                : "Selección de {$count} registros";
            $filename = $count === 1
                ? "contacto_{$ids[0]}.pdf"
                : "formularios_seleccionados_{$count}.pdf";

        } else {
            $dateFilter = $request->input('date_filter', '');
            $labelMap   = [
                'today' => 'Registros de hoy',
                'week'  => 'Registros de esta semana',
                'month' => 'Registros de este mes',
                'year'  => 'Registros de este año',
                ''      => 'Todos los registros',
            ];
            $fileMap = [
                'today' => 'formularios_hoy.pdf',
                'week'  => 'formularios_esta_semana.pdf',
                'month' => 'formularios_este_mes.pdf',
                'year'  => 'formularios_este_año.pdf',
                ''      => 'formularios_contacto.pdf',
            ];
            $label    = $labelMap[$dateFilter]  ?? 'Todos los registros';
            $filename = $fileMap[$dateFilter]   ?? 'formularios_contacto.pdf';
        }

        return [
            'label'    => $label,
            'filename' => $filename,
            'total'    => $forms->count(),
        ];
    }
}