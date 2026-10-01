<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJugadorRequest;
use App\Http\Requests\UpdateJugadorRequest;
use App\Http\Resources\JugadorResource;
use App\Models\Jugador;

class JugadorController extends Controller
{
    public function index()
    {
        return JugadorResource::collection(Jugador::orderBy('dorsal')->get());
    }

    public function store(StoreJugadorRequest $request)
    {
        $this->authorize('create', Jugador::class);
        $jugador = Jugador::create($request->validated());
        return new JugadorResource($jugador);
    }

    public function show(Jugador $jugador)
    {
        return new JugadorResource($jugador);
    }

    public function update(UpdateJugadorRequest $request, Jugador $jugador)
    {
        $this->authorize('update', $jugador);
        $jugador->update($request->validated());
        return new JugadorResource($jugador);
    }

    public function destroy(Jugador $jugador)
    {
        $this->authorize('delete', $jugador);
        $jugador->delete();
        return response()->json(['message' => 'Jugador eliminado']);
    }
}
