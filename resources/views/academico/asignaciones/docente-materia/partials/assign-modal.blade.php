{{-- Modal de Asignación (2 Pasos) --}}
<div x-show="showAssignModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    {{-- Modal Content --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="closeAssignModal()"
             class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">

            {{-- Header --}}
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 z-10">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Nueva Asignación Docente-Materia
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            <span x-show="currentStep === 1">Paso 1: Seleccione docente, materia y paralelo</span>
                            <span x-show="currentStep === 2">Paso 2: Defina los horarios de clase</span>
                        </p>
                    </div>
                    <button @click="closeAssignModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Progress Steps --}}
                <div class="mt-4 flex items-center justify-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                             :class="currentStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'">
                            1
                        </div>
                        <span class="text-sm font-medium" :class="currentStep >= 1 ? 'text-blue-600' : 'text-gray-500'">
                            Asignación
                        </span>
                    </div>
                    <div class="w-16 h-1 rounded" :class="currentStep >= 2 ? 'bg-blue-600' : 'bg-gray-200'"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium"
                             :class="currentStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'">
                            2
                        </div>
                        <span class="text-sm font-medium" :class="currentStep >= 2 ? 'text-blue-600' : 'text-gray-500'">
                            Horarios
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6">

                {{-- Errores de Validación --}}
                <div x-show="validationErrors.length > 0"
                     class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-red-900 mb-2">❌ Errores de Validación</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                <template x-for="(error, index) in validationErrors" :key="index">
                                    <li x-text="error"></li>
                                </template>
                            </ul>
                        </div>
                        <button @click="validationErrors = []" class="text-red-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- PASO 1: Selección de Asignación --}}
                <div x-show="currentStep === 1" class="space-y-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Docente --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Docente <span class="text-red-500">*</span>
                            </label>
                            <select x-model="form.docente_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione un docente</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">
                                        {{ $docente->user->name }} - {{ $docente->especialidad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Materia --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Materia <span class="text-red-500">*</span>
                            </label>
                            <select x-model="form.materia_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione una materia</option>
                                @foreach($todasMaterias as $mat)
                                    <option value="{{ $mat->id }}">{{ $mat->nombre }} ({{ $mat->area->nombre }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Paralelo --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Paralelo <span class="text-red-500">*</span>
                            </label>
                            <select x-model="form.paralelo_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccione un paralelo</option>
                                @foreach($todosParalelos as $par)
                                    <option value="{{ $par->id }}">
                                        {{ $par->curso->nombre }} - {{ $par->nombre }}
                                        @if($par->aula) (Aula: {{ $par->aula->nombre }}) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rol --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Rol del Docente
                            </label>
                            <select x-model="form.rol"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Principal">Principal</option>
                                <option value="Auxiliar">Auxiliar</option>
                                <option value="Practicante">Practicante</option>
                                <option value="Suplente">Suplente</option>
                                <option value="Co-teaching">Co-teaching</option>
                            </select>
                        </div>
                    </div>

                    {{-- Información adicional --}}
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">ℹ️ Información</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Puede asignar múltiples docentes a la misma materia con diferentes roles</li>
                            <li>• En el siguiente paso definirá los horarios específicos de clase</li>
                            <li>• El sistema detectará automáticamente conflictos de horarios</li>
                        </ul>
                    </div>
                </div>

                {{-- PASO 2: Definir Horarios --}}
                <div x-show="currentStep === 2" class="space-y-4">

                    {{-- Información de disponibilidad --}}
                    <div x-show="disponibilidad" class="p-4 rounded-lg border"
                         :class="disponibilidad?.disponible ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200'">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" :class="disponibilidad?.disponible ? 'text-green-600' : 'text-amber-600'"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium" :class="disponibilidad?.disponible ? 'text-green-900' : 'text-amber-900'">
                                    Carga horaria actual: <span x-text="disponibilidad?.carga_total || 0"></span> horas semanales
                                </p>
                                <p class="text-xs" :class="disponibilidad?.disponible ? 'text-green-700' : 'text-amber-700'">
                                    <span x-show="disponibilidad?.disponible">✅ El docente tiene disponibilidad (límite: 25 horas)</span>
                                    <span x-show="!disponibilidad?.disponible">⚠️ El docente está cerca del límite de 25 horas semanales</span>
                                </p>
                            </div>
                        </div>

                        {{-- Mostrar horarios existentes del docente --}}
                        <div x-show="disponibilidad?.horarios && disponibilidad.horarios.length > 0" class="mt-4 pt-4 border-t border-gray-200">
                            <h5 class="text-xs font-medium text-gray-700 mb-2">📅 Horarios actuales del docente:</h5>
                            <div class="max-h-40 overflow-y-auto">
                                <table class="min-w-full text-xs">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-2 py-1 text-left text-gray-600">Día</th>
                                            <th class="px-2 py-1 text-left text-gray-600">Hora</th>
                                            <th class="px-2 py-1 text-left text-gray-600">Materia</th>
                                            <th class="px-2 py-1 text-left text-gray-600">Paralelo</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <template x-for="(h, idx) in disponibilidad.horarios" :key="idx">
                                            <tr>
                                                <td class="px-2 py-1 text-gray-700" x-text="h.dia_semana"></td>
                                                <td class="px-2 py-1 text-gray-700" x-text="h.hora_inicio?.substring(0,5) + ' - ' + h.hora_fin?.substring(0,5)"></td>
                                                <td class="px-2 py-1 text-gray-700" x-text="h.docente_materia?.materia?.nombre"></td>
                                                <td class="px-2 py-1 text-gray-700" x-text="h.docente_materia?.paralelo?.nombre"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Lista de horarios --}}
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <h4 class="text-sm font-medium text-gray-900">Horarios de Clase</h4>
                            <button @click="addHorario()"
                                    type="button"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Agregar Horario
                            </button>
                        </div>

                        <template x-for="(horario, index) in form.horarios" :key="index">
                            <div class="flex gap-3 items-start p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    {{-- Día --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Día</label>
                                        <select x-model="horario.dia_semana"
                                                class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="Lunes">Lunes</option>
                                            <option value="Martes">Martes</option>
                                            <option value="Miércoles">Miércoles</option>
                                            <option value="Jueves">Jueves</option>
                                            <option value="Viernes">Viernes</option>
                                            <option value="Sábado">Sábado</option>
                                        </select>
                                    </div>

                                    {{-- Hora Inicio --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Hora Inicio</label>
                                        <input type="time"
                                               x-model="horario.hora_inicio"
                                               class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    {{-- Hora Fin --}}
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Hora Fin</label>
                                        <input type="time"
                                               x-model="horario.hora_fin"
                                               class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                {{-- Botón Eliminar --}}
                                <button @click="removeHorario(index)"
                                        type="button"
                                        class="mt-6 text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <div x-show="form.horarios.length === 0" class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2">No hay horarios agregados</p>
                            <p class="text-sm">Haga clic en "Agregar Horario" para comenzar</p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <button @click="currentStep === 1 ? closeAssignModal() : prevStep()"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        <span x-show="currentStep === 1">Cancelar</span>
                        <span x-show="currentStep === 2">← Anterior</span>
                    </button>

                    <button @click="currentStep === 1 ? nextStep() : submitForm()"
                            type="button"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        <span x-show="currentStep === 1">Siguiente →</span>
                        <span x-show="currentStep === 2">✓ Guardar Asignación</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
