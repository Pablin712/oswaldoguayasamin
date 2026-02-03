<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComponenteCalificacionRequest extends FormRequest
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
            'calificacion_id' => 'required|exists:calificaciones,id',
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:tarea,leccion,examen,proyecto,trabajo',
            'nota' => 'required|numeric|min:0|max:10',
            'porcentaje' => 'required|numeric|min:0|max:100',
            'descripcion' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'calificacion_id' => 'calificación',
            'nombre' => 'nombre',
            'tipo' => 'tipo',
            'nota' => 'nota',
            'porcentaje' => 'porcentaje',
            'descripcion' => 'descripción',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'calificacion_id.required' => 'La calificación es obligatoria.',
            'calificacion_id.exists' => 'La calificación seleccionada no existe.',
            'nombre.required' => 'El nombre del componente es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'tipo.required' => 'El tipo de componente es obligatorio.',
            'tipo.in' => 'El tipo debe ser: tarea, lección, examen, proyecto o trabajo.',
            'nota.required' => 'La nota es obligatoria.',
            'nota.numeric' => 'La nota debe ser un número.',
            'nota.min' => 'La nota debe ser mayor o igual a 0.',
            'nota.max' => 'La nota debe ser menor o igual a 10.',
            'porcentaje.required' => 'El porcentaje es obligatorio.',
            'porcentaje.numeric' => 'El porcentaje debe ser un número.',
            'porcentaje.min' => 'El porcentaje debe ser mayor o igual a 0.',
            'porcentaje.max' => 'El porcentaje debe ser menor o igual a 100.',
            'descripcion.max' => 'La descripción no puede tener más de 500 caracteres.',
        ];
    }
}
