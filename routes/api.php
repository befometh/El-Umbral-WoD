<?php
use App\Http\Controllers\Api\ClanController;
use App\Http\Controllers\Api\HabilidadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Ruta por defecto
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Rutas creadas para el proyecto Umbral-Wod
Route::get('/clanes', [ClanController::class, 'index']);
Route::get('/clanes/{id}', [ClanController::class, 'show']);

Route::get('/habilidades', [HabilidadController::class, 'index']);
Route::get('/habilidades/{id}', [HabilidadController::class, 'show']);
Route::get('/habilidades/tipo/{id}', [HabilidadController::class, 'porTipo']);
