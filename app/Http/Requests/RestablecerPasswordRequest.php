<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestablecerPasswordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'codigo' => 'required|string|size:6',
            'password_nueva' => 'required|string|min:6',
        ];
    }
}
