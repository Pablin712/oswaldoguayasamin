<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalificacionRequest extends FormRequest
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
            'matricula_id' => 'required|exists:matriculas,id',
            'curso_materia_id' => 'required|exists:curso_materia,id',
            'parcial_id' => 'required|exists:parciales,id',
            'docente_id' => 'required|exists:docentes,id',
            'nota_final' => 'nullable|numeric|min:0|max:10',
            'observaciones' => 'nullable|string|max:1000',
            'fecha_registro' => 'nullable|date',
            'estado' => 'nullable|in:registrada,modificada,aprobada,publicada',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'matricula_id' => 'matrícula',
            'curso_materia_id' => 'materia del curso',
            'parcial_id' => 'parcial',
            'docente_id' => 'docente',
            'nota_final' => 'nota final',
            'observaciones' => 'observaciones',
            'fecha_registro' => 'fecha de registro',
            'estado' => 'estado',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'matricula_id.required' => 'La matrícula es obligatoria.',
            'matricula_id.exists' => 'La matrícula seleccionada no existe.',
            'curso_materia_id.required' => 'La materia del curso es obligatoria.',
            'curso_materia_id.exists' => 'La materia del curso seleccionada no existe.',
            'parcial_id.required' => 'El parcial es obligatorio.',
            'parcial_id.exists' => 'El parcial seleccionado no existe.',
            'docente_id.required' => 'El docente es obligatorio.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'nota_final.numeric' => 'La nota final debe ser un número.',
            'nota_final.min' => 'La nota final debe ser mayor o igual a 0.',
            'nota_final.max' => 'La nota final debe ser menor o igual a 10.',
            'estado.in' => 'El estado debe ser: registrada, modificada, aprobada o publicada.',
        ];
    }
}
