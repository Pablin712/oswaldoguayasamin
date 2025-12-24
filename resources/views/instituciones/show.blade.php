<x-app-layout>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="bg-theme-primary dark:bg-theme-primary-light text-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Mi Institución</h1>
            @canany(['editar institución', 'gestionar institución'])
                <button x-data="{}" @click="$dispatch('open-modal', 'edit-institucion')" class="bg-white text-theme-primary dark:text-theme-primary-light hover:bg-theme-primary-light dark:hover:bg-theme-primary px-4 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </button>
            @endcanany
        </div>
    </div>

    @if ($institucion)
        <!-- Logo y Nombre -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-8 mb-6 text-center">
            @if ($institucion->logo)
                <img src="{{ Storage::url($institucion->logo) }}" alt="Logo {{ $institucion->nombre }}" class="h-48 mx-auto mb-4 object-contain">
            @else
                <div class="h-48 w-48 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            @endif
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $institucion->nombre }}</h2>
        </div>

        <!-- Grid de Información -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Información General -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-theme-primary dark:text-theme-primary-light mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Información General
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Nombre:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->nombre }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Código AMIE:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->codigo_amie }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Tipo:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->tipo }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Nivel:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->nivel }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Jornada:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->jornada }}</p>
                    </div>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-theme-primary dark:text-theme-primary-light mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ubicación
                </h3>
                <div class="space-y-3">
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Provincia:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->provincia }}</p>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Ciudad:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->ciudad }}</p>
                    </div>
                    @if ($institucion->canton)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Cantón:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->canton }}</p>
                        </div>
                    @endif
                    @if ($institucion->parroquia)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Parroquia:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->parroquia }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Dirección:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->direccion }}</p>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-theme-primary dark:text-theme-primary-light mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contacto
                </h3>
                <div class="space-y-3">
                    @if ($institucion->telefono)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Teléfono:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->telefono }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Email:</span>
                        <p class="text-gray-600 dark:text-gray-400">{{ $institucion->email }}</p>
                    </div>
                    @if ($institucion->sitio_web)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Sitio Web:</span>
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ $institucion->sitio_web }}" target="_blank" class="text-theme-primary dark:text-theme-primary-light hover:underline">
                                    {{ $institucion->sitio_web }}
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Autoridades -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-theme-primary dark:text-theme-primary-light mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Autoridades
                </h3>
                <div class="space-y-3">
                    @if ($institucion->rector)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Rector:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->rector }}</p>
                        </div>
                    @endif
                    @if ($institucion->vicerrector)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Vicerrector:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->vicerrector }}</p>
                        </div>
                    @endif
                    @if ($institucion->inspector)
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Inspector:</span>
                            <p class="text-gray-600 dark:text-gray-400">{{ $institucion->inspector }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        No se ha configurado la información de la institución.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal de Edición -->
@canany(['editar institución', 'gestionar institución'])
    @include('instituciones.edit')
@endcanany
</x-app-layout>
