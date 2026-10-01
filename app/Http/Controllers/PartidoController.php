<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartidoRequest;
use App\Http\Requests\UpdatePartidoRequest;
use App\Http\Resources\PartidoResource;
use App\Models\Partido;

class PartidoController extends Controller
{
    public function index()
    {
        $partidos = Partido::with('user:id,name,email,role')->orderBy('fecha', 'desc')->get();
        return PartidoResource::collection($partidos);
    }

    public function store(StorePartidoRequest $request)
    {
        $this->authorize('create', Partido::class);
        $partido = $request->user()->partidos()->create($request->validated());
        return new PartidoResource($partido);
    }

    public function show(Partido $partido)
    {
        $this->authorize('view', $partido);
        $partido->load('user:id,name,email,role');
        return new PartidoResource($partido);
    }

    public function update(UpdatePartidoRequest $request, Partido $partido)
    {
        $this->authorize('update', $partido);
        $partido->update($request->validated());
        return new PartidoResource($partido);
    }

    public function destroy(Partido $partido)
    {
        $this->authorize('delete', $partido);
        $partido->delete();
        return response()->json(['message' => 'Partido eliminado correctamente']);
    }
}
