<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AulaRequest extends FormRequest
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
            'capacidad' => 'required|integer|min:1',
            'edificio' => 'nullable|string|max:100',
            'piso' => 'nullable|integer|min:1',
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
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.integer' => 'La capacidad debe ser un valor numérico.',
            'capacidad.min' => 'La capacidad debe ser al menos 1.',
            'edificio.max' => 'El edificio no debe exceder los 100 caracteres.',
            'piso.integer' => 'El piso debe ser un valor numérico.',
            'piso.min' => 'El piso debe ser al menos 1.',
        ];
    }
}
