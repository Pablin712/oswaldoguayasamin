<x-app-layout>
    @canany(['gestionar justificaciones', 'aprobar justificaciones', 'rechazar justificaciones'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Justificaciones Pendientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Botón volver -->
            <div class="mb-6">
                <a href="{{ route('justificaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver al Listado
                </a>
            </div>

            <!-- Contador y descripción -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-6 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">
                            {{ $justificaciones->count() }} Justificación(es) Pendiente(s) de Revisión
                        </h3>
                        <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                            Las siguientes justificaciones requieren su aprobación o rechazo
                        </p>
                    </div>
                </div>
            </div>

            <!-- Lista de Justificaciones Pendientes -->
            @if($justificaciones->count() > 0)
                <div class="space-y-4">
                    @foreach($justificaciones as $justificacion)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-3">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 mr-3">
                                                Pendiente
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                Solicitada el {{ $justificacion->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>

                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                            {{ $justificacion->asistencia->estudiante->user->name }}
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Ausencia</p>
                                                <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($justificacion->asistencia->fecha)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Estado Original</p>
                                                <div class="mt-1">
                                                    @if($justificacion->asistencia->estado == 'ausente')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                            Ausente
                                                        </span>
                                                    @elseif($justificacion->asistencia->estado == 'atrasado')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            Atrasado
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Padre/Representante</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">
                                                    {{ $justificacion->padre->user->name }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Motivo:</p>
                                            <p class="text-base text-gray-900 dark:text-gray-100">
                                                {{ Str::limit($justificacion->motivo, 200) }}
                                            </p>
                                        </div>

                                        @if($justificacion->archivo_adjunto)
                                            <div class="mt-3">
                                                <a href="{{ asset('storage/' . $justificacion->archivo_adjunto) }}" target="_blank"
                                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                    </svg>
                                                    Ver documento adjunto
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Acciones -->
                                    <div class="ml-6 flex flex-col space-y-2">
                                        <a href="{{ route('justificaciones.show', $justificacion) }}"
                                           class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver Detalle
                                        </a>

                                        @canany(['aprobar justificaciones', 'gestionar justificaciones'])
                                            <button x-data @click="$dispatch('open-modal-data', { modal: 'approve-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                    class="w-full inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Aprobar
                                            </button>
                                        @endcanany

                                        @canany(['rechazar justificaciones', 'gestionar justificaciones'])
                                            <button x-data @click="$dispatch('open-modal-data', { modal: 'reject-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                    class="w-full inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Rechazar
                                            </button>
                                        @endcanany
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">
                            No hay justificaciones pendientes
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Todas las justificaciones han sido revisadas
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modales -->
    @canany(['gestionar justificaciones', 'aprobar justificaciones'])
        @include('academico.justificaciones.approve')
    @endcanany

    @canany(['gestionar justificaciones', 'rechazar justificaciones'])
        @include('academico.justificaciones.reject')
    @endcanany
    @endcanany
</x-app-layout>
