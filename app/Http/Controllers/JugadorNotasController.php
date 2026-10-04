<?php

namespace App\Http\Controllers;

use App\Http\Resources\JugadorResource;
use App\Models\Jugador;
use Illuminate\Http\Request;

class JugadorNotasController extends Controller
{
    public function readaptacion(Request $request, Jugador $jugador)
    {
        $this->authorize('editarReadaptacion', $jugador);
        $request->validate(['readaptacion' => 'nullable|string|max:500']);

        $jugador->readaptacion = $request->input('readaptacion');
        $jugador->save();

        return new JugadorResource($jugador);
    }

    public function observaciones(Request $request, Jugador $jugador)
    {
        $this->authorize('editarObservaciones', $jugador);
        $request->validate(['observaciones' => 'nullable|string|max:500']);

        $jugador->observaciones = $request->input('observaciones');
        $jugador->save();

        return new JugadorResource($jugador);
    }
}
