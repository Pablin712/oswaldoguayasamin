<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Área') }}
            </h2>
            <a href="{{ route('areas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition ease-in-out duration-150">
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
                        <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1H8a3 3 0 00-3 3v1.5a1.5 1.5 0 01-3 0V6z" clip-rule="evenodd"></path>
                            <path d="M6 12a2 2 0 012-2h8a2 2 0 012 2v2a2 2 0 01-2 2H2h2a2 2 0 002-2v-2z"></path>
                        </svg>
                        {{ $area->nombre }}
                    </h3>
                </div>

                <!-- Contenido del Card -->
                <div class="p-6">
                    <!-- Información General -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información General
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Nombre:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $area->nombre }}</p>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Estado:</span>
                                <div class="mt-1">
                                    @if($area->estado === 'activa')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Activa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Inactiva
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($area->descripcion)
                            <div class="mt-4">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Descripción:</span>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $area->descripcion }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Materias Asociadas -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-theme-primary dark:text-theme-primary-light mb-3 flex items-center border-b border-gray-200 dark:border-gray-700 pb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Materias Asociadas
                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                {{ $area->materias->count() }}
                            </span>
                        </h4>

                        @if($area->materias->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($area->materias as $materia)
                                    <a href="{{ route('materias.show', $materia) }}" class="group">
                                        <div class="border-2 rounded-lg p-4 transition-all duration-200 hover:shadow-lg hover:scale-105 cursor-pointer"
                                             style="border-color: {{ $materia->color }}; background-color: {{ $materia->color }}10;">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-1">
                                                        <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $materia->color }};"></span>
                                                        <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $materia->nombre }}</h5>
                                                    </div>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $materia->codigo }}</p>
                                                    @if($materia->estado === 'activa')
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 mt-2">
                                                            Activa
                                                        </span>
                                                    @endif
                                                </div>
                                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No hay materias asociadas a esta área</p>
                            </div>
                        @endif
                    </div>

                    <!-- Acciones -->
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                        @canany(['gestionar areas', 'editar areas'])
                            <button x-data
                                    @click="$dispatch('open-edit-modal', {
                                        id: {{ $area->id }},
                                        nombre: '{{ addslashes($area->nombre) }}',
                                        descripcion: '{{ addslashes($area->descripcion ?? '') }}',
                                        estado: '{{ $area->estado }}'
                                    })"
                                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar
                            </button>
                        @endcanany
                        @canany(['gestionar areas', 'eliminar areas'])
                            <button x-data
                                    @click="$dispatch('open-delete-modal', {
                                        id: {{ $area->id }},
                                        nombre: '{{ addslashes($area->nombre) }}'
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
    @canany(['gestionar areas', 'editar areas'])
        @include('estructura.areas.edit')
    @endcanany
    @canany(['gestionar areas', 'eliminar areas'])
        @include('estructura.areas.delete')
    @endcanany
</x-app-layout>
