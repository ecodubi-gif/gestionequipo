<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsistenciaRequest;
use App\Http\Resources\AsistenciaResource;
use App\Models\Entrenamiento;

class AsistenciaController extends Controller
{
    public function index(Entrenamiento $entrenamiento)
    {
        return AsistenciaResource::collection(
            $entrenamiento->asistencias()->with('jugador')->get()
        );
    }

    public function store(StoreAsistenciaRequest $request, Entrenamiento $entrenamiento)
    {
        $this->authorize('gestionarAsistencia', $entrenamiento);

        $entrenamiento->asistencias()->delete();

        foreach ($request->validated('asistencias') as $a) {
            $entrenamiento->asistencias()->create([
                'jugador_id' => $a['jugador_id'],
                'estado' => $a['estado'],
                'multa' => $a['multa'] ?? 0,
                'motivo' => $a['motivo'] ?? null,
            ]);
        }

        return AsistenciaResource::collection(
            $entrenamiento->asistencias()->with('jugador')->get()
        );
    }
}
