<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\EditPageContactController;
use App\Http\Controllers\Admin\EditPageBoardController;
use App\Http\Controllers\Admin\EditPageAlliesController;
use App\Http\Controllers\Admin\EditPageActivitiesController;
use App\Http\Controllers\Admin\ProjectEditController;
use App\Http\Controllers\Admin\FaqEditController;
use App\Http\Controllers\Page\PublicPageController;
use App\Http\Controllers\Page\ServicesController;
use App\Http\Controllers\Page\EventsController;

/* ── Rate limiter para el formulario de contacto ── */
RateLimiter::for('contact', function (Request $request) {
    return Limit::perMinutes(10, 3)->by($request->ip());
});

/* ===== RUTAS PÚBLICAS ===== */
Route::get('/',       [PublicPageController::class, 'home'])->name('home');
Route::get('/pagina', [PublicPageController::class, 'index'])->name('pagina');

Route::post('/contact', [ContactController::class, 'store'])
     ->middleware('throttle:contact')
     ->name('contact.store');

Route::get('/events/{year}', [EventsController::class, 'show'])
     ->name('events.year')
     ->where('year', '[0-9]{4}');

/* ── Actividades públicas por año (AJAX desde services.js) ── */
Route::get('/actividades/ano/{ano}', [ServicesController::class, 'actividadesByAno'])
     ->name('public.actividades.byAno')
     ->where('ano', '[0-9]{4}');

/* Login */
Route::get('/login',  fn() => view('login'))->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/* Loading */
Route::get('/loading', fn() => view('loading'))->name('loading');

