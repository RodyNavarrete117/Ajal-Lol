<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportsController;

/* Página pública */
Route::get('/', fn() => view('index'));


/* Login */
Route::get('/login', fn() => view('login'))->name('login'); // Formulario
Route::post('/login', [AuthController::class, 'login'])->name('login.post'); // Autenticación


/* Pantalla de carga */
Route::get('/loading', fn() => view('loading'))->name('loading');


/* Panel admin */
Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home'); // Dashboard
Route::get('/admin/page', fn() => view('admin.page')); // Vista prueba


/* ===== INFORMES ===== */
Route::prefix('admin')->group(function () {

    Route::get('/report', [ReportsController::class, 'index'])
        ->name('admin.reports');

    Route::post('/report', [ReportsController::class, 'store'])
        ->name('admin.reports.store');

    Route::get('/report/blank', [ReportsController::class, 'blankPdf'])
        ->name('admin.reports.blank');

    // ← NUEVA RUTA (antes de las rutas con {id})
    Route::post('/report/preview-pdf', [ReportsController::class, 'previewPdf'])
        ->name('admin.reports.previewPdf');

    Route::get('/api/report/{id}', [ReportsController::class, 'apiShow'])
        ->name('admin.reports.api');

    Route::get('/report/{id}/edit', [ReportsController::class, 'edit'])
        ->name('admin.reports.edit');

    Route::put('/report/{id}', [ReportsController::class, 'update'])
        ->name('admin.reports.update');

    Route::delete('/report/{id}', [ReportsController::class, 'destroy'])
        ->name('admin.reports.destroy');

    Route::get('/report/{id}/pdf', [ReportsController::class, 'pdf'])
        ->name('admin.reports.pdf');
});

/* Manual */
Route::get('/admin/manual', fn() => view('admin.manual'));


/* ===== FORMULARIOS ===== */
Route::prefix('admin')->group(function () {

    Route::get('/forms', [FormController::class, 'index'])
        ->name('admin.forms'); // Listado

    Route::get('/forms/export', [FormController::class, 'export'])
        ->name('admin.forms.export'); // Exportar datos

    Route::get('/forms/export/pdf', [FormController::class, 'exportPdf'])
        ->name('admin.forms.export.pdf'); // Exportar PDF

    Route::get('/forms/{id}', [FormController::class, 'show'])
        ->name('admin.forms.show'); // Ver detalle

    Route::delete('/forms/{id}', [FormController::class, 'destroy'])
        ->name('admin.forms.destroy'); // Eliminar
});


/* ===== CONFIGURACIÓN ===== */
Route::prefix('admin')->group(function () {

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('admin.settings'); // Vista ajustes

    Route::post('/settings/change-password',
        [SettingsController::class, 'changePassword'])
        ->name('admin.settings.change-password'); // Cambiar contraseña

    Route::post('/settings/update-profile',
        [SettingsController::class, 'updateProfile'])
        ->name('admin.settings.update-profile'); // Actualizar perfil
});


/* ===== USUARIOS ===== */
Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users'); // Listar

Route::post('/admin/users', [UserController::class, 'store'])
    ->name('admin.users.store'); // Crear

Route::get('/admin/users/{id}', [UserController::class, 'show'])
    ->name('admin.users.show'); // Obtener

Route::put('/admin/users/{id}', [UserController::class, 'update'])
    ->name('admin.users.update'); // Actualizar

Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
    ->name('admin.users.destroy'); // Eliminar


/* ===== EDICIÓN DE PÁGINAS ===== */
Route::get('/admin/pages/home/edit',
    fn() => view('admin.pages.home_edit'))
    ->name('admin.pages.home.edit'); // Editar inicio

Route::get('/admin/pages/about/edit',
    fn() => view('admin.pages.about_edit'))
    ->name('admin.pages.about.edit'); // Editar nosotros

Route::get('/admin/pages/contact/edit',
    fn() => view('admin.pages.contact_edit'))
    ->name('admin.pages.contact.edit'); // Editar contacto