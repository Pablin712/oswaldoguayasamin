<x-app-layout>
    @can('ver auditoria')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Historial de Registro') }} - {{ ucfirst($historial->first()->tabla_afectada ?? 'N/A') }} #{{ $historial->first()->registro_id ?? 'N/A' }}
            </h2>
            <a href="{{ route('auditoria.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($historial->count() > 0)
            <!-- Timeline de Historial -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Historial de Cambios</h3>

                    <div class="relative">
                        <!-- Línea vertical del timeline -->
                        <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>

                        <!-- Eventos del timeline -->
                        <div class="space-y-6">
                            @foreach($historial as $evento)
                            <div class="relative flex items-start">
                                <!-- Punto del timeline -->
                                <div class="absolute left-6 flex items-center justify-center">
                                    <div class="flex h-4 w-4 items-center justify-center rounded-full ring-8 ring-white dark:ring-gray-800
                                        @if($evento->accion == 'create') bg-blue-500
                                        @elseif($evento->accion == 'update') bg-yellow-500
                                        @elseif($evento->accion == 'delete') bg-red-500
                                        @else bg-gray-500
                                        @endif">
                                    </div>
                                </div>

                                <!-- Contenido del evento -->
                                <div class="ml-16 w-full">
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                    @if($evento->accion == 'create')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            Creado
                                                        </span>
                                                    @elseif($evento->accion == 'update')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            Actualizado
                                                        </span>
                                                    @elseif($evento->accion == 'delete')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                            Eliminado
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                                            {{ ucfirst($evento->accion) }}
                                                        </span>
                                                    @endif
                                                </h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    Por {{ $evento->user->name ?? 'Sistema' }} el {{ $evento->created_at->format('d/m/Y H:i:s') }}
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500">
                                                    IP: {{ $evento->ip_address }}
                                                </p>
                                            </div>
                                            <a href="{{ route('auditoria.show', $evento) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm">
                                                Ver Detalles
                                            </a>
                                        </div>

                                        @if($evento->descripcion)
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $evento->descripcion }}</p>
                                        </div>
                                        @endif

                                        @if($evento->accion == 'update' && $evento->datos_anteriores && $evento->datos_nuevos)
                                        <div class="mt-3">
                                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2">Cambios realizados:</p>
                                            <div class="space-y-1">
                                                @foreach($evento->datos_nuevos as $campo => $valorNuevo)
                                                    @php
                                                        $valorAnterior = $evento->datos_anteriores[$campo] ?? null;
                                                        $cambio = $valorAnterior != $valorNuevo;
                                                    @endphp
                                                    @if($cambio)
                                                    <div class="text-xs">
                                                        <span class="font-medium text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $campo)) }}:</span>
                                                        <span class="text-red-600 dark:text-red-400 line-through">{{ is_array($valorAnterior) ? json_encode($valorAnterior) : ($valorAnterior ?? 'N/A') }}</span>
                                                        <span class="mx-1">→</span>
                                                        <span class="text-green-600 dark:text-green-400">{{ is_array($valorNuevo) ? json_encode($valorNuevo) : ($valorNuevo ?? 'N/A') }}</span>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
            <!-- Sin Historial -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay historial disponible</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        No se encontraron registros de auditoría para este elemento.
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endcan
</x-app-layout>
