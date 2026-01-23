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

