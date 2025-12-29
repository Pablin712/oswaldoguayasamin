<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Padre/Representante
            </h2>
            <a href="{{ route('padres.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Información del Padre/Representante -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $padre->user->name }}</h3>
                        <p class="text-gray-500">Padre/Representante</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 mb-4">Información Personal</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->user->cedula }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->user->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono Personal</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->user->telefono ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->user->direccion ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                    <dd class="text-sm text-gray-900">
                                        {{ $padre->user->fecha_nacimiento ? \Carbon\Carbon::parse($padre->user->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Información Laboral -->
                        <div>
                            <h4 class="font-semibold text-lg text-gray-900 mb-4">Información Laboral</h4>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ocupación</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->ocupacion ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Lugar de Trabajo</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->lugar_trabajo ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono de Trabajo</dt>
                                    <dd class="text-sm text-gray-900">{{ $padre->telefono_trabajo ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Estudiantes a Cargo</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $padre->estudiantes->count() }}</dd>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Justificaciones Enviadas</dt>
                                    <dd class="text-lg font-semibold text-gray-900">{{ $padre->justificaciones->count() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estudiantes a Cargo -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Estudiantes a Cargo</h3>
                        @canany(['gestionar padres', 'editar padres'])
                            <button
                                type="button"
                                @click="$dispatch('open-modal', 'add-estudiante-modal')"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Asociar Estudiante
                            </button>
                        @endcanany
                    </div>

                    @if($padre->estudiantes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($padre->estudiantes as $estudiante)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="font-semibold text-gray-900">{{ $estudiante->user->name }}</h4>
                                                @if($estudiante->pivot->es_principal)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        Principal
                                                    </span>
                                                @endif
                                            </div>
                                            <dl class="space-y-1 text-sm">
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Código:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ $estudiante->codigo_estudiante }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Parentesco:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ ucfirst($estudiante->pivot->parentesco) }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Cédula:</dt>
                                                    <dd class="inline text-gray-900 ml-1">{{ $estudiante->user->cedula }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="inline font-medium text-gray-500">Estado:</dt>
                                                    <dd class="inline text-gray-900 ml-1">
                                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                                            {{ $estudiante->estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ ucfirst($estudiante->estado) }}
                                                        </span>
                                                    </dd>
                                                </div>
                                            </dl>
                                        </div>
                                        @canany(['gestionar padres', 'editar padres'])
                                            <div class="flex gap-2 ml-4">
                                                <button
                                                    type="button"
                                                    @click="$dispatch('open-modal', 'edit-estudiante-{{ $estudiante->id }}-modal')"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                    title="Editar relación"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('padres.detach-estudiante', [$padre, $estudiante]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de desvincular este estudiante?');">
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
                        <p class="text-gray-500 text-center py-4">No hay estudiantes asociados a este padre/representante.</p>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex space-x-3">
                        @can('editar padres')
                            <button
                                type="button"
                                @click="$dispatch('open-edit-modal', {
                                    id: {{ $padre->id }},
                                    nombre_completo: '{{ $padre->user->name }}',
                                    cedula: '{{ $padre->user->cedula }}',
                                    email: '{{ $padre->user->email }}',
                                    telefono: '{{ $padre->user->telefono }}',
                                    direccion: '{{ $padre->user->direccion }}',
                                    fecha_nacimiento: '{{ $padre->user->fecha_nacimiento }}',
                                    ocupacion: '{{ $padre->ocupacion }}',
                                    lugar_trabajo: '{{ $padre->lugar_trabajo }}',
                                    telefono_trabajo: '{{ $padre->telefono_trabajo }}'
                                })"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700"
                            >
                                Editar Padre/Representante
                            </button>
                        @endcan

                        @can('eliminar padres')
                            <button
                                type="button"
                                @click="$dispatch('open-delete-modal', { id: {{ $padre->id }}, name: {{ json_encode($padre->user->name) }} })"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                            >
                                Eliminar Padre/Representante
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('editar padres')
        @include('usuarios.padres.edit')
    @endcan

    @can('eliminar padres')
        @include('usuarios.padres.delete')
    @endcan

    @canany(['gestionar padres', 'editar padres'])
        @include('usuarios.padres.associate-estudiante')
        @include('usuarios.padres.edit-estudiante-relation')
    @endcanany

    <x-session-messages />
</x-app-layout>
