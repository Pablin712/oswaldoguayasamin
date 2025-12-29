{{-- Modal para eliminar docente --}}
<div x-data="{
    deleteData: {},
    modalOpen: false
}"
     @open-delete-modal.window="deleteData = $event.detail; modalOpen = true; $dispatch('open-modal', 'delete-docente')"
     @close-modal.window="if ($event.detail === 'delete-docente') { modalOpen = false; deleteData = {}; }">

    <x-modal name="delete-docente" maxWidth="md" focusable>
        <form method="POST" :action="`{{ route('docentes.index') }}/${deleteData.id}`" class="p-6">
            @csrf
            @method('DELETE')

            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 bg-red-100 dark:bg-red-900 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Eliminar Docente') }}
                    </h2>
                </div>
            </div>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                ¿Está seguro que desea eliminar al docente <strong x-text="deleteData.nombre"></strong>?
            </p>

            <p class="mt-2 text-sm text-red-600 dark:text-red-400 font-medium">
                ⚠️ Esta acción no se puede deshacer. Se eliminará el docente y su usuario asociado.
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'delete-docente')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Sí, Eliminar') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
