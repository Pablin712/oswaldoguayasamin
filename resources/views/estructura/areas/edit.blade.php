{{-- Modal para editar área --}}
<x-modal name="edit-area" maxWidth="2xl" focusable>
    <div x-data="{
        areaId: null,
        nombre: '',
        descripcion: '',
        estado: 'activa',
        openEdit(id, nombre, descripcion, estado) {
            this.areaId = id;
            this.nombre = nombre;
            this.descripcion = descripcion;
            this.estado = estado;
            $dispatch('open-modal', 'edit-area');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.nombre, $event.detail.descripcion, $event.detail.estado)"
    class="p-6">
        <form method="POST" :action="`{{ route('areas.index') }}/${areaId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Área') }}
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

            <!-- Descripción -->
            <div class="mb-4">
                <x-input-label for="edit_descripcion" :value="__('Descripción')" />
                <textarea id="edit_descripcion"
                          name="descripcion"
                          rows="3"
                          maxlength="500"
                          x-model="descripcion"
                          class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"></textarea>
                @error('descripcion')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <x-input-label for="edit_estado" :value="__('Estado')" />
                <select id="edit_estado"
                        name="estado"
                        x-model="estado"
                        required
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option value="activa">Activa</option>
                    <option value="inactiva">Inactiva</option>
                </select>
                @error('estado')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-area')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar Área') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
