<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocenteRequest extends FormRequest
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
        $docenteId = $this->route('docente')?->id;
        $userId = $this->route('docente')?->user_id;

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
            'codigo_docente' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('docentes', 'codigo_docente')->ignore($docenteId),
            ],
            'titulo_profesional' => ['nullable', 'string', 'max:255'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'fecha_ingreso' => ['nullable', 'date'],
            'tipo_contrato' => ['nullable', 'in:nombramiento,contrato'],
            'estado' => ['required', 'in:activo,inactivo,licencia'],
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
            'codigo_docente.max' => 'El código no puede tener más de 20 caracteres',
            'codigo_docente.unique' => 'Este código de docente ya está registrado',
            'titulo_profesional.max' => 'El título no puede tener más de 255 caracteres',
            'especialidad.max' => 'La especialidad no puede tener más de 100 caracteres',
            'fecha_ingreso.date' => 'La fecha de ingreso no es válida',
            'tipo_contrato.in' => 'El tipo de contrato debe ser nombramiento o contrato',
            'estado.required' => 'El estado es obligatorio',
            'estado.in' => 'El estado debe ser activo, inactivo o licencia',
        ];
    }
}
