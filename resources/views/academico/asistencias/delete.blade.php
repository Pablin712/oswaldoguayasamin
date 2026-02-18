<x-modal name="delete-asistencia-modal" maxWidth="md" focusable>
    <div x-data="{
        asistenciaId: null,
        asistenciaName: '',
        openDelete(id, name) {
            this.asistenciaId = id;
            this.asistenciaName = name;
            $dispatch('open-modal', 'delete-asistencia-modal');
        }
    }"
    @open-delete-modal.window="openDelete($event.detail.id, $event.detail.name)"
    class="p-6">
        <form method="POST" :action="`{{ route('asistencias.index') }}/${asistenciaId}`">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                ¿Estás seguro de eliminar este registro de asistencia?
            </h2>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                Se eliminará el registro de asistencia de: <strong x-text="asistenciaName"></strong>
            </p>

            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                Esta acción no se puede deshacer.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'delete-asistencia-modal')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button type="submit">
                    {{ __('Eliminar') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</x-modal>
