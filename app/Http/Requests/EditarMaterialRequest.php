<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarMaterialRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return ['material' => 'nullable|string'];
    }
}
