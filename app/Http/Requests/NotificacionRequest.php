<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacionRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'usuarios' => 'nullable|array',
            'usuarios.*' => 'exists:users,id',
            'tipo' => 'required|string|max:50',
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string|max:1000',
            'url' => 'nullable|url|max:255',
            'enviar_email' => 'nullable|boolean',
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
            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.exists' => 'El usuario seleccionado no existe.',
            'usuarios.array' => 'Los usuarios deben ser un conjunto válido.',
            'usuarios.*.exists' => 'Uno o más usuarios seleccionados no existen.',
            'tipo.required' => 'El tipo de notificación es obligatorio.',
            'tipo.max' => 'El tipo no debe exceder los 50 caracteres.',
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.max' => 'El mensaje no debe exceder los 1000 caracteres.',
            'url.url' => 'La URL debe ser una dirección válida.',
            'url.max' => 'La URL no debe exceder los 255 caracteres.',
            'enviar_email.boolean' => 'El campo "enviar email" debe ser verdadero o falso.',
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
            'user_id' => 'usuario',
            'usuarios' => 'usuarios',
            'tipo' => 'tipo',
            'titulo' => 'título',
            'mensaje' => 'mensaje',
            'url' => 'URL',
            'enviar_email' => 'enviar email',
        ];
    }
}