/* Logout */
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* Reset de contraseña */
Route::get('/forgot-password',        [PasswordResetController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password',       [PasswordResetController::class, 'sendResetLink'])->name('password.forgot.send');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password',        [PasswordResetController::class, 'resetPassword'])->name('password.reset');

/* ===== RUTAS PROTEGIDAS (requieren sesión) ===== */
Route::middleware(['admin'])->prefix('admin')->group(function () {

    /* ── Home y páginas generales ── */
    Route::get('/home',   [HomeController::class, 'index'])->name('admin.home');
    Route::get('/page',   fn() => view('admin.page'));
    Route::get('/manual', fn() => view('admin.manual'));

    /* ===== INFORMES ===== */
    Route::prefix('report')->group(function () {
        Route::get('/',                    [ReportsController::class, 'index'])->name('admin.reports');
        Route::post('/',                   [ReportsController::class, 'store'])->name('admin.reports.store');
        Route::get('/blank/report',        [ReportsController::class, 'blankReportPdf'])->name('admin.reports.blankReport');
        Route::get('/blank/attendance',    [ReportsController::class, 'blankAttendancePdf'])->name('admin.reports.blankAttendance');
        Route::post('/preview-pdf',        [ReportsController::class, 'previewPdf'])->name('admin.reports.previewPdf');
        Route::get('/{id}',                [ReportsController::class, 'apiShow'])->name('admin.reports.api')->where('id', '[0-9]+');
        Route::get('/{id}/edit',           [ReportsController::class, 'edit'])->name('admin.reports.edit');
        Route::put('/{id}',                [ReportsController::class, 'update'])->name('admin.reports.update');
        Route::delete('/{id}',             [ReportsController::class, 'destroy'])->name('admin.reports.destroy');
        Route::get('/{id}/pdf',            [ReportsController::class, 'pdf'])->name('admin.reports.pdf');
    });

    /* ===== FORMULARIOS ===== */
    Route::prefix('forms')->group(function () {
        Route::get('/',           [FormController::class, 'index'])->name('admin.forms');
        Route::get('/export',     [FormController::class, 'export'])->name('admin.forms.export');
        Route::get('/export/pdf', [FormController::class, 'exportPdf'])->name('admin.forms.export.pdf');
        Route::get('/{id}',       [FormController::class, 'show'])->name('admin.forms.show');
        Route::delete('/{id}',    [FormController::class, 'destroy'])->name('admin.forms.destroy');
    });

    /* ===== CONFIGURACIÓN ===== */
    Route::prefix('settings')->group(function () {
        Route::get('/',                    [SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/change-password',    [SettingsController::class, 'changePassword'])->name('admin.settings.change-password');
        Route::post('/update-profile',     [SettingsController::class, 'updateProfile'])->name('admin.settings.update-profile');
        Route::post('/keep-session',       [SettingsController::class, 'keepSession']);
    });

    /* ===== USUARIOS ===== */
    Route::prefix('users')->group(function () {
        Route::get('/',        [UserController::class, 'index'])->name('admin.users');
        Route::post('/',       [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}',    [UserController::class, 'show'])->name('admin.users.show');
        Route::put('/{id}',    [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    /* ===== EDICIÓN DE PÁGINAS ===== */
    Route::prefix('pages')->group(function () {

        /* Páginas simples */
        Route::get('/home/edit',  fn() => view('admin.pages.home_edit'))->name('admin.pages.home.edit');
        Route::get('/about/edit', fn() => view('admin.pages.about_edit'))->name('admin.pages.about.edit');

        /* ── Actividades ── */
        Route::prefix('activities')->group(function () {
            Route::get('/edit',                [EditPageActivitiesController::class, 'index'])->name('admin.pages.activities.edit');
            Route::get('/ano/{ano}',           [EditPageActivitiesController::class, 'getByAno'])->name('admin.pages.activities.byAno')->where('ano', '[0-9]{4}');
            Route::post('/actividades',        [EditPageActivitiesController::class, 'updateActividades'])->name('admin.pages.activities.actividades');
            Route::patch('/anos/{id}/toggle',  [EditPageActivitiesController::class, 'toggleAno'])->name('admin.pages.activities.toggleAno')->where('id', '[0-9]+');
            Route::delete('/anos/{id}',        [EditPageActivitiesController::class, 'destroyAno'])->name('admin.pages.activities.destroyAno')->where('id', '[0-9]+');
            Route::post('/anos',               [EditPageActivitiesController::class, 'storeAno'])->name('admin.pages.activities.storeAno');
        });

        /* ── Aliados ── */
        Route::get('/allies/edit',   [EditPageAlliesController::class, 'index'])->name('admin.pages.allies.edit');
        Route::put('/allies/update', [EditPageAlliesController::class, 'update'])->name('admin.pages.allies.update');

        /* ── FAQ ── */
        Route::get('/faq/edit',   [FaqEditController::class, 'edit'])->name('admin.pages.faq.edit');
        Route::put('/faq/update', [FaqEditController::class, 'update'])->name('admin.pages.faq.update');

        /* ── Proyectos ── */
        Route::prefix('projects')->group(function () {
            Route::get('/edit',             [ProjectEditController::class, 'index'])->name('admin.pages.projects.edit');
            Route::put('/year-update',      [ProjectEditController::class, 'yearUpdate'])->name('admin.projects.year.update');
            Route::post('/year-store',      [ProjectEditController::class, 'yearStore'])->name('admin.projects.year.store');
            Route::delete('/year-destroy',  [ProjectEditController::class, 'yearDestroy'])->name('admin.projects.year.destroy');
            Route::post('/image',           [ProjectEditController::class, 'imageStore'])->name('admin.projects.image.store');
            Route::post('/image/{id}',      [ProjectEditController::class, 'imageUpdate'])->name('admin.projects.image.update');
            Route::delete('/image/{id}',    [ProjectEditController::class, 'imageDestroy'])->name('admin.projects.image.destroy');
            Route::post('/category',        [ProjectEditController::class, 'categoryStore'])->name('admin.projects.category.store');
            Route::delete('/category/{id}', [ProjectEditController::class, 'categoryDestroy'])->name('admin.projects.category.destroy');
            Route::post('/category-order', [ProjectEditController::class, 'categoryOrder'])->name('admin.projects.category.order');
        });

        /* ── Directiva ── */
        Route::get('/board/edit',   [EditPageBoardController::class, 'index'])->name('admin.pages.board.edit');
        Route::put('/board/update', [EditPageBoardController::class, 'update'])->name('admin.pages.board.update');

        /* ── Contacto ── */
        Route::get('/contact/edit',   [EditPageContactController::class, 'index'])->name('admin.pages.contact.edit');
        Route::put('/contact/update', [EditPageContactController::class, 'update'])->name('admin.pages.contact.update');
    });

    /* ===== NOTIFICACIONES (API) ===== */
    Route::prefix('api/notifications')->group(function () {
        Route::get('count',        [NotificationController::class, 'count']);
        Route::get('list',         [NotificationController::class, 'list']);
        Route::post('read-all',    [NotificationController::class, 'markAllRead']);
        Route::delete('clear-all', [NotificationController::class, 'clearAll']);
        Route::post('{id}/read',   [NotificationController::class, 'markRead']);
    });
});