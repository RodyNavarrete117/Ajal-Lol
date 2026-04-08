<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageHomeController extends Controller
// {
//     public function index()
//     {
//         $items = DB::table('inicio')
//             ->where('id_pagina', 1)
//             ->orderBy('id_inicio')
//             ->get();
//
//         return view('admin.pages.home_edit', compact('items'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'titulo_inicio' => 'nullable|string|max:150',
//             'texto_inicio'  => 'nullable|string',
//             'img_inicio'    => 'nullable|string|max:255',
//             'url_inicio'    => 'nullable|string|max:255',
//             'activo'        => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 1;
//
//         $id = DB::table('inicio')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'titulo_inicio' => 'nullable|string|max:150',
//             'texto_inicio'  => 'nullable|string',
//             'img_inicio'    => 'nullable|string|max:255',
//             'url_inicio'    => 'nullable|string|max:255',
//             'activo'        => 'boolean',
//         ]);
//
//         DB::table('inicio')
//             ->where('id_inicio', $id)
//             ->where('id_pagina', 1)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Inicio actualizado.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('inicio')
//             ->where('id_inicio', $id)
//             ->where('id_pagina', 1)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Bloque eliminado.']);
//     }
// }