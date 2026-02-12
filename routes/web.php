<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportsController;

/* ================================
 | Página principal
 ================================= */
Route::get('/', fn() => view('index'));

/* ================================
 | Login
 ================================= */
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* ================================
 | Loader
 ================================= */
Route::get('/loading', fn() => view('loading'))->name('loading');

/* ================================
 | Admin (sin seguridad por ahora)
 ================================= */
Route::get('/admin/home', fn() => view('admin.home'))->name('admin.home');
Route::get('/admin/page', fn() => view('admin.page'));
Route::get('/admin/report', fn() => view('admin.reports'));
Route::get('/admin/manual', fn() => view('admin.manual'));

/* ================================
 | Formularios de contacto
 | (se usa controller para pasar $forms)
 ================================= */
Route::get('/admin/forms', [FormController::class, 'index'])
    ->name('admin.forms');

/* ================================
 | Configuración
 ================================= */
Route::get('/admin/settings', fn() => view('admin.settings'));

/* ================================
 | Sección usuarios
 | Actividades de agregar, editar y eliminar
 ================================= */

/* Listado de usuarios */
Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users');

/* Crear nuevo usuario */
Route::post('/admin/users', [UserController::class, 'store'])
    ->name('admin.users.store');

/* Obtener usuario específico (editar) */
Route::get('/admin/users/{id}', [UserController::class, 'show'])
    ->name('admin.users.show');

/* Actualizar usuario */
Route::put('/admin/users/{id}', [UserController::class, 'update'])
    ->name('admin.users.update');

/* Eliminar usuario */
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
    ->name('admin.users.destroy');
