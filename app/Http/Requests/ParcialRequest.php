<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParcialRequest extends FormRequest
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
            'quimestre_id' => 'required|exists:quimestres,id',
            'nombre' => 'required|string|max:100',
            'numero' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'permite_edicion' => 'required|boolean',
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
            'quimestre_id.required' => 'El quimestre es obligatorio.',
            'quimestre_id.exists' => 'El quimestre seleccionado no es válido.',
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'numero.required' => 'El número es obligatorio.',
            'numero.integer' => 'El número debe ser un valor numérico.',
            'numero.min' => 'El número debe ser al menos 1.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'permite_edicion.required' => 'El campo permite edición es obligatorio.',
            'permite_edicion.boolean' => 'El campo permite edición debe ser verdadero o falso.',
        ];
    }
}
