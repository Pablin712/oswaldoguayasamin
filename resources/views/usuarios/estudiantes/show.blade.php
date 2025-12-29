<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Estudiante
            </h2>
            <a href="{{ route('estudiantes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Información del Estudiante -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $estudiante->user->name }}</h3>
                            <p class="text-gray-500">{{ $estudiante->codigo_estudiante }}</p>
                        </div>
                        <div>
                            @if($estudiante->estado === 'activo')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                            @elseif($estudiante->estado === 'inactivo')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">Inactivo</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Retirado</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 mb-4">Información Personal</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->user->cedula }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->user->telefono ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->user->direccion ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $estudiante->user->fecha_nacimiento ? \Carbon\Carbon::parse($estudiante->user->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Información Académica y Médica -->
                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 mb-4">Información Académica y Médica</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $estudiante->fecha_ingreso ? \Carbon\Carbon::parse($estudiante->fecha_ingreso)->format('d/m/Y') : 'N/A' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tipo de Sangre</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->tipo_sangre ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Alergias</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->alergias ?? 'Ninguna' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Contacto de Emergencia</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->contacto_emergencia ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono de Emergencia</dt>
                                    <dd class="text-sm text-gray-900">{{ $estudiante->telefono_emergencia ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Padres/Representantes</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $estudiante->padres->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Asistencias</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $estudiante->asistencias->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Tareas Asignadas</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $estudiante->tareaEstudiantes->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Padres/Representantes Asociados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Padres/Representantes</h3>
                        @canany(['gestionar estudiantes', 'editar estudiantes'])
                            <button
                                type="button"
                                @click="$dispatch('open-modal', 'add-padre-modal')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Asociar Padre
                            </button>
                        @endcanany
                    </div>

                    @if($estudiante->padres->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($estudiante->padres as $padre)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="font-semibold text-gray-900">{{ $padre->user->name }}</h4>
                                                @if($padre->pivot->es_principal)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        Principal
                                                    </span>
                                                @endif
                                            </div>
                                            <dl class="space-y-1 text-sm">
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Parentesco:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ ucfirst($padre->pivot->parentesco) }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Cédula:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ $padre->user->cedula }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Teléfono:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ $padre->user->telefono ?? 'N/A' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Email:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ $padre->user->email }}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                        @canany(['gestionar estudiantes', 'editar estudiantes'])
                                            <div class="flex gap-2 ml-4">
                                                <button
                                                    type="button"
                                                    @click="$dispatch('open-modal', 'edit-padre-{{ $padre->id }}-modal')"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    title="Editar relación"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('estudiantes.detach-padre', [$estudiante, $padre]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de desvincular este padre/representante?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Desvincular">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endcanany
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No hay padres/representantes asociados a este estudiante.</p>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex space-x-3">
                        @can('editar estudiantes')
                            <button
                                type="button"
                                @click="$dispatch('open-edit-modal', {
                                    id: {{ $estudiante->id }},
                                    codigo_estudiante: '{{ $estudiante->codigo_estudiante }}',
                                    nombre_completo: '{{ $estudiante->user->name }}',
                                    cedula: '{{ $estudiante->user->cedula }}',
                                    email: '{{ $estudiante->user->email }}',
                                    telefono: '{{ $estudiante->user->telefono }}',
                                    direccion: '{{ $estudiante->user->direccion }}',
                                    fecha_nacimiento: '{{ $estudiante->user->fecha_nacimiento }}',
                                    fecha_ingreso: '{{ $estudiante->fecha_ingreso }}',
                                    tipo_sangre: '{{ $estudiante->tipo_sangre }}',
                                    alergias: '{{ $estudiante->alergias }}',
                                    contacto_emergencia: '{{ $estudiante->contacto_emergencia }}',
                                    telefono_emergencia: '{{ $estudiante->telefono_emergencia }}',
                                    estado: '{{ $estudiante->estado }}'
                                })"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                            >
                                Editar Estudiante
                            </button>
                        @endcan

                        @can('eliminar estudiantes')
                            <button
                                type="button"
                                @click="$dispatch('open-delete-modal', { id: {{ $estudiante->id }}, name: {{ json_encode($estudiante->user->name) }} })"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                            >
                                Eliminar Estudiante
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('editar estudiantes')
        @include('usuarios.estudiantes.edit')
    @endcan

    @can('eliminar estudiantes')
        @include('usuarios.estudiantes.delete')
    @endcan

    @canany(['gestionar estudiantes', 'editar estudiantes'])
        @include('usuarios.estudiantes.associate-padre')
        @include('usuarios.estudiantes.edit-padre-relation')
    @endcanany

    <x-session-messages />
</x-app-layout>
