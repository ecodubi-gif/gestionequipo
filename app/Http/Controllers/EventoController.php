<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventoRequest;
use App\Http\Resources\EventoResource;
use App\Models\Evento;
use App\Models\Partido;

class EventoController extends Controller
{
    public function index(Partido $partido)
    {
        return EventoResource::collection($partido->eventos()->orderBy('minuto')->get());
    }

    public function store(StoreEventoRequest $request, Partido $partido)
    {
        $this->authorize('update', $partido);
        $evento = $partido->eventos()->create($request->validated());
        return new EventoResource($evento);
    }

    public function destroy(Evento $evento)
    {
        $this->authorize('update', $evento->partido);
        $evento->delete();
        return response()->json(['message' => 'Evento eliminado']);
    }
}
