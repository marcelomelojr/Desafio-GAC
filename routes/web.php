<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/init', [App\Http\Controllers\InitController::class, 'index']);
