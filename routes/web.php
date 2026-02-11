<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/* Página principal */
Route::get('/', fn() => view('index'));

/* Login */
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* Loader */
Route::get('/loading', fn() => view('loading'))->name('loading');

/* Admin (sin seguridad por ahora) */
Route::get('/admin/home', fn() => view('admin.home'))->name('admin.home');
Route::get('/admin/page', fn() => view('admin.page'));
Route::get('/admin/report', fn() => view('admin.reports'));
Route::get('/admin/manual', fn() => view('admin.manual'));
Route::get('/admin/forms', fn() => view('admin.forms'));
Route::get('/admin/settings', fn() => view('admin.settings'));

/* Sección usuario, actividades de agregar, eliminar y editar*/

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
// Ruta para crear un nuevo usuario
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
// Ruta para obtener datos de un usuario específico (para editar)
Route::get('/admin/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
// Ruta para actualizar un usuario
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
// Ruta para eliminar un usuario
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');