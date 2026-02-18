<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MensajeRequest extends FormRequest
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
            'destinatario_id' => 'nullable|exists:users,id',
            'destinatarios' => 'nullable|array',
            'destinatarios.*' => 'exists:users,id',
            'tipo' => 'nullable|in:individual,masivo,anuncio',
            'asunto' => 'required|string|max:255',
            'cuerpo' => 'required|string|max:10000',
            'programado_para' => 'nullable|date|after_or_equal:now',
            'adjuntos.*' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120', // 5MB max
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
            'destinatario_id.exists' => 'El destinatario seleccionado no existe.',
            'destinatarios.array' => 'Los destinatarios deben ser un conjunto válido.',
            'destinatarios.*.exists' => 'Uno o más destinatarios seleccionados no existen.',
            'tipo.in' => 'El tipo de mensaje debe ser: individual, masivo o anuncio.',
            'asunto.required' => 'El asunto es obligatorio.',
            'asunto.max' => 'El asunto no debe exceder los 255 caracteres.',
            'cuerpo.required' => 'El mensaje es obligatorio.',
            'cuerpo.max' => 'El mensaje no debe exceder los 10000 caracteres.',
            'programado_para.date' => 'La fecha programada debe ser una fecha válida.',
            'programado_para.after_or_equal' => 'La fecha programada debe ser igual o posterior a la fecha actual.',
            'adjuntos.*.file' => 'Cada adjunto debe ser un archivo válido.',
            'adjuntos.*.mimes' => 'Los adjuntos deben ser de tipo: PDF, Word, Excel, imágenes o ZIP.',
            'adjuntos.*.max' => 'Cada adjunto no debe superar los 5MB.',
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
            'destinatario_id' => 'destinatario',
            'destinatarios' => 'destinatarios',
            'tipo' => 'tipo de mensaje',
            'asunto' => 'asunto',
            'cuerpo' => 'mensaje',
            'programado_para' => 'fecha programada',
            'adjuntos.*' => 'adjuntos',
        ];
    }
}
