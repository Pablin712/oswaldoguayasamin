<!-- Modal de Crear Notificación -->
<x-modal name="create-notificacion-modal" maxWidth="2xl">
    <form action="{{ route('notificaciones.store') }}" method="POST" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            Nueva Notificación
        </h2>

        <div class="space-y-6">
            <!-- Destinatarios -->
            <div>
                <label for="create_usuarios" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Destinatarios <span class="text-red-500">*</span>
                </label>
                <select name="usuarios[]"
                        id="create_usuarios"
                        multiple
                        size="5"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second shadow-sm">
                    @foreach($usuarios as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} - {{ $user->email }}
                            @if($user->roles->count() > 0)
                                ({{ $user->roles->pluck('name')->join(', ') }})
                            @endif
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Mantenga presionada la tecla Ctrl (o Cmd en Mac) para seleccionar múltiples destinatarios
                </p>
                @error('usuarios')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tipo -->
                <div>
                    <label for="create_tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipo <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo"
                            id="create_tipo"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second shadow-sm">
                        <option value="">Seleccione un tipo</option>
                        <option value="info">📘 Información</option>
                        <option value="success">✅ Éxito</option>
                        <option value="warning">⚠️ Advertencia</option>
                        <option value="error">❌ Error</option>
                    </select>
                    @error('tipo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Título -->
                <div>
                    <label for="create_titulo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="titulo"
                           id="create_titulo"
                           required
                           maxlength="255"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second shadow-sm"
                           placeholder="Ej: Nueva actualización disponible">
                    @error('titulo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Mensaje -->
            <div>
                <label for="create_mensaje" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mensaje <span class="text-red-500">*</span>
                </label>
                <textarea name="mensaje"
                          id="create_mensaje"
                          rows="4"
                          required
                          maxlength="1000"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second shadow-sm"
                          placeholder="Escriba el mensaje de la notificación..."></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Máximo 1000 caracteres
                </p>
                @error('mensaje')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL (Opcional) -->
            <div>
                <label for="create_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    URL <span class="text-gray-500 text-xs">(Opcional)</span>
                </label>
                <input type="url"
                       name="url"
                       id="create_url"
                       maxlength="255"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-second focus:ring-theme-primary dark:focus:ring-theme-second shadow-sm"
                       placeholder="https://ejemplo.com/detalle">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Enlace relacionado con la notificación (opcional)
                </p>
                @error('url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Enviar Email -->
            <div class="flex items-center">
                <input type="checkbox"
                       name="enviar_email"
                       id="create_enviar_email"
                       value="1"
                       class="rounded border-gray-300 dark:border-gray-700 text-theme-primary shadow-sm focus:ring-theme-primary dark:focus:ring-theme-second dark:bg-gray-900">
                <label for="create_enviar_email" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                    Enviar también por correo electrónico
                </label>
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Información:</strong> La notificación se enviará inmediatamente a todos los destinatarios seleccionados.
                            Si activa el envío por email, también recibirán un correo electrónico.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button type="button" @click="$dispatch('close-modal', 'create-notificacion-modal')">
                Cancelar
            </x-secondary-button>

            <x-primary-button type="submit">
                Enviar Notificación
            </x-primary-button>
        </div>
    </form>
</x-modal>
