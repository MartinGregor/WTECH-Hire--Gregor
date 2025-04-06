<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ShowGameController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ShowAdminController;
use App\Http\Controllers\AdminEditController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/games', [ShowGameController::class, 'index'])->name('game.index');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.show');

Route::resource('/', ShowGameController::class);

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'insertToCart'])->name('insert.game.to.cart');
Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.delete');

Route::get('/details', [CartController::class, 'startPayment'])->name('payment.details');
Route::get('/shipping', [CartController::class, 'backToShipping'])->name('payment.shipping.back');
Route::post('/shipping', [CartController::class, 'goToShipping'])->name('payment.shipping');
Route::post('/payment', [CartController::class, 'goToPayment'])->name('payment.payment');

//admin
Route::get('/admin', [ShowAdminController::class, 'index'])->name('admin');
Route::get('/edit/{id}', [AdminEditController::class, 'show'])->name('game.edit');

use App\Http\Controllers\MediaController;
Route::delete('/game/image/{id}', [MediaController::class, 'deleteImage'])->name('game.image.delete');
Route::delete('/game/video/{id}', [MediaController::class, 'deleteVideo'])->name('game.video.delete');
Route::post('/game/logo/{id}', [MediaController::class, 'updateLogo'])->name('game.logo.update');
Route::post('/game/image/{id}', [MediaController::class, 'uploadImage'])->name('game.image.upload');
Route::post('/game/video/{id}', [MediaController::class, 'uploadVideoLink'])->name('game.video.upload');

use App\Http\Controllers\GameInfoController;
Route::delete('/game/{id}', [GameInfoController::class, 'destroy'])->name('game.delete');
Route::put('game/{id}/update', [GameInfoController::class, 'update'])->name('game.update');

Route::post('/admin/add-default-game', [GameInfoController::class, 'storeDefaultGame'])->name('game.store.default');
