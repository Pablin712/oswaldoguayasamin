<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JustificacionRequest extends FormRequest
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
        $rules = [
            'asistencia_id' => 'required|exists:asistencias,id',
            'padre_id' => 'nullable|exists:padres,id',
            'motivo' => 'required|string|max:1000',
            'archivo_adjunto' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'estado' => 'nullable|in:pendiente,aprobada,rechazada',
        ];

        // Si es actualización, el archivo no es requerido
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['archivo_adjunto'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'asistencia_id.required' => 'La asistencia es obligatoria.',
            'asistencia_id.exists' => 'La asistencia seleccionada no existe.',
            'padre_id.exists' => 'El padre/representante seleccionado no existe.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.max' => 'El motivo no debe exceder los 1000 caracteres.',
            'archivo_adjunto.file' => 'El archivo adjunto debe ser un archivo válido.',
            'archivo_adjunto.mimes' => 'El archivo debe ser de tipo: PDF, JPG, JPEG o PNG.',
            'archivo_adjunto.max' => 'El archivo no debe superar los 5MB.',
            'estado.in' => 'El estado debe ser: pendiente, aprobada o rechazada.',
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
            'asistencia_id' => 'asistencia',
            'padre_id' => 'padre/representante',
            'motivo' => 'motivo',
            'archivo_adjunto' => 'archivo adjunto',
            'estado' => 'estado',
        ];
    }
}
