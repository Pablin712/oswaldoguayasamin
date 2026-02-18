<x-modal name="edit-asistencia-modal" maxWidth="2xl" focusable>
    <div x-data="{
        asistenciaId: null,
        estudiante_id: '',
        paralelo_id: '',
        fecha: '',
        hora: '',
        estado: 'presente',
        materia_id: '',
        observaciones: '',
        openEdit(id) {
            this.asistenciaId = id;
            this.fetchAsistenciaData();
            $dispatch('open-modal', 'edit-asistencia-modal');
        },
        fetchAsistenciaData() {
            fetch(`/asistencias/${this.asistenciaId}`)
                .then(r => r.json())
                .then(data => {
                    this.estudiante_id = data.estudiante_id || '';
                    this.paralelo_id = data.paralelo_id || '';
                    this.fecha = data.fecha || '';
                    this.hora = data.hora || '';
                    this.estado = data.estado || 'presente';
                    this.materia_id = data.materia_id || '';
                    this.observaciones = data.observaciones || '';
                });
        }
    }"
    @open-edit-modal.window="openEdit($event.detail)"
    class="p-6">
        <form method="POST" :action="`{{ route('asistencias.index') }}/${asistenciaId}`">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Editar Asistencia
            </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Paralelo -->
            <div>
                <label for="paralelo_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Curso y Paralelo <span class="text-red-500">*</span>
                </label>
                <select id="paralelo_id_edit" name="paralelo_id" x-model="paralelo_id" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Seleccione un curso y paralelo</option>
                    @foreach($paralelos as $paralelo)
                        <option value="{{ $paralelo->id }}">{{ $paralelo->nombre_completo }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Estudiante -->
            <div>
                <label for="estudiante_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Estudiante <span class="text-red-500">*</span>
                </label>
                <select id="estudiante_id_edit" name="estudiante_id" x-model="estudiante_id" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Seleccione un estudiante</option>
                    @foreach($estudiantes as $estudiante)
                        <option value="{{ $estudiante->id }}">{{ $estudiante->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Fecha -->
            <div>
                <label for="fecha_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Fecha <span class="text-red-500">*</span>
                </label>
                <input type="date" id="fecha_edit" name="fecha" x-model="fecha" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Hora -->
            <div>
                <label for="hora_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Hora
                </label>
                <input type="time" id="hora_edit" name="hora" x-model="hora"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Estado -->
            <div>
                <label for="estado_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Estado <span class="text-red-500">*</span>
                </label>
                <select id="estado_edit" name="estado" x-model="estado" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="presente">Presente</option>
                    <option value="ausente">Ausente</option>
                    <option value="atrasado">Atrasado</option>
                    <option value="justificado">Justificado</option>
                </select>
            </div>

            <!-- Materia -->
            <div>
                <label for="materia_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Materia (Opcional)
                </label>
                <input type="number" id="materia_id_edit" name="materia_id"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Observaciones -->
            <div class="md:col-span-2">
                <label for="observaciones_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Observaciones
                </label>
                <textarea id="observaciones_edit" name="observaciones" rows="3" x-model="observaciones"
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
        </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'edit-asistencia-modal')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Actualizar Asistencia') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
