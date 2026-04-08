<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageActivitiesController extends Controller
// {
//     public function index()
//     {
//         $actividades = DB::table('actividades')
//             ->where('id_pagina', 4)
//             ->orderBy('año_actividad', 'desc')
//             ->get();
//
//         $actividades->each(function ($actividad) {
//             $actividad->widgets = DB::table('widgets_actividades')
//                 ->where('actividad_id', $actividad->id_actividad)
//                 ->get();
//         });
//
//         return view('admin.pages.activities_edit', compact('actividades'));
//     }
//
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'año_actividad'    => 'nullable|integer|min:2000|max:2099',
//             'titulo_actividad' => 'nullable|string|max:150',
//             'texto_actividad'  => 'nullable|string',
//             'activo'           => 'boolean',
//         ]);
//
//         $validated['id_pagina'] = 4;
//
//         $id = DB::table('actividades')->insertGetId($validated);
//
//         return response()->json(['success' => true, 'id' => $id]);
//     }
//
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'año_actividad'    => 'nullable|integer|min:2000|max:2099',
//             'titulo_actividad' => 'nullable|string|max:150',
//             'texto_actividad'  => 'nullable|string',
//             'activo'           => 'boolean',
//         ]);
//
//         DB::table('actividades')
//             ->where('id_actividad', $id)
//             ->where('id_pagina', 4)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Actividad actualizada.']);
//     }
//
//     public function destroy($id)
//     {
//         DB::table('widgets_actividades')
//             ->where('actividad_id', $id)
//             ->delete();
//
//         DB::table('actividades')
//             ->where('id_actividad', $id)
//             ->where('id_pagina', 4)
//             ->delete();
//
//         return response()->json(['success' => true, 'message' => 'Actividad eliminada.']);
//     }
// }