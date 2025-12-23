{{-- Modal para editar usuario --}}
<x-modal name="edit-user" maxWidth="2xl" focusable>
    <div x-data="{
        userId: null,
        userName: '',
        userEmail: '',
        userRoles: [],
        openEdit(id, name, email, roles) {
            this.userId = id;
            this.userName = name;
            this.userEmail = email;
            this.userRoles = roles;
            $dispatch('open-modal', 'edit-user');
        }
    }"
    @open-edit-modal.window="openEdit($event.detail.id, $event.detail.name, $event.detail.email, $event.detail.roles)"
    class="p-6">
        <form method="POST" :action="`{{ route('users.index') }}/${userId}`" x-ref="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Usuario') }}
            </h2>

            <!-- Foto de perfil -->
            <div class="mb-4">
                <x-input-label for="edit_foto" :value="__('Foto de Perfil (opcional)')" />
                <input type="file"
                       id="edit_foto"
                       name="foto"
                       accept="image/*"
                       class="block w-full mt-1 text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-theme-primary">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB. Deja vacío para mantener la foto actual.</p>
                @error('foto')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div class="mb-4">
                <x-input-label for="edit_name" :value="__('Nombre')" />
                <input id="edit_name"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="text"
                       name="name"
                       x-model="userName"
                       required />
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="edit_email" :value="__('Email')" />
                <input id="edit_email"
                       class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                       type="email"
                       name="email"
                       x-model="userEmail"
                       required />
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <x-input-label for="edit_password" :value="__('Nueva Contraseña (opcional)')" />
                <x-text-input id="edit_password" class="block mt-1 w-full" type="password" name="password" />
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Deja este campo vacío si no deseas cambiar la contraseña.</p>
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-4">
                <x-input-label for="edit_password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                <x-text-input id="edit_password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Roles -->
            <div class="mb-6">
                <x-input-label for="edit_roles" :value="__('Roles')" />
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center mr-6">
                            <input type="checkbox"
                                   name="roles[]"
                                   value="{{ $role->name }}"
                                   x-bind:checked="userRoles.includes('{{ $role->name }}')"
                                   class="rounded border-gray-300 text-theme-primary shadow-sm focus:ring-theme-primary">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('roles')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-user')" type="button">
                    {{ __('Cancelar') }}
                </x-secondary-button>
                <x-primary-button>
                    {{ __('Actualizar Usuario') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
