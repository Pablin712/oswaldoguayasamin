{{-- Modal para crear parcial --}}
<x-modal name="create-parcial" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('parciales.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Parcial') }}
        </h2>

        <!-- Quimestre -->
        <div class="mb-4">
            <x-input-label for="quimestre_id" :value="__('Quimestre')" />
            <select id="quimestre_id" name="quimestre_id" required
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                <option value="">Seleccione un quimestre</option>
                @foreach($quimestres as $quimestre)
                    <option value="{{ $quimestre->id }}" {{ old('quimestre_id') == $quimestre->id ? 'selected' : '' }}>
                        {{ $quimestre->nombre }} - {{ $quimestre->periodoAcademico->nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('quimestre_id')" class="mt-2" />
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required maxlength="100" placeholder="Ej: Primer Parcial" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Número -->
        <div class="mb-4">
            <x-input-label for="numero" :value="__('Número')" />
            <x-text-input id="numero" class="block mt-1 w-full" type="number" name="numero" :value="old('numero')" required min="1" placeholder="Ej: 1" />
            <x-input-error :messages="$errors->get('numero')" class="mt-2" />
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                <x-text-input id="fecha_inicio" class="block mt-1 w-full" type="date" name="fecha_inicio" :value="old('fecha_inicio')" required />
                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="fecha_fin" :value="__('Fecha de Fin')" />
                <x-text-input id="fecha_fin" class="block mt-1 w-full" type="date" name="fecha_fin" :value="old('fecha_fin')" required />
                <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
            </div>
        </div>

        <!-- Permite Edición -->
        <div class="mb-4">
            <x-input-label for="permite_edicion" :value="__('¿Permite Edición?')" />
            <select id="permite_edicion" name="permite_edicion" required
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                <option value="1" {{ old('permite_edicion', '1') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ old('permite_edicion') == '0' ? 'selected' : '' }}>No</option>
            </select>
            <x-input-error :messages="$errors->get('permite_edicion')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-parcial')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Parcial') }}
            </button>
        </div>
    </form>
</x-modal>
