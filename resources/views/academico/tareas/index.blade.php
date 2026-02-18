<x-app-layout>
    @canany(['gestionar tareas', 'ver tareas'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Tareas') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('tareas.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Materia -->
                            <div>
                                <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Materia
                                </label>
                                <x-searchable-select
                                    id="materia_id"
                                    name="materia_id"
                                    :options="$materias"
                                    :selected="request('materia_id')"
                                    placeholder="Todas las materias"
                                    valueField="id"
                                    labelField="nombre"
                                />
                            </div>

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

                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Estado
                                </label>
                                <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Todas</option>
                                    <option value="activas" {{ request('estado') == 'activas' ? 'selected' : '' }}>Vigentes</option>
                                    <option value="vencidas" {{ request('estado') == 'vencidas' ? 'selected' : '' }}>Vencidas</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('tareas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                Limpiar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de tareas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        :headers="[
                            ['label' => 'Título', 'type' => 'string'],
                            ['label' => 'Materia', 'type' => 'string'],
                            ['label' => 'Curso/Paralelo', 'type' => 'string'],
                            ['label' => 'Asignación', 'type' => 'date'],
                            ['label' => 'Entrega', 'type' => 'date'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :data="$tareas"
                        emptyMessage="No se encontraron tareas"
                    >
                    <x-slot name="buttons">
                        @can('gestionar tareas')
                        <button @click="$dispatch('open-modal', 'create-tarea')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nueva Tarea
                        </button>
                        @endcan
                    </x-slot>
                        @foreach($tareas as $tarea)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $tarea->titulo }}
                                </div>
                                @if($tarea->es_calificada)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    Calificada ({{ $tarea->puntaje_maximo }} pts)
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $tarea->materia?->nombre ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $tarea->paralelo?->curso?->nombre ?? 'N/A' }} - {{ $tarea->paralelo?->nombre ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $tarea->fecha_asignacion?->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $tarea->fecha_entrega?->format('d/m/Y') ?? 'N/A' }}
                                </div>
                                @if($tarea->fecha_entrega && $tarea->fecha_entrega->isPast())
                                <span class="text-xs text-red-600 dark:text-red-400">
                                    Vencida
                                </span>
                                @elseif($tarea->fecha_entrega && $tarea->fecha_entrega->diffInDays(now()) <= 2)
                                <span class="text-xs text-yellow-600 dark:text-yellow-400">
                                    Próxima
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($tarea->fecha_entrega && $tarea->fecha_entrega->isPast())
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Vencida
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Vigente
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                <a href="{{ route('tareas.show', $tarea) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Ver detalles">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @can('gestionar tareas')
                                <button @click="$dispatch('open-modal', 'edit-tarea-{{ $tarea->id }}')" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Editar">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button @click="$dispatch('open-modal', 'delete-tarea-{{ $tarea->id }}')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Eliminar">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </x-enhanced-table>

                    <div class="mt-4">
                        {{ $tareas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales de creación -->
    @can('gestionar tareas')
    @include('academico.tareas.create')
    @endcan

    <!-- Modales de edición y eliminación -->
    @can('gestionar tareas')
    @foreach($tareas as $tarea)
        @include('academico.tareas.edit', ['tarea' => $tarea])
        @include('academico.tareas.delete', ['tarea' => $tarea])
    @endforeach
    @endcan

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
