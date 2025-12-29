<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Paralelos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('paralelos.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="curso_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Curso
                        </label>
                        <select name="curso_id" id="curso_id"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Todos los cursos</option>
                            @foreach($todosLosCursos as $c)
                                <option value="{{ $c->id }}" {{ $cursoId == $c->id ? 'selected' : '' }}>
                                    {{ $c->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label for="periodo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Período Académico
                        </label>
                        <select name="periodo_id" id="periodo_id"
                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar
                        </button>
                    </div>

                    @canany(['gestionar paralelos', 'crear paralelos'])
                        <div class="ml-auto">
                            <button type="button" x-data
                                @click="$dispatch('open-modal', 'create-paralelo-modal')"
                                class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('Nuevo Paralelo') }}
                            </button>
                        </div>
                    @endcanany
                </form>
            </div>

            <!-- Cursos con Paralelos -->
            @forelse($cursos as $curso)
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ $curso->nombre }}
                        </h3>
                        @canany(['gestionar paralelos', 'crear paralelos'])
                            <button type="button" x-data
                                @click="$dispatch('open-modal', 'create-paralelo-modal'); $nextTick(() => { document.getElementById('curso_id').value = '{{ $curso->id }}' })"
                                class="inline-flex items-center px-3 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Paralelo
                            </button>
                        @endcanany
                    </div>

                    @if($curso->paralelos->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($curso->paralelos as $paralelo)
                                @php
                                    $estudiantesMatriculados = $paralelo->matriculas->where('estado', 'activa')->count();
                                    $porcentaje = $paralelo->cupo_maximo > 0 ? ($estudiantesMatriculados / $paralelo->cupo_maximo) * 100 : 0;

                                    if ($porcentaje >= 100) {
                                        $badgeColor = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                        $disponibilidad = 'Completo';
                                    } elseif ($porcentaje >= 90) {
                                        $badgeColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                        $disponibilidad = 'Limitado';
                                    } else {
                                        $badgeColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                        $disponibilidad = 'Disponible';
                                    }
                                @endphp

                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                                    <h4 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-3">
                                        Paralelo {{ $paralelo->nombre }}
                                    </h4>

                                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span>{{ $paralelo->aula ? $paralelo->aula->nombre : 'Sin aula asignada' }}</span>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span>{{ $estudiantesMatriculados }}/{{ $paralelo->cupo_maximo }} estudiantes</span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                            {{ $disponibilidad }}
                                        </span>
                                    </div>

                                    <div class="flex gap-2">
                                        @canany(['gestionar paralelos', 'ver paralelos'])
                                            <a href="{{ route('paralelos.show', $paralelo) }}"
                                               class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Ver
                                            </a>
                                        @endcanany

                                        @canany(['gestionar paralelos', 'editar paralelos'])
                                            <button type="button" x-data
                                                @click="$dispatch('open-edit-modal', {
                                                    id: {{ $paralelo->id }},
                                                    curso_id: {{ $paralelo->curso_id }},
                                                    periodo_academico_id: {{ $paralelo->periodo_academico_id }},
                                                    nombre: {{ json_encode($paralelo->nombre) }},
                                                    aula_id: {{ $paralelo->aula_id ?? 'null' }},
                                                    cupo_maximo: {{ $paralelo->cupo_maximo }}
                                                })"
                                                class="inline-flex items-center justify-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endcanany

                                        @canany(['gestionar paralelos', 'eliminar paralelos'])
                                            <button type="button" x-data
                                                @click="$dispatch('open-delete-modal', { id: {{ $paralelo->id }}, name: {{ json_encode($paralelo->nombre_completo) }} })"
                                                class="inline-flex items-center justify-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                title="Eliminar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endcanany
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            No hay paralelos creados para este curso.
                        </p>
                    @endif
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 text-center">
                    <p class="text-gray-500 dark:text-gray-400">
                        No se encontraron cursos. Por favor, crea cursos primero.
                    </p>
                </div>
            @endforelse
        </div>
    </div>

    @canany(['gestionar paralelos', 'crear paralelos'])
        @include('academico.paralelos.create')
    @endcanany

    @canany(['gestionar paralelos', 'editar paralelos'])
        @include('academico.paralelos.edit')
    @endcanany

    @canany(['gestionar paralelos', 'eliminar paralelos'])
        @include('academico.paralelos.delete')
    @endcanany
</x-app-layout>
