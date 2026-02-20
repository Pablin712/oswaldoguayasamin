<!-- Modal de Eliminación -->
<x-modal name="delete-notificacion-modal"
         :show="false"
         maxWidth="md"
         x-data="{
             notificacionData: {
                 id: null,
                 titulo: ''
             }
         }"
         @open-delete-modal.window="
             notificacionData = $event.detail;
             $dispatch('open-modal', 'delete-notificacion-modal');
         ">
    <form :action="`{{ route('notificaciones.index') }}/${notificacionData.id}`"
          method="POST"
          class="p-6">
        @csrf
        @method('DELETE')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Eliminar Notificación
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            ¿Está seguro de que desea eliminar esta notificación?
        </p>

        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6">
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                <span class="text-gray-600 dark:text-gray-400">Título:</span>
                <span x-text="notificacionData.titulo"></span>
            </p>
        </div>

        <p class="text-sm text-red-600 dark:text-red-400 mb-6">
            Esta acción no se puede deshacer.
        </p>

        <div class="flex justify-end gap-3">
            <x-secondary-button type="button" @click="$dispatch('close-modal', 'delete-notificacion-modal')">
                Cancelar
            </x-secondary-button>

            <x-danger-button type="submit">
                Eliminar
            </x-danger-button>
        </div>
    </form>
</x-modal>
