<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SendEmailController;


Route::get('/send-email', [SendEmailController::class,'index'])->name ('kirim-email');

// Terapkan middleware pada route 'restricted'
Route::get('restricted', function () {
    return redirect()->route('dashboard')->with('success', 'Anda berusia lebih dari 18 tahun!');
})->middleware('checkage');


Route::post('/post-email', [SendEmailController::class, 'store'])->name ('post-email');


// Ubah route index dengan menambahkan nama routingnya
Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::resource('users', UserController::class);
Route::resource('gallery', GalleryController::class);
Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
Route::put('/gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');




Route::controller (LoginRegisterController::class)->group(function(){
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');


} );




