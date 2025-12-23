{{-- Modal de confirmación de eliminación de rol --}}
<x-modal name="delete-role" maxWidth="md" focusable>
    <div x-data="{
        roleId: null,
        roleName: '',
        openDelete(id, name) {
            this.roleId = id;
            this.roleName = name;
            $dispatch('open-modal', 'delete-role');
        }
    }"
    @open-delete-modal.window="openDelete($event.detail.id, $event.detail.name)"
    class="p-6">
        <form method="POST" :action="`{{ route('roles.index') }}/${roleId}`" x-ref="deleteForm">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Eliminar Rol') }}
            </h2>

            <p class="mb-6 text-sm text-gray-600 dark:text-gray-400">
                {{ __('¿Estás seguro de que deseas eliminar el rol') }} "<span class="font-semibold" x-text="roleName"></span>"? {{ __('Esta acción no se puede deshacer.') }}
            </p>

            <div class="flex items-center justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-role')" type="button">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-danger-button>
                    {{ __('Eliminar Rol') }}
                </x-danger-button>
            </div>
        </form>
    </div>
</x-modal>
