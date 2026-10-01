<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JugadorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'dorsal' => $this->dorsal,
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'apodo' => $this->apodo,
            'posicion' => $this->posicion,
            'pierna' => $this->pierna,
            'estado' => $this->estado,
        ];
    }
}
