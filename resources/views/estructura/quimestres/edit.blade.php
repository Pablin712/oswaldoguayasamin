{{-- Modal para editar quimestre --}}
<x-modal name="edit-quimestre" maxWidth="2xl" focusable>
    <div x-data="{
        quimestreId: null,
        periodoAcademicoId: null,
        nombre: '',
        numero: null,
        fechaInicio: '',
        fechaFin: '',
        openEdit(id, periodo_academico_id, nombre, numero, fecha_inicio, fecha_fin) {
            this.quimestreId = id;
            this.periodoAcademicoId = periodo_academico_id;
            this.nombre = nombre;
            this.numero = numero;
            this.fechaInicio = fecha_inicio;
            this.fechaFin = fecha_fin;
            $dispatch('open-modal', 'edit-quimestre');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.periodo_academico_id, $event.detail.nombre, $event.detail.numero, $event.detail.fecha_inicio, $event.detail.fecha_fin)"
    class="p-6">
        <form method="POST" :action="`{{ route('quimestres.index') }}/${quimestreId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Quimestre') }}
            </h2>

            <!-- Periodo Académico -->
            <div class="mb-4">
                <x-input-label for="edit_periodo_academico_id" :value="__('Periodo Académico')" />
                <select id="edit_periodo_academico_id" name="periodo_academico_id" required x-model="periodoAcademicoId"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option value="">Seleccione un periodo académico</option>
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->id }}">
                            {{ $periodo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('periodo_academico_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div class="mb-4">
                <x-input-label for="edit_nombre" :value="__('Nombre')" />
                <input id="edit_nombre"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="text"
                       name="nombre"
                       x-model="nombre"
                       required
                       maxlength="100" />
                @error('nombre')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Número -->
            <div class="mb-4">
                <x-input-label for="edit_numero" :value="__('Número')" />
                <input id="edit_numero"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="number"
                       name="numero"
                       x-model="numero"
                       required
                       min="1"
                       max="2" />
                @error('numero')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="edit_fecha_inicio" :value="__('Fecha de Inicio')" />
                    <input id="edit_fecha_inicio"
                           class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                           type="date"
                           name="fecha_inicio"
                           x-model="fechaInicio"
                           required />
                    @error('fecha_inicio')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="edit_fecha_fin" :value="__('Fecha de Fin')" />
                    <input id="edit_fecha_fin"
                           class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                           type="date"
                           name="fecha_fin"
                           x-model="fechaFin"
                           required />
                    @error('fecha_fin')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-quimestre')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar Quimestre') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
