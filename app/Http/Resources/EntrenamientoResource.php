<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntrenamientoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'tipo_sesion' => $this->tipo_sesion,
            'bloques' => $this->bloques ? json_decode($this->bloques, true) : null,
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
