<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\EntrenamientoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\JugadorNotasController;
use App\Http\Controllers\PartidoController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/olvide-password', [PasswordResetController::class, 'enviarCodigo']);
Route::post('/restablecer-password', [PasswordResetController::class, 'restablecer']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => new UserResource($request->user()));
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/cambiar-password', [AuthController::class, 'cambiarPassword']);

    Route::apiResource('partidos', PartidoController::class);
    Route::apiResource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador']);
    Route::put('/jugadores/{jugador}/readaptacion', [JugadorNotasController::class, 'readaptacion']);
    Route::put('/jugadores/{jugador}/observaciones', [JugadorNotasController::class, 'observaciones']);

    Route::get('/partidos/{partido}/convocatoria', [ConvocatoriaController::class, 'index']);
    Route::post('/partidos/{partido}/convocatoria', [ConvocatoriaController::class, 'store']);

    Route::get('/partidos/{partido}/eventos', [EventoController::class, 'index']);
    Route::post('/partidos/{partido}/eventos', [EventoController::class, 'store']);
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy']);

    Route::apiResource('entrenamientos', EntrenamientoController::class);
    Route::put('/entrenamientos/{entrenamiento}/material', [EntrenamientoController::class, 'editarMaterial']);
    Route::get('/entrenamientos/{entrenamiento}/asistencias', [AsistenciaController::class, 'index']);
    Route::post('/entrenamientos/{entrenamiento}/asistencias', [AsistenciaController::class, 'store']);
});

require __DIR__ . '/plan_sesion.php';

require __DIR__ . '/carga.php';
