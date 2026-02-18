<x-app-layout>
    @canany(['gestionar mensajes', 'ver mensajes'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mensajes') }}
            </h2>
            {{-- separación --}}
            <div class="flex-1"></div>
            <div class="flex space-x-2">
                @canany(['gestionar mensajes', 'crear mensajes'])
                <button @click="$dispatch('open-modal', 'create-mensaje-masivo')" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                    </svg>
                    Mensaje Masivo
                </button>
                <button @click="$dispatch('open-modal', 'create-mensaje')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo Mensaje
                </button>
                @endcanany
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Pestañas -->
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <a href="{{ route('mensajes.index', ['tipo' => 'recibidos']) }}"
                            class="group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm {{ $tipo === 'recibidos' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            <svg class="w-5 h-5 mr-2 {{ $tipo === 'recibidos' ? 'text-blue-500 dark:text-blue-400' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Recibidos
                        </a>
                        <a href="{{ route('mensajes.index', ['tipo' => 'enviados']) }}"
                            class="group inline-flex items-center py-4 px-6 border-b-2 font-medium text-sm {{ $tipo === 'enviados' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            <svg class="w-5 h-5 mr-2 {{ $tipo === 'enviados' ? 'text-blue-500 dark:text-blue-400' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Enviados
                        </a>
                    </nav>
                </div>

                <!-- Filtros -->
                <div class="p-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('mensajes.index') }}" class="flex flex-wrap gap-3 items-end">
                        <input type="hidden" name="tipo" value="{{ $tipo }}">

                        <!-- Tipo de Mensaje -->
                        <div>
                            <label for="tipo_mensaje" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tipo de Mensaje
                            </label>
                            <select id="tipo_mensaje" name="tipo_mensaje" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-sm">
                                <option value="">Todos</option>
                                <option value="individual" {{ request('tipo_mensaje') == 'individual' ? 'selected' : '' }}>Individual</option>
                                <option value="masivo" {{ request('tipo_mensaje') == 'masivo' ? 'selected' : '' }}>Masivo</option>
                                <option value="anuncio" {{ request('tipo_mensaje') == 'anuncio' ? 'selected' : '' }}>Anuncio</option>
                            </select>
                        </div>

                        @if($tipo === 'recibidos')
                        <!-- Estado de Lectura -->
                        <div>
                            <label for="leido" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Estado
                            </label>
                            <select id="leido" name="leido" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-sm">
                                <option value="">Todos</option>
                                <option value="0" {{ request('leido') === '0' ? 'selected' : '' }}>No Leídos</option>
                                <option value="1" {{ request('leido') === '1' ? 'selected' : '' }}>Leídos</option>
                            </select>
                        </div>
                        @endif

                        <!-- Botones -->
                        <div class="flex space-x-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrar
                            </button>
                            <a href="{{ route('mensajes.index', ['tipo' => $tipo]) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Lista de Mensajes -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($mensajes as $mensaje)
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 {{ $tipo === 'recibidos' && !$mensaje->es_leido ? 'bg-blue-50 dark:bg-blue-900/10' : '' }}">
                        <div class="flex items-start space-x-4">
                            <!-- Checkbox para selección (futuro) -->
                            <div class="flex-shrink-0 pt-1">
                                @if($tipo === 'recibidos' && !$mensaje->es_leido)
                                <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
                                @else
                                <div class="w-2 h-2"></div>
                                @endif
                            </div>

                            <!-- Contenido del mensaje -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <!-- Remitente/Destinatario -->
                                        <div class="flex items-center space-x-2 mb-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                @if($tipo === 'recibidos')
                                                    {{ $mensaje->remitente?->name ?? 'Remitente Desconocido' }}
                                                @else
                                                    Para: {{ $mensaje->tipo === 'masivo' ? 'Múltiples destinatarios' : ($mensaje->destinatario?->name ?? 'N/A') }}
                                                @endif
                                            </p>

                                            <!-- Badge de tipo -->
                                            @if($mensaje->tipo === 'masivo')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                                Masivo
                                            </span>
                                            @elseif($mensaje->tipo === 'anuncio')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                Anuncio
                                            </span>
                                            @endif

                                            <!-- Adjuntos -->
                                            @if($mensaje->adjuntos->count() > 0)
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            @endif
                                        </div>

                                        <!-- Asunto -->
                                        <a href="{{ route('mensajes.show', $mensaje) }}" class="block group">
                                            <p class="text-sm {{ $tipo === 'recibidos' && !$mensaje->es_leido ? 'font-semibold text-gray-900 dark:text-gray-100' : 'font-medium text-gray-700 dark:text-gray-300' }} group-hover:text-blue-600 dark:group-hover:text-blue-400 truncate">
                                                {{ $mensaje->asunto }}
                                            </p>
                                            <!-- Preview del cuerpo -->
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate mt-1">
                                                {{ Str::limit(strip_tags($mensaje->cuerpo), 80) }}
                                            </p>
                                        </a>
                                    </div>

                                    <!-- Fecha y Acciones -->
                                    <div class="flex-shrink-0 ml-4 text-right">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                            {{ $mensaje->fecha_envio?->diffForHumans() ?? $mensaje->created_at?->diffForHumans() }}
                                        </p>

                                        <!-- Acciones -->
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('mensajes.show', $mensaje) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Ver mensaje">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>

                                            @if($tipo === 'recibidos')
                                            <form method="POST" action="{{ route('mensajes.marcar-leido', $mensaje) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300" title="{{ $mensaje->es_leido ? 'Marcar como no leído' : 'Marcar como leído' }}">
                                                    @if($mensaje->es_leido)
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
                                                    </svg>
                                                    @endif
                                                </button>
                                            </form>
                                            @endif

                                            <button @click="$dispatch('open-delete-modal', { id: {{ $mensaje->id }}, asunto: '{{ addslashes($mensaje->asunto) }}' })" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay mensajes</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ $tipo === 'recibidos' ? 'No tienes mensajes recibidos.' : 'No has enviado mensajes.' }}
                        </p>
                    </div>
                    @endforelse
                </div>

                <!-- Paginación -->
                @if($mensajes->hasPages())
                <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $mensajes->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modales de creación -->
    @include('comunicacion.mensajes.create')
    @can('gestionar mensajes')
    @include('comunicacion.mensajes.create-masivo')
    @endcan

    <!-- Modal de eliminación -->
    @include('comunicacion.mensajes.delete')

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
