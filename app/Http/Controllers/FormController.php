<?php

namespace App\Http\Controllers;

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
        // Obtener todos los formularios ordenados por fecha más reciente
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
     * Mostrar detalles de un formulario específico
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

            $callback = function() use ($forms) {
                $file = fopen('php://output', 'w');
                
                // Encabezados CSV
                fputcsv($file, [
                    'ID',
                    'Nombre Completo',
                    'Correo',
                    'Teléfono',
                    'Asunto',
                    'Mensaje',
                    'Fecha de Envío'
                ]);

                // Datos
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
            Log::error('Error al exportar formularios', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Error al exportar los formularios');
        }
    }
}