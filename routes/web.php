<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/* Página principal */
Route::get('/', function () {
    return view('index');
});

/* Login */
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* Admin (SIN SEGURIDAD POR AHORA) */
Route::get('/admin/home', fn () => view('admin.home'))->name('admin.home');
Route::get('/admin/page', fn () => view('admin.page'));
Route::get('/admin/report', fn () => view('admin.reports'));
Route::get('/admin/manual', fn () => view('admin.manual'));
Route::get('/admin/users', fn () => view('admin.users'));
Route::get('/admin/forms', fn () => view('admin.forms'));
Route::get('/admin/settings', fn () => view('admin.settings'));