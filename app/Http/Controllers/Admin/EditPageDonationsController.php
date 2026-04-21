<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EditPageDonationsController extends Controller
{
    private const ID_PAGINA = 1;

    /* ══════════════════════════════════════════════════════
       VISTA PRINCIPAL
    ══════════════════════════════════════════════════════ */
    public function index()
    {
        $donacion = DB::table('donaciones')
            ->where('id_pagina', self::ID_PAGINA)
            ->first();

        $idDonacion = $donacion?->id_donacion;

        $info = $idDonacion
            ? DB::table('donaciones_info')
                ->where('id_donacion', $idDonacion)
                ->first()
            : null;

        $bancario = $idDonacion
            ? DB::table('donaciones_bancario')
                ->where('id_donacion', $idDonacion)
                ->first()
            : null;

        $paypal = $idDonacion
            ? DB::table('donaciones_paypal')
                ->where('id_donacion', $idDonacion)
                ->first()
            : null;

        return view('admin.pages.donations_edit', compact(
            'info',
            'bancario',
            'paypal'
        ));
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR INFO
    ══════════════════════════════════════════════════════ */
    public function updateInfo(Request $request)
    {
        $request->validate([
            'titulo'      => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
        ]);

        $idDonacion = $this->getOrCreateDonacion();
        $existe = DB::table('donaciones_info')->where('id_donacion', $idDonacion)->exists();
        $data = ['titulo' => $request->titulo, 'descripcion' => $request->descripcion, 'updated_at' => now()];

        if ($existe) {
            DB::table('donaciones_info')->where('id_donacion', $idDonacion)->update($data);
        } else {
            DB::table('donaciones_info')->insert(array_merge($data, ['id_donacion' => $idDonacion, 'created_at' => now()]));
        }

        return response()->json(['success' => true, 'message' => 'Información guardada correctamente.']);
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR BANCARIO
    ══════════════════════════════════════════════════════ */
    public function updateBancario(Request $request)
    {
        $request->validate([
            'beneficiario' => 'nullable|string|max:150',
            'banco'        => 'nullable|string|max:100',
            'clabe'        => 'nullable|string|max:20',
        ]);

        $idDonacion = $this->getOrCreateDonacion();
        $existe = DB::table('donaciones_bancario')->where('id_donacion', $idDonacion)->exists();
        $data = ['beneficiario' => $request->beneficiario, 'banco' => $request->banco, 'clabe' => $request->clabe, 'updated_at' => now()];

        if ($existe) {
            DB::table('donaciones_bancario')->where('id_donacion', $idDonacion)->update($data);
        } else {
            DB::table('donaciones_bancario')->insert(array_merge($data, ['id_donacion' => $idDonacion, 'created_at' => now()]));
        }

        return response()->json(['success' => true, 'message' => 'Datos bancarios guardados correctamente.']);
    }

    /* ══════════════════════════════════════════════════════
       GUARDAR PAYPAL
    ══════════════════════════════════════════════════════ */
    public function updatePaypal(Request $request)
    {
        $request->validate([
            'paypal_usuario' => 'nullable|string|max:100',
        ]);

        $idDonacion = $this->getOrCreateDonacion();
        $existe = DB::table('donaciones_paypal')->where('id_donacion', $idDonacion)->exists();
        $data = ['paypal_usuario' => $request->paypal_usuario, 'updated_at' => now()];

        if ($existe) {
            DB::table('donaciones_paypal')->where('id_donacion', $idDonacion)->update($data);
        } else {
            DB::table('donaciones_paypal')->insert(array_merge($data, ['id_donacion' => $idDonacion, 'created_at' => now()]));
        }

        return response()->json(['success' => true, 'message' => 'PayPal guardado correctamente.']);
    }

    /* ══════════════════════════════════════════════════════
       HELPER
    ══════════════════════════════════════════════════════ */
    private function getOrCreateDonacion(): int
    {
        $donacion = DB::table('donaciones')->where('id_pagina', self::ID_PAGINA)->first();
        if ($donacion) return $donacion->id_donacion;
        return DB::table('donaciones')->insertGetId(['id_pagina' => self::ID_PAGINA, 'created_at' => now(), 'updated_at' => now()]);
    }
}