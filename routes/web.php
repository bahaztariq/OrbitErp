<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login',[LoginController::class , 'create']);
Route::post('/login',[LoginController::class , 'store']);
// Register
Route::get('/Register',[RegisterController::class , 'create']);
Route::post('/Register',[RegisterController::class , 'store']);