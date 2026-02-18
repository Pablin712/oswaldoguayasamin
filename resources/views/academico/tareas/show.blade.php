<x-app-layout>
    @canany(['gestionar tareas', 'ver tareas'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Tarea') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('tareas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <!-- Total -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Estudiantes</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $estadisticas['total'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pendientes -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pendientes</p>
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $estadisticas['pendientes'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/20">
                                <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completadas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completadas</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $estadisticas['completadas'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revisadas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Revisadas</p>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $estadisticas['revisadas'] }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/20">
                                <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Layout de 3 columnas -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna 1: Información de la Tarea -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Detalles de la Tarea -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Información de la Tarea
                            </h3>

                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Título</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $tarea->titulo }}</dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Materia</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $tarea->materia?->nombre ?? 'N/A' }}</dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Curso y Paralelo</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $tarea->paralelo?->curso?->nombre ?? 'N/A' }} - {{ $tarea->paralelo?->nombre ?? 'N/A' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Docente</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">{{ $tarea->docente?->user?->name ?? 'N/A' }}</dd>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Tipo</dt>
                                    <dd class="mt-1">
                                        @if($tarea->es_calificada)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            Calificada ({{ $tarea->puntaje_maximo }} puntos)
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            No Calificada
                                        </span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Fechas
                            </h3>

                            <dl class="space-y-3 text-sm">
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Fecha de Asignación</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $tarea->fecha_asignacion?->format('d/m/Y') ?? 'N/A' }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Fecha de Entrega</dt>
                                    <dd class="mt-1">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-900 dark:text-gray-100">
                                                {{ $tarea->fecha_entrega?->format('d/m/Y') ?? 'N/A' }}
                                            </span>
                                            @if($tarea->fecha_entrega)
                                                @if($tarea->fecha_entrega->isPast())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Vencida
                                                </span>
                                                @elseif($tarea->fecha_entrega->diffInDays(now()) <= 2)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    Próxima
                                                </span>
                                                @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    Vigente
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </dd>
                                </div>

                                @if($tarea->fecha_entrega && !$tarea->fecha_entrega->isPast())
                                <div>
                                    <dt class="font-medium text-gray-700 dark:text-gray-300">Tiempo Restante</dt>
                                    <dd class="mt-1 text-gray-900 dark:text-gray-100">
                                        {{ $tarea->fecha_entrega->diffForHumans() }}
                                    </dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>

                    <!-- Archivos Adjuntos -->
                    @if($tarea->archivos->count() > 0)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Archivos Adjuntos
                            </h3>

                            <ul class="space-y-2">
                                @foreach($tarea->archivos as $archivo)
                                <li class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="ml-2 text-sm text-gray-900 dark:text-gray-100 truncate">
                                            {{ $archivo->nombre_archivo }}
                                        </span>
                                    </div>
                                    <a href="{{ asset('storage/' . $archivo->ruta_archivo) }}" target="_blank"
                                        class="ml-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Columna 2-3: Descripción y Entregas de Estudiantes -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Descripción -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Descripción de la Tarea
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                {{ $tarea->descripcion }}
                            </div>
                        </div>
                    </div>

                    <!-- Entregas de Estudiantes -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Entregas de Estudiantes ({{ $tarea->tareaEstudiantes->count() }})
                            </h3>

                            @if($tarea->tareaEstudiantes->count() > 0)
                            <x-enhanced-table
                                :headers="[
                                    ['label' => 'Estudiante', 'type' => 'string'],
                                    ['label' => 'Estado', 'type' => 'string'],
                                    ['label' => 'Fecha Completada', 'type' => 'date'],
                                    ['label' => 'Calificación', 'type' => 'string'],
                                    ['label' => 'Comentarios', 'type' => 'string'],
                                ]"
                                :data="$tarea->tareaEstudiantes"
                                emptyMessage="No hay entregas registradas"
                            >
                                @foreach($tarea->tareaEstudiantes as $entrega)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $entrega->estudiante?->user?->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($entrega->estado === 'pendiente')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pendiente
                                        </span>
                                        @elseif($entrega->estado === 'completada')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Completada
                                        </span>
                                        @elseif($entrega->estado === 'revisada')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            Revisada
                                        </span>
                                        @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            {{ ucfirst($entrega->estado) }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $entrega->fecha_completada?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        @if($tarea->es_calificada)
                                            @if($entrega->calificacion !== null)
                                            <span class="font-semibold">{{ $entrega->calificacion }}/{{ $tarea->puntaje_maximo }}</span>
                                            @else
                                            <span class="text-gray-400">Sin calificar</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">No aplica</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        @if($entrega->comentarios_docente)
                                        <button type="button"
                                            onclick="alert('{{ addslashes($entrega->comentarios_docente) }}')"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            Ver comentarios
                                        </button>
                                        @else
                                        <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </x-enhanced-table>
                            @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2">No hay estudiantes asignados a esta tarea</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __('No tiene permisos para acceder a esta sección.') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endcanany
</x-app-layout>
