<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AsistenciaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'estado' => $this->estado,
            'multa' => (float) $this->multa,
            'motivo' => $this->motivo,
            'jugador' => new JugadorResource($this->whenLoaded('jugador')),
        ];
    }
}
