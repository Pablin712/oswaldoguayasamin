<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParaleloRequest extends FormRequest
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
        $paraleloId = $this->route('paralelo')?->id;

        return [
            'curso_id' => ['required', 'exists:cursos,id'],
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'nombre' => [
                'required',
                'string',
                'max:10',
                Rule::unique('paralelos')
                    ->where('curso_id', $this->curso_id)
                    ->where('periodo_academico_id', $this->periodo_academico_id)
                    ->ignore($paraleloId)
            ],
            'aula_id' => ['nullable', 'exists:aulas,id'],
            'cupo_maximo' => ['required', 'integer', 'min:1', 'max:50'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'curso_id' => 'curso',
            'periodo_academico_id' => 'período académico',
            'nombre' => 'nombre del paralelo',
            'aula_id' => 'aula',
            'cupo_maximo' => 'cupo máximo',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ya existe un paralelo con este nombre para el curso y período académico seleccionados.',
            'cupo_maximo.min' => 'El cupo máximo debe ser al menos 1 estudiante.',
            'cupo_maximo.max' => 'El cupo máximo no puede ser mayor a 50 estudiantes.',
        ];
    }
}
