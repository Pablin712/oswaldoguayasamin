<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaRequest extends FormRequest
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
        $materiaId = $this->route('materia') ? $this->route('materia')->id : null;

        return [
            'codigo' => 'required|string|max:20|unique:materias,codigo,' . $materiaId,
            'nombre' => 'required|string|max:100',
            'area_id' => 'required|exists:areas,id',
            'color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
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
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'El código ya está en uso.',
            'codigo.max' => 'El código no debe exceder los 20 caracteres.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'area_id.required' => 'El área es obligatoria.',
            'area_id.exists' => 'El área seleccionada no es válida.',
            'color.required' => 'El color es obligatorio.',
            'color.regex' => 'El color debe ser un valor hexadecimal válido (ej: #FF5733).',
        ];
    }
}
