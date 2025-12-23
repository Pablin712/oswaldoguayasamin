{{-- Modal para editar rol --}}
<x-modal name="edit-role" maxWidth="2xl" focusable>
    <div x-data="{
        roleId: null,
        roleName: '',
        rolePermissions: [],
        openEdit(id, name, permissions) {
            this.roleId = id;
            this.roleName = name;
            this.rolePermissions = permissions;
            $dispatch('open-modal', 'edit-role');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.name, $event.detail.permissions)"
    class="p-6">
        <form method="POST" :action="`{{ route('roles.index') }}/${roleId}`" x-ref="editForm">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Rol') }}
            </h2>

            <!-- Nombre -->
            <div class="mb-4">
                <x-input-label for="edit_name" :value="__('Nombre del Rol')" />
                <input id="edit_name"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="text"
                       name="name"
                       x-model="roleName"
                       required />
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Permisos -->
            <div class="mb-6">
                <x-input-label for="edit_permissions" :value="__('Permisos')" />
                <div class="mt-2 space-y-2 max-h-64 overflow-y-auto p-2 border border-gray-300 dark:border-gray-700 rounded-md">
                    @foreach($permissions as $permission)
                        <label class="flex items-center mr-6">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->name }}"
                                   x-bind:checked="rolePermissions.includes('{{ $permission->name }}')"
                                   class="rounded border-gray-300 text-theme-primary shadow-sm focus:ring-theme-primary">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('permissions')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-role')" type="button">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-primary-button>
                    {{ __('Actualizar Rol') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
