<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Quimestres') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="quimestresTable"
                        :headers="[
                            ['label' => 'ID', 'type' => 'number'],
                            ['label' => 'Nombre', 'type' => 'string'],
                            ['label' => 'Número', 'type' => 'number'],
                            ['label' => 'Periodo Académico', 'type' => 'string'],
                            ['label' => 'Fecha Inicio', 'type' => 'date'],
                            ['label' => 'Fecha Fin', 'type' => 'date'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte quimestres', 'gestionar quimestres'])"
                        :excel="auth()->user()->canany(['generar reporte quimestres', 'gestionar quimestres'])"
                        :pdf="auth()->user()->canany(['generar reporte quimestres', 'gestionar quimestres'])"
                        :print="auth()->user()->canany(['generar reporte quimestres', 'gestionar quimestres'])"
                        :json="auth()->user()->canany(['generar reporte quimestres', 'gestionar quimestres'])"
                    >
                        <x-slot name="buttons">
                            @canany(['crear quimestres', 'gestionar quimestres'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-quimestre')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Nuevo Quimestre
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($quimestres as $quimestre)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $quimestre->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $quimestre->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            Q{{ $quimestre->numero }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $quimestre->periodoAcademico->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $quimestre->fecha_inicio->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $quimestre->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        @canany(['editar quimestres', 'gestionar quimestres'])
                                            <button x-data
                                                    @click="$dispatch('open-modal', 'edit-quimestre-{{ $quimestre->id }}')"
                                                    class="text-theme-primary dark:text-theme-primary-light hover:text-theme-primary-dark dark:hover:text-theme-secondary transition-colors duration-200"
                                                    title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endcanany

                                        @canany(['eliminar quimestres', 'gestionar quimestres'])
                                            <button x-data
                                                    @click="$dispatch('open-modal', 'delete-quimestre-{{ $quimestre->id }}')"
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200"
                                                    title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        @endcanany
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay quimestres registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Quimestre -->
    @canany(['crear quimestres', 'gestionar quimestres'])
        <x-modal name="create-quimestre" title="Nuevo Quimestre" maxWidth="2xl">
            <form method="POST" action="{{ route('quimestres.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Periodo Académico -->
                    <div class="md:col-span-2">
                        <label for="periodo_academico_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Periodo Académico <span class="text-red-500">*</span>
                        </label>
                        <select name="periodo_academico_id" id="periodo_academico_id"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                required>
                            <option value="">Seleccione...</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ old('periodo_academico_id') == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('periodo_academico_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                               placeholder="Ej: Primer Quimestre" required>
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número -->
                    <div>
                        <label for="numero" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Número <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="numero" id="numero" value="{{ old('numero', 1) }}"
                               min="1" max="4"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                               required>
                        @error('numero')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha Inicio -->
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Inicio <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                               required>
                        @error('fecha_inicio')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha Fin -->
                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha de Fin <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                               required>
                        @error('fecha_fin')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                            @click="$dispatch('close-modal', 'create-quimestre')"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-theme-primary dark:bg-theme-third text-white rounded-md hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition-colors duration-200">
                        Guardar
                    </button>
                </div>
            </form>
        </x-modal>
    @endcanany

    <!-- Modales Editar -->
    @canany(['editar quimestres', 'gestionar quimestres'])
        @foreach($quimestres as $quimestre)
            <x-modal name="edit-quimestre-{{ $quimestre->id }}" title="Editar Quimestre" maxWidth="2xl">
                <form method="POST" action="{{ route('quimestres.update', $quimestre) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Periodo Académico -->
                        <div class="md:col-span-2">
                            <label for="edit_periodo_academico_id_{{ $quimestre->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Periodo Académico <span class="text-red-500">*</span>
                            </label>
                            <select name="periodo_academico_id" id="edit_periodo_academico_id_{{ $quimestre->id }}"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                    required>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ old('periodo_academico_id', $quimestre->periodo_academico_id) == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('periodo_academico_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="edit_nombre_{{ $quimestre->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" id="edit_nombre_{{ $quimestre->id }}"
                                   value="{{ old('nombre', $quimestre->nombre) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Número -->
                        <div>
                            <label for="edit_numero_{{ $quimestre->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Número <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="numero" id="edit_numero_{{ $quimestre->id }}"
                                   value="{{ old('numero', $quimestre->numero) }}"
                                   min="1" max="4"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('numero')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Inicio -->
                        <div>
                            <label for="edit_fecha_inicio_{{ $quimestre->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_inicio" id="edit_fecha_inicio_{{ $quimestre->id }}"
                                   value="{{ old('fecha_inicio', $quimestre->fecha_inicio->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('fecha_inicio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Fin -->
                        <div>
                            <label for="edit_fecha_fin_{{ $quimestre->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha de Fin <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_fin" id="edit_fecha_fin_{{ $quimestre->id }}"
                                   value="{{ old('fecha_fin', $quimestre->fecha_fin->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('fecha_fin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button"
                                @click="$dispatch('close-modal', 'edit-quimestre-{{ $quimestre->id }}')"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-theme-primary dark:bg-theme-third text-white rounded-md hover:bg-theme-primary-dark dark:hover:bg-theme-secondary transition-colors duration-200">
                            Actualizar
                        </button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endcanany

    <!-- Modales Eliminar -->
    @canany(['eliminar quimestres', 'gestionar quimestres'])
        @foreach($quimestres as $quimestre)
            <x-modal name="delete-quimestre-{{ $quimestre->id }}" title="Eliminar Quimestre" maxWidth="md">
                <form method="POST" action="{{ route('quimestres.destroy', $quimestre) }}" class="p-6">
                    @csrf
                    @method('DELETE')

                    <div class="mb-6">
                        <p class="text-gray-700 dark:text-gray-300">
                            ¿Está seguro que desea eliminar el quimestre <strong>{{ $quimestre->nombre }}</strong>?
                        </p>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-2">
                            Esta acción no se puede deshacer y eliminará todos los datos relacionados.
                        </p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button"
                                @click="$dispatch('close-modal', 'delete-quimestre-{{ $quimestre->id }}')"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 dark:bg-red-700 text-white rounded-md hover:bg-red-700 dark:hover:bg-red-800 transition-colors duration-200">
                            Eliminar
                        </button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endcanany
</x-app-layout>
