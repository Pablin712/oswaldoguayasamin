{{-- Modal para crear curso --}}
<x-modal name="create-curso" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('cursos.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Curso') }}
        </h2>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required maxlength="100" placeholder="Ej: 1ro BGU A" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Nivel -->
        <div class="mb-4">
            <x-input-label for="nivel" :value="__('Nivel')" />
            <select id="nivel" name="nivel" required
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                <option value="">Seleccione un nivel</option>
                <option value="Básica" {{ old('nivel') == 'Básica' ? 'selected' : '' }}>Básica</option>
                <option value="Bachillerato" {{ old('nivel') == 'Bachillerato' ? 'selected' : '' }}>Bachillerato</option>
            </select>
            <x-input-error :messages="$errors->get('nivel')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-curso')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Curso') }}
            </button>
        </div>
    </form>
</x-modal>
