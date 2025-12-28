<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Periodo Académico') }}
            </h2>
            <a href="{{ route('periodos-academicos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header del Card -->
                <div class="bg-gradient-to-r from-theme-primary to-theme-primary-dark dark:from-theme-third dark:to-theme-secondary px-6 py-4">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $periodoAcademico->nombre }}
                    </h3>
                </div>

                <!-- Contenido del Card -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información General -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Información General
                            </h4>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Nombre:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $periodoAcademico->nombre }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Estado:</span>
                                <div class="mt-1">
                                    @if($periodoAcademico->estado === 'activo')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Activo
                                        </span>
                                    @elseif($periodoAcademico->estado === 'inactivo')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Inactivo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Finalizado
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Fechas
                            </h4>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Fecha de Inicio:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $periodoAcademico->fecha_inicio->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">{{ $periodoAcademico->fecha_inicio->diffForHumans() }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Fecha de Fin:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $periodoAcademico->fecha_fin->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-500">{{ $periodoAcademico->fecha_fin->diffForHumans() }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Duración:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $periodoAcademico->fecha_inicio->diffInDays($periodoAcademico->fecha_fin) }} días
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                        @canany(['gestionar periodos académicos', 'editar periodos académicos'])
                            <button x-data
                                    @click="$dispatch('open-edit-modal', {
                                        id: {{ $periodoAcademico->id }},
                                        nombre: '{{ addslashes($periodoAcademico->nombre) }}',
                                        fecha_inicio: '{{ $periodoAcademico->fecha_inicio->format('Y-m-d') }}',
                                        fecha_fin: '{{ $periodoAcademico->fecha_fin->format('Y-m-d') }}',
                                        estado: '{{ $periodoAcademico->estado }}'
                                    })"
                                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </button>
                        @endcanany
                        @canany(['gestionar periodos académicos', 'eliminar periodos académicos'])
                            <button x-data
                                    @click="$dispatch('open-delete-modal', {
                                        id: {{ $periodoAcademico->id }},
                                        nombre: '{{ addslashes($periodoAcademico->nombre) }}'
                                    })"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar
                            </button>
                        @endcanany
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Incluir modales --}}
    @canany(['gestionar periodos académicos', 'editar periodos académicos'])
        @include('estructura.periodos-academicos.edit')
    @endcanany
    @canany(['gestionar periodos académicos', 'eliminar periodos académicos'])
        @include('estructura.periodos-academicos.delete')
    @endcanany
</x-app-layout>
