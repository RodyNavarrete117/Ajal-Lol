<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageAboutController extends Controller
// {
//     public function index()
//     {
//         $items = DB::table('nosotros')
//             ->where('id_pagina', 2)
//             ->orderBy('id_nosotros')
//             ->get();
//
//         return view('admin.pages.about_edit', compact('items'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'titulo_nosotros'    => 'nullable|string|max:150',
//             'imagen_nosotros'    => 'nullable|string|max:255',
//             'subtitulo_nosotros' => 'nullable|string|max:150',
//             'texto_nosotros'     => 'nullable|string',
//             'activo'             => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 2;
//
//         $id = DB::table('nosotros')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'titulo_nosotros'    => 'nullable|string|max:150',
//             'imagen_nosotros'    => 'nullable|string|max:255',
//             'subtitulo_nosotros' => 'nullable|string|max:150',
//             'texto_nosotros'     => 'nullable|string',
//             'activo'             => 'boolean',
//         ]);
//
//         DB::table('nosotros')
//             ->where('id_nosotros', $id)
//             ->where('id_pagina', 2)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Nosotros actualizado.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('nosotros')
//             ->where('id_nosotros', $id)
//             ->where('id_pagina', 2)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Bloque eliminado.']);
//     }
// }