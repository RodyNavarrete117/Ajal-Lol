<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageFaqController extends Controller
// {
//     public function index()
//     {
//         $preguntas = DB::table('preguntas_frecuentes')
//             ->where('id_pagina', 7)
//             ->orderBy('orden')
//             ->get();
//
//         return view('admin.pages.faq_edit', compact('preguntas'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'titulo_pregunta' => 'nullable|string|max:150',
//             'texto_respuesta' => 'nullable|string',
//             'orden'           => 'integer|min:0',
//             'activo'          => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 7;
//
//         $id = DB::table('preguntas_frecuentes')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'titulo_pregunta' => 'nullable|string|max:150',
//             'texto_respuesta' => 'nullable|string',
//             'orden'           => 'integer|min:0',
//             'activo'          => 'boolean',
//         ]);
//
//         DB::table('preguntas_frecuentes')
//             ->where('id_preguntasfrecuentes', $id)
//             ->where('id_pagina', 7)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Pregunta actualizada.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('preguntas_frecuentes')
//             ->where('id_preguntasfrecuentes', $id)
//             ->where('id_pagina', 7)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Pregunta eliminada.']);
//     }
// }