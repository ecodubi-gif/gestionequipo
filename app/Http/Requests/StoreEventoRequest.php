<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'dorsal_rival' => 'nullable|integer|min:1|max:999',
            'tipo' => 'required|in:tiro,corner,amarilla,roja,falta,cambio',
            'equipo' => 'required|in:local,visitante',
            'minuto' => 'required|integer|min:0',
            'parte' => 'nullable|integer|min:1|max:2',
            'resultado' => 'nullable|string',
            'jugador_id' => 'nullable|exists:jugadores,id',
            'jugador_sale_id' => 'nullable|exists:jugadores,id',
            'jugador_entra_id' => 'nullable|exists:jugadores,id',
        ];
    }
}
