{{-- Modal para crear horario --}}
<x-modal name="create-horario" maxWidth="3xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('horarios.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Nuevo Horario') }}
        </h2>

        <div class="space-y-4">
            <!-- Período Académico -->
            <div>
                            <label for="periodo_academico_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Período Académico <span class="text-red-500">*</span>
                </label>
                <x-searchable-select
                    id="periodo_academico_id"
                    name="periodo_academico_id"
                    :options="$periodos"
                    :selected="old('periodo_academico_id')"
                    placeholder="Seleccione el período académico"
                    valueField="id"
                    labelField="nombre"
                    required="true"
                />
                <x-input-error :messages="$errors->get('periodo_academico_id')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Paralelo -->
                <div>
                    <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Paralelo <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="paralelo_id"
                        name="paralelo_id"
                        :options="$paralelos"
                        :selected="old('paralelo_id')"
                        placeholder="Seleccione el paralelo"
                        valueField="id"
                        labelField="nombre_completo"
                        required="true"
                    />
                    <x-input-error :messages="$errors->get('paralelo_id')" class="mt-2" />
                </div>

                <!-- Materia -->
                <div>
                    <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Materia <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="materia_id"
                        name="materia_id"
                        :options="$materias"
                        :selected="old('materia_id')"
                        placeholder="Seleccione la materia"
                        valueField="id"
                        labelField="nombre"
                        required="true"
                    />
                    <x-input-error :messages="$errors->get('materia_id')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Docente -->
                <div>
                    <label for="docente_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Docente <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="docente_id"
                        name="docente_id"
                        :options="$docentes"
                        :selected="old('docente_id')"
                        placeholder="Seleccione el docente"
                        valueField="id"
                        labelField="user.name"
                        required="true"
                    />
                    <x-input-error :messages="$errors->get('docente_id')" class="mt-2" />
                </div>

                <!-- Aula (opcional) -->
                <div>
                    <label for="aula_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Aula <span class="text-xs text-gray-500">(opcional)</span>
                    </label>
                    <x-searchable-select
                        id="aula_id"
                        name="aula_id"
                        :options="$aulas"
                        :selected="old('aula_id')"
                        placeholder="Seleccione el aula"
                        valueField="id"
                        labelField="nombre"
                    />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        El sistema verificará que no haya conflictos
                    </p>
                    <x-input-error :messages="$errors->get('aula_id')" class="mt-2" />
                </div>
            </div>

            <!-- Día de la semana -->
            <div>
                <label for="dia_semana" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Día de la Semana <span class="text-red-500">*</span>
                </label>
                <select name="dia_semana" id="dia_semana" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    <option value="">Seleccione un día</option>
                    <option value="Lunes" {{ old('dia_semana') == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                    <option value="Martes" {{ old('dia_semana') == 'Martes' ? 'selected' : '' }}>Martes</option>
                    <option value="Miércoles" {{ old('dia_semana') == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                    <option value="Jueves" {{ old('dia_semana') == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                    <option value="Viernes" {{ old('dia_semana') == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                    <option value="Sábado" {{ old('dia_semana') == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                </select>
                <x-input-error :messages="$errors->get('dia_semana')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Hora de inicio -->
                <div>
                    <label for="hora_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Hora de Inicio <span class="text-red-500">*</span>
                    </label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Formato 24 horas (Ej: 08:00)
                    </p>
                    <x-input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                </div>

                <!-- Hora de fin -->
                <div>
                    <label for="hora_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Hora de Fin <span class="text-red-500">*</span>
                    </label>
                    <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Debe ser posterior a la hora de inicio
                    </p>
                    <x-input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                </div>
            </div>

            <!-- Nota de detección de conflictos -->
            <div class="rounded-md bg-blue-50 dark:bg-blue-900/20 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Detección automática de conflictos
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>El sistema verificará que no haya conflictos de horario con paralelo, docente y aula.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Crear Horario') }}
            </button>
        </div>
    </form>
</x-modal>
