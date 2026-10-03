<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePartidoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'equipo_local' => 'required|string|max:255',
            'equipo_visitante' => 'required|string|max:255',
            'fecha' => 'required|date',
            'lugar' => 'required|string|max:255',
            'es_local' => 'required|boolean',
            'lugar_citacion' => 'nullable|string|max:255',
            'hora_citacion' => 'nullable|date_format:H:i',
        ];
    }
}
