<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsistenciaRequest extends FormRequest
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
            'estudiante_id' => 'required|exists:estudiantes,id',
            'paralelo_id' => 'required|exists:paralelos,id',
            'materia_id' => 'nullable|exists:materias,id',
            'docente_id' => 'nullable|exists:docentes,id',
            'fecha' => 'required|date',
            'hora' => 'nullable|date_format:H:i',
            'estado' => 'required|in:presente,ausente,atrasado,justificado',
            'observaciones' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'estudiante_id.required' => 'El estudiante es obligatorio.',
            'estudiante_id.exists' => 'El estudiante seleccionado no existe.',
            'paralelo_id.required' => 'El paralelo es obligatorio.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'hora.date_format' => 'La hora debe tener el formato HH:MM.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: presente, ausente, atrasado o justificado.',
            'observaciones.max' => 'Las observaciones no deben exceder los 1000 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'estudiante_id' => 'estudiante',
            'paralelo_id' => 'paralelo',
            'materia_id' => 'materia',
            'docente_id' => 'docente',
            'fecha' => 'fecha',
            'hora' => 'hora',
            'estado' => 'estado',
            'observaciones' => 'observaciones',
        ];
    }
}
