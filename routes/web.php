<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportsController;

/* Página principal */
Route::get('/', fn() => view('index'));

/* Login */
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* Loader */
Route::get('/loading', fn() => view('loading'))->name('loading');

/* Admin (sin seguridad por ahora)*/
Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');

Route::get('/admin/page', fn() => view('admin.page'));
Route::get('/admin/report', fn() => view('admin.reports'));
Route::get('/admin/manual', fn() => view('admin.manual'));

Route::prefix('admin')->group(function () {

    // Lista
    Route::get('/forms', [FormController::class, 'index'])
        ->name('admin.forms');

    // Exportaciones (ANTES del {id})
    Route::get('/forms/export', [FormController::class, 'export'])
        ->name('admin.forms.export');

    Route::get('/forms/export/pdf', [FormController::class, 'exportPdf'])
        ->name('admin.forms.export.pdf');

    // Mostrar detalle
    Route::get('/forms/{id}', [FormController::class, 'show'])
        ->name('admin.forms.show');

    // Eliminar
    Route::delete('/forms/{id}', [FormController::class, 'destroy'])
        ->name('admin.forms.destroy');
});

    

/* Configuración: acá se hacen los cambios de datos del usuario */
Route::prefix('admin')->group(function () {

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('admin.settings');

    Route::post('/settings/change-password', [SettingsController::class, 'changePassword'])
        ->name('admin.settings.change-password');

    Route::post('/settings/update-profile', [SettingsController::class, 'updateProfile'])
        ->name('admin.settings.update-profile');

});

/* Sección usuarios: Actividades de agregar, editar y eliminar*/

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
    
/* Sección edición de páginas de Ajal-Lol
/* Edición de páginas de Ajal-Lol */

Route::get('/admin/pages/home/edit', fn() => view('admin.pages.home_edit'))
    ->name('admin.pages.home.edit');

Route::get('/admin/pages/about/edit', fn() => view('admin.pages.about_edit'))
    ->name('admin.pages.about.edit');

Route::get('/admin/pages/contact/edit', fn() => view('admin.pages.contact_edit'))
    ->name('admin.pages.contact.edit');
