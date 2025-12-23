{{-- Modal para crear usuario --}}
<x-modal name="create-role" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('roles.store') }}" class="p-6" enctype="multipart/form-data">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Rol') }}
        </h2>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Permisos -->
        <div class="mb-6">
            <x-input-label for="permissions" :value="__('Permisos')" />
            <div class="mt-2 space-y-2">
                @foreach($permissions as $permission)
                    <label class="inline-flex items-center mr-6">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                               {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-theme-primary shadow-sm focus:ring-theme-primary">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
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
