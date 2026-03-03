{{-- Modal para eliminar horario --}}
<x-modal name="delete-horario" maxWidth="md" focusable>
    <div x-data="{
        horarioId: null,
        descripcion: '',
        openDelete(id, paralelo, materia, dia, horario) {
            this.horarioId = id;
            this.descripcion = `${paralelo} - ${materia} - ${dia} (${horario})`;
            $dispatch('open-modal', 'delete-horario');
        }
    }"
    @open-delete-modal.window="openDelete($event.detail.id, $event.detail.paralelo, $event.detail.materia, $event.detail.dia, $event.detail.horario)"
    class="p-6">
        <form method="POST" :action="`{{ route('horarios.index') }}/${horarioId}`" x-ref="deleteForm">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Eliminar Horario') }}
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                {{ __('¿Está seguro de que desea eliminar este horario?') }}
            </p>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100" x-text="descripcion"></p>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700 dark:text-yellow-300">
                            {{ __('Esta acción no se puede deshacer. El horario será eliminado permanentemente.') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                        class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Eliminar') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
