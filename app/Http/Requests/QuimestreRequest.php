<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuimestreRequest extends FormRequest
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
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'nombre' => ['required', 'string', 'max:100'],
            'numero' => ['required', 'integer', 'min:1'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
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
            'nombre.required' => 'El nombre del quimestre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'numero.required' => 'El número del quimestre es obligatorio.',
            'numero.integer' => 'El número debe ser un valor entero.',
            'numero.min' => 'El número debe ser al menos 1.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
        ];
    }
}
