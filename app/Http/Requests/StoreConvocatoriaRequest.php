<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConvocatoriaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'jugadores' => 'required|array|max:40',
            'jugadores.*.jugador_id' => 'required|distinct|exists:jugadores,id',
            'jugadores.*.titular' => 'required|boolean',
            'jugadores.*.capitan' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'jugadores.required' => 'Falta la lista de jugadores convocados.',
            'jugadores.*.jugador_id.distinct' => 'Un jugador no puede estar dos veces en la convocatoria.',
            'jugadores.*.jugador_id.exists' => 'Hay un jugador de la lista que no existe.',
        ];
    }

    // Reglas que dependen de varios jugadores a la vez: un solo capitán, y que sea titular.
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $verdadero = fn ($valor) => filter_var($valor, FILTER_VALIDATE_BOOLEAN);

            $capitanes = collect($this->input('jugadores', []))
                ->filter(fn ($j) => is_array($j) && $verdadero($j['capitan'] ?? false))
                ->values();

            if ($capitanes->count() > 1) {
                $validator->errors()->add('jugadores', 'Solo puede haber un capitán.');
            } elseif ($capitanes->count() === 1 && ! $verdadero($capitanes[0]['titular'] ?? false)) {
                $validator->errors()->add('jugadores', 'El capitán tiene que ser titular.');
            }
        });
    }
}
