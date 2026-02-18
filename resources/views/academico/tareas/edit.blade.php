<x-modal name="edit-tarea" maxWidth="2xl">
    <div x-data="{
        tareaId: null,
        titulo: '',
        descripcion: '',
        materiaId: null,
        paraleloId: null,
        fechaAsignacion: '',
        fechaEntrega: '',
        esCalificada: false,
        puntajeMaximo: 10,
        async fetchTareaData(id) {
            try {
                const response = await fetch(`/academico/tareas/${id}/edit`);
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                // No necesitamos cargar datos, solo guardar el ID
                this.tareaId = id;
                $dispatch('open-modal', 'edit-tarea');
            } catch (error) {
                console.error('Error al cargar datos de la tarea:', error);
            }
        }
    }" @open-edit-modal.window="fetchTareaData($event.detail.id)">
        <form method="POST" :action="`{{ route('tareas.index') }}/${tareaId}`" enctype="multipart/form-data" class="p-6" x-show="tareaId">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                Editar Tarea
            </h2>

            <div class="space-y-4">
                <!-- Título -->
                <div>
                    <label for="titulo_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo_edit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required maxlength="255">
                    @error('titulo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Materia y Paralelo -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Materia -->
                    <div>
                        <label for="materia_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Materia <span class="text-red-500">*</span>
                        </label>
                        <x-searchable-select
                            id="materia_id_edit"
                            name="materia_id"
                            :options="$materias ?? []"
                            placeholder="Seleccione una materia"
                            valueField="id"
                            labelField="nombre"
                            required="true"
                        />
                        @error('materia_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Paralelo -->
                    <div>
                        <label for="paralelo_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Curso y Paralelo <span class="text-red-500">*</span>
                        </label>
                        <x-searchable-select
                            id="paralelo_id_edit"
                            name="paralelo_id"
                            :options="$paralelos ?? []"
                            placeholder="Seleccione un paralelo"
                            valueField="id"
                            labelField="nombre_completo"
                            required="true"
                        />
                        @error('paralelo_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Descripción <span class="text-red-500">*</span>
                    </label>
                    <textarea name="descripcion" id="descripcion_edit" rows="4" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
                    @error('descripcion')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fecha de Asignación -->
                    <div>
                        <label for="fecha_asignacion_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Asignación <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_asignacion" id="fecha_asignacion_edit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            required>
                        @error('fecha_asignacion')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Entrega -->
                    <div>
                        <label for="fecha_entrega_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Entrega <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_entrega" id="fecha_entrega_edit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            required>
                        @error('fecha_entrega')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Calificación -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center mb-3">
                        <input type="checkbox" name="es_calificada" id="es_calificada_edit" value="1"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                            onchange="document.getElementById('puntaje_container_edit').classList.toggle('hidden', !this.checked)">
                        <label for="es_calificada_edit" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Esta tarea es calificada
                        </label>
                    </div>

                    <div id="puntaje_container_edit" class="hidden">
                        <label for="puntaje_maximo_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Puntaje Máximo
                        </label>
                        <input type="number" name="puntaje_maximo" id="puntaje_maximo_edit"
                            value="10" step="0.01" min="0" max="100"
                            class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        @error('puntaje_maximo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nuevos archivos adjuntos -->
                <div>
                    <label for="archivos_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Archivos Adjuntos (opcional)
                    </label>
                    <input type="file" name="archivos[]" id="archivos_edit" multiple
                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 focus:outline-none"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Formatos permitidos: PDF, Word, Excel, PowerPoint, imágenes. Puede seleccionar múltiples archivos.
                    </p>
                    @error('archivos')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button>
                    Actualizar Tarea
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
