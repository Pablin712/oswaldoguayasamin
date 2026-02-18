<div x-data="{
    justificacionId: null,
    estudianteNombre: '',

    openDelete(data) {
        this.justificacionId = data.id;
        this.estudianteNombre = data.estudiante;
        this.$dispatch('open-modal', 'delete-justificacion-modal');
    }
}"
@open-modal-data.window="if ($event.detail.modal === 'delete-justificacion-modal') openDelete($event.detail.data)">
    <x-modal name="delete-justificacion-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Eliminar Justificación
            </h2>

            <form :action="`{{ route('justificaciones.index') }}/${justificacionId}`" method="POST">
                @csrf
                @method('DELETE')

                <div class="space-y-4">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            ¿Está seguro de eliminar esta justificación?
                        </p>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" x-text="estudianteNombre"></p>
                        <p class="mt-3 text-sm text-red-600 dark:text-red-400 font-medium">
                            Esta acción no se puede deshacer.
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t mt-6">
                    <x-secondary-button type="button" @click="$dispatch('close-modal', 'delete-justificacion-modal')">
                        Cancelar
                    </x-secondary-button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Sí, Eliminar
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
