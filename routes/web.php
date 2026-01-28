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

/*Vistas del administrador en la parte administrativa*/
Route::get('/admin', function () {
    return view('admin.home');
});

Route::get('/admin/home', fn () => view('admin.home'));

Route::get('/admin/page', fn () => view('admin.page'));
Route::get('/admin/report', fn () => view('admin.reports'));
Route::get('/admin/manual', fn () => view('admin.manual'));
Route::get('/admin/users', fn () => view('admin.users'));
Route::get('/admin/forms', fn () => view('admin.forms'));
Route::get('/admin/settings', fn () => view('admin.settings'));

/*Vistas del usuario limitado en uso*/
/* Vistas del usuario */
Route::get('/user', function () {
    return view('user.home');
});

Route::get('/user/home', fn () => view('user.home'));

Route::get('/user/page', fn () => view('user.page'));
Route::get('/user/report', fn () => view('user.reports'));
Route::get('/user/manual', fn () => view('user.manual'));
Route::get('/user/forms', fn () => view('user.forms'));
Route::get('/user/settings', fn () => view('user.settings'));



