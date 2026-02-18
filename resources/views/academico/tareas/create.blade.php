<x-modal name="create-tarea" maxWidth="2xl" :show="$errors->any() && !isset($tarea)">
    <form method="POST" action="{{ route('tareas.store') }}" enctype="multipart/form-data" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            Nueva Tarea
        </h2>

        <div class="space-y-4">
            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
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
                    <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Materia <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="materia_id"
                        name="materia_id"
                        :options="$materias"
                        :selected="old('materia_id')"
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
                    <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Curso y Paralelo <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="paralelo_id"
                        name="paralelo_id"
                        :options="$paralelos"
                        :selected="old('paralelo_id')"
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
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea name="descripcion" id="descripcion" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Fecha de Asignación -->
                <div>
                    <label for="fecha_asignacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de Asignación <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_asignacion" id="fecha_asignacion"
                        value="{{ old('fecha_asignacion', date('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required>
                    @error('fecha_asignacion')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha de Entrega -->
                <div>
                    <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de Entrega <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_entrega" id="fecha_entrega"
                        value="{{ old('fecha_entrega') }}"
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
                    <input type="checkbox" name="es_calificada" id="es_calificada" value="1"
                        {{ old('es_calificada') ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                        onchange="document.getElementById('puntaje_container').classList.toggle('hidden', !this.checked)">
                    <label for="es_calificada" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Esta tarea es calificada
                    </label>
                </div>

                <div id="puntaje_container" class="{{ old('es_calificada') ? '' : 'hidden' }}">
                    <label for="puntaje_maximo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Puntaje Máximo
                    </label>
                    <input type="number" name="puntaje_maximo" id="puntaje_maximo"
                        value="{{ old('puntaje_maximo', 10) }}" step="0.01" min="0" max="100"
                        class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    @error('puntaje_maximo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Archivos adjuntos -->
            <div>
                <label for="archivos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Archivos Adjuntos (opcional)
                </label>
                <input type="file" name="archivos[]" id="archivos" multiple
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
                Crear Tarea
            </x-primary-button>
        </div>
    </form>
</x-modal>
