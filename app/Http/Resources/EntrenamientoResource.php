<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntrenamientoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'lugar' => $this->lugar,
            'material' => $this->material,
            'notas' => $this->notas,
            'creado_por' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
