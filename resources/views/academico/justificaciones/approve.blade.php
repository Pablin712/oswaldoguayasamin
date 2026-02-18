<div x-data="{
    justificacionId: null,
    estudianteNombre: '',

    openApprove(data) {
        this.justificacionId = data.id;
        this.estudianteNombre = data.estudiante;
        this.$dispatch('open-modal', 'approve-justificacion-modal');
    }
}"
@open-modal-data.window="if ($event.detail.modal === 'approve-justificacion-modal') openApprove($event.detail.data)">
    <x-modal name="approve-justificacion-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Aprobar Justificación
            </h2>

            <form :action="`{{ route('justificaciones.index') }}/${justificacionId}/aprobar`" method="POST">
                @csrf

                <div class="space-y-4">
                    <div class="flex items-center justify-center">
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900/30">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            ¿Está seguro de aprobar esta justificación?
                        </p>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" x-text="estudianteNombre"></p>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-600 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400 dark:text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-400">
                                    Al aprobar, la asistencia cambiará a "Justificado" y no se podrá editar.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t mt-6">
                    <x-secondary-button type="button" @click="$dispatch('close-modal', 'approve-justificacion-modal')">
                        Cancelar
                    </x-secondary-button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Aprobar
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
