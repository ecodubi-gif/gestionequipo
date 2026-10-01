<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipo_local' => $this->equipo_local,
            'equipo_visitante' => $this->equipo_visitante,
            'fecha' => $this->fecha,
            'lugar' => $this->lugar,
            'estado' => $this->estado,
            'goles_local' => $this->goles_local,
            'goles_visitante' => $this->goles_visitante,
            'creado_por' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
        ];
    }
}
