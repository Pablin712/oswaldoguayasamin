<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Docente') }}
            </h2>
            <a href="{{ route('docentes.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Información Personal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            {{ $docente->user->name }}
                        </h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $docente->estado === 'activo' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                               ($docente->estado === 'licencia' ? 'bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200' :
                               'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200') }}">
                            {{ ucfirst($docente->estado) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Básica -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Código Docente</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->codigo_docente }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->user->cedula }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->user->telefono ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Nacimiento</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                    {{ $docente->user->fecha_nacimiento?->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Información Profesional -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Título Profesional</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->titulo_profesional ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Especialidad</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->especialidad ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Ingreso</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">
                                    {{ $docente->fecha_ingreso?->format('d/m/Y') ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Contrato</label>
                                <p class="mt-1">
                                    @if($docente->tipo_contrato)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $docente->tipo_contrato === 'nombramiento' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' }}">
                                            {{ ucfirst($docente->tipo_contrato) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</label>
                                <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $docente->user->direccion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tareas Asignadas</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $docente->tareas->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Asistencias Registradas</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $docente->asistenciasRegistradas->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Horarios Asignados</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $docente->horarios->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end gap-3">
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
                                class="inline-flex items-center px-4 py-2 bg-theme-primary hover:bg-theme-primary-dark text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </button>
                    @endcanany

                    @canany(['gestionar docentes', 'eliminar docentes'])
                        <button x-data
                                @click="$dispatch('open-delete-modal', {
                                    id: {{ $docente->id }},
                                    nombre: '{{ addslashes($docente->user->name) }}'
                                })"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    @endcanany
                </div>
            </div>
        </div>
    </div>

    @include('usuarios.docentes.edit')
    @include('usuarios.docentes.delete')
</x-app-layout>
