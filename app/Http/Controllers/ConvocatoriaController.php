<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConvocatoriaRequest;
use App\Http\Resources\ConvocatoriaResource;
use App\Models\Partido;

class ConvocatoriaController extends Controller
{
    public function index(Partido $partido)
    {
        return ConvocatoriaResource::collection($partido->convocatorias()->with('jugador')->get());
    }

    public function store(StoreConvocatoriaRequest $request, Partido $partido)
    {
        $this->authorize('update', $partido);

        $partido->convocatorias()->delete();

        foreach ($request->validated('jugadores') as $j) {
            $partido->convocatorias()->create([
                'jugador_id' => $j['jugador_id'],
                'titular' => $j['titular'],
                'capitan' => $j['capitan'] ?? false,
            ]);
        }

        return ConvocatoriaResource::collection($partido->convocatorias()->with('jugador')->get());
    }
}
