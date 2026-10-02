<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEntrenamientoRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'lugar' => 'required|string|max:255',
            'material' => 'nullable|string',
            'notas' => 'nullable|string',
        ];
    }
}
