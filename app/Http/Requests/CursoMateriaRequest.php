<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CursoMateriaRequest extends FormRequest
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
        $cursoMateriaId = $this->route('curso_materia') ? $this->route('curso_materia')->id : null;

        return [
            'curso_id' => ['required', 'exists:cursos,id'],
            'materia_id' => [
                'required',
                'exists:materias,id',
                Rule::unique('curso_materia')
                    ->where('curso_id', $this->curso_id)
                    ->where('periodo_academico_id', $this->periodo_academico_id)
                    ->ignore($cursoMateriaId)
            ],
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'horas_semanales' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'curso_id' => 'curso',
            'materia_id' => 'materia',
            'periodo_academico_id' => 'período académico',
            'horas_semanales' => 'horas semanales',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'materia_id.unique' => 'Esta materia ya está asignada a este curso en el período seleccionado.',
            'horas_semanales.min' => 'Las horas semanales deben ser al menos 1.',
            'horas_semanales.max' => 'Las horas semanales no pueden exceder 10.',
        ];
    }
}
