<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;

/* Página pública */
Route::get('/', fn() => view('index'));

/* Página pública visual */
Route::get('/pagina', fn() => view('visualpage'));

/// Páginas de events por año
// Acepta: 2023, 2024, 2025
Route::get('/events/{year}', function ($year) {

    $yearsAllowed = ['2023', '2024', '2025'];

    if (!in_array($year, $yearsAllowed)) {
        abort(404);
    }

    return view("events.{$year}");

})->name('events.year')
  ->where('year', '202[0-9]'); // Solo años que empiecen con 202
  // Cuando se agregué la base de datos se realizarán cambios o de plano se eliminará estas rutas

/* Login */
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* Pantalla de carga */
Route::get('/loading', fn() => view('loading'))->name('loading');

/* Panel admin */
Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');
Route::get('/admin/page', fn() => view('admin.page'));

/* ===== INFORMES ===== */
Route::prefix('admin')->group(function () {

    Route::get('/report', [ReportsController::class, 'index'])
        ->name('admin.reports');

    Route::post('/report', [ReportsController::class, 'store'])
        ->name('admin.reports.store');

    Route::get('/report/blank/report', [ReportsController::class, 'blankReportPdf'])
        ->name('admin.reports.blankReport');

    Route::get('/report/blank/attendance', [ReportsController::class, 'blankAttendancePdf'])
        ->name('admin.reports.blankAttendance');

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
        ->name('admin.forms');

    Route::get('/forms/export', [FormController::class, 'export'])
        ->name('admin.forms.export');

    Route::get('/forms/export/pdf', [FormController::class, 'exportPdf'])
        ->name('admin.forms.export.pdf');

    Route::get('/forms/{id}', [FormController::class, 'show'])
        ->name('admin.forms.show');

    Route::delete('/forms/{id}', [FormController::class, 'destroy'])
        ->name('admin.forms.destroy');
});

/* ===== CONFIGURACIÓN ===== */
Route::prefix('admin')->group(function () {

    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('admin.settings');

    Route::post('/settings/change-password',
        [SettingsController::class, 'changePassword'])
        ->name('admin.settings.change-password');

    Route::post('/settings/update-profile',
        [SettingsController::class, 'updateProfile'])
        ->name('admin.settings.update-profile');
});

/* ===== USUARIOS ===== */
Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users');

Route::post('/admin/users', [UserController::class, 'store'])
    ->name('admin.users.store');

Route::get('/admin/users/{id}', [UserController::class, 'show'])
    ->name('admin.users.show');

Route::put('/admin/users/{id}', [UserController::class, 'update'])
    ->name('admin.users.update');

Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])
    ->name('admin.users.destroy');

/* ===== EDICIÓN DE PÁGINAS ===== */
Route::prefix('admin/pages')->group(function () {

    Route::get('/home/edit',
        fn() => view('admin.pages.home_edit'))
        ->name('admin.pages.home.edit');

    Route::get('/about/edit',
        fn() => view('admin.pages.about_edit'))
        ->name('admin.pages.about.edit');

    Route::get('/allies/edit',
        fn() => view('admin.pages.allies_edit'))
        ->name('admin.pages.allies.edit');

    Route::get('/activities/edit',
        fn() => view('admin.pages.activities_edit'))
        ->name('admin.pages.activities.edit');

    Route::get('/projects/edit',
        fn() => view('admin.pages.projects_edit'))
        ->name('admin.pages.projects.edit');

    Route::get('/board/edit',
        fn() => view('admin.pages.board_edit'))
        ->name('admin.pages.board.edit');

    Route::get('/faq/edit',
        fn() => view('admin.pages.faq_edit'))
        ->name('admin.pages.faq.edit');

    Route::get('/contact/edit',
        fn() => view('admin.pages.contact_edit'))
        ->name('admin.pages.contact.edit');

});

/* ===== NOTIFICACIONES (API) ===== */
Route::prefix('api/notifications')->group(function () {

    Route::get('count',        [NotificationController::class, 'count']);
    Route::get('list',         [NotificationController::class, 'list']);

    Route::post('read-all',    [NotificationController::class, 'markAllRead']);
    Route::delete('clear-all', [NotificationController::class, 'clearAll']);

    Route::post('{id}/read',   [NotificationController::class, 'markRead']);
});

Route::get('/forgot-password',        [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password',       [PasswordResetController::class, 'sendResetLink'])->name('password.forgot.send');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password',        [PasswordResetController::class, 'resetPassword'])->name('password.reset');