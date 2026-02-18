<div x-data="{
    justificacionId: null,
    motivo: '',
    archivo_existente: '',

    openEdit(id) {
        this.justificacionId = id;
        this.fetchJustificacionData(id);
    },

    async fetchJustificacionData(id) {
        try {
            const response = await fetch(`/justificaciones/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();

            this.motivo = data.motivo || '';
            this.archivo_existente = data.archivo_adjunto || '';

            this.$dispatch('open-modal', 'edit-justificacion-modal');
        } catch (error) {
            console.error('Error loading data:', error);
            alert('Error al cargar los datos de la justificación');
        }
    }
}"
@open-modal-data.window="if ($event.detail.modal === 'edit-justificacion-modal') openEdit($event.detail.data)">
    <x-modal name="edit-justificacion-modal" maxWidth="2xl">
        <form :action="`{{ route('justificaciones.index') }}/${justificacionId}`" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Editar Justificación
            </h2>

            <div class="space-y-4">
                <!-- Motivo -->
                <div>
                    <label for="edit_motivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Motivo <span class="text-red-500">*</span>
                    </label>
                    <textarea name="motivo" id="edit_motivo" x-model="motivo" rows="4" required
                              class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                              placeholder="Describa el motivo de la ausencia..."></textarea>
                    @error('motivo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Archivo adjunto actual -->
                <div x-show="archivo_existente">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Archivo Actual
                    </label>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <a :href="`/storage/${archivo_existente}`" target="_blank"
                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                            Ver archivo adjunto
                        </a>
                    </div>
                </div>

                <!-- Nuevo archivo adjunto -->
                <div>
                    <label for="edit_archivo_adjunto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nuevo Archivo Adjunto (opcional)
                    </label>
                    <input type="file" name="archivo_adjunto" id="edit_archivo_adjunto" accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Si sube un nuevo archivo, reemplazará el anterior
                    </p>
                    @error('archivo_adjunto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-600 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                Solo puede editar justificaciones que estén en estado pendiente.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Actualizar') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
