<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Obtener la institución actual (singleton)
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $institucion = \App\Models\Institucion::first();
            if ($institucion) {
                $this->merge(['institucion_id' => $institucion->id]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Obtener el ID de la institución que se está editando (viene del prepareForValidation)
        $institucionId = $this->input('institucion_id');

        return [
            'institucion_id' => ['sometimes', 'exists:instituciones,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'codigo_amie' => ['required', 'string', 'max:20', 'unique:instituciones,codigo_amie,' . $institucionId],
            'tipo' => ['required', 'in:Fiscal,Fiscomisional,Municipal,Particular'],
            'nivel' => ['required', 'string', 'max:255'],
            'jornada' => ['required', 'in:Matutina,Vespertina,Nocturna,Ambas'],
            'provincia' => ['required', 'string', 'max:100'],
            'ciudad' => ['required', 'string', 'max:100'],
            'canton' => ['nullable', 'string', 'max:100'],
            'parroquia' => ['nullable', 'string', 'max:100'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:100'],
            'sitio_web' => ['nullable', 'url', 'max:255'],
            'rector' => ['nullable', 'string', 'max:200'],
            'vicerrector' => ['nullable', 'string', 'max:200'],
            'inspector' => ['nullable', 'string', 'max:200'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
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
            'nombre.required' => 'El nombre de la institución es obligatorio.',
            'codigo_amie.required' => 'El código AMIE es obligatorio.',
            'codigo_amie.unique' => 'Este código AMIE ya está registrado.',
            'tipo.required' => 'El tipo de institución es obligatorio.',
            'tipo.in' => 'El tipo de institución debe ser: Fiscal, Fiscomisional, Municipal o Particular.',
            'nivel.required' => 'El nivel educativo es obligatorio.',
            'jornada.required' => 'La jornada es obligatoria.',
            'jornada.in' => 'La jornada debe ser: Matutina, Vespertina, Nocturna o Ambas.',
            'provincia.required' => 'La provincia es obligatoria.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'direccion.required' => 'La dirección es obligatoria.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'sitio_web.url' => 'El sitio web debe ser una URL válida.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'El logo debe ser formato: jpg, jpeg o png.',
            'logo.max' => 'El logo no debe superar los 2MB.',
        ];
    }
}
