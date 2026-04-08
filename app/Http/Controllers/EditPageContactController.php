<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class EditPageContactController extends Controller
// {
//     public function index()
//     {
//         $contacto = DB::table('contacto')
//             ->where('id_pagina', 8)
//             ->first();
//
//         return view('admin.pages.contact_edit', compact('contacto'));
//     }
//
//     public function update(Request $request)
//     {
//         $validated = $request->validate([
//             'direccion_contacto' => 'nullable|string|max:255',
//             'telefono_contacto'  => 'nullable|string|max:50',
//             'email_contacto'     => 'nullable|email|max:100',
//             'activo'             => 'boolean',
//         ]);
//
//         DB::table('contacto')
//             ->where('id_pagina', 8)
//             ->update($validated);
//
//         return response()->json(['success' => true, 'message' => 'Contacto actualizado.']);
//     }
// }