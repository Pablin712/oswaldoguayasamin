<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Aula') }}
            </h2>
            <a href="{{ route('aulas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        {{ $aula->nombre }}
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
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $aula->nombre }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Capacidad:</span>
                                <div class="mt-2">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-teal-100 dark:bg-teal-900/30 rounded-lg px-4 py-3 flex items-center">
                                            <svg class="w-8 h-8 text-teal-600 dark:text-teal-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-2xl font-bold text-teal-900 dark:text-teal-100">{{ $aula->capacidad }}</p>
                                                <p class="text-xs text-teal-700 dark:text-teal-300">estudiantes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">ID:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $aula->id }}</p>
                            </div>
                        </div>

                        <!-- Visualización del Aula -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Vista del Aula
                            </h4>

                            <div class="bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg p-6 text-center">
                                <svg class="w-24 h-24 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <div class="space-y-2">
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">{{ $aula->nombre }}</p>
                                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white dark:bg-gray-900 shadow-sm">
                                        <svg class="w-5 h-5 text-teal-600 dark:text-teal-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Capacidad: {{ $aula->capacidad }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Información adicional</p>
                                        <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">Esta aula puede albergar hasta {{ $aula->capacidad }} estudiantes simultáneamente.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                        @canany(['gestionar aulas', 'editar aulas'])
                            <button x-data
                                    @click="$dispatch('open-edit-modal', {
                                        id: {{ $aula->id }},
                                        nombre: '{{ addslashes($aula->nombre) }}',
                                        capacidad: {{ $aula->capacidad }}
                                    })"
                                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </button>
                        @endcanany
                        @canany(['gestionar aulas', 'eliminar aulas'])
                            <button x-data
                                    @click="$dispatch('open-delete-modal', {
                                        id: {{ $aula->id }},
                                        nombre: '{{ addslashes($aula->nombre) }}'
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
    @canany(['gestionar aulas', 'editar aulas'])
        @include('estructura.aulas.edit')
    @endcanany
    @canany(['gestionar aulas', 'eliminar aulas'])
        @include('estructura.aulas.delete')
    @endcanany
</x-app-layout>
