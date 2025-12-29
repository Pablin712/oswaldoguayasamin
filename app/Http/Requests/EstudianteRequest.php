<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstudianteRequest extends FormRequest
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
        $estudianteId = $this->route('estudiante')?->id;
        $userId = $this->route('estudiante')?->user_id;

        return [
            'nombre_completo' => ['required', 'string', 'max:255'],
            'cedula' => [
                'required',
                'string',
                'digits:10',
                Rule::unique('users', 'cedula')->ignore($userId),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'telefono' => ['nullable', 'string', 'max:20'],
            'direccion' => ['nullable', 'string'],
            'fecha_nacimiento' => ['nullable', 'date', 'before:today'],
            'fecha_ingreso' => ['nullable', 'date'],
            'tipo_sangre' => ['nullable', 'string', 'max:5'],
            'alergias' => ['nullable', 'string'],
            'contacto_emergencia' => ['nullable', 'string', 'max:255'],
            'telefono_emergencia' => ['nullable', 'string', 'max:20'],
            'estado' => ['required', 'in:activo,inactivo,retirado'],
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
            'nombre_completo.required' => 'El nombre completo es obligatorio',
            'nombre_completo.max' => 'El nombre no puede tener más de 255 caracteres',
            'cedula.required' => 'La cédula es obligatoria',
            'cedula.digits' => 'La cédula debe tener exactamente 10 dígitos',
            'cedula.unique' => 'Esta cédula ya está registrada',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El formato del correo no es válido',
            'email.unique' => 'Este correo ya está registrado',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres',
            'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'fecha_ingreso.date' => 'La fecha de ingreso no es válida',
            'tipo_sangre.max' => 'El tipo de sangre no puede tener más de 5 caracteres',
            'contacto_emergencia.max' => 'El contacto de emergencia no puede tener más de 255 caracteres',
            'telefono_emergencia.max' => 'El teléfono de emergencia no puede tener más de 20 caracteres',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado debe ser activo, inactivo o retirado',
        ];
    }
}
