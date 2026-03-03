<x-app-layout>
    @can('ver horarios')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Horario') }}
            </h2>
            <div class="flex space-x-2">
                @can('editar horarios')
                <a href="{{ route('horarios.edit', $horario) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
                @endcan
                <a href="{{ route('horarios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Información General -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Información General
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Período Académico</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $horario->docenteMateria->periodoAcademico->nombre ?? 'N/A' }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Día de la Semana</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $horario->dia_semana }}
                                        </span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Hora de Inicio</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Hora de Fin</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Asignación Académica -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Asignación Académica
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Paralelo</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $horario->paralelo->curso->nombre }} {{ $horario->paralelo->nombre }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Materia</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $horario->materia->nombre }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Docente</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $horario->docente->user->name }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones rápidas -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Ver Horarios Completos
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('horarios.paralelo', $horario->docenteMateria->paralelo_id) }}" class="inline-flex items-center justify-center px-4 py-3 bg-blue-100 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md font-semibold text-sm text-blue-700 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    Horario del Paralelo
                                </a>

                                <a href="{{ route('horarios.docente', $horario->docenteMateria->docente_id) }}" class="inline-flex items-center justify-center px-4 py-3 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-md font-semibold text-sm text-green-700 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Horario del Docente
                                </a>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        @can('eliminar horarios')
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <form action="{{ route('horarios.destroy', $horario) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este horario? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar Horario
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    @endcan
</x-app-layout>
