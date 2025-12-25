{{-- Modal de confirmación de eliminación de rol --}}
<x-modal name="delete-user" maxWidth="md" focusable>
    <div x-data="{
        userId: null,
        userName: '',
        openDelete(id, name) {
            this.userId = id;
            this.userName = name;
            $dispatch('open-modal', 'delete-user');
        }
    }"
    @open-delete-modal.window="openDelete($event.detail.id, $event.detail.name)"
    class="p-6">
        <form method="POST" :action="`{{ route('users.index') }}/${userId}`" x-ref="deleteForm">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Eliminar Usuario') }}
            </h2>

            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                {{ __('¿Estás seguro de que deseas eliminar el usuario') }} "<span class="font-semibold" x-text="userName"></span>"? {{ __('Esta acción no se puede deshacer.') }}
            </p>

            <div class="flex items-center justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-user')" type="button">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-danger-button>
                    {{ __('Eliminar Usuario') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</x-modal>
