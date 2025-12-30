<div x-data="{
    curso_id: {{ $cursoId ?? 'null' }},
    materia_id: null,
    periodo_academico_id: {{ $periodoId ?? 'null' }},
    horas_semanales: 4
}" @open-create-modal.window="$dispatch('open-modal', 'create-curso-materia-modal')">
    <x-modal name="create-curso-materia-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Asignar Materia
            </h2>

            <form method="POST" action="{{ route('curso-materia.store') }}">
                @csrf

                <!-- Información del Curso -->
                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Curso:</strong> {{ $cursoSeleccionado->nombre ?? 'N/A' }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <strong>Período:</strong> {{ $periodos->firstWhere('id', $periodoId)->nombre ?? 'N/A' }}
                    </div>
                </div>

                <!-- Hidden fields -->
                <input type="hidden" name="curso_id" :value="curso_id">
                <input type="hidden" name="periodo_academico_id" :value="periodo_academico_id">

                <!-- Materia -->
                <div class="mb-4">
                    <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Materia <span class="text-red-500">*</span>
                    </label>
                    @php
                        // Obtener materias que NO están asignadas al curso en el período seleccionado
                        $materiasAsignadas = $cursoSeleccionado && $periodoId
                            ? \App\Models\CursoMateria::where('curso_id', $cursoId)
                                ->where('periodo_academico_id', $periodoId)
                                ->pluck('materia_id')
                            : collect();

                        $materiasDisponibles = \App\Models\Materia::whereNotIn('id', $materiasAsignadas)
                            ->orderBy('nombre')
                            ->get();
                    @endphp
                    <x-searchable-select
                        id="materia_id"
                        name="materia_id"
                        :options="$materiasDisponibles"
                        placeholder="Seleccione una materia"
                        label-field="nombre"
                        value-field="id"
                        required
                        class="mt-1"
                        x-model="materia_id"
                        dropdown-parent="#create-curso-materia-modal"
                    />
                    @error('materia_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Horas Semanales -->
                <div class="mb-4">
                    <label for="horas_semanales" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Horas Semanales <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="horas_semanales"
                        name="horas_semanales"
                        x-model="horas_semanales"
                        min="1"
                        max="10"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('horas_semanales')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        💡 Generalmente entre 2 y 6 horas semanales
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 mt-6">
                    <button
                        type="button"
                        @click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                        Asignar Materia
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
