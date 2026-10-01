<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJugadorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'dorsal' => 'nullable|integer',
            'nombre' => 'sometimes|required|string|max:255',
            'apellidos' => 'sometimes|required|string|max:255',
            'apodo' => 'nullable|string|max:255',
            'posicion' => 'nullable|string|max:255',
            'pierna' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
        ];
    }
}
