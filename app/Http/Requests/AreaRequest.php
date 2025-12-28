<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
        $areaId = $this->route('area') ? $this->route('area')->id : null;

        return [
            'nombre' => 'required|string|max:100|unique:areas,nombre,' . $areaId,
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'required|in:activa,inactiva',
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
            'nombre.unique' => 'El nombre del área ya está en uso.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activa o inactiva.',
        ];
    }
}
