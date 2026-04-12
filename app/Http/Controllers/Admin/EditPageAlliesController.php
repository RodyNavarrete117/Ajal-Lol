<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageAlliesController extends Controller
// {
//     public function index()
//     {
//         $aliados = DB::table('aliados')
//             ->where('id_pagina', 3)
//             ->orderBy('id_aliados')
//             ->get();
//
//         return view('admin.pages.allies_edit', compact('aliados'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'img_aliados' => 'nullable|string|max:255',
//             'nombre'      => 'nullable|string|max:150',
//             'url'         => 'nullable|url|max:255',
//             'activo'      => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 3;
//
//         $id = DB::table('aliados')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'img_aliados' => 'nullable|string|max:255',
//             'nombre'      => 'nullable|string|max:150',
//             'url'         => 'nullable|url|max:255',
//             'activo'      => 'boolean',
//         ]);
//
//         DB::table('aliados')
//             ->where('id_aliados', $id)
//             ->where('id_pagina', 3)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Aliado actualizado.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('aliados')
//             ->where('id_aliados', $id)
//             ->where('id_pagina', 3)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Aliado eliminado.']);
//     }
// }