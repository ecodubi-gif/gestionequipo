<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntrenamientoRequest;
use App\Http\Requests\UpdateEntrenamientoRequest;
use App\Http\Resources\EntrenamientoResource;
use App\Models\Entrenamiento;

class EntrenamientoController extends Controller
{
    public function index()
    {
        $entrenamientos = Entrenamiento::with('user:id,name,email,role')
            ->orderBy('fecha', 'desc')->orderBy('hora', 'desc')->get();

        return EntrenamientoResource::collection($entrenamientos);
    }

    public function store(StoreEntrenamientoRequest $request)
    {
        $this->authorize('create', Entrenamiento::class);

        $entrenamiento = Entrenamiento::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return new EntrenamientoResource($entrenamiento);
    }

    public function show(Entrenamiento $entrenamiento)
    {
        $entrenamiento->load('user:id,name,email,role', 'asistencias.jugador');
        return new EntrenamientoResource($entrenamiento);
    }

    public function update(UpdateEntrenamientoRequest $request, Entrenamiento $entrenamiento)
    {
        $this->authorize('update', $entrenamiento);
        $entrenamiento->update($request->validated());
        return new EntrenamientoResource($entrenamiento);
    }

    public function destroy(Entrenamiento $entrenamiento)
    {
        $this->authorize('delete', $entrenamiento);
        $entrenamiento->delete();
        return response()->json(['message' => 'Entrenamiento eliminado']);
    }
}
