<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageBoardController extends Controller
// {
//     public function index()
//     {
//         $miembros = DB::table('directiva')
//             ->where('id_pagina', 6)
//             ->orderBy('orden_directiva')
//             ->get();
//
//         return view('admin.pages.board_edit', compact('miembros'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'nombre_directiva' => 'nullable|string|max:150',
//             'foto_directiva'   => 'nullable|string|max:255',
//             'orden_directiva'  => 'nullable|integer|min:0',
//             'activo'           => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 6;
//
//         $id = DB::table('directiva')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'nombre_directiva' => 'nullable|string|max:150',
//             'foto_directiva'   => 'nullable|string|max:255',
//             'orden_directiva'  => 'nullable|integer|min:0',
//             'activo'           => 'boolean',
//         ]);
//
//         DB::table('directiva')
//             ->where('id_directiva', $id)
//             ->where('id_pagina', 6)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Miembro actualizado.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('directiva')
//             ->where('id_directiva', $id)
//             ->where('id_pagina', 6)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Miembro eliminado.']);
//     }
// }