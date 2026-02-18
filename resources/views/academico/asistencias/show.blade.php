<x-app-layout>
    @can('ver asistencias')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Asistencia') }}
            </h2>
            <a href="{{ route('asistencias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información General -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estudiante</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $asistencia->estudiante->user->name }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->estudiante->user->cedula }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Paralelo</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->paralelo->curso->nombre }} {{ $asistencia->paralelo->nombre }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->fecha->format('d/m/Y') }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Hora</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->hora?->format('H:i') ?? 'No registrada' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado</label>
                            <p class="mt-1">
                                @if($asistencia->estado == 'presente')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Presente
                                    </span>
                                @elseif($asistencia->estado == 'ausente')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Ausente
                                    </span>
                                @elseif($asistencia->estado == 'atrasado')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Atrasado
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        Justificado
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Materia</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->materia->nombre ?? 'No especificada' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Docente</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->docente->user->name ?? 'No registrado' }}
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Registrado</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>

                        @if($asistencia->observaciones)
                        <div class="md:col-span-3">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Observaciones</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $asistencia->observaciones }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Justificaciones relacionadas -->
            @if($asistencia->justificaciones && $asistencia->justificaciones->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Justificaciones</h3>
                    <div class="space-y-4">
                        @foreach($asistencia->justificaciones as $justificacion)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $justificacion->motivo }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Fecha: {{ $justificacion->fecha_justificacion->format('d/m/Y') }}
                                    </p>
                                    @if($justificacion->descripcion)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        {{ $justificacion->descripcion }}
                                    </p>
                                    @endif
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @if($justificacion->estado == 'aprobado') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($justificacion->estado == 'rechazado') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @endif">
                                    {{ ucfirst($justificacion->estado) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endcan
</x-app-layout>
