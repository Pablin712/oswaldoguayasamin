<x-app-layout>
    @canany(['gestionar eventos', 'ver eventos'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Evento') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            @if($evento->requiere_confirmacion)
            <!-- Estadísticas de Confirmación -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Respuestas</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $estadisticas['total'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmados -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Confirmados</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $estadisticas['confirmados'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No Confirmados -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">No Asistirán</p>
                                <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $estadisticas['no_confirmados'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/20">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Porcentaje -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">% Confirmación</p>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $estadisticas['porcentaje_confirmados'] }}%</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/20">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Layout de 3 columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna 1: Información del Evento -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Detalles del Evento -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Información del Evento
                            </h3>

                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Título</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $evento->titulo }}</dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Tipo</dt>
                                    <dd class="mt-1">
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
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200">
                                            {{ ucfirst($evento->tipo) }}
                                        </span>
                                    </dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Período Académico</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $evento->periodoAcademico?->nombre ?? 'N/A' }}</dd>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Visibilidad</dt>
                                    <dd class="mt-1">
                                        @if($evento->es_publico)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Público
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Privado
                                        </span>
                                        @endif
                                    </dd>
                                </div>

                                @if($evento->lugar)
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Lugar</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $evento->lugar }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Fechas y Horario
                            </h3>

                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Inicio</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $evento->fecha_inicio?->format('d/m/Y') ?? 'N/A' }}
                                        @if($evento->hora_inicio)
                                            - {{ $evento->hora_inicio }}
                                        @endif
                                    </dd>
                                </div>

                                @if($evento->fecha_fin)
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Fin</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $evento->fecha_fin?->format('d/m/Y') ?? 'N/A' }}
                                        @if($evento->hora_fin)
                                            - {{ $evento->hora_fin }}
                                        @endif
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Paralelos -->
                    @if($evento->paralelos->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Cursos y Paralelos
                            </h3>
                            <ul class="space-y-2 text-sm">
                                @foreach($evento->paralelos as $paralelo)
                                <li class="flex items-center text-gray-700 dark:text-gray-300">
                                    <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    {{ $paralelo->curso?->nombre ?? 'N/A' }} - {{ $paralelo->nombre }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Columna 2-3: Descripción y Confirmaciones -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Descripción -->
                    @if($evento->descripcion)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Descripción
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                {{ $evento->descripcion }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Confirmaciones de Asistencia -->
                    @if($evento->requiere_confirmacion && $evento->confirmaciones->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Confirmaciones de Asistencia ({{ $evento->confirmaciones->count() }})
                            </h3>

                            <x-enhanced-table
                                :headers="[
                                    ['label' => 'Usuario', 'type' => 'string'],
                                    ['label' => 'Estado', 'type' => 'string'],
                                    ['label' => 'Fecha Confirmación', 'type' => 'datetime'],
                                    ['label' => 'Observaciones', 'type' => 'string'],
                                ]"
                                :data="$evento->confirmaciones"
                                emptyMessage="No hay confirmaciones registradas"
                            >
                                @foreach($evento->confirmaciones as $confirmacion)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $confirmacion->user?->name ?? 'N/A' }}
                                            @if($confirmacion->estudiante)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                ({{ $confirmacion->estudiante->user?->name }})
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($confirmacion->confirmado)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Confirmado
                                        </span>
                                        @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            No Asistirá
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $confirmacion->fecha_confirmacion?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $confirmacion->observaciones ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </x-enhanced-table>
                        </div>
                    </div>
                    @endif
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
    @endcanany
</x-app-layout>
