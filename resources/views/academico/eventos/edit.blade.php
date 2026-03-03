<x-modal name="edit-evento" maxWidth="2xl">
    <div x-data="{
        eventoId: null,
        eventoData: {},
        async fetchEventoData(id) {
            this.eventoId = id;
            try {
                const response = await fetch(`/eventos/${id}/edit`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (!response.ok) {
                    const errorData = await response.text();
                    console.error('Response error:', errorData);
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();
                console.log('Datos cargados:', data);
                this.eventoData = data;

                // Llenar los campos del formulario
                await this.$nextTick();
                setTimeout(() => {
                    const titleInput = document.getElementById('titulo_edit');
                    if (titleInput) titleInput.value = this.eventoData.titulo || '';

                    const descInput = document.getElementById('descripcion_edit');
                    if (descInput) descInput.value = this.eventoData.descripcion || '';

                    const tipoSelect = document.getElementById('tipo_edit');
                    if (tipoSelect) tipoSelect.value = this.eventoData.tipo || '';

                    const fechaInicioInput = document.getElementById('fecha_inicio_edit');
                    if (fechaInicioInput) fechaInicioInput.value = this.eventoData.fecha_inicio || '';

                    const horaInicioInput = document.getElementById('hora_inicio_edit');
                    if (horaInicioInput) horaInicioInput.value = this.eventoData.hora_inicio || '';

                    const fechaFinInput = document.getElementById('fecha_fin_edit');
                    if (fechaFinInput) fechaFinInput.value = this.eventoData.fecha_fin || '';

                    const horaFinInput = document.getElementById('hora_fin_edit');
                    if (horaFinInput) horaFinInput.value = this.eventoData.hora_fin || '';

                    const ubicacionInput = document.getElementById('ubicacion_edit');
                    if (ubicacionInput) ubicacionInput.value = this.eventoData.ubicacion || '';

                    const esPublicoCheck = document.getElementById('es_publico_edit');
                    if (esPublicoCheck) esPublicoCheck.checked = this.eventoData.es_publico == 1;

                    const requiereConfCheck = document.getElementById('requiere_confirmacion_edit');
                    if (requiereConfCheck) requiereConfCheck.checked = this.eventoData.requiere_confirmacion == 1;

                    // Actualizar searchable-selects mediante eventos personalizados
                    if (this.eventoData.periodo_academico_id) {
                        this.$dispatch('update-searchable-select', {
                            id: 'periodo_academico_id_edit',
                            value: this.eventoData.periodo_academico_id
                        });
                    }
                    if (this.eventoData.paralelos && this.eventoData.paralelos.length > 0) {
                        this.$dispatch('update-searchable-select', {
                            id: 'paralelos_edit',
                            value: this.eventoData.paralelos
                        });
                    }
                }, 100);

                this.$dispatch('open-modal', 'edit-evento');
            } catch (error) {
                console.error('Error completo:', error);
                alert('Error al cargar los datos del evento: ' + error.message);
            }
        }
    }" @open-edit-modal.window="fetchEventoData($event.detail.id)">
        <form method="POST" :action="`/eventos/${eventoId}`" class="p-6" x-show="eventoId">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                Editar Evento
            </h2>

            <div class="space-y-4">
                <!-- Título -->
                <div>
                    <label for="titulo_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Título del Evento <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="titulo" id="titulo_edit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required maxlength="255">
                    @error('titulo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion_edit" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"></textarea>
                    @error('descripcion')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipo y Período -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tipo -->
                    <div>
                        <label for="tipo_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tipo de Evento <span class="text-red-500">*</span>
                        </label>
                        <select name="tipo" id="tipo_edit" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                            <option value="">Seleccione un tipo</option>
                            <option value="examen">Examen</option>
                            <option value="reunion">Reunión</option>
                            <option value="actividad">Actividad</option>
                            <option value="feriado">Feriado</option>
                            <option value="ceremonia">Ceremonia</option>
                            <option value="otro">Otro</option>
                        </select>
                        @error('tipo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Período Académico -->
                    <div>
                        <label for="periodo_academico_id_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Período Académico <span class="text-red-500">*</span>
                        </label>
                        <x-searchable-select
                            id="periodo_academico_id_edit"
                            name="periodo_academico_id"
                            :options="$periodos ?? []"
                            placeholder="Seleccione un período"
                            valueField="id"
                            labelField="nombre"
                            required="true"
                        />
                        @error('periodo_academico_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fechas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Fecha y Hora de Inicio -->
                    <div>
                        <label for="fecha_inicio_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Inicio <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio_edit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            required>
                        @error('fecha_inicio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <input type="time" name="hora_inicio" id="hora_inicio_edit"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            placeholder="Hora (opcional)">
                        @error('hora_inicio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha y Hora de Fin -->
                    <div>
                        <label for="fecha_fin_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Fecha de Fin (opcional)
                        </label>
                        <input type="date" name="fecha_fin" id="fecha_fin_edit"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                        @error('fecha_fin')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <input type="time" name="hora_fin" id="hora_fin_edit"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            placeholder="Hora (opcional)">
                        @error('hora_fin')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Ubicación -->
                <div>
                    <label for="ubicacion_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Ubicación
                    </label>
                    <input type="text" name="ubicacion" id="ubicacion_edit"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        maxlength="255"
                        placeholder="Ej: Auditorio principal, Aula 301">
                    @error('ubicacion')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Evento Público -->
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="es_publico" id="es_publico_edit" value="1"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                        <label for="es_publico_edit" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Evento público (visible para toda la institución)
                        </label>
                    </div>
                </div>

                <!-- Paralelos (opcional) -->
                <div>
                    <label for="paralelos_edit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Cursos y Paralelos (opcional)
                    </label>
                    <x-searchable-select
                        id="paralelos_edit"
                        name="paralelos[]"
                        :options="$paralelos ?? []"
                        placeholder="Seleccione paralelos específicos"
                        valueField="id"
                        labelField="nombre_completo"
                        :multiple="true"
                    />
                    @error('paralelos')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Requiere Confirmación -->
                <div class="flex items-center">
                    <input type="checkbox" name="requiere_confirmacion" id="requiere_confirmacion_edit" value="1"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                    <label for="requiere_confirmacion_edit" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Requiere confirmación de asistencia
                    </label>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    Cancelar
                </x-secondary-button>
                <x-primary-button>
                    Actualizar Evento
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
