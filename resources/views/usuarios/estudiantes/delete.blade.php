<div x-data="{
    deleteData: {
        id: null,
        name: ''
    }
}"
@open-delete-modal.window="
    deleteData = $event.detail;
    $dispatch('open-modal', 'delete-estudiante-modal');
">
    <x-modal name="delete-estudiante-modal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Eliminar Estudiante
            </h2>

            <form method="POST" :action="`{{ route('estudiantes.index') }}/${deleteData.id}`">
            @csrf
            @method('DELETE')

            <div class="space-y-4">
                <div class="flex items-center justify-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-lg font-medium text-gray-900">
                        ¿Está seguro de eliminar este estudiante?
                    </p>
                    <p class="mt-2 text-sm text-gray-500" x-text="deleteData.name"></p>
                    <p class="mt-3 text-sm text-red-600 font-medium">
                        Se eliminará el estudiante y su usuario asociado. Esta acción no se puede deshacer.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t mt-6">
                <button type="button" @click="$dispatch('close-modal', 'delete-estudiante-modal')" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Cancelar
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                    Sí, Eliminar
                </button>
            </div>
        </form>
        </div>
    </x-modal>
</div>
