<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Asignación de Materias a Cursos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

        <!-- Filtros -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <form method="GET" action="{{ route('curso-materia.index') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Filtro Período Académico -->
                <div class="flex-1 min-w-[200px]">
                    <label for="periodo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Período Académico
                    </label>
                    <x-searchable-select
                        id="periodo_id"
                        name="periodo_id"
                        :options="$periodos"
                        :selected="$periodoId"
                        placeholder="Seleccione período"
                        label-field="nombre"
                        value-field="id"
                        :allow-clear="false"
                    />
                </div>

                <!-- Filtro Curso -->
                <div class="flex-1 min-w-[200px]">
                    <label for="curso_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Curso
                    </label>
                    <x-searchable-select
                        id="curso_id"
                        name="curso_id"
                        :options="$cursos"
                        :selected="$cursoId"
                        placeholder="Seleccione curso"
                        label-field="nombre"
                        value-field="id"
                        :allow-clear="false"
                    />
                </div>

                <!-- Botón Buscar -->
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Buscar
                    </button>
                </div>
            </form>
        </div>

        @if($cursoSeleccionado && $periodoId)
            <!-- Información del Curso Seleccionado -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $cursoSeleccionado->nombre }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Período: {{ $periodos->firstWhere('id', $periodoId)->nombre ?? 'N/A' }}
                        </p>
                    </div>
                    @canany(['crear asignaciones', 'gestionar asignaciones'])
                        <button
                            @click="$dispatch('open-create-modal')"
                            class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Asignar Materia
                        </button>
                    @endcanany
                </div>

                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Materias asignadas:</span>
                    <span class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 rounded-full">
                        {{ $asignaciones->count() }}
                    </span>
                </div>
            </div>

            @if($asignaciones->count() > 0)
                <!-- Cards de Materias Asignadas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    @foreach($asignaciones as $asignacion)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 border-l-4 overflow-hidden"
                             style="border-left-color: {{ $asignacion->materia->color }};">
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $asignacion->materia->nombre }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            Código: {{ $asignacion->materia->codigo }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full"
                                          style="background-color: {{ $asignacion->materia->color }}20; color: {{ $asignacion->materia->color }};">
                                        {{ $asignacion->materia->area->nombre ?? 'Sin área' }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="font-medium text-gray-900 dark:text-white">Horas semanales:</span>
                                        <span class="ml-2 text-lg font-bold text-indigo-600 dark:text-indigo-400">
                                            {{ $asignacion->horas_semanales }}
                                        </span>
                                    </div>

                                    <div class="flex gap-2">
                                        @canany(['editar asignaciones', 'gestionar asignaciones'])
                                            <button
                                                @click="$dispatch('open-edit-modal', {
                                                    id: {{ $asignacion->id }},
                                                    curso_id: {{ $asignacion->curso_id }},
                                                    materia_id: {{ $asignacion->materia_id }},
                                                    materia_nombre: '{{ $asignacion->materia->nombre }}',
                                                    periodo_academico_id: {{ $asignacion->periodo_academico_id }},
                                                    horas_semanales: {{ $asignacion->horas_semanales }}
                                                })"
                                                class="p-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                                title="Editar horas">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        @endcanany

                                        @canany(['eliminar asignaciones', 'gestionar asignaciones'])
                                            <button
                                                @click="$dispatch('open-delete-modal', {
                                                    id: {{ $asignacion->id }},
                                                    materia_nombre: '{{ $asignacion->materia->nombre }}',
                                                    curso_nombre: '{{ $cursoSeleccionado->nombre }}',
                                                    horas_semanales: {{ $asignacion->horas_semanales }}
                                                })"
                                                class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                title="Eliminar asignación">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endcanany
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Resumen Total de Horas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Total de Horas Semanales
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Carga académica total del curso
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-4xl font-bold
                                @if($totalHoras >= 25 && $totalHoras <= 35) text-green-600 dark:text-green-400
                                @elseif($totalHoras > 35 && $totalHoras <= 40) text-yellow-600 dark:text-yellow-400
                                @else text-red-600 dark:text-red-400
                                @endif">
                                {{ $totalHoras }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">horas</div>
                        </div>
                    </div>
                    @if($totalHoras > 40)
                        <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                            <p class="text-sm text-red-800 dark:text-red-200">
                                ⚠️ La carga horaria excede el límite recomendado de 40 horas semanales
                            </p>
                        </div>
                    @elseif($totalHoras < 20)
                        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                💡 La carga horaria está por debajo del mínimo recomendado de 20 horas semanales
                            </p>
                        </div>
                    @endif
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                            No hay materias asignadas
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Comience asignando materias a este curso
                        </p>
                        @canany(['crear asignaciones', 'gestionar asignaciones'])
                            <button
                                @click="$dispatch('open-create-modal')"
                                class="mt-6 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Asignar Primera Materia
                            </button>
                        @endcanany
                    </div>
                </div>
            @endif
        @else
            <!-- Mensaje inicial: Seleccione un curso -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">
                        Seleccione un curso para gestionar sus materias
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Use los filtros superiores para seleccionar un período académico y un curso
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modals -->
@canany(['crear asignaciones', 'gestionar asignaciones'])
    @include('academico.asignaciones.curso-materia.create')
@endcanany

@canany(['editar asignaciones', 'gestionar asignaciones'])
    @include('academico.asignaciones.curso-materia.edit')
@endcanany

@canany(['eliminar asignaciones', 'gestionar asignaciones'])
    @include('academico.asignaciones.curso-materia.delete')
@endcanany
        </div>
    </div>
</x-app-layout>
