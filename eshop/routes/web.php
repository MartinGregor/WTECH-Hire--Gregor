<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ShowGameController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/home', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/home', [LoginController::class, 'login']);

Route::get('/games', [ShowGameController::class, 'index'])->name('game.index');

//Route::get('/', function () {
//    return view('home');
//});

Route::resource('/', ShowGameController::class);

