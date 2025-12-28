<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de la Materia') }}
            </h2>
            <a href="{{ route('materias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ $materia->nombre }}
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
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $materia->nombre }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Código:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $materia->codigo }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Área:</span>
                                <div class="mt-1">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z" clip-rule="evenodd"></path>
                                            <path d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z"></path>
                                        </svg>
                                        {{ $materia->area->nombre }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Estado:</span>
                                <div class="mt-1">
                                    @if($materia->estado === 'activa')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Activa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            Inactiva
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Color y Detalles -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                Color y Presentación
                            </h4>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Color:</span>
                                <div class="mt-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 h-16 rounded-lg border-4" style="background-color: {{ $materia->color }}; border-color: {{ $materia->color }}80;"></div>
                                        <div>
                                            <p class="text-gray-900 dark:text-gray-100 font-mono font-semibold">{{ strtoupper($materia->color) }}</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Código hexadecimal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Vista previa:</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border-2"
                                      style="background-color: {{ $materia->color }}20; border-color: {{ $materia->color }}; color: {{ $materia->color }};">
                                    <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $materia->color }};"></span>
                                    {{ $materia->nombre }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción del Área -->
                    @if($materia->area->descripcion)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción del Área:</h4>
                            <p class="text-gray-600 dark:text-gray-400">{{ $materia->area->descripcion }}</p>
                        </div>
                    @endif

                    <!-- Acciones -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                        @canany(['gestionar materias', 'editar materias'])
                            <button x-data
                                    @click="$dispatch('open-edit-modal', {
                                        id: {{ $materia->id }},
                                        codigo: '{{ addslashes($materia->codigo) }}',
                                        nombre: '{{ addslashes($materia->nombre) }}',
                                        area_id: {{ $materia->area_id }},
                                        color: '{{ $materia->color }}'
                                    })"
                                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </button>
                        @endcanany
                        @canany(['gestionar materias', 'eliminar materias'])
                            <button x-data
                                    @click="$dispatch('open-delete-modal', {
                                        id: {{ $materia->id }},
                                        nombre: '{{ addslashes($materia->nombre) }}'
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
    @canany(['gestionar materias', 'editar materias'])
        @include('estructura.materias.edit')
    @endcanany
    @canany(['gestionar materias', 'eliminar materias'])
        @include('estructura.materias.delete')
    @endcanany
</x-app-layout>
