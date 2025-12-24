<!-- Tab: Calificaciones -->
<div id="tab-calificaciones" class="tab-content hidden">
    <div class="space-y-6">
        <!-- Escala de Calificación -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Escala de Calificación</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="calificacion_minima" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Calificación Mínima</label>
                    <input type="number" id="calificacion_minima" name="calificacion_minima"
                        value="{{ old('calificacion_minima', $configuracion->calificacion_minima ?? 0) }}"
                        min="0" step="0.01"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('calificacion_minima')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="calificacion_maxima" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Calificación Máxima</label>
                    <input type="number" id="calificacion_maxima" name="calificacion_maxima"
                        value="{{ old('calificacion_maxima', $configuracion->calificacion_maxima ?? 10) }}"
                        min="0" step="0.01"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('calificacion_maxima')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nota_minima_aprobacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nota Mínima Aprobación</label>
                    <input type="number" id="nota_minima_aprobacion" name="nota_minima_aprobacion"
                        value="{{ old('nota_minima_aprobacion', $configuracion->nota_minima_aprobacion ?? 7) }}"
                        min="0" step="0.01"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('nota_minima_aprobacion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="decimales" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Decimales</label>
                    <select id="decimales" name="decimales"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <option value="0" {{ old('decimales', $configuracion->decimales ?? 2) == 0 ? 'selected' : '' }}>0</option>
                        <option value="1" {{ old('decimales', $configuracion->decimales ?? 2) == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('decimales', $configuracion->decimales ?? 2) == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('decimales', $configuracion->decimales ?? 2) == 3 ? 'selected' : '' }}>3</option>
                    </select>
                    @error('decimales')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Ponderaciones -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Ponderaciones</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="ponderacion_examen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Examen Quimestral</label>
                    <div class="flex items-center">
                        <input type="number" id="ponderacion_examen" name="ponderacion_examen"
                            value="{{ old('ponderacion_examen', $configuracion->ponderacion_examen ?? 20) }}"
                            min="0" max="100" step="1"
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                            oninput="calcularTotalPonderacion()">
                        <span class="ml-2 text-gray-600 dark:text-gray-400">%</span>
                    </div>
                    @error('ponderacion_examen')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="ponderacion_parciales" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Promedio Parciales</label>
                    <div class="flex items-center">
                        <input type="number" id="ponderacion_parciales" name="ponderacion_parciales"
                            value="{{ old('ponderacion_parciales', $configuracion->ponderacion_parciales ?? 80) }}"
                            min="0" max="100" step="1"
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                            oninput="calcularTotalPonderacion()">
                        <span class="ml-2 text-gray-600 dark:text-gray-400">%</span>
                    </div>
                    @error('ponderacion_parciales')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Total: </span>
                        <span id="total_ponderacion" class="text-lg font-bold text-theme-primary dark:text-theme-primary-light">100%</span>
                        <span id="check_ponderacion" class="ml-2">✓</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reglas Especiales -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Reglas Especiales</h4>
            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" id="permitir_supletorio" name="permitir_supletorio" value="1"
                        {{ old('permitir_supletorio', $configuracion->permitir_supletorio ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="permitir_supletorio" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Permitir supletorio</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="permitir_remedial" name="permitir_remedial" value="1"
                        {{ old('permitir_remedial', $configuracion->permitir_remedial ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="permitir_remedial" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Permitir remedial</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="permitir_gracia" name="permitir_gracia" value="1"
                        {{ old('permitir_gracia', $configuracion->permitir_gracia ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="permitir_gracia" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Permitir gracia</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="redondear_calificaciones" name="redondear_calificaciones" value="1"
                        {{ old('redondear_calificaciones', $configuracion->redondear_calificaciones ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="redondear_calificaciones" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Redondear calificaciones</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function calcularTotalPonderacion() {
    const examen = parseFloat(document.getElementById('ponderacion_examen')?.value || 0);
    const parciales = parseFloat(document.getElementById('ponderacion_parciales')?.value || 0);
    const total = examen + parciales;

    const totalElement = document.getElementById('total_ponderacion');
    const checkElement = document.getElementById('check_ponderacion');

    totalElement.textContent = total + '%';

    if (total === 100) {
        totalElement.classList.remove('text-red-600');
        totalElement.classList.add('text-theme-primary dark:text-theme-primary-light');
        checkElement.textContent = '✓';
        checkElement.classList.remove('text-red-500');
        checkElement.classList.add('text-green-500');
    } else {
        totalElement.classList.remove('text-theme-primary dark:text-theme-primary-light');
        totalElement.classList.add('text-red-600');
        checkElement.textContent = '✗';
        checkElement.classList.remove('text-green-500');
        checkElement.classList.add('text-red-500');
    }
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', function() {
    calcularTotalPonderacion();
});
</script>
