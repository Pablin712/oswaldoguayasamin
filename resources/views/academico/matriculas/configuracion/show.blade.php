<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Configuración de Costos de Matrícula') }}
            </h2>
            @canany(['editar configuracion matriculas', 'gestionar configuracion matriculas'])
                <a href="{{ route('configuracion.matricula.edit') }}"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Configuración
                </a>
            @endcanany
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Información de la Institución -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Institución
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</label>
                            <p class="text-gray-900 dark:text-gray-100 text-lg">{{ $institucion->nombre }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Código AMIE</label>
                            <p class="text-gray-900 dark:text-gray-100 text-lg">{{ $institucion->codigo_amie }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuración de Costos -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">
                        Costos de Matrícula
                    </h3>

                    <div class="space-y-6">
                        <!-- Tipo de Institución -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Institución</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($configuracion->tipo_institucion === 'fiscal') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($configuracion->tipo_institucion === 'fiscomisional') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                    @else bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 @endif">
                                    {{ ucfirst($configuracion->tipo_institucion) }}
                                </span>
                            </p>
                        </div>

                        <!-- Monto Primera Matrícula -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Costo Primera Matrícula</label>
                            <div class="mt-2">
                                @if($configuracion->monto_primera_matricula == 0)
                                    <span class="text-3xl font-bold text-green-600 dark:text-green-400">GRATUITA</span>
                                @else
                                    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($configuracion->monto_primera_matricula, 2) }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Aplica para estudiantes que se matriculan por primera vez en el periodo académico.
                            </p>
                        </div>

                        <!-- Monto Segunda Matrícula -->
                        <div class="pb-4">
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Costo Segunda Matrícula</label>
                            <div class="mt-2">
                                @if($configuracion->monto_segunda_matricula == 0)
                                    <span class="text-3xl font-bold text-green-600 dark:text-green-400">GRATUITA</span>
                                @else
                                    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                        ${{ number_format($configuracion->monto_segunda_matricula, 2) }}
                                    </span>
                                @endif
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Aplica cuando un estudiante requiere una segunda matrícula en el mismo periodo académico.
                            </p>
                        </div>

                        <!-- Información Adicional -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-sm text-blue-800 dark:text-blue-200">
                                    <p class="font-medium mb-1">Información importante:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Los costos se aplicarán automáticamente al generar órdenes de pago</li>
                                        <li>Los estudiantes pueden tener máximo 2 matrículas por periodo académico</li>
                                        <li>Los montos con valor 0 se consideran matrículas gratuitas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Fechas -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Creación</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $configuracion->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Última Actualización</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $configuracion->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
