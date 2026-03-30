<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $usuario = DB::table('usuario')
            ->where('correo_usuario', $request->email)
            ->first();

        // Mensaje genérico para no revelar si el correo existe
        if (! $usuario) {
            return back()->with('status', '¡Listo! Si ese correo está registrado recibirás el enlace en breve.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->upsert(
            [
                'email'      => $request->email,
                'token'      => Hash::make($token),
                'created_at' => now(),
            ],
            ['email'],
            ['token', 'created_at']
        );

        $resetUrl = route('password.reset.form', [
            'token' => $token,
            'email' => $request->email,
        ]);

        Mail::to($request->email)->send(
            new ResetPasswordMail($resetUrl, $usuario->nombre_usuario)
        );

        return back()->with('status', '¡Listo! Si ese correo está registrado recibirás el enlace en breve.');
    }

    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['token' => 'El enlace no es válido o ya fue usado.']);
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['token' => 'El enlace expiró. Solicita uno nuevo.']);
        }

        DB::table('usuario')
            ->where('correo_usuario', $request->email)
            ->update(['contraseña_usuario' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('status', 'Contraseña actualizada correctamente. Ya puedes iniciar sesión.');
    }
}