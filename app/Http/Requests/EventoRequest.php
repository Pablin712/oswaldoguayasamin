<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
            'periodo_academico_id' => 'required|exists:periodo_academicos,id',
            'tipo' => 'required|in:examen,reunion,actividad,feriado,ceremonia,otro',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:5000',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'nullable|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'ubicacion' => 'nullable|string|max:255',
            'requiere_confirmacion' => 'required|boolean',
            'es_publico' => 'required|boolean',
            'paralelos' => 'nullable|array',
            'paralelos.*' => 'exists:paralelos,id',
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
            'periodo_academico_id.required' => 'El periodo académico es obligatorio.',
            'periodo_academico_id.exists' => 'El periodo académico seleccionado no existe.',
            'tipo.required' => 'El tipo de evento es obligatorio.',
            'tipo.in' => 'El tipo debe ser: examen, reunión, actividad, feriado, ceremonia u otro.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los 5000 caracteres.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
            'ubicacion.max' => 'La ubicación no debe exceder los 255 caracteres.',
            'requiere_confirmacion.required' => 'Debe especificar si requiere confirmación.',
            'requiere_confirmacion.boolean' => 'El campo "requiere confirmación" debe ser verdadero o falso.',
            'es_publico.required' => 'Debe especificar si es público.',
            'es_publico.boolean' => 'El campo "es público" debe ser verdadero o falso.',
            'paralelos.array' => 'Los paralelos deben ser un conjunto válido.',
            'paralelos.*.exists' => 'Uno o más paralelos seleccionados no existen.',
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
            'periodo_academico_id' => 'periodo académico',
            'tipo' => 'tipo',
            'titulo' => 'título',
            'descripcion' => 'descripción',
            'fecha_inicio' => 'fecha de inicio',
            'fecha_fin' => 'fecha de fin',
            'hora_inicio' => 'hora de inicio',
            'hora_fin' => 'hora de fin',
            'ubicacion' => 'ubicación',
            'requiere_confirmacion' => 'requiere confirmación',
            'es_publico' => 'es público',
            'paralelos' => 'paralelos',
        ];
    }
}
