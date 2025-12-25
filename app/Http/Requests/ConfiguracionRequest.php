<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfiguracionRequest extends FormRequest
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
            // Configuración Académica
            'periodo_actual_id' => ['nullable', 'exists:periodos_academicos,id'],
            'numero_quimestres' => ['nullable', 'integer', 'min:1', 'max:4'],
            'numero_parciales' => ['nullable', 'integer', 'min:1', 'max:6'],
            'fecha_inicio_clases' => ['nullable', 'date'],
            'fecha_fin_clases' => ['nullable', 'date', 'after:fecha_inicio_clases'],
            'fecha_inicio_q1' => ['nullable', 'date'],
            'fecha_fin_q1' => ['nullable', 'date', 'after:fecha_inicio_q1'],
            'fecha_inicio_q2' => ['nullable', 'date'],
            'fecha_fin_q2' => ['nullable', 'date', 'after:fecha_inicio_q2'],
            'porcentaje_minimo_asistencia' => ['nullable', 'numeric', 'min:0', 'max:100'],

            // Configuración Calificaciones
            'calificacion_minima' => ['nullable', 'numeric', 'min:0'],
            'calificacion_maxima' => ['nullable', 'numeric', 'min:0'],
            'nota_minima_aprobacion' => ['nullable', 'numeric', 'min:0'],
            'decimales' => ['nullable', 'integer', 'min:0', 'max:4'],
            'ponderacion_examen' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'ponderacion_parciales' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'permitir_supletorio' => ['nullable', 'boolean'],
            'permitir_remedial' => ['nullable', 'boolean'],
            'permitir_gracia' => ['nullable', 'boolean'],
            'redondear_calificaciones' => ['nullable', 'boolean'],

            // Configuración Horarios
            'duracion_periodo' => ['nullable', 'integer', 'min:15', 'max:120'],
            'duracion_recreo' => ['nullable', 'integer', 'min:5', 'max:60'],
            'periodos_por_dia' => ['nullable', 'integer', 'min:1', 'max:12'],
            'dias_laborales' => ['nullable', 'array'],
            'dias_laborales.*' => ['string'],

            // Configuración Correo
            'smtp_host' => ['nullable', 'string', 'max:255'],
            'smtp_port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'smtp_encriptacion' => ['nullable', 'in:TLS,SSL'],
            'smtp_usuario' => ['nullable', 'string', 'max:255'],
            'smtp_password' => ['nullable', 'string', 'max:255'],
            'remitente_nombre' => ['nullable', 'string', 'max:255'],
            'remitente_email' => ['nullable', 'email', 'max:255'],
            'notificar_calificaciones' => ['nullable', 'boolean'],
            'notificar_asistencia' => ['nullable', 'boolean'],
            'notificar_eventos' => ['nullable', 'boolean'],
            'resumen_semanal_padres' => ['nullable', 'boolean'],
            'resumen_mensual_docentes' => ['nullable', 'boolean'],
            'plantilla_correo' => ['nullable', 'string'],
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
            'periodo_actual_id.exists' => 'El periodo académico seleccionado no existe.',
            'numero_quimestres.min' => 'Debe haber al menos 1 quimestre.',
            'numero_parciales.min' => 'Debe haber al menos 1 parcial.',
            'fecha_fin_clases.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'fecha_fin_q1.after' => 'La fecha de fin del Q1 debe ser posterior a su inicio.',
            'fecha_fin_q2.after' => 'La fecha de fin del Q2 debe ser posterior a su inicio.',
            'porcentaje_minimo_asistencia.max' => 'El porcentaje no puede superar el 100%.',
            'calificacion_maxima.min' => 'La calificación máxima debe ser mayor que 0.',
            'ponderacion_examen.max' => 'La ponderación no puede superar el 100%.',
            'ponderacion_parciales.max' => 'La ponderación no puede superar el 100%.',
            'duracion_periodo.min' => 'El periodo debe durar al menos 15 minutos.',
            'duracion_recreo.min' => 'El recreo debe durar al menos 5 minutos.',
            'smtp_port.min' => 'El puerto debe ser un número válido.',
            'smtp_encriptacion.in' => 'La encriptación debe ser TLS o SSL.',
            'remitente_email.email' => 'El correo del remitente debe ser válido.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Manejar dias_laborales
        if ($this->has('dias_laborales') && is_array($this->dias_laborales)) {
            $this->merge([
                'dias_laborales' => $this->dias_laborales,
            ]);
        } else {
            $this->merge([
                'dias_laborales' => [],
            ]);
        }

        // Manejar checkboxes booleanos (si no están marcados, no se envían)
        // Los checkboxes no marcados deben establecerse como false
        $booleanFields = [
            'permitir_supletorio',
            'permitir_remedial',
            'permitir_gracia',
            'redondear_calificaciones',
            'notificar_calificaciones',
            'notificar_asistencia',
            'notificar_eventos',
            'resumen_semanal_padres',
            'resumen_mensual_docentes',
        ];

        $booleanData = [];
        foreach ($booleanFields as $field) {
            $booleanData[$field] = $this->has($field) ? true : false;
        }

        $this->merge($booleanData);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que la suma de ponderaciones sea 100%
            if ($this->filled(['ponderacion_examen', 'ponderacion_parciales'])) {
                $suma = $this->ponderacion_examen + $this->ponderacion_parciales;
                if ($suma != 100) {
                    $validator->errors()->add('ponderacion_examen', 'La suma de las ponderaciones debe ser 100%.');
                }
            }
        });
    }
}
