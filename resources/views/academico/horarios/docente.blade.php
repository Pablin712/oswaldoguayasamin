<x-app-layout>
    @canany(['gestionar horarios', 'ver horarios', 'ver horarios por docente'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Horario del Docente') }}: {{ $docente->user->name }}
            </h2>
            <a href="{{ route('horarios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Información del docente -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Docente</p>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $docente->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cédula</p>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $docente->cedula }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Especialidad</p>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $docente->especialidad ?? 'No especificada' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total de clases</p>
                            <p class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $horarios->flatten()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grid de horario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Hora
                                    </th>
                                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            {{ $dia }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    // Obtener todas las horas únicas
                                    $todasHoras = $horarios->flatten()->map(function($h) {
                                        return \Carbon\Carbon::parse($h->hora_inicio)->format('H:i');
                                    })->unique()->sort()->values();

                                    // Agregar receso manualmente si no está
                                    $todasHoras = $todasHoras->merge(['10:20'])->unique()->sort()->values();
                                @endphp

                                @forelse($todasHoras as $hora)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $hora }}
                                    </td>
                                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] as $dia)
                                        <td class="px-3 py-3 text-sm text-gray-900 dark:text-gray-100">
                                            @php
                                                // Verificar si es hora de receso
                                                $esReceso = $hora == '10:20';

                                                $clase = $horarios->get($dia)?->first(function($h) use ($hora) {
                                                    return \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') == $hora;
                                                });
                                            @endphp
                                            @if($esReceso)
                                                <div class="bg-orange-100 dark:bg-orange-900 border border-orange-300 dark:border-orange-700 rounded-lg p-3">
                                                    <p class="font-semibold text-sm text-orange-900 dark:text-orange-100 text-center">
                                                        🍎 RECESO
                                                    </p>
                                                    <p class="text-xs text-orange-600 dark:text-orange-400 text-center mt-1">
                                                        10:20 - 10:50
                                                    </p>
                                                </div>
                                            @elseif($clase)
                                                <div class="bg-green-100 dark:bg-green-900 border border-green-300 dark:border-green-700 rounded-lg p-3">
                                                    <p class="font-semibold text-sm text-green-900 dark:text-green-100">
                                                        {{ $clase->materia->nombre }}
                                                    </p>
                                                    <p class="text-xs text-green-700 dark:text-green-300 mt-1">
                                                        {{ $clase->paralelo->curso->nombre }} {{ $clase->paralelo->nombre }}
                                                    </p>
                                                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                                                        {{ \Carbon\Carbon::parse($clase->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($clase->hora_fin)->format('H:i') }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="h-16"></div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay horarios registrados para este docente
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Acción para imprimir -->
            <div class="mt-6 flex justify-end">
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir Horario
                </button>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
    @endpush
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
