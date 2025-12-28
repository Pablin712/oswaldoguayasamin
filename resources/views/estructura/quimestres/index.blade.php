<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Quimestres') }}
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
                            @canany(['gestionar quimestres', 'crear quimestres'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-quimestre')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('Nuevo Quimestre') }}
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($quimestres as $quimestre)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $quimestre->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $quimestre->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                            Q{{ $quimestre->numero }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $quimestre->periodoAcademico->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $quimestre->fecha_inicio->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $quimestre->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @canany(['gestionar quimestres', 'editar quimestres'])
                                                <button x-data
                                                        @click="$dispatch('open-edit-modal', {
                                                            id: {{ $quimestre->id }},
                                                            periodo_academico_id: {{ $quimestre->periodo_academico_id }},
                                                            nombre: '{{ addslashes($quimestre->nombre) }}',
                                                            numero: {{ $quimestre->numero }},
                                                            fecha_inicio: '{{ $quimestre->fecha_inicio->format('Y-m-d') }}',
                                                            fecha_fin: '{{ $quimestre->fecha_fin->format('Y-m-d') }}'
                                                        })"
                                                        class="text-theme-primary hover:text-theme-primary-dark dark:text-theme-primary-light dark:hover:text-theme-secondary transition-colors"
                                                        title="Editar quimestre">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            @endcanany
                                            @canany(['gestionar quimestres', 'eliminar quimestres'])
                                                <button x-data
                                                        @click="$dispatch('open-delete-modal', {
                                                            id: {{ $quimestre->id }},
                                                            nombre: '{{ addslashes($quimestre->nombre) }}'
                                                        })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                        title="Eliminar quimestre">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @endcanany
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay quimestres registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    {{-- Incluir modales --}}
    @canany(['gestionar quimestres', 'crear quimestres'])
        @include('estructura.quimestres.create')
    @endcanany
    @canany(['gestionar quimestres', 'editar quimestres'])
        @include('estructura.quimestres.edit')
    @endcanany
    @canany(['gestionar quimestres', 'eliminar quimestres'])
        @include('estructura.quimestres.delete')
    @endcanany
</x-app-layout>
