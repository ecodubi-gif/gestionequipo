<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsistenciaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'asistencias' => 'required|array',
            'asistencias.*.jugador_id' => 'required|exists:jugadores,id',
            'asistencias.*.estado' => 'required|in:presente,retraso,falta_justificada,falta_injustificada',
            'asistencias.*.multa' => 'nullable|numeric|min:0',
            'asistencias.*.motivo' => 'nullable|string|max:255',
        ];
    }
}
