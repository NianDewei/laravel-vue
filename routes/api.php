<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Listado API**/
// establecimientos
Route::get('/establecimientos',['App\Http\Controllers\ApiController','establecimientos'])->name('api.establecimientos');
Route::get('/establecimientos/{establecimiento}',['App\Http\Controllers\ApiController','establecimiento'])->name('api.establecimiento');
// categorias -> establecimientos
Route::get('/categorias',['App\Http\Controllers\ApiController','categorys'])->name('api.categorias');
Route::get('/categorias/{categoria}',['App\Http\Controllers\ApiController','category'])->name('api.categoria');

