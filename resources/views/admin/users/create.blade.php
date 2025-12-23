{{-- Modal para crear usuario --}}
<x-modal name="create-user" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('users.store') }}" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Usuario') }}
        </h2>

        <!-- Foto de perfil -->
        <div class="mb-4">
            <x-input-label for="create_foto" :value="__('Foto de Perfil (opcional)')" />
            <input type="file"
                   id="create_foto"
                   name="foto"
                   accept="image/*"
                   class="block w-full mt-1 text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-theme-primary">
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB</p>
            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mb-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div class="mb-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Roles -->
        <div class="mb-6">
            <x-input-label for="roles" :value="__('Roles')" />
            <div class="mt-2 space-y-2">
                @foreach($roles as $role)
                    <label class="inline-flex items-center mr-6">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                               {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-theme-primary shadow-sm focus:ring-theme-primary">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-4">
            <x-secondary-button x-on:click="$dispatch('close-modal', 'create-user')" type="button">
                {{ __('Cancelar') }}
            </x-secondary-button>
            <x-primary-button>
                {{ __('Crear Usuario') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
