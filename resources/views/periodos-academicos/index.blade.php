<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Periodos Académicos') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="periodosTable"
                        :headers="[
                            ['label' => 'ID', 'type' => 'number'],
                            ['label' => 'Nombre', 'type' => 'string'],
                            ['label' => 'Fecha Inicio', 'type' => 'date'],
                            ['label' => 'Fecha Fin', 'type' => 'date'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte periodos académicos', 'gestionar periodos académicos'])"
                        :excel="auth()->user()->canany(['generar reporte periodos académicos', 'gestionar periodos académicos'])"
                        :pdf="auth()->user()->canany(['generar reporte periodos académicos', 'gestionar periodos académicos'])"
                        :print="auth()->user()->canany(['generar reporte periodos académicos', 'gestionar periodos académicos'])"
                        :json="auth()->user()->canany(['generar reporte periodos académicos', 'gestionar periodos académicos'])"
                    >
                        <x-slot name="buttons">
                            @canany(['crear periodos académicos', 'gestionar periodos académicos'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-periodo')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Nuevo Periodo
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($periodos as $periodo)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $periodo->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $periodo->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $periodo->fecha_inicio->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $periodo->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($periodo->estado === 'activo')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                Activo
                                            </span>
                                        @elseif($periodo->estado === 'inactivo')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                Inactivo
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                Finalizado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        @canany(['editar periodos académicos', 'gestionar periodos académicos'])
                                            <button x-data
                                                    @click="$dispatch('open-modal', 'edit-periodo-{{ $periodo->id }}')"
                                                    class="text-theme-primary dark:text-theme-primary-light hover:text-theme-primary-dark dark:hover:text-theme-secondary transition-colors duration-200"
                                                    title="Editar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                        @endcanany

                                        @canany(['eliminar periodos académicos', 'gestionar periodos académicos'])
                                            <button x-data
                                                    @click="$dispatch('open-modal', 'delete-periodo-{{ $periodo->id }}')"
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
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay periodos académicos registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Periodo -->
    @canany(['crear periodos académicos', 'gestionar periodos académicos'])
        <x-modal name="create-periodo" title="Nuevo Periodo Académico" maxWidth="2xl">
            <form method="POST" action="{{ route('periodos-academicos.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre del Periodo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                               placeholder="Ej: 2024-2025" required>
                        @error('nombre')
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

                    <!-- Estado -->
                    <div class="md:col-span-2">
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="estado" id="estado"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                required>
                            <option value="">Seleccione...</option>
                            <option value="activo" {{ old('estado') === 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado') === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                            <option value="finalizado" {{ old('estado') === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                        </select>
                        @error('estado')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                            @click="$dispatch('close-modal', 'create-periodo')"
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

    <!-- Modales Editar (uno por cada periodo) -->
    @canany(['editar periodos académicos', 'gestionar periodos académicos'])
        @foreach($periodos as $periodo)
            <x-modal name="edit-periodo-{{ $periodo->id }}" title="Editar Periodo Académico" maxWidth="2xl">
                <form method="POST" action="{{ route('periodos-academicos.update', $periodo) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="md:col-span-2">
                            <label for="edit_nombre_{{ $periodo->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre del Periodo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nombre" id="edit_nombre_{{ $periodo->id }}"
                                   value="{{ old('nombre', $periodo->nombre) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('nombre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Inicio -->
                        <div>
                            <label for="edit_fecha_inicio_{{ $periodo->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_inicio" id="edit_fecha_inicio_{{ $periodo->id }}"
                                   value="{{ old('fecha_inicio', $periodo->fecha_inicio->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('fecha_inicio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Fin -->
                        <div>
                            <label for="edit_fecha_fin_{{ $periodo->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha de Fin <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="fecha_fin" id="edit_fecha_fin_{{ $periodo->id }}"
                                   value="{{ old('fecha_fin', $periodo->fecha_fin->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                   required>
                            @error('fecha_fin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="md:col-span-2">
                            <label for="edit_estado_{{ $periodo->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Estado <span class="text-red-500">*</span>
                            </label>
                            <select name="estado" id="edit_estado_{{ $periodo->id }}"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light"
                                    required>
                                <option value="activo" {{ old('estado', $periodo->estado) === 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="inactivo" {{ old('estado', $periodo->estado) === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="finalizado" {{ old('estado', $periodo->estado) === 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                            @error('estado')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button"
                                @click="$dispatch('close-modal', 'edit-periodo-{{ $periodo->id }}')"
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

    <!-- Modales Eliminar (uno por cada periodo) -->
    @canany(['eliminar periodos académicos', 'gestionar periodos académicos'])
        @foreach($periodos as $periodo)
            <x-modal name="delete-periodo-{{ $periodo->id }}" title="Eliminar Periodo Académico" maxWidth="md">
                <form method="POST" action="{{ route('periodos-academicos.destroy', $periodo) }}" class="p-6">
                    @csrf
                    @method('DELETE')

                    <div class="mb-6">
                        <p class="text-gray-700 dark:text-gray-300">
                            ¿Está seguro que desea eliminar el periodo académico <strong>{{ $periodo->nombre }}</strong>?
                        </p>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-2">
                            Esta acción no se puede deshacer y eliminará todos los datos relacionados.
                        </p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button"
                                @click="$dispatch('close-modal', 'delete-periodo-{{ $periodo->id }}')"
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
