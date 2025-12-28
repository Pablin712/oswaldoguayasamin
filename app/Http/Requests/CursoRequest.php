<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'nivel' => ['required', Rule::in(['basica', 'bachillerato'])],
            'orden' => 'required|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nivel.required' => 'El nivel es obligatorio.',
            'nivel.in' => 'El nivel debe ser básica o bachillerato.',
            'orden.required' => 'El orden es obligatorio.',
            'orden.integer' => 'El orden debe ser un valor numérico.',
            'orden.min' => 'El orden debe ser al menos 1.',
        ];
    }
}
