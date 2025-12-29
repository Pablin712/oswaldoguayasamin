<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Estudiantes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="estudiantesTable"
                        :headers="[
                            ['label' => 'Código', 'type' => 'string'],
                            ['label' => 'Nombre Completo', 'type' => 'string'],
                            ['label' => 'Cédula', 'type' => 'string'],
                            ['label' => 'Fecha Ingreso', 'type' => 'date'],
                            ['label' => 'Tipo Sangre', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte estudiantes', 'generar reportes'])"
                        :excel="auth()->user()->canany(['generar reporte estudiantes', 'generar reportes'])"
                        :pdf="auth()->user()->canany(['generar reporte estudiantes', 'generar reportes'])"
                        :print="auth()->user()->canany(['generar reporte estudiantes', 'generar reportes'])"
                        :json="auth()->user()->canany(['generar reporte estudiantes', 'generar reportes'])"
                    >
                        <x-slot name="buttons">
                            @canany(['gestionar estudiantes', 'crear estudiantes'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-estudiante-modal')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('Nuevo Estudiante') }}
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($estudiantes as $estudiante)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $estudiante->codigo_estudiante }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $estudiante->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $estudiante->user->cedula }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $estudiante->fecha_ingreso ? $estudiante->fecha_ingreso->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $estudiante->tipo_sangre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($estudiante->estado === 'activo')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                Activo
                                            </span>
                                        @elseif($estudiante->estado === 'inactivo')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                                Inactivo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                Retirado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('estudiantes.show', $estudiante) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors"
                                                title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @canany(['gestionar estudiantes', 'editar estudiantes'])
                                                <button type="button"
                                                    @click="$dispatch('open-edit-modal', {
                                                        id: {{ $estudiante->id }},
                                                        codigo_estudiante: {{ json_encode($estudiante->codigo_estudiante) }},
                                                        nombre_completo: {{ json_encode($estudiante->user->name) }},
                                                        cedula: {{ json_encode($estudiante->user->cedula) }},
                                                        email: {{ json_encode($estudiante->user->email) }},
                                                        telefono: {{ json_encode($estudiante->user->telefono) }},
                                                        direccion: {{ json_encode($estudiante->user->direccion) }},
                                                        fecha_nacimiento: {{ json_encode($estudiante->user->fecha_nacimiento) }},
                                                        fecha_ingreso: {{ json_encode($estudiante->fecha_ingreso?->format('Y-m-d')) }},
                                                        tipo_sangre: {{ json_encode($estudiante->tipo_sangre) }},
                                                        alergias: {{ json_encode($estudiante->alergias) }},
                                                        contacto_emergencia: {{ json_encode($estudiante->contacto_emergencia) }},
                                                        telefono_emergencia: {{ json_encode($estudiante->telefono_emergencia) }},
                                                        estado: {{ json_encode($estudiante->estado) }}
                                                    })"
                                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors"
                                                    title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            @endcanany

                                            @canany(['gestionar estudiantes', 'eliminar estudiantes'])
                                                <button type="button"
                                                    @click="$dispatch('open-delete-modal', { id: {{ $estudiante->id }}, name: {{ json_encode($estudiante->user->name) }} })"
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-colors"
                                                    title="Eliminar">
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
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No hay estudiantes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    @canany(['crear estudiantes', 'gestionar estudiantes'])
        @include('usuarios.estudiantes.create')
    @endcanany

    @canany(['editar estudiantes', 'gestionar estudiantes'])
        @include('usuarios.estudiantes.edit')
    @endcanany

    @canany(['eliminar estudiantes', 'gestionar estudiantes'])
        @include('usuarios.estudiantes.delete')
    @endcanany
</x-app-layout>
