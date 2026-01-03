<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Configuración de Costos de Matrícula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Información de la Institución -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="text-sm text-blue-800 dark:text-blue-200">
                        <p class="font-medium">Editando configuración para: <span class="font-bold">{{ $institucion->nombre }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('configuracion.matricula.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Tipo de Institución -->
                            <div>
                                <label for="tipo_institucion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tipo de Institución <span class="text-red-500">*</span>
                                </label>
                                <select id="tipo_institucion" name="tipo_institucion" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-theme-primary focus:ring-theme-primary @error('tipo_institucion') border-red-500 @enderror">
                                    <option value="">Seleccione un tipo</option>
                                    <option value="fiscal" {{ old('tipo_institucion', $configuracion->tipo_institucion) === 'fiscal' ? 'selected' : '' }}>
                                        Fiscal (Educación gratuita)
                                    </option>
                                    <option value="fiscomisional" {{ old('tipo_institucion', $configuracion->tipo_institucion) === 'fiscomisional' ? 'selected' : '' }}>
                                        Fiscomisional (Coopera con el estado)
                                    </option>
                                    <option value="particular" {{ old('tipo_institucion', $configuracion->tipo_institucion) === 'particular' ? 'selected' : '' }}>
                                        Particular (Privada)
                                    </option>
                                </select>
                                @error('tipo_institucion')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Seleccione el tipo de institución según su clasificación oficial.
                                </p>
                            </div>

                            <!-- Monto Primera Matrícula -->
                            <div>
                                <label for="monto_primera_matricula" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Costo Primera Matrícula (USD) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="monto_primera_matricula" name="monto_primera_matricula"
                                        value="{{ old('monto_primera_matricula', $configuracion->monto_primera_matricula) }}"
                                        min="0" max="9999.99" step="0.01" required
                                        class="pl-7 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-theme-primary focus:ring-theme-primary @error('monto_primera_matricula') border-red-500 @enderror">
                                </div>
                                @error('monto_primera_matricula')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Ingrese 0 si la matrícula es gratuita. Aplica para estudiantes que se matriculan por primera vez.
                                </p>
                            </div>

                            <!-- Monto Segunda Matrícula -->
                            <div>
                                <label for="monto_segunda_matricula" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Costo Segunda Matrícula (USD) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" id="monto_segunda_matricula" name="monto_segunda_matricula"
                                        value="{{ old('monto_segunda_matricula', $configuracion->monto_segunda_matricula) }}"
                                        min="0" max="9999.99" step="0.01" required
                                        class="pl-7 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-theme-primary focus:ring-theme-primary @error('monto_segunda_matricula') border-red-500 @enderror">
                                </div>
                                @error('monto_segunda_matricula')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Ingrese 0 si la segunda matrícula es gratuita. Aplica cuando un estudiante requiere matricularse nuevamente.
                                </p>
                            </div>

                            <!-- Información Adicional -->
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <div class="text-sm text-yellow-800 dark:text-yellow-200">
                                        <p class="font-medium mb-1">Consideraciones importantes:</p>
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>Los cambios afectarán las nuevas órdenes de pago generadas</li>
                                            <li>Las órdenes de pago existentes no se modificarán</li>
                                            <li>Asegúrese de coordinar los cambios con el área administrativa</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('configuracion.matricula.show') }}"
                                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
