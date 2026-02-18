<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorarioRequest extends FormRequest
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
            'paralelo_id' => 'required|exists:paralelos,id',
            'materia_id' => 'required|exists:materias,id',
            'docente_id' => 'required|exists:docentes,id',
            'aula_id' => 'nullable|exists:aulas,id',
            'periodo_academico_id' => 'required|exists:periodo_academicos,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
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
            'paralelo_id.required' => 'El paralelo es obligatorio.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'materia_id.required' => 'La materia es obligatoria.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'docente_id.required' => 'El docente es obligatorio.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'aula_id.exists' => 'El aula seleccionada no existe.',
            'periodo_academico_id.required' => 'El periodo académico es obligatorio.',
            'periodo_academico_id.exists' => 'El periodo académico seleccionado no existe.',
            'dia_semana.required' => 'El día de la semana es obligatorio.',
            'dia_semana.in' => 'El día de la semana debe ser: Lunes, Martes, Miércoles, Jueves, Viernes o Sábado.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'La hora de fin es obligatoria.',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
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
            'paralelo_id' => 'paralelo',
            'materia_id' => 'materia',
            'docente_id' => 'docente',
            'aula_id' => 'aula',
            'periodo_academico_id' => 'periodo académico',
            'dia_semana' => 'día de la semana',
            'hora_inicio' => 'hora de inicio',
            'hora_fin' => 'hora de fin',
        ];
    }
}
