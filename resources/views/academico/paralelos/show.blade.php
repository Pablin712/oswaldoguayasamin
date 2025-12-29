<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Detalles del Paralelo
            </h2>
            <a href="{{ route('paralelos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Información del Paralelo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $paralelo->nombre_completo }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400">Información General del Paralelo</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-4">Datos Básicos</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Curso</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $paralelo->curso->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Paralelo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $paralelo->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Aula</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                        {{ $paralelo->aula ? $paralelo->aula->nombre : 'Sin aula asignada' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cupo Máximo</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $paralelo->cupo_maximo }} estudiantes</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-4">Estadísticas</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estudiantes Matriculados</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $totalEstudiantes }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Porcentaje de Ocupación</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                        {{ number_format($porcentajeOcupacion, 2) }}%
                                        @if($porcentajeOcupacion >= 100)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 ml-2">
                                                Completo
                                            </span>
                                        @elseif($porcentajeOcupacion >= 90)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 ml-2">
                                                Limitado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 ml-2">
                                                Disponible
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Docentes Asignados</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">{{ $totalDocentes }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cupos Disponibles</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-200">
                                        {{ max(0, $paralelo->cupo_maximo - $totalEstudiantes) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estudiantes Matriculados -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Estudiantes Matriculados ({{ $totalEstudiantes }})
                    </h3>

                    @if($paralelo->matriculas->where('estado', 'activa')->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Código</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cédula</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($paralelo->matriculas->where('estado', 'activa') as $matricula)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                {{ $matricula->estudiante->codigo_estudiante }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ $matricula->estudiante->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $matricula->estudiante->user->cedula }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $matricula->estudiante->user->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @canany(['gestionar estudiantes', 'ver estudiantes'])
                                                    <a href="{{ route('estudiantes.show', $matricula->estudiante) }}"
                                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                        Ver perfil
                                                    </a>
                                                @endcanany
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                            No hay estudiantes matriculados en este paralelo.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Materias y Docentes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Materias y Docentes Asignados
                    </h3>

                    @if($paralelo->docenteMaterias->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Materia</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Docente</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($paralelo->docenteMaterias as $asignacion)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                      style="background-color: {{ $asignacion->cursoMateria->materia->color }}20; color: {{ $asignacion->cursoMateria->materia->color }};">
                                                    {{ $asignacion->cursoMateria->materia->nombre }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                                {{ $asignacion->docente->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                                {{ $asignacion->docente->user->email }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">
                            No hay materias ni docentes asignados a este paralelo.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex space-x-3">
                        @canany(['gestionar paralelos', 'editar paralelos'])
                            <button type="button"
                                @click="$dispatch('open-edit-modal', {
                                    id: {{ $paralelo->id }},
                                    curso_id: {{ $paralelo->curso_id }},
                                    nombre: {{ json_encode($paralelo->nombre) }},
                                    aula_id: {{ $paralelo->aula_id ?? 'null' }},
                                    cupo_maximo: {{ $paralelo->cupo_maximo }}
                                })"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Editar Paralelo
                            </button>
                        @endcanany

                        @canany(['gestionar paralelos', 'eliminar paralelos'])
                            <button type="button"
                                @click="$dispatch('open-delete-modal', { id: {{ $paralelo->id }}, name: {{ json_encode($paralelo->nombre_completo) }} })"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                                Eliminar Paralelo
                            </button>
                        @endcanany
                    </div>
                </div>
            </div>
        </div>
    </div>

    @canany(['gestionar paralelos', 'editar paralelos'])
        @include('academico.paralelos.edit')
    @endcanany

    @canany(['gestionar paralelos', 'eliminar paralelos'])
        @include('academico.paralelos.delete')
    @endcanany

    <x-session-messages />
</x-app-layout>
