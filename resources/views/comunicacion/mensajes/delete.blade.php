<x-modal name="delete-mensaje" :show="false" maxWidth="md">
    <div x-data="{
        mensajeId: null,
        mensajeAsunto: '',
        openDelete(id, asunto) {
            this.mensajeId = id;
            this.mensajeAsunto = asunto;
            $dispatch('open-modal', 'delete-mensaje');
        }
    }" @open-delete-modal.window="openDelete($event.detail.id, $event.detail.asunto)">
        <form method="POST" :action="`{{ route('mensajes.index') }}/${mensajeId}`" class="p-6" x-show="mensajeId">
            @csrf
            @method('DELETE')

            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Eliminar Mensaje') }}
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        ¿Está seguro que desea eliminar el mensaje:
                        <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="'\"' + mensajeAsunto + '\"'"></span>?
                    </p>

                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Esta acción no se puede deshacer.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    @click="$dispatch('close')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancelar
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Sí, Eliminar
                </button>
            </div>
        </form>
    </div>
</x-modal>
