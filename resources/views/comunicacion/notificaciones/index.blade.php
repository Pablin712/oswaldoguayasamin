<x-app-layout>
    @canany(['gestionar notificaciones', 'ver notificaciones'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notificaciones') }}
            @if($noLeidas > 0)
                <span class="ml-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                    {{ $noLeidas }} nueva{{ $noLeidas > 1 ? 's' : '' }}
                </span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de éxito/error -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('notificaciones.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Filtro por tipo -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipo
                            </label>
                            <select name="tipo" id="tipo"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second">
                                <option value="">Todos los tipos</option>
                                <option value="info" {{ request('tipo') === 'info' ? 'selected' : '' }}>Información</option>
                                <option value="success" {{ request('tipo') === 'success' ? 'selected' : '' }}>Éxito</option>
                                <option value="warning" {{ request('tipo') === 'warning' ? 'selected' : '' }}>Advertencia</option>
                                <option value="error" {{ request('tipo') === 'error' ? 'selected' : '' }}>Error</option>
                            </select>
                        </div>

                        <!-- Filtro por estado -->
                        <div>
                            <label for="leida" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Estado
                            </label>
                            <select name="leida" id="leida"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second">
                                <option value="">Todas</option>
                                <option value="0" {{ request('leida') === '0' ? 'selected' : '' }}>No leídas</option>
                                <option value="1" {{ request('leida') === '1' ? 'selected' : '' }}>Leídas</option>
                            </select>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filtrar
                            </button>
                            <a href="{{ route('notificaciones.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:bg-gray-400 dark:focus:bg-gray-500 active:bg-gray-500 dark:active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Limpiar
                            </a>

                            @if($notificaciones->where('es_leida', true)->count() > 0)
                                @can('eliminar notificaciones')
                                <form action="{{ route('notificaciones.eliminar-leidas') }}" method="POST" class="inline"
                                      onsubmit="return confirm('¿Está seguro de eliminar todas las notificaciones leídas?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Eliminar Leídas
                                    </button>
                                </form>
                                @endcan
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enhanced Table -->
            <x-enhanced-table
                id="notificacionesTable"
                :headers="[
                    ['label' => 'Estado', 'type' => 'string'],
                    ['label' => 'Tipo', 'type' => 'string'],
                    ['label' => 'Título', 'type' => 'string'],
                    ['label' => 'Mensaje', 'type' => 'string'],
                    ['label' => 'Fecha', 'type' => 'datetime'],
                    ['label' => 'Acciones', 'type' => 'actions'],
                ]"
                :csv="auth()->user()->canany(['generar reporte notificaciones', 'gestionar notificaciones'])"
                :excel="auth()->user()->canany(['generar reporte notificaciones', 'gestionar notificaciones'])"
                :pdf="auth()->user()->canany(['generar reporte notificaciones', 'gestionar notificaciones'])"
                :print="auth()->user()->canany(['generar reporte notificaciones', 'gestionar notificaciones'])"
                :json="auth()->user()->canany(['generar reporte notificaciones', 'gestionar notificaciones'])"
            >
                <x-slot name="buttons">
                    @if($noLeidas > 0)
                        @can('marcar notificaciones leidas')
                        <form action="{{ route('notificaciones.marcar-todas-leidas') }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Marcar todas como leídas
                            </button>
                        </form>
                        @endcan
                    @endif

                    @can('crear notificaciones')
                        <button x-data @click="$dispatch('open-modal', 'create-notificacion-modal')"
                                class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-secondary dark:hover:bg-theme-primary focus:bg-theme-secondary active:bg-theme-secondary focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nueva Notificación
                        </button>
                    @endcan
                </x-slot>

                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($notificaciones as $notificacion)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 {{ !$notificacion->es_leida ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                        <!-- Estado -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(!$notificacion->es_leida)
                                <span class="flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                </span>
                            @else
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </td>

                        <!-- Tipo -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $tipoClasses = [
                                    'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
                                    'success' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                    'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
                                    'error' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'
                                ];
                                $tipoNombres = [
                                    'info' => 'Info',
                                    'success' => 'Éxito',
                                    'warning' => 'Alerta',
                                    'error' => 'Error'
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $tipoClasses[$notificacion->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $tipoNombres[$notificacion->tipo] ?? ucfirst($notificacion->tipo) }}
                            </span>
                        </td>

                        <!-- Título -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $notificacion->titulo }}
                            </div>
                        </td>

                        <!-- Mensaje -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 max-w-md truncate">
                                {{ Str::limit($notificacion->mensaje, 80) }}
                            </div>
                        </td>

                        <!-- Fecha -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <div>{{ $notificacion->created_at->diffForHumans() }}</div>
                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                {{ $notificacion->created_at->format('d/m/Y H:i') }}
                            </div>
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <!-- Marcar como leída/no leída -->
                                @can('marcar notificaciones leidas')
                                @if(!$notificacion->es_leida)
                                    <form action="{{ route('notificaciones.marcar-leida', $notificacion) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                title="Marcar como leída">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('notificaciones.marcar-no-leida', $notificacion) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300"
                                                title="Marcar como no leída">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                @endcan

                                <!-- Ver URL si existe -->
                                @if($notificacion->url)
                                    <a href="{{ $notificacion->url }}"
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                @endif

                                <!-- Eliminar -->
                                @can('eliminar notificaciones')
                                <button @click="$dispatch('open-delete-modal', {{ json_encode([
                                            'id' => $notificacion->id,
                                            'titulo' => $notificacion->titulo
                                        ]) }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No se encontraron notificaciones.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </x-enhanced-table>
        </div>
    </div>

    <!-- Modales -->
    @can('crear notificaciones')
        @include('comunicacion.notificaciones.create')
    @endcan

    @can('eliminar notificaciones')
        @include('comunicacion.notificaciones.delete')
    @endcan

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
