<x-app-layout>
    @canany(['gestionar eventos', 'ver eventos'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Eventos') }}
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
                    <form method="GET" action="{{ route('eventos.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Período Académico -->
                            <div>
                                <label for="periodo_academico_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Período Académico
                                </label>
                                <x-searchable-select
                                    id="periodo_academico_id"
                                    name="periodo_academico_id"
                                    :options="$periodos"
                                    :selected="request('periodo_academico_id')"
                                    placeholder="Todos los períodos"
                                    valueField="id"
                                    labelField="nombre"
                                />
                            </div>

                            <!-- Tipo -->
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Tipo de Evento
                                </label>
                                <select id="tipo" name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Todos los tipos</option>
                                    <option value="examen" {{ request('tipo') == 'examen' ? 'selected' : '' }}>Examen</option>
                                    <option value="reunion" {{ request('tipo') == 'reunion' ? 'selected' : '' }}>Reunión</option>
                                    <option value="actividad" {{ request('tipo') == 'actividad' ? 'selected' : '' }}>Actividad</option>
                                    <option value="feriado" {{ request('tipo') == 'feriado' ? 'selected' : '' }}>Feriado</option>
                                    <option value="ceremonia" {{ request('tipo') == 'ceremonia' ? 'selected' : '' }}>Ceremonia</option>
                                    <option value="otro" {{ request('tipo') == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                            </div>

                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Estado
                                </label>
                                <select id="estado" name="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Todos</option>
                                    <option value="proximos" {{ request('estado') == 'proximos' ? 'selected' : '' }}>Próximos</option>
                                    <option value="en_curso" {{ request('estado') == 'en_curso' ? 'selected' : '' }}>En Curso</option>
                                    <option value="pasados" {{ request('estado') == 'pasados' ? 'selected' : '' }}>Pasados</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                Limpiar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de eventos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        :headers="[
                            ['label' => 'Título', 'type' => 'string'],
                            ['label' => 'Tipo', 'type' => 'string'],
                            ['label' => 'Fecha Inicio', 'type' => 'date'],
                            ['label' => 'Fecha Fin', 'type' => 'date'],
                            ['label' => 'Ubicación', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :data="$eventos"
                        emptyMessage="No se encontraron eventos"
                    >
                    <x-slot name="buttons">
                        <div class="flex space-x-2">
                            @can('ver calendario eventos')
                            <a href="{{ route('eventos.calendario') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Ver Calendario
                            </a>
                            @endcan
                            @canany(['gestionar eventos', 'crear eventos'])
                            <button @click="$dispatch('open-modal', 'create-evento')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Nuevo Evento
                            </button>
                            @endcanany
                        </div>
                    </x-slot>
                        @foreach($eventos as $evento)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $evento->titulo }}
                                </div>
                                @if($evento->requiere_confirmacion)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Requiere confirmación
                                </span>
                                @endif
                                @if(!$evento->es_publico)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    Privado
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $colores = [
                                        'examen' => 'red',
                                        'reunion' => 'blue',
                                        'actividad' => 'green',
                                        'feriado' => 'purple',
                                        'ceremonia' => 'orange',
                                        'otro' => 'gray'
                                    ];
                                    $color = $colores[$evento->tipo] ?? 'gray';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200">
                                    {{ ucfirst($evento->tipo) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $evento->fecha_inicio?->format('d/m/Y') ?? 'N/A' }}
                                @if($evento->hora_inicio)
                                <br><span class="text-xs">{{ $evento->hora_inicio }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $evento->fecha_fin?->format('d/m/Y') ?? '-' }}
                                @if($evento->hora_fin)
                                <br><span class="text-xs">{{ $evento->hora_fin }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $evento->ubicacion ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($evento->fecha_inicio && $evento->fecha_inicio->isFuture())
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Próximo
                                </span>
                                @elseif($evento->fecha_fin && $evento->fecha_fin->isPast())
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                    Finalizado
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    En Curso
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                <a href="{{ route('eventos.show', $evento) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Ver detalles">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @canany(['gestionar eventos', 'editar eventos'])
                                <button @click="$dispatch('open-edit-modal', { id: {{ $evento->id }} })" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Editar">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                @endcanany
                                @canany(['gestionar eventos', 'eliminar eventos'])
                                <button @click="$dispatch('open-delete-modal', { id: {{ $evento->id }}, titulo: '{{ addslashes($evento->titulo) }}' })" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Eliminar">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                @endcanany
                            </td>
                        </tr>
                        @endforeach
                    </x-enhanced-table>

                    <div class="mt-4">
                        {{ $eventos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @canany(['gestionar eventos', 'crear eventos'])
    @include('academico.eventos.create')
    @endcanany

    @canany(['gestionar eventos', 'editar eventos'])
    @include('academico.eventos.edit')
    @endcanany

    @canany(['gestionar eventos', 'eliminar eventos'])
    @include('academico.eventos.delete')
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
