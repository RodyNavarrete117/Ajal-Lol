<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqEditController extends Controller
{
    private const ID_PAGINA = 7;

    /* GET admin/pages/faq/edit */
    public function edit()
    {
        $preguntas = DB::table('preguntas_frecuentes')
            ->where('id_pagina', self::ID_PAGINA)
            ->orderBy('id_preguntasfrecuentes', 'asc')
            ->get();

        return view('admin.pages.faq_edit', [
            'preguntas' => $preguntas,
            'id_pagina' => self::ID_PAGINA,
        ]);
    }

    /* PUT admin/pages/faq/update */
    public function update(Request $request)
    {
        $total       = (int) $request->input('total_faqs', 0);
        $idsEnviados = [];

        DB::beginTransaction();

        try {
            for ($n = 1; $n <= $total; $n++) {
                $id        = (int) $request->input("id_{$n}", 0);
                $pregunta  = trim($request->input("titulo_pregunta_{$n}", ''));
                $respuesta = trim($request->input("texto_respuesta_{$n}", ''));

                if ($pregunta === '' && $respuesta === '') continue;

                if ($id > 0) {
                    DB::table('preguntas_frecuentes')
                        ->where('id_preguntasfrecuentes', $id)
                        ->where('id_pagina', self::ID_PAGINA)
                        ->update([
                            'titulo_pregunta' => $pregunta,
                            'texto_respuesta' => $respuesta,
                        ]);
                    $idsEnviados[] = $id;
                } else {
                    $nuevoId = DB::table('preguntas_frecuentes')->insertGetId([
                        'id_pagina'       => self::ID_PAGINA,
                        'titulo_pregunta' => $pregunta,
                        'texto_respuesta' => $respuesta,
                    ]);
                    $idsEnviados[] = $nuevoId;
                }
            }

            if (!empty($idsEnviados)) {
                DB::table('preguntas_frecuentes')
                    ->where('id_pagina', self::ID_PAGINA)
                    ->whereNotIn('id_preguntasfrecuentes', $idsEnviados)
                    ->delete();
            } else {
                DB::table('preguntas_frecuentes')
                    ->where('id_pagina', self::ID_PAGINA)
                    ->delete();
            }

            DB::commit();

            return redirect()
                ->route('admin.pages.faq.edit')
                ->with('success', 'Preguntas frecuentes actualizadas correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('admin.pages.faq.edit')
                ->with('error', 'Error al guardar: ' . $e->getMessage())
                ->withInput();
        }
    }
}