<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Docentes') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="docentesTable"
                        :headers="[
                            ['label' => 'Código', 'type' => 'string'],
                            ['label' => 'Nombre Completo', 'type' => 'string'],
                            ['label' => 'Cédula', 'type' => 'string'],
                            ['label' => 'Especialidad', 'type' => 'string'],
                            ['label' => 'Tipo Contrato', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte docentes', 'gestionar docentes'])"
                        :excel="auth()->user()->canany(['generar reporte docentes', 'gestionar docentes'])"
                        :pdf="auth()->user()->canany(['generar reporte docentes', 'gestionar docentes'])"
                        :print="auth()->user()->canany(['generar reporte docentes', 'gestionar docentes'])"
                        :json="auth()->user()->canany(['generar reporte docentes', 'gestionar docentes'])"
                    >
                        <x-slot name="buttons">
                            @canany(['gestionar docentes', 'crear docentes'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-docente')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('Nuevo Docente') }}
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($docentes as $docente)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $docente->codigo_docente }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $docente->user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $docente->user->cedula }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $docente->especialidad ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($docente->tipo_contrato)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $docente->tipo_contrato === 'nombramiento' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' }}">
                                                {{ ucfirst($docente->tipo_contrato) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($docente->estado === 'activo')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                Activo
                                            </span>
                                        @elseif($docente->estado === 'licencia')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                                Licencia
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('docentes.show', $docente) }}"
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                               title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @canany(['gestionar docentes', 'editar docentes'])
                                                <button x-data
                                                        @click="$dispatch('open-edit-modal', {
                                                            id: {{ $docente->id }},
                                                            codigo_docente: '{{ addslashes($docente->codigo_docente) }}',
                                                            nombre_completo: '{{ addslashes($docente->user->name) }}',
                                                            cedula: '{{ $docente->user->cedula }}',
                                                            email: '{{ $docente->user->email }}',
                                                            telefono: '{{ $docente->user->telefono ?? '' }}',
                                                            direccion: '{{ addslashes($docente->user->direccion ?? '') }}',
                                                            fecha_nacimiento: '{{ $docente->user->fecha_nacimiento?->format('Y-m-d') ?? '' }}',
                                                            titulo_profesional: '{{ addslashes($docente->titulo_profesional ?? '') }}',
                                                            especialidad: '{{ addslashes($docente->especialidad ?? '') }}',
                                                            fecha_ingreso: '{{ $docente->fecha_ingreso?->format('Y-m-d') ?? '' }}',
                                                            tipo_contrato: '{{ $docente->tipo_contrato ?? '' }}',
                                                            estado: '{{ $docente->estado }}'
                                                        })"
                                                        class="text-theme-primary hover:text-theme-primary-dark dark:text-theme-primary-light dark:hover:text-theme-secondary transition-colors"
                                                        title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            @endcanany

                                            @canany(['gestionar docentes', 'eliminar docentes'])
                                                <button x-data
                                                        @click="$dispatch('open-delete-modal', {
                                                            id: {{ $docente->id }},
                                                            nombre: '{{ addslashes($docente->user->name) }}'
                                                        })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
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
                                        No hay docentes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    @include('usuarios.docentes.create')
    @include('usuarios.docentes.edit')
    @include('usuarios.docentes.delete')
</x-app-layout>
