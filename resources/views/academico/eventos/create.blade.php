<x-modal name="create-evento" maxWidth="2xl">
    <form method="POST" action="{{ route('eventos.store') }}" class="p-6" x-data="{
        init() {
            // Pre-llenar fecha y hora actual
            const ahora = new Date();
            const fecha = ahora.toISOString().split('T')[0];
            const hora = ahora.toTimeString().split(' ')[0].substring(0, 5);

            document.getElementById('fecha_inicio').value = fecha;
            document.getElementById('hora_inicio').value = hora;

            @if($periodoActivo ?? false)
            // Si hay período activo, pre-seleccionarlo
            this.$nextTick(() => {
                this.$dispatch('update-searchable-select', {
                    id: 'periodo_academico_id',
                    value: {{ $periodoActivo->id }}
                });
            });
            @endif
        }
    }">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            Nuevo Evento
        </h2>

        <div class="space-y-4">
            <!-- Título -->
            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Título del Evento <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    required maxlength="255" placeholder="Ej: Examen de Matemáticas, Reunión de Padres">
                @error('titulo')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Descripción
                </label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    placeholder="Detalles adicionales del evento...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo y Período -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tipo -->
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tipo de Evento <span class="text-red-500">*</span>
                    </label>
                    <x-searchable-select
                        id="tipo"
                        name="tipo"
                        :options="[
                            ['value' => 'examen', 'label' => 'Examen'],
                            ['value' => 'reunion', 'label' => 'Reunión'],
                            ['value' => 'actividad', 'label' => 'Actividad'],
                            ['value' => 'feriado', 'label' => 'Feriado'],
                            ['value' => 'ceremonia', 'label' => 'Ceremonia'],
                            ['value' => 'otro', 'label' => 'Otro']
                        ]"
                        :selected="old('tipo')"
                        placeholder="Seleccione un tipo"
                        valueField="value"
                        labelField="label"
                        required="true"
                    />
                    @error('tipo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Período Académico -->
                <div>
                    <label for="periodo_academico_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Período Académico <span class="text-red-500">*</span>
                        @if($periodoActivo ?? false)
                        <span class="ml-2 text-xs text-green-600 dark:text-green-400">(Período actual)</span>
                        @endif
                    </label>
                    <x-searchable-select
                        id="periodo_academico_id"
                        name="periodo_academico_id"
                        :options="$periodos"
                        :selected="old('periodo_academico_id', $periodoActivo->id ?? null)"
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
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de Inicio <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                        value="{{ old('fecha_inicio') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                        required>
                    @error('fecha_inicio')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <label for="hora_inicio" class="block text-xs text-gray-600 dark:text-gray-400 mt-2 mb-1">
                        Hora de Inicio
                    </label>
                    <input type="time" name="hora_inicio" id="hora_inicio"
                        value="{{ old('hora_inicio') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    @error('hora_inicio')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora de Fin -->
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Fecha de Fin <span class="text-xs text-gray-500">(opcional)</span>
                    </label>
                    <input type="date" name="fecha_fin" id="fecha_fin"
                        value="{{ old('fecha_fin') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    @error('fecha_fin')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <label for="hora_fin" class="block text-xs text-gray-600 dark:text-gray-400 mt-2 mb-1">
                        Hora de Fin
                    </label>
                    <input type="time" name="hora_fin" id="hora_fin"
                        value="{{ old('hora_fin') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                    @error('hora_fin')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Ubicación -->
            <div>
                <label for="ubicacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Ubicación <span class="text-xs text-gray-500">(opcional)</span>
                </label>
                <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    maxlength="255" placeholder="Ej: Auditorio principal, Aula 301">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Indique el lugar físico donde se realizará el evento
                </p>
                @error('ubicacion')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Evento Público -->
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                @canany(['gestionar eventos', 'crear eventos publicos'])
                <div class="flex items-start">
                    <input type="checkbox" name="es_publico" id="es_publico" value="1"
                        {{ old('es_publico', true) ? 'checked' : '' }}
                        class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                    <div class="ml-3">
                        <label for="es_publico" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Evento público
                        </label>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Todos los usuarios de la institución podrán ver este evento en el calendario
                        </p>
                    </div>
                </div>
                @else
                <input type="hidden" name="es_publico" value="1">
                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Los eventos que crees serán públicos por defecto
                </div>
                @endcanany
            </div>

            <!-- Paralelos (opcional) -->
            <div>
                <label for="paralelos" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Cursos y Paralelos <span class="text-xs text-gray-500">(opcional)</span>
                </label>
                <x-searchable-select
                    id="paralelos"
                    name="paralelos[]"
                    :options="$paralelos"
                    placeholder="Seleccione paralelos específicos"
                    valueField="id"
                    labelField="nombre_completo"
                    :multiple="true"
                />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Selecciona paralelos específicos si el evento es solo para ciertos cursos. Si está marcado como público, todos verán el evento además de estos paralelos
                </p>
                @error('paralelos')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Requiere Confirmación -->
            <div class="flex items-start">
                <input type="checkbox" name="requiere_confirmacion" id="requiere_confirmacion" value="1"
                    {{ old('requiere_confirmacion') ? 'checked' : '' }}
                    class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                <div class="ml-3">
                    <label for="requiere_confirmacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Requiere confirmación de asistencia
                    </label>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Los usuarios deberán confirmar si asistirán o no al evento
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                Cancelar
            </x-secondary-button>
            <x-primary-button>
                Crear Evento
            </x-primary-button>
        </div>
    </form>
</x-modal>
