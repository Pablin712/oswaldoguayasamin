<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\DocenteMateria;
use App\Models\Horario;
use Illuminate\Support\Facades\DB;

class DocenteMateriaRequest extends FormRequest
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
            'docente_id' => ['required', 'exists:docentes,id'],
            'materia_id' => ['required', 'exists:materias,id'],
            'paralelo_id' => ['required', 'exists:paralelos,id'],
            'periodo_academico_id' => ['required', 'exists:periodos_academicos,id'],
            'rol' => ['nullable', 'in:Principal,Auxiliar,Practicante,Suplente,Co-teaching'],
            'horarios' => ['required', 'array', 'min:1'],
            'horarios.*.dia_semana' => ['required', 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado'],
            'horarios.*.hora_inicio' => ['required', 'date_format:H:i'],
            'horarios.*.hora_fin' => ['required', 'date_format:H:i', 'after:horarios.*.hora_inicio'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'docente_id.required' => 'El docente es obligatorio.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'materia_id.required' => 'La materia es obligatoria.',
            'materia_id.exists' => 'La materia seleccionada no existe.',
            'paralelo_id.required' => 'El paralelo es obligatorio.',
            'paralelo_id.exists' => 'El paralelo seleccionado no existe.',
            'periodo_academico_id.required' => 'El período académico es obligatorio.',
            'periodo_academico_id.exists' => 'El período académico seleccionado no existe.',
            'rol.in' => 'El rol debe ser: Principal, Auxiliar, Practicante, Suplente o Co-teaching.',
            'horarios.required' => 'Debe agregar al menos un horario.',
            'horarios.min' => 'Debe agregar al menos un horario.',
            'horarios.*.dia_semana.required' => 'El día de la semana es obligatorio.',
            'horarios.*.dia_semana.in' => 'Día inválido. Use: Lunes, Martes, Miércoles, Jueves, Viernes, Sábado.',
            'horarios.*.hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'horarios.*.hora_inicio.date_format' => 'La hora de inicio debe estar en formato HH:MM.',
            'horarios.*.hora_fin.required' => 'La hora de fin es obligatoria.',
            'horarios.*.hora_fin.date_format' => 'La hora de fin debe estar en formato HH:MM.',
            'horarios.*.hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // 1. Verificar asignación duplicada del mismo docente
            $exists = DocenteMateria::where('docente_id', $this->docente_id)
                ->where('materia_id', $this->materia_id)
                ->where('paralelo_id', $this->paralelo_id)
                ->where('periodo_academico_id', $this->periodo_academico_id)
                ->when($this->route('docente_materia'), function ($query, $id) {
                    return $query->where('id', '!=', $id);
                })
                ->exists();

            if ($exists) {
                $validator->errors()->add(
                    'docente_id',
                    'Este docente ya está asignado a esta materia en este paralelo.'
                );
            }

            // 2. Validar conflictos de horarios
            if (!$validator->errors()->has('horarios')) {
                $this->validarConflictosHorarios($validator);
            }
        });
    }

    /**
     * Validar conflictos de horarios
     */
    protected function validarConflictosHorarios(Validator $validator): void
    {
        $horarios = $this->input('horarios', []);
        $docenteId = $this->input('docente_id');
        $paraleloId = $this->input('paralelo_id');
        $periodoAcademicoId = $this->input('periodo_academico_id');

        foreach ($horarios as $index => $horario) {
            $diaSemana = $horario['dia_semana'] ?? null;
            $horaInicio = $horario['hora_inicio'] ?? null;
            $horaFin = $horario['hora_fin'] ?? null;

            if (!$diaSemana || !$horaInicio || !$horaFin) {
                continue;
            }

            // Obtener paralelo para acceder al aula
            $paralelo = \App\Models\Paralelo::find($paraleloId);
            $aulaId = $paralelo?->aula_id;

            // A. Conflicto de DOCENTE (no puede estar en dos lugares al mismo tiempo)
            $conflictoDocente = Horario::whereHas('docenteMateria', function ($query) use ($docenteId, $periodoAcademicoId) {
                    $query->where('docente_id', $docenteId)
                        ->where('periodo_academico_id', $periodoAcademicoId);
                })
                ->where('dia_semana', $diaSemana)
                ->where(function ($query) use ($horaInicio, $horaFin) {
                    $query->where(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '<', $horaFin)
                          ->where('hora_fin', '>', $horaInicio);
                    });
                })
                ->when($this->route('docente_materia'), function ($query, $id) {
                    return $query->where('docente_materia_id', '!=', $id);
                })
                ->with('docenteMateria.materia', 'docenteMateria.paralelo')
                ->first();

            if ($conflictoDocente) {
                $validator->errors()->add(
                    "horarios.{$index}.hora_inicio",
                    "⚠️ CONFLICTO DE DOCENTE: El docente ya tiene clase de {$conflictoDocente->docenteMateria->materia->nombre} en {$conflictoDocente->docenteMateria->paralelo->nombre_completo} el {$diaSemana} de {$conflictoDocente->hora_inicio} a {$conflictoDocente->hora_fin}."
                );
            }

            // B. Conflicto de AULA (el aula no puede tener dos clases simultáneas)
            if ($aulaId) {
                $conflictoAula = Horario::whereHas('docenteMateria', function ($query) use ($aulaId, $periodoAcademicoId) {
                        $query->whereHas('paralelo', function ($q) use ($aulaId) {
                            $q->where('aula_id', $aulaId);
                        })
                        ->where('periodo_academico_id', $periodoAcademicoId);
                    })
                    ->where('dia_semana', $diaSemana)
                    ->where(function ($query) use ($horaInicio, $horaFin) {
                        $query->where(function ($q) use ($horaInicio, $horaFin) {
                            $q->where('hora_inicio', '<', $horaFin)
                              ->where('hora_fin', '>', $horaInicio);
                        });
                    })
                    ->when($this->route('docente_materia'), function ($query, $id) {
                        return $query->where('docente_materia_id', '!=', $id);
                    })
                    ->with('docenteMateria.materia', 'docenteMateria.paralelo')
                    ->first();

                if ($conflictoAula) {
                    $validator->errors()->add(
                        "horarios.{$index}.hora_inicio",
                        "⚠️ CONFLICTO DE AULA: El aula {$paralelo->aula->nombre} ya está ocupada con {$conflictoAula->docenteMateria->materia->nombre} para {$conflictoAula->docenteMateria->paralelo->nombre_completo} el {$diaSemana} de {$conflictoAula->hora_inicio} a {$conflictoAula->hora_fin}."
                    );
                }
            }

            // C. Conflicto de PARALELO (el paralelo no puede tener dos materias al mismo tiempo)
            $conflictoParalelo = Horario::whereHas('docenteMateria', function ($query) use ($paraleloId, $periodoAcademicoId) {
                    $query->where('paralelo_id', $paraleloId)
                        ->where('periodo_academico_id', $periodoAcademicoId);
                })
                ->where('dia_semana', $diaSemana)
                ->where(function ($query) use ($horaInicio, $horaFin) {
                    $query->where(function ($q) use ($horaInicio, $horaFin) {
                        $q->where('hora_inicio', '<', $horaFin)
                          ->where('hora_fin', '>', $horaInicio);
                    });
                })
                ->when($this->route('docente_materia'), function ($query, $id) {
                    return $query->where('docente_materia_id', '!=', $id);
                })
                ->with('docenteMateria.materia', 'docenteMateria.docente.user')
                ->first();

            if ($conflictoParalelo) {
                $validator->errors()->add(
                    "horarios.{$index}.hora_inicio",
                    "⚠️ CONFLICTO DE PARALELO: El paralelo ya tiene clase de {$conflictoParalelo->docenteMateria->materia->nombre} con {$conflictoParalelo->docenteMateria->docente->user->name} el {$diaSemana} de {$conflictoParalelo->hora_inicio} a {$conflictoParalelo->hora_fin}."
                );
            }
        }
    }
}
