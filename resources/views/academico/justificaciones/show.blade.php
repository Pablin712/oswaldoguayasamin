<x-app-layout>
    @canany(['gestionar justificaciones', 'ver justificaciones'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalle de Justificación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Botón volver -->
            <div class="mb-6">
                <a href="{{ route('justificaciones.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver al Listado
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Información Principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Estado y Acciones -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                        Estado de la Justificación
                                    </h3>
                                    @if($justificacion->estado == 'pendiente')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pendiente de Revisión
                                        </span>
                                    @elseif($justificacion->estado == 'aprobada')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Aprobada
                                        </span>
                                    @elseif($justificacion->estado == 'rechazada')
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Rechazada
                                        </span>
                                    @endif
                                </div>

                                <!-- Acciones rápidas -->
                                @if($justificacion->estado === 'pendiente')
                                    <div class="flex space-x-2">
                                        @canany(['aprobar justificaciones', 'gestionar justificaciones'])
                                            <form action="{{ route('justificaciones.aprobar', $justificacion) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        onclick="return confirm('¿Está seguro de aprobar esta justificación?')"
                                                        class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Aprobar
                                                </button>
                                            </form>
                                        @endcanany

                                        @canany(['rechazar justificaciones', 'gestionar justificaciones'])
                                            <button x-data @click="$dispatch('open-modal-data', { modal: 'reject-justificacion-modal', data: { id: {{ $justificacion->id }}, estudiante: '{{ $justificacion->asistencia->estudiante->user->name }}' } })"
                                                    class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Rechazar
                                            </button>
                                        @endcanany
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Datos de la Justificación -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Información de la Justificación
                            </h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Solicitud</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Última Actualización</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>

                                @if($justificacion->fecha_revision)
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de Revisión</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                            {{ $justificacion->fecha_revision->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Motivo</p>
                                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-base text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $justificacion->motivo }}</p>
                                </div>
                            </div>

                            @if($justificacion->motivo_rechazo)
                                <div class="mt-6">
                                    <p class="text-sm text-red-600 dark:text-red-400 mb-2 font-semibold">Motivo del Rechazo</p>
                                    <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                                        <p class="text-base text-red-800 dark:text-red-300 whitespace-pre-wrap">{{ $justificacion->motivo_rechazo }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($justificacion->archivo_adjunto)
                                <div class="mt-6">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Archivo Adjunto</p>
                                    <a href="{{ asset('storage/' . $justificacion->archivo_adjunto) }}" target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Ver Documento Adjunto
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Información Relacionada -->
                <div class="space-y-6">
                    <!-- Datos del Estudiante -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Estudiante
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->asistencia->estudiante->user->name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Curso</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->asistencia->paralelo->curso->nombre ?? 'N/A' }}
                                        {{ $justificacion->asistencia->paralelo->nombre ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Padre/Representante -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Padre/Representante
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->padre->user->name }}
                                    </p>
                                </div>
                                @if($justificacion->padre->user->email)
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                        <p class="text-base text-gray-900 dark:text-gray-100">
                                            {{ $justificacion->padre->user->email }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Datos de la Asistencia -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Asistencia Relacionada
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Fecha</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ \Carbon\Carbon::parse($justificacion->asistencia->fecha)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Estado Original</p>
                                    <div class="mt-1">
                                        @if($justificacion->asistencia->estado == 'presente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Presente
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'ausente')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Ausente
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'atrasado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Atrasado
                                            </span>
                                        @elseif($justificacion->asistencia->estado == 'justificado')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                Justificado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Revisor -->
                    @if($justificacion->revisor)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    Revisado Por
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Nombre</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                                            {{ $justificacion->revisor->name }}
                                        </p>
                                    </div>
                                    @if($justificacion->fecha_revision)
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Fecha</p>
                                            <p class="text-base text-gray-900 dark:text-gray-100">
                                                {{ $justificacion->fecha_revision->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de rechazo (solo si está pendiente) -->
    @if($justificacion->estado === 'pendiente')
        @canany(['gestionar justificaciones', 'rechazar justificaciones'])
            @include('academico.justificaciones.reject')
        @endcanany
    @endif
    @endcanany
</x-app-layout>
