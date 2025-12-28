{{-- Modal para editar parcial --}}
<x-modal name="edit-parcial" maxWidth="2xl" focusable>
    <div x-data="{
        parcialId: null,
        quimestreId: null,
        nombre: '',
        numero: null,
        fechaInicio: '',
        fechaFin: '',
        permiteEdicion: true,
        openEdit(id, quimestre_id, nombre, numero, fecha_inicio, fecha_fin, permite_edicion) {
            this.parcialId = id;
            this.quimestreId = quimestre_id;
            this.nombre = nombre;
            this.numero = numero;
            this.fechaInicio = fecha_inicio;
            this.fechaFin = fecha_fin;
            this.permiteEdicion = permite_edicion;
            $dispatch('open-modal', 'edit-parcial');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.quimestre_id, $event.detail.nombre, $event.detail.numero, $event.detail.fecha_inicio, $event.detail.fecha_fin, $event.detail.permite_edicion)"
    class="p-6">
        <form method="POST" :action="`{{ route('parciales.index') }}/${parcialId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Parcial') }}
            </h2>

            <!-- Quimestre -->
            <div class="mb-4">
                <x-input-label for="edit_quimestre_id" :value="__('Quimestre')" />
                <select id="edit_quimestre_id" name="quimestre_id" required x-model="quimestreId"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option value="">Seleccione un quimestre</option>
                    @foreach($quimestres as $quimestre)
                        <option value="{{ $quimestre->id }}">
                            {{ $quimestre->nombre }} - {{ $quimestre->periodoAcademico->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('quimestre_id')
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
                       min="1" />
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

            <!-- Permite Edición -->
            <div class="mb-4">
                <x-input-label for="edit_permite_edicion" :value="__('¿Permite Edición?')" />
                <select id="edit_permite_edicion" name="permite_edicion" required x-model="permiteEdicion"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option :value="true">Sí</option>
                    <option :value="false">No</option>
                </select>
                @error('permite_edicion')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-parcial')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar Parcial') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
