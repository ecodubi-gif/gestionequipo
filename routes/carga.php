<?php

use App\Http\Controllers\CargaController;
use Illuminate\Support\Facades\Route;

// Carga de entrenamiento / RPE (se carga desde routes/api.php, así que lleva el prefijo /api).
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/entrenamientos/{entrenamiento}/carga', [CargaController::class, 'actualizarCarga']);
    Route::get('/partidos/{partido}/rpe', [CargaController::class, 'rpePartido']);
    Route::put('/partidos/{partido}/rpe', [CargaController::class, 'guardarRpePartido']);
    Route::get('/carga/semanas', [CargaController::class, 'semanas']);
});
