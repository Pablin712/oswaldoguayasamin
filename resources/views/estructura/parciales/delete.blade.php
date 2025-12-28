{{-- Modal para eliminar parcial --}}
<x-modal name="delete-parcial" maxWidth="md" focusable>
    <div x-data="{
        parcialId: null,
        parcialNombre: '',
        openDelete(id, nombre) {
            this.parcialId = id;
            this.parcialNombre = nombre;
            $dispatch('open-modal', 'delete-parcial');
        }
    }"
    @open-delete-modal.window="openDelete($event.detail.id, $event.detail.nombre)"
    class="p-6">
        <form method="POST" :action="`{{ route('parciales.index') }}/${parcialId}`" x-ref="deleteForm">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                {{ __('¿Estás seguro de eliminar este parcial?') }}
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ __('Estás a punto de eliminar el parcial:') }}
                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="parcialNombre"></span>.
                {{ __('Esta acción no se puede deshacer.') }}
            </p>

            <div class="flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'delete-parcial')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Eliminar') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
