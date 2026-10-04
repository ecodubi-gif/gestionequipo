<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJugadorRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'posicion_secundaria' => 'nullable|string|max:40',
            'dorsal' => 'nullable|integer',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'apodo' => 'nullable|string|max:255',
            'posicion' => 'nullable|string|max:255',
            'pierna' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
        ];
    }
}
