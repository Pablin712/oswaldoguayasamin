{{-- Modal para editar periodo académico --}}
<x-modal name="edit-periodo" maxWidth="2xl" focusable>
    <div x-data="{
        periodoId: null,
        nombre: '',
        fechaInicio: '',
        fechaFin: '',
        estado: 'activo',
        openEdit(id, nombre, fecha_inicio, fecha_fin, estado) {
            this.periodoId = id;
            this.nombre = nombre;
            this.fechaInicio = fecha_inicio;
            this.fechaFin = fecha_fin;
            this.estado = estado;
            $dispatch('open-modal', 'edit-periodo');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.nombre, $event.detail.fecha_inicio, $event.detail.fecha_fin, $event.detail.estado)"
    class="p-6">
        <form method="POST" :action="`{{ route('periodos-academicos.index') }}/${periodoId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Periodo Académico') }}
            </h2>

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

            <!-- Estado -->
            <div class="mb-4">
                <x-input-label for="edit_estado" :value="__('Estado')" />
                <select id="edit_estado" name="estado" required x-model="estado"
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="finalizado">Finalizado</option>
                </select>
                @error('estado')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-periodo')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar Periodo') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
