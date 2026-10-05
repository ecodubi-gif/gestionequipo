<?php

use App\Http\Controllers\TareaSesionController;
use Illuminate\Support\Facades\Route;

// Tareas de la sesión (se carga desde routes/api.php, así que lleva el prefijo /api).
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/entrenamientos/{entrenamiento}/tareas', [TareaSesionController::class, 'index']);
    Route::post('/entrenamientos/{entrenamiento}/tareas', [TareaSesionController::class, 'store']);
    Route::put('/tareas/{tarea}', [TareaSesionController::class, 'update']);
    Route::delete('/tareas/{tarea}', [TareaSesionController::class, 'destroy']);
});
