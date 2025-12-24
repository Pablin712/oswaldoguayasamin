<!-- Tab: Horarios -->
<div id="tab-horarios" class="tab-content hidden">
    <div class="space-y-6">
        <!-- Bloques Horarios -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Bloques Horarios</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="duracion_periodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duración de Periodo</label>
                    <div class="flex items-center">
                        <input type="number" id="duracion_periodo" name="duracion_periodo"
                            value="{{ old('duracion_periodo', $configuracion->duracion_periodo ?? 45) }}"
                            min="15" max="120" step="5"
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <span class="ml-2 text-gray-600 dark:text-gray-400">minutos</span>
                    </div>
                    @error('duracion_periodo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duracion_recreo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duración de Recreo</label>
                    <div class="flex items-center">
                        <input type="number" id="duracion_recreo" name="duracion_recreo"
                            value="{{ old('duracion_recreo', $configuracion->duracion_recreo ?? 15) }}"
                            min="5" max="60" step="5"
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <span class="ml-2 text-gray-600 dark:text-gray-400">minutos</span>
                    </div>
                    @error('duracion_recreo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="periodos_por_dia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periodos por Día</label>
                    <select id="periodos_por_dia" name="periodos_por_dia"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @for($i = 4; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('periodos_por_dia', $configuracion->periodos_por_dia ?? 6) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    @error('periodos_por_dia')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Días Laborales -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Días Laborales</h4>
            @php
                $diasLaborales = old('dias_laborales',
                    $configuracion->dias_laborales ?? ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']
                );
            @endphp
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <input type="checkbox" id="dia_lunes" name="dias_laborales[]" value="Lunes"
                        {{ in_array('Lunes', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_lunes" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Lunes</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_martes" name="dias_laborales[]" value="Martes"
                        {{ in_array('Martes', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_martes" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Martes</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_miercoles" name="dias_laborales[]" value="Miércoles"
                        {{ in_array('Miércoles', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_miercoles" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Miércoles</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_jueves" name="dias_laborales[]" value="Jueves"
                        {{ in_array('Jueves', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_jueves" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Jueves</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_viernes" name="dias_laborales[]" value="Viernes"
                        {{ in_array('Viernes', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_viernes" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Viernes</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_sabado" name="dias_laborales[]" value="Sábado"
                        {{ in_array('Sábado', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_sabado" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sábado</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="dia_domingo" name="dias_laborales[]" value="Domingo"
                        {{ in_array('Domingo', $diasLaborales) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="dia_domingo" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Domingo</label>
                </div>
            </div>
            @error('dias_laborales')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Información adicional -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        Los horarios específicos de cada bloque (hora de inicio y fin) se configuran automáticamente basándose en la duración de periodos y recreos definidos aquí.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
