<x-modal name="create-asistencia-modal" maxWidth="2xl">
    <form method="POST" action="{{ route('asistencias.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Registrar Asistencia Individual
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Paralelo -->
            <div>
                <label for="paralelo_id_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Curso y Paralelo <span class="text-red-500">*</span>
                </label>
                <x-searchable-select
                    id="paralelo_id_create"
                    name="paralelo_id"
                    :options="$paralelos"
                    placeholder="Seleccione un curso y paralelo"
                    valueField="id"
                    labelField="nombre_completo"
                    required
                />
                @error('paralelo_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estudiante -->
            <div>
                <label for="estudiante_id_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Estudiante <span class="text-red-500">*</span>
                </label>
                <x-searchable-select
                    id="estudiante_id_create"
                    name="estudiante_id"
                    :options="$estudiantes->map(fn($e) => ['id' => $e->id, 'name' => $e->user->name])"
                    placeholder="Seleccione un estudiante"
                    valueField="id"
                    labelField="name"
                    required
                />
                @error('estudiante_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha -->
            <div>
                <label for="fecha_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="date" id="fecha_create" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('fecha')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hora -->
            <div>
                <label for="hora_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Hora
                </label>
                <input type="time" id="hora_create" name="hora" value="{{ old('hora', date('H:i')) }}"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('hora')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div>
                <label for="estado_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select id="estado_create" name="estado" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="presente" {{ old('estado') == 'presente' ? 'selected' : '' }}>Presente</option>
                    <option value="ausente" {{ old('estado') == 'ausente' ? 'selected' : '' }}>Ausente</option>
                    <option value="atrasado" {{ old('estado') == 'atrasado' ? 'selected' : '' }}>Atrasado</option>
                    <option value="justificado" {{ old('estado') == 'justificado' ? 'selected' : '' }}>Justificado</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Materia -->
            <div>
                <label for="materia_id_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Materia (Opcional)
                </label>
                <x-searchable-select
                    id="materia_id_create"
                    name="materia_id"
                    :options="[]"
                    placeholder="Seleccione una materia"
                    valueField="id"
                    labelField="nombre"
                />
                @error('materia_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Observaciones -->
            <div class="md:col-span-2">
                <label for="observaciones_create" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Observaciones
                </label>
                <textarea id="observaciones_create" name="observaciones" rows="3"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observaciones') }}</textarea>
                @error('observaciones')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Guardar Asistencia') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
