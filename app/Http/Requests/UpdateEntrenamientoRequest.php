<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEntrenamientoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i',
            'lugar' => 'sometimes|string|max:255',
            'material' => 'nullable|string',
            'notas' => 'nullable|string',
        ];
    }
}
