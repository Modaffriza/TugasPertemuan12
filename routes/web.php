<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\UserController;

// Terapkan middleware pada route 'restricted'
Route::get('restricted', function () {
    return redirect()->route('dashboard')->withSuccess("Anda berusia lebih dari 18 tahun!");
})->middleware('checkage');

// Ubah route index dengan menambahkan nama routingnya
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::resource('users', UserController::class);




Route::controller (LoginRegisterController::class)->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');


} );




