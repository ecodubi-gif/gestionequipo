<?php

use App\Http\Controllers\BibliotecaTareaController;
use Illuminate\Support\Facades\Route;

// Biblioteca de tareas (se carga desde routes/api.php, así que lleva el prefijo /api).
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/biblioteca-tareas', [BibliotecaTareaController::class, 'index']);
    Route::post('/biblioteca-tareas', [BibliotecaTareaController::class, 'store']);
    Route::put('/biblioteca-tareas/{tarea}', [BibliotecaTareaController::class, 'update']);
    Route::delete('/biblioteca-tareas/{tarea}', [BibliotecaTareaController::class, 'destroy']);
});
