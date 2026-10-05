<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConvocatoriaRequest;
use App\Http\Resources\ConvocatoriaResource;
use App\Models\Partido;
use Illuminate\Support\Facades\DB;

class ConvocatoriaController extends Controller
{
    public function index(Partido $partido)
    {
        return ConvocatoriaResource::collection($partido->convocatorias()->with('jugador')->get());
    }

    public function store(StoreConvocatoriaRequest $request, Partido $partido)
    {
        $this->authorize('gestionarConvocatoria', $partido);

        // Una vez empezado el partido, la convocatoria queda cerrada: las salidas durante el juego se
        // apuntan como cambios. Solo se deja crearla si el partido todavía no tenía ninguna.
        abort_unless(
            $partido->estado === 'pendiente' || ! $partido->convocatorias()->exists(),
            422,
            'La convocatoria ya no se puede cambiar: el partido ha empezado.'
        );

        // Todo o nada: si algo falla a mitad, se conserva la convocatoria anterior.
        DB::transaction(function () use ($request, $partido) {
            $partido->convocatorias()->delete();

            foreach ($request->validated('jugadores') as $j) {
                $partido->convocatorias()->create([
                    'jugador_id' => $j['jugador_id'],
                    'titular' => $j['titular'],
                    'capitan' => $j['capitan'] ?? false,
                ]);
            }
        });

        return ConvocatoriaResource::collection($partido->convocatorias()->with('jugador')->get());
    }
}
