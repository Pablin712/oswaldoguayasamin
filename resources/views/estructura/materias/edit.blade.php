{{-- Modal para editar materia --}}
<x-modal name="edit-materia" maxWidth="2xl" focusable>
    <div x-data="{
        materiaId: null,
        codigo: '',
        nombre: '',
        area_id: null,
        color: '#3B82F6',
        openEdit(id, codigo, nombre, area_id, color) {
            this.materiaId = id;
            this.codigo = codigo;
            this.nombre = nombre;
            this.area_id = area_id;
            this.color = color;
            $dispatch('open-modal', 'edit-materia');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.codigo, $event.detail.nombre, $event.detail.area_id, $event.detail.color)"
    class="p-6">
        <form method="POST" :action="`{{ route('materias.index') }}/${materiaId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Materia') }}
            </h2>

            <!-- Código -->
            <div class="mb-4">
                <x-input-label for="edit_codigo" :value="__('Código')" />
                <input id="edit_codigo"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="text"
                       name="codigo"
                       x-model="codigo"
                       required
                       maxlength="20" />
                @error('codigo')
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
                       maxlength="150" />
                @error('nombre')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Área -->
            <div class="mb-4">
                <x-input-label for="edit_area_id" :value="__('Área')" />
                <select id="edit_area_id"
                        name="area_id"
                        x-model="area_id"
                        required
                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                    <option value="">{{ __('Seleccione un área') }}</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
                @error('area_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Color -->
            <div class="mb-4">
                <x-input-label for="edit_color" :value="__('Color')" />
                <div class="flex gap-2 items-center mt-1">
                    <input id="edit_color"
                           class="block h-10 w-20 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary"
                           type="color"
                           name="color"
                           x-model="color"
                           required />
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Seleccione el color para identificar la materia') }}</span>
                </div>
                @error('color')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-materia')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar Materia') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
