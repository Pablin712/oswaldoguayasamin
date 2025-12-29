<div x-data="{
    id: null,
    name: ''
}" @open-delete-modal.window="
    id = $event.detail.id;
    name = $event.detail.name;
    $dispatch('open-modal', 'delete-paralelo-modal');
">
    <x-modal name="delete-paralelo-modal" maxWidth="md">
        <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            ¿Eliminar Paralelo?
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            ¿Estás seguro de que deseas eliminar el paralelo <strong x-text="name"></strong>?
        </p>

        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 dark:border-yellow-600 p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">
                        <strong>Advertencia:</strong> Si este paralelo tiene estudiantes matriculados, docentes asignados o registros asociados, no se podrá eliminar.
                    </p>
                </div>
            </div>
        </div>

        <form :action="`/paralelos/${id}`" method="POST">
            @csrf
            @method('DELETE')

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button type="button" @click="$dispatch('close-modal', 'delete-paralelo-modal')">
                    Cancelar
                </x-secondary-button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Eliminar
                </button>
            </div>
        </form>
    </div>
    </x-modal>
</div>
