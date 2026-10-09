<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'actualizado_en' => $this->updated_at ? $this->updated_at->toIso8601String() : null,
            'minuto_final' => $this->minuto_final,
            'id' => $this->id,
            'equipo_local' => $this->equipo_local,
            'equipo_visitante' => $this->equipo_visitante,
            'fecha' => $this->fecha,
            'lugar' => $this->lugar,
            'estado' => $this->estado,
            'goles_local' => $this->goles_local,
            'es_local' => (bool) $this->es_local,
            'lugar_citacion' => $this->lugar_citacion,
            'hora_citacion' => $this->hora_citacion,
            'goles_visitante' => $this->goles_visitante,
            'creado_por' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
        ];
    }
}
