<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'equipo' => $this->equipo,
            'minuto' => $this->minuto,
            'parte' => $this->parte,
            'resultado' => $this->resultado,
            'jugador' => $this->jugador?->nombre,
            'jugador_sale' => $this->jugadorSale?->nombre,
            'jugador_entra' => $this->jugadorEntra?->nombre,
        ];
    }
}
