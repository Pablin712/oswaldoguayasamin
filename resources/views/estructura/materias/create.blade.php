{{-- Modal para crear materia --}}
<x-modal name="create-materia" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('materias.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nueva Materia') }}
        </h2>

        <!-- Código -->
        <div class="mb-4">
            <x-input-label for="codigo" :value="__('Código')" />
            <x-text-input id="codigo" class="block mt-1 w-full" type="text" name="codigo" :value="old('codigo')" required maxlength="20" placeholder="Ej: MAT-001" />
            <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required maxlength="150" placeholder="Ej: Matemáticas" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Área -->
        <div class="mb-4">
            <x-input-label for="area_id" :value="__('Área')" />
            <select id="area_id" name="area_id" required
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                <option value="">{{ __('Seleccione un área') }}</option>
                @foreach($areas as $area)
                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                        {{ $area->nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
        </div>

        <!-- Color -->
        <div class="mb-4">
            <x-input-label for="color" :value="__('Color')" />
            <div class="flex gap-2 items-center mt-1">
                <input id="color" class="block h-10 w-20 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary" type="color" name="color" value="{{ old('color', '#3B82F6') }}" required />
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Seleccione el color para identificar la materia') }}</span>
            </div>
            <x-input-error :messages="$errors->get('color')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-materia')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Materia') }}
            </button>
        </div>
    </form>
</x-modal>
