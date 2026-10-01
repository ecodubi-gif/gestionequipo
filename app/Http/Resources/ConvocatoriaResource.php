<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConvocatoriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titular' => $this->titular,
            'jugador' => new JugadorResource($this->whenLoaded('jugador')),
        ];
    }
}
