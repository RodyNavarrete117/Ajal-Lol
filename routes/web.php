<?php

use Illuminate\Support\Facades\Route;

/* Página principal */
Route::get('/', function () {
    return view('index');
});

/* Login (solo vista) */
Route::get('/login', function () {
    return view('login');
})->name('login');

/*Vistas del usuario en la parte administrativa*/
Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin', fn () => view('admin.admin'));

Route::get('/admin/page', fn () => view('admin.page'));
Route::get('/admin/report', fn () => view('admin.reports'));
Route::get('/admin/manual', fn () => view('admin.manual'));
Route::get('/admin/users', fn () => view('admin.users'));
Route::get('/admin/forms', fn () => view('admin.forms'));
Route::get('/admin/settings', fn () => view('admin.settings'));

