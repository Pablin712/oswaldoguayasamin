<!-- Tab: Académico -->
<div id="tab-academico" class="tab-content">
    <div class="space-y-6">
        <!-- Periodo Académico -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Periodo Académico</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="periodo_actual_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periodo Actual</label>
                    <select id="periodo_actual_id" name="periodo_actual_id"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <option value="">Seleccione un periodo...</option>
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}" {{ old('periodo_actual_id', $configuracion->periodo_actual_id ?? '') == $periodo->id ? 'selected' : '' }}>
                                {{ $periodo->nombre }} ({{ $periodo->anio_inicio }}-{{ $periodo->anio_fin }})
                            </option>
                        @endforeach
                    </select>
                    @error('periodo_actual_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Duración de Periodos -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Duración de Periodos</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="numero_quimestres" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quimestres</label>
                    <select id="numero_quimestres" name="numero_quimestres"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <option value="2" {{ old('numero_quimestres', $configuracion->numero_quimestres ?? 2) == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('numero_quimestres', $configuracion->numero_quimestres ?? 2) == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ old('numero_quimestres', $configuracion->numero_quimestres ?? 2) == 4 ? 'selected' : '' }}>4</option>
                    </select>
                    @error('numero_quimestres')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="numero_parciales" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parciales por Quimestre</label>
                    <select id="numero_parciales" name="numero_parciales"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <option value="2" {{ old('numero_parciales', $configuracion->numero_parciales ?? 3) == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('numero_parciales', $configuracion->numero_parciales ?? 3) == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ old('numero_parciales', $configuracion->numero_parciales ?? 3) == 4 ? 'selected' : '' }}>4</option>
                    </select>
                    @error('numero_parciales')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Fechas Importantes -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Fechas Importantes</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fecha_inicio_clases" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Inicio de Clases</label>
                    <input type="date" id="fecha_inicio_clases" name="fecha_inicio_clases" value="{{ old('fecha_inicio_clases', $configuracion->fecha_inicio_clases ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_inicio_clases')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_fin_clases" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fin de Clases</label>
                    <input type="date" id="fecha_fin_clases" name="fecha_fin_clases" value="{{ old('fecha_fin_clases', $configuracion->fecha_fin_clases ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_fin_clases')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_inicio_q1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Inicio 1Q</label>
                    <input type="date" id="fecha_inicio_q1" name="fecha_inicio_q1" value="{{ old('fecha_inicio_q1', $configuracion->fecha_inicio_q1 ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_inicio_q1')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_fin_q1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fin 1Q</label>
                    <input type="date" id="fecha_fin_q1" name="fecha_fin_q1" value="{{ old('fecha_fin_q1', $configuracion->fecha_fin_q1 ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_fin_q1')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_inicio_q2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Inicio 2Q</label>
                    <input type="date" id="fecha_inicio_q2" name="fecha_inicio_q2" value="{{ old('fecha_inicio_q2', $configuracion->fecha_inicio_q2 ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_inicio_q2')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="fecha_fin_q2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fin 2Q</label>
                    <input type="date" id="fecha_fin_q2" name="fecha_fin_q2" value="{{ old('fecha_fin_q2', $configuracion->fecha_fin_q2 ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('fecha_fin_q2')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Parámetros de Asistencia -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Parámetros de Asistencia</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="porcentaje_minimo_asistencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">% Mínimo de Asistencia</label>
                    <div class="flex items-center">
                        <input type="number" id="porcentaje_minimo_asistencia" name="porcentaje_minimo_asistencia"
                            value="{{ old('porcentaje_minimo_asistencia', $configuracion->porcentaje_minimo_asistencia ?? 85) }}"
                            min="0" max="100" step="1"
                            class="flex-1 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <span class="ml-2 text-gray-600">%</span>
                    </div>
                    @error('porcentaje_minimo_asistencia')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
