<div x-data="{
    id: null,
    curso_id: null,
    materia_id: null,
    materia_nombre: '',
    periodo_academico_id: null,
    horas_semanales: 1
}" @open-edit-modal.window="
    id = $event.detail.id;
    curso_id = $event.detail.curso_id;
    materia_id = $event.detail.materia_id;
    materia_nombre = $event.detail.materia_nombre;
    periodo_academico_id = $event.detail.periodo_academico_id;
    horas_semanales = $event.detail.horas_semanales;
    $dispatch('open-modal', 'edit-curso-materia-modal');
">
    <x-modal name="edit-curso-materia-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Editar Horas de Materia
            </h2>

            <form :action="`{{ route('curso-materia.index') }}/${id}`" method="POST">
                @csrf
                @method('PUT')

                <!-- Información de la Materia -->
                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <strong>Materia:</strong> <span x-text="materia_nombre"></span>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <strong>Curso:</strong> {{ $cursoSeleccionado->nombre ?? 'N/A' }}
                    </div>
                </div>

                <!-- Hidden fields -->
                <input type="hidden" name="curso_id" :value="curso_id">
                <input type="hidden" name="materia_id" :value="materia_id">
                <input type="hidden" name="periodo_academico_id" :value="periodo_academico_id">

                <!-- Horas Semanales -->
                <div class="mb-4">
                    <label for="edit_horas_semanales" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Horas Semanales <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        id="edit_horas_semanales"
                        name="horas_semanales"
                        x-model="horas_semanales"
                        min="1"
                        max="10"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('horas_semanales')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        💡 Ajuste las horas según la malla curricular
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 mt-6">
                    <button
                        type="button"
                        @click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
