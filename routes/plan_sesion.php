<?php

use App\Http\Controllers\PlanSesionController;
use Illuminate\Support\Facades\Route;

// Plan de la sesión (se carga desde routes/api.php, así que lleva el prefijo /api).
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/plantillas-entreno', [PlanSesionController::class, 'plantillas']);
    Route::put('/plantillas-entreno/{numero}', [PlanSesionController::class, 'actualizarPlantilla'])->whereNumber('numero');
    Route::put('/plantillas-entreno/{numero}/semana', [PlanSesionController::class, 'actualizarSemana'])->whereNumber('numero');
    Route::put('/entrenamientos/{entrenamiento}/bloques', [PlanSesionController::class, 'actualizarBloques']);
    Route::put('/entrenamientos/{entrenamiento}/tipo-sesion', [PlanSesionController::class, 'actualizarTipo']);
});
