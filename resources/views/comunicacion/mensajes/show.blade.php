<x-app-layout>
    @canany(['gestionar mensajes', 'ver mensajes'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Mensaje') }}
            </h2>
            <a href="{{ route('mensajes.index', ['tipo' => request('tipo', 'recibidos')]) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver a Mensajes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Tarjeta del Mensaje -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Encabezado del Mensaje -->
                <div class="p-6 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $mensaje->asunto }}
                            </h3>

                            <!-- Badges de tipo -->
                            <div class="mt-2 flex items-center space-x-2">
                                @if($mensaje->tipo === 'masivo')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                                    </svg>
                                    Masivo
                                </span>
                                @elseif($mensaje->tipo === 'anuncio')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                    </svg>
                                    Anuncio
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    Individual
                                </span>
                                @endif

                                @if($mensaje->adjuntos->count() > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                    {{ $mensaje->adjuntos->count() }} {{ Str::plural('adjunto', $mensaje->adjuntos->count()) }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="flex space-x-2">
                            @if($mensaje->remitente_id !== auth()->id())
                            <button @click="$dispatch('open-modal', 'reply-mensaje')"
                                class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Responder
                            </button>
                            @endif

                            <button @click="$dispatch('open-modal', 'delete-mensaje-{{ $mensaje->id }}')"
                                class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Información del Mensaje -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Remitente -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">De:</p>
                            <div class="mt-1 flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($mensaje->remitente?->name ?? 'S', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $mensaje->remitente?->name ?? 'Sistema' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $mensaje->remitente?->email ?? 'sistema@institucion.edu' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Destinatario(s) -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Para:</p>
                            <div class="mt-1">
                                @if($mensaje->tipo === 'masivo')
                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $mensaje->destinatarios->count() }} {{ Str::plural('destinatario', $mensaje->destinatarios->count()) }}
                                </p>
                                <details class="mt-1">
                                    <summary class="text-xs text-blue-600 dark:text-blue-400 cursor-pointer hover:underline">
                                        Ver lista completa
                                    </summary>
                                    <ul class="mt-2 text-xs text-gray-600 dark:text-gray-400 space-y-1 max-h-32 overflow-y-auto">
                                        @foreach($mensaje->destinatarios as $dest)
                                        <li>• {{ $dest->usuario->name }} ({{ $dest->usuario->email }})</li>
                                        @endforeach
                                    </ul>
                                </details>
                                @else
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($mensaje->destinatario?->name ?? 'D', 0, 1)) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $mensaje->destinatario?->name ?? 'Destinatario Desconocido' }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $mensaje->destinatario?->email ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Fecha de Envío -->
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Envío:</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $mensaje->fecha_envio?->format('d/m/Y H:i') ?? $mensaje->created_at?->format('d/m/Y H:i') }}
                                <span class="text-xs text-gray-500">
                                    ({{ $mensaje->fecha_envio?->diffForHumans() ?? $mensaje->created_at?->diffForHumans() }})
                                </span>
                            </p>
                        </div>

                        <!-- Estado de Lectura -->
                        @if($mensaje->destinatario_id === auth()->id())
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado:</p>
                            <p class="mt-1">
                                @if($mensaje->es_leido)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    ✓ Leído el {{ $mensaje->fecha_lectura?->format('d/m/Y H:i') }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    ⚬ No leído
                                </span>
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cuerpo del Mensaje -->
                <div class="p-6 bg-white dark:bg-gray-800">
                    <div class="prose dark:prose-invert max-w-none">
                        {!! nl2br(e($mensaje->cuerpo)) !!}
                    </div>
                </div>

                <!-- Archivos Adjuntos -->
                @if($mensaje->adjuntos->count() > 0)
                <div class="p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">
                        Archivos Adjuntos ({{ $mensaje->adjuntos->count() }})
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($mensaje->adjuntos as $adjunto)
                        <a href="{{ Storage::url($adjunto->ruta_archivo) }}"
                            download="{{ $adjunto->nombre_archivo }}"
                            class="flex items-center p-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                    {{ $adjunto->nombre_archivo }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($adjunto->tamanio / 1024, 2) }} KB
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-blue-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de responder -->
    @if($mensaje->remitente_id !== auth()->id())
    <x-modal name="reply-mensaje" :show="false" maxWidth="2xl">
        <form method="POST" action="{{ route('mensajes.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf
            <input type="hidden" name="tipo" value="individual">
            <input type="hidden" name="destinatario_id" value="{{ $mensaje->remitente_id }}">
            <input type="hidden" name="asunto" value="Re: {{ $mensaje->asunto }}">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Responder a: {{ $mensaje->remitente?->name }}
            </h2>

            <div class="mb-4 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg border-l-4 border-blue-500">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Mensaje original:</p>
                <p class="text-sm text-gray-700 dark:text-gray-300">{{ Str::limit($mensaje->cuerpo, 200) }}</p>
            </div>

            <div>
                <label for="cuerpo_reply" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Tu respuesta <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="cuerpo_reply"
                    name="cuerpo"
                    rows="6"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                    placeholder="Escribe tu respuesta..."
                ></textarea>
            </div>

            <div class="mt-4">
                <label for="adjuntos_reply" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Archivos Adjuntos (Opcional)
                </label>
                <input
                    type="file"
                    id="adjuntos_reply"
                    name="adjuntos[]"
                    multiple
                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                >
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button"
                    @click="$dispatch('close-modal', 'reply-mensaje')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Cancelar
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    Enviar Respuesta
                </button>
            </div>
        </form>
    </x-modal>
    @endif

    <!-- Modal de eliminación -->
    @include('comunicacion.mensajes.delete', ['mensaje' => $mensaje])

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
