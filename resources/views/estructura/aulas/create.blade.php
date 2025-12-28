{{-- Modal para crear aula --}}
<x-modal name="create-aula" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('aulas.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nueva Aula') }}
        </h2>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required maxlength="100" placeholder="Ej: Aula 101" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Capacidad -->
        <div class="mb-4">
            <x-input-label for="capacidad" :value="__('Capacidad')" />
            <x-text-input id="capacidad" class="block mt-1 w-full" type="number" name="capacidad" :value="old('capacidad')" required min="1" placeholder="Ej: 30" />
            <x-input-error :messages="$errors->get('capacidad')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-aula')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Aula') }}
            </button>
        </div>
    </form>
</x-modal>
