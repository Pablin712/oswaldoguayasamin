{{-- Modal para crear quimestre --}}
<x-modal name="create-quimestre" maxWidth="2xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('quimestres.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Quimestre') }}
        </h2>

        <!-- Periodo Académico -->
        <div class="mb-4">
            <x-input-label for="periodo_academico_id" :value="__('Periodo Académico')" />
            <select id="periodo_academico_id" name="periodo_academico_id" required
                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                <option value="">Seleccione un periodo académico</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ old('periodo_academico_id') == $periodo->id ? 'selected' : '' }}>
                        {{ $periodo->nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('periodo_academico_id')" class="mt-2" />
        </div>

        <!-- Nombre -->
        <div class="mb-4">
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required maxlength="100" placeholder="Ej: Primer Quimestre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Número -->
        <div class="mb-4">
            <x-input-label for="numero" :value="__('Número')" />
            <x-text-input id="numero" class="block mt-1 w-full" type="number" name="numero" :value="old('numero')" required min="1" max="2" placeholder="Ej: 1" />
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

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-quimestre')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Quimestre') }}
            </button>
        </div>
    </form>
</x-modal>
