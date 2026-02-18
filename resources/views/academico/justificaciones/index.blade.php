<x-app-layout>
    @canany(['gestionar justificaciones', 'ver justificaciones'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Justificaciones de Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('justificaciones.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Estado -->
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Estado
                                </label>
                                <select name="estado" id="estado" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="">Todos</option>
                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('justificaciones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Limpiar Filtros
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Justificaciones -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="justificacionesTable"
                        :headers="[
                            ['label' => 'Fecha Solicitud', 'type' => 'datetime'],
                            ['label' => 'Estudiante', 'type' => 'string'],
                            ['label' => 'Padre/Representante', 'type' => 'string'],
                            ['label' => 'Asistencia', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Revisado Por', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte justificaciones', 'gestionar justificaciones'])"
                        :excel="auth()->user()->canany(['generar reporte justificaciones', 'gestionar justificaciones'])"
                        :pdf="auth()->user()->canany(['generar reporte justificaciones', 'gestionar justificaciones'])"
                        :print="auth()->user()->canany(['generar reporte justificaciones', 'gestionar justificaciones'])"
                    >
                        <x-slot name="buttons">
                            @canany(['ver justificaciones', 'gestionar justificaciones', 'aprobar justificaciones', 'rechazar justificaciones'])
                            <a href="{{ route('justificaciones.pendientes') }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pendientes
                            </a>
                            @endcanany

                            @canany(['gestionar justificaciones', 'crear justificaciones'])
                            <button x-data @click="$dispatch('open-modal', 'create-justificacion-modal')" class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nueva Justificación
                            </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($justificaciones as $justificacion)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $justificacion->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $justificacion->asistencia->estudiante->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $justificacion->padre->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <div>{{ \Carbon\Carbon::parse($justificacion->asistencia->fecha)->format('d/m/Y') }}</div>
                                    <div class="text-xs">
                                        @if($justificacion->asistencia->estado == 'presente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Presente
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'ausente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Ausente
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'atrasado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Atrasado
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'justificado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Justificado
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($justificacion->estado == 'pendiente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pendiente
                                        </span>
                                    @elseif($justificacion->estado == 'aprobada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Aprobada
                                        </span>
                                    @elseif($justificacion->estado == 'rechazada')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Rechazada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($justificacion->revisor)
                                        <div>{{ $justificacion->revisor->name }}</div>
                                        <div class="text-xs">{{ $justificacion->fecha_revision?->format('d/m/Y') }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-3">
                                        <!-- Ver -->
                                        <a href="{{ route('justificaciones.show', $justificacion) }}"
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                           title="Ver detalles">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        @if($justificacion->estado === 'pendiente')
                                            <!-- Aprobar y Rechazar -->
                                            @canany(['aprobar justificaciones', 'gestionar justificaciones'])
                                                <button x-data @click="$dispatch('open-modal-data', { modal: 'approve-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                                        title="Aprobar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                                <button x-data @click="$dispatch('open-modal-data', { modal: 'reject-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        title="Rechazar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            @endcanany

                                            <!-- Editar -->
                                            @canany(['editar justificaciones', 'gestionar justificaciones'])
                                                <button x-data @click="$dispatch('open-modal-data', { modal: 'edit-justificacion-modal', data: {{ $justificacion->id }} })"
                                                        class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                        title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </button>
                                            @endcanany
                                        @endif

                                        <!-- Eliminar (solo pendientes o rechazadas) -->
                                        @if(in_array($justificacion->estado, ['pendiente', 'rechazada']))
                                            @canany(['eliminar justificaciones', 'gestionar justificaciones'])
                                                <button x-data @click="$dispatch('open-modal-data', { modal: 'delete-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        title="Eliminar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @endcanany
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No se encontraron justificaciones
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>

                    <!-- Paginación -->
                    <div class="mt-4">
                        {{ $justificaciones->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @canany(['gestionar justificaciones', 'crear justificaciones'])
        @include('academico.justificaciones.create')
    @endcanany

    @canany(['gestionar justificaciones', 'editar justificaciones'])
        @include('academico.justificaciones.edit')
    @endcanany

    @canany(['gestionar justificaciones', 'eliminar justificaciones'])
        @include('academico.justificaciones.delete')
    @endcanany

    @canany(['gestionar justificaciones', 'aprobar justificaciones'])
        @include('academico.justificaciones.approve')
        @include('academico.justificaciones.reject')
    @endcanany
    @endcanany
</x-app-layout>
