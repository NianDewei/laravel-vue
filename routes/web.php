<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', App\Http\Controllers\InicioController::class)->name('home');

Route::fallback(function () {
    return view('inicio.index');
});

Auth::routes(['verify' => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/establecimientos/create', [App\Http\Controllers\EstablecimientoController::class, 'create'])
        ->name('establecimiento.create')->middleware('tiene.establecimiento');
    Route::post('/establecimientos', [App\Http\Controllers\EstablecimientoController::class, 'store'])
        ->name('establecimiento.store');

    Route::get('/establecimientos/edit/{establecimiento}', [App\Http\Controllers\EstablecimientoController::class, 'edit'])
        ->name('establecimiento.edit');

    Route::put('/establecimientos/{establecimiento}', [App\Http\Controllers\EstablecimientoController::class, 'update'])
        ->name('establecimiento.update');

    Route::post('/imagenes/store', [App\Http\Controllers\ImagenController::class, 'store'])->name('imagenes.store');
    Route::post('/imagenes/destroy', [App\Http\Controllers\ImagenController::class, 'destroy'])->name('imagenes.destroy');
});

