<div x-data="{
    justificacionId: null,
    estudianteNombre: '',
    motivo_rechazo: '',

    openReject(data) {
        this.justificacionId = data.id;
        this.estudianteNombre = data.estudiante;
        this.motivo_rechazo = '';
        this.$dispatch('open-modal', 'reject-justificacion-modal');
    }
}"
@open-modal-data.window="if ($event.detail.modal === 'reject-justificacion-modal') openReject($event.detail.data)">
    <x-modal name="reject-justificacion-modal" maxWidth="lg">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Rechazar Justificación
            </h2>

            <form :action="`{{ route('justificaciones.index') }}/${justificacionId}/rechazar`" method="POST">
                @csrf

                <div class="space-y-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        ¿Está seguro de rechazar la justificación de <strong x-text="estudianteNombre"></strong>?
                    </p>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-600 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                    Al rechazar, la asistencia mantendrá su estado original. Se recomienda proporcionar un motivo.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="motivo_rechazo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Motivo del Rechazo (opcional)
                        </label>
                        <textarea name="motivo_rechazo" id="motivo_rechazo" x-model="motivo_rechazo" rows="4"
                                  class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                  placeholder="Explique por qué se rechaza la justificación (ej: documento ilegible, fecha incorrecta, etc.)"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-6 border-t mt-6">
                    <x-secondary-button type="button" @click="$dispatch('close-modal', 'reject-justificacion-modal')">
                        Cancelar
                    </x-secondary-button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
