<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\GastoController;
use App\Models\categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

     Route::get('cine',                  [CategoriaController::class, 'index']);
     Route::post('cine',                 [CategoriaController::class, 'store']);



     Route::get('gasto',                  [GastoController::class, 'index']);
     Route::get('gastos',                  [GastoController::class, 'show']);
     Route::post('habitaciones',                 [GastoController::class, 'store']);
     Route::post('reserva',                 [GastoController::class, 'reservarAsientos']);
     