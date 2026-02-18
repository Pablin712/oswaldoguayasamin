<x-app-layout>
    @can('ver auditoria')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Estadísticas de Auditoría') }}
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
            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtros de Fecha</h3>
                    <form method="GET" action="{{ route('auditoria.estadisticas') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Fecha Inicio
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Fecha Fin
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('auditoria.estadisticas') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Limpiar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen General -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-10 w-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total de Acciones</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($estadisticas['total_acciones']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-10 w-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Usuarios Activos</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($estadisticas['usuarios_activos']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-10 w-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">IPs Únicas</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($estadisticas['ips_unicas']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones por Tipo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Acciones por Tipo</h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        @foreach($estadisticas['por_accion'] as $accion => $total)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">{{ ucfirst($accion) }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($total) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top 10 Tablas más Modificadas -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="tablasTable"
                        :headers="[
                            ['label' => 'Tabla', 'type' => 'string'],
                            ['label' => 'Total de Acciones', 'type' => 'number'],
                            ['label' => 'Porcentaje', 'type' => 'string'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :excel="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :pdf="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :print="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :json="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                    >
                        <x-slot name="buttons">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Top 10 Tablas más Modificadas</h3>
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $totalTablas = $estadisticas['por_tabla']->sum();
                            @endphp
                            @forelse($estadisticas['por_tabla'] as $tabla => $total)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($tabla) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ number_format($total) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <div class="flex-1 mr-4">
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($total / $totalTablas) * 100 }}%"></div>
                                            </div>
                                        </div>
                                        <span>{{ number_format(($total / $totalTablas) * 100, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron datos.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>
    @endcan
</x-app-layout>
