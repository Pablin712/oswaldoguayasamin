<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
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
            'docente_id' => 'nullable|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'paralelo_id' => 'nullable|exists:paralelos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:5000',
            'fecha_asignacion' => 'required|date',
            'fecha_entrega' => 'required|date|after_or_equal:fecha_asignacion',
            'es_calificada' => 'required|boolean',
            'puntaje_maximo' => 'nullable|numeric|min:0|max:100',
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip|max:10240', // 10MB max
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
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'materia_id.required' => 'La materia es obligatoria.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'descripcion.max' => 'La descripción no debe exceder los 5000 caracteres.',
            'fecha_asignacion.required' => 'La fecha de asignación es obligatoria.',
            'fecha_asignacion.date' => 'La fecha de asignación debe ser una fecha válida.',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria.',
            'fecha_entrega.date' => 'La fecha de entrega debe ser una fecha válida.',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser igual o posterior a la fecha de asignación.',
            'es_calificada.required' => 'Debe especificar si la tarea es calificada.',
            'es_calificada.boolean' => 'El campo "es calificada" debe ser verdadero o falso.',
            'puntaje_maximo.numeric' => 'El puntaje máximo debe ser un número.',
            'puntaje_maximo.min' => 'El puntaje máximo debe ser al menos 0.',
            'puntaje_maximo.max' => 'El puntaje máximo no debe exceder 100.',
            'archivos.*.file' => 'Cada archivo debe ser un archivo válido.',
            'archivos.*.mimes' => 'Los archivos deben ser de tipo: PDF, Word, Excel, PowerPoint, imágenes o ZIP.',
            'archivos.*.max' => 'Cada archivo no debe superar los 10MB.',
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
            'docente_id' => 'docente',
            'materia_id' => 'materia',
            'paralelo_id' => 'paralelo',
            'titulo' => 'título',
            'descripcion' => 'descripción',
            'fecha_asignacion' => 'fecha de asignación',
            'fecha_entrega' => 'fecha de entrega',
            'es_calificada' => 'es calificada',
            'puntaje_maximo' => 'puntaje máximo',
            'archivos.*' => 'archivos',
        ];
    }
}
