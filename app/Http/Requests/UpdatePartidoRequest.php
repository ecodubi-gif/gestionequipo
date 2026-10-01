<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartidoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'equipo_local' => 'sometimes|string|max:255',
            'equipo_visitante' => 'sometimes|string|max:255',
            'fecha' => 'sometimes|date',
            'lugar' => 'sometimes|string|max:255',
            'estado' => 'sometimes|in:pendiente,en_curso,finalizado,cancelado',
            'goles_local' => 'nullable|integer|min:0',
            'goles_visitante' => 'nullable|integer|min:0',
        ];
    }
}
