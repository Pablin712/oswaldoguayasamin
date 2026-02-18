<x-app-layout>
    @canany(['gestionar asistencias', 'ver asistencias'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control de Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('asistencias.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Paralelo -->
                            <div>
                                <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Curso y Paralelo
                                </label>
                                <x-searchable-select
                                    id="paralelo_id"
                                    name="paralelo_id"
                                    :options="$paralelos"
                                    :selected="request('paralelo_id')"
                                    placeholder="Todos los paralelos"
                                    valueField="id"
                                    labelField="nombre_completo"
                                />
                            </div>

                            <!-- Estudiante -->
                            <div>
                                <label for="estudiante_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Estudiante
                                </label>
                                <x-searchable-select
                                    id="estudiante_id"
                                    name="estudiante_id"
                                    :options="$estudiantes->map(fn($e) => ['id' => $e->id, 'name' => $e->user->name])"
                                    :selected="request('estudiante_id')"
                                    placeholder="Todos los estudiantes"
                                    valueField="id"
                                    labelField="name"
                                />
                            </div>

                            <!-- Fecha -->
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Fecha
                                </label>
                                <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Estado
                                </label>
                                <select name="estado" id="estado" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="">Todos</option>
                                    <option value="presente" {{ request('estado') == 'presente' ? 'selected' : '' }}>Presente</option>
                                    <option value="ausente" {{ request('estado') == 'ausente' ? 'selected' : '' }}>Ausente</option>
                                    <option value="atrasado" {{ request('estado') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                                    <option value="justificado" {{ request('estado') == 'justificado' ? 'selected' : '' }}>Justificado</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('asistencias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Limpiar Filtros
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Asistencias -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="asistenciasTable"
                        :headers="[
                            ['label' => 'Fecha/Hora', 'type' => 'datetime'],
                            ['label' => 'Estudiante', 'type' => 'string'],
                            ['label' => 'Paralelo', 'type' => 'string'],
                            ['label' => 'Materia', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Docente', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte asistencias', 'gestionar asistencias'])"
                        :excel="auth()->user()->canany(['generar reporte asistencias', 'gestionar asistencias'])"
                        :pdf="auth()->user()->canany(['generar reporte asistencias', 'gestionar asistencias'])"
                        :print="auth()->user()->canany(['generar reporte asistencias', 'gestionar asistencias'])"
                        :json="auth()->user()->canany(['generar reporte asistencias', 'gestionar asistencias'])"
                    >
                        <x-slot name="buttons">
                            @canany(['gestionar asistencias', 'registrar asistencias'])
                            <a href="{{ route('asistencias.registro-masivo.form') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Registro Masivo
                            </a>
                            @endcanany

                            @canany(['gestionar asistencias', 'registrar asistencias'])
                            <button x-data @click="$dispatch('open-modal', 'create-asistencia-modal')" class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nueva Asistencia
                            </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($asistencias as $asistencia)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    <div>{{ $asistencia->fecha->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $asistencia->hora?->format('H:i') ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $asistencia->estudiante->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $asistencia->paralelo->curso->nombre }} {{ $asistencia->paralelo->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $asistencia->materia->nombre ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asistencia->estado == 'presente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Presente
                                        </span>
                                    @elseif($asistencia->estado == 'ausente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Ausente
                                        </span>
                                    @elseif($asistencia->estado == 'atrasado')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Atrasado
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Justificado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $asistencia->docente->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        @canany(['gestionar asistencias', 'ver asistencias'])
                                        <a href="{{ route('asistencias.show', $asistencia) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors" title="Ver detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        @endcanany

                                        @canany(['gestionar asistencias', 'editar asistencias'])
                                        <button type="button" x-data @click="$dispatch('open-edit-modal', {{ json_encode($asistencia->id) }})" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors" title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        @endcanany

                                        @canany(['gestionar asistencias', 'eliminar asistencias'])
                                        <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $asistencia->id }}, name: '{{ $asistencia->estudiante->user->name }} - {{ $asistencia->fecha->format('d/m/Y') }}' })" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors" title="Eliminar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        @endcanany
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron registros de asistencia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    @canany(['registrar asistencias', 'gestionar asistencias'])
        @include('academico.asistencias.create')
    @endcanany

    @canany(['editar asistencias', 'gestionar asistencias'])
        @include('academico.asistencias.edit')
    @endcanany

    @canany(['eliminar asistencias', 'gestionar asistencias'])
        @include('academico.asistencias.delete')
    @endcanany
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __('No tiene permisos para acceder a esta sección.') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endcanany
</x-app-layout>
