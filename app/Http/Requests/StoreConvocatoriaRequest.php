<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConvocatoriaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'jugadores' => 'required|array',
            'jugadores.*.jugador_id' => 'required|exists:jugadores,id',
            'jugadores.*.titular' => 'required|boolean',
        ];
    }
}
