<!-- Tab: Correo -->
<div id="tab-correo" class="tab-content hidden">
    <div class="space-y-6">
        <!-- Configuración SMTP -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Configuración SMTP</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="smtp_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Servidor SMTP</label>
                    <input type="text" id="smtp_host" name="smtp_host"
                        value="{{ old('smtp_host', $configuracion->smtp_host ?? '') }}"
                        placeholder="smtp.gmail.com"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('smtp_host')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Puerto</label>
                    <input type="number" id="smtp_port" name="smtp_port"
                        value="{{ old('smtp_port', $configuracion->smtp_port ?? 587) }}"
                        min="1" max="65535"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('smtp_port')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_encriptacion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Encriptación</label>
                    <select id="smtp_encriptacion" name="smtp_encriptacion"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        <option value="TLS" {{ old('smtp_encriptacion', $configuracion->smtp_encriptacion ?? 'TLS') == 'TLS' ? 'selected' : '' }}>TLS</option>
                        <option value="SSL" {{ old('smtp_encriptacion', $configuracion->smtp_encriptacion ?? 'TLS') == 'SSL' ? 'selected' : '' }}>SSL</option>
                    </select>
                    @error('smtp_encriptacion')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_usuario" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usuario</label>
                    <input type="text" id="smtp_usuario" name="smtp_usuario"
                        value="{{ old('smtp_usuario', $configuracion->smtp_usuario ?? '') }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('smtp_usuario')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="smtp_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
                    <div class="relative">
                        <input type="password" id="smtp_password" name="smtp_password"
                            value="{{ old('smtp_password', $configuracion->smtp_password ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light pr-10">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('smtp_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Remitente Predeterminado -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Remitente Predeterminado</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="remitente_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                    <input type="text" id="remitente_nombre" name="remitente_nombre"
                        value="{{ old('remitente_nombre', $configuracion->remitente_nombre ?? '') }}"
                        placeholder="Sistema Escolar"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('remitente_nombre')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="remitente_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                    <input type="email" id="remitente_email" name="remitente_email"
                        value="{{ old('remitente_email', $configuracion->remitente_email ?? '') }}"
                        placeholder="noreply@institucion.edu.ec"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    @error('remitente_email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Configuración de Notificaciones -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Configuración de Notificaciones</h4>
            <div class="space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" id="notificar_calificaciones" name="notificar_calificaciones" value="1"
                        {{ old('notificar_calificaciones', $configuracion->notificar_calificaciones ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="notificar_calificaciones" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enviar notificaciones de calificaciones</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="notificar_asistencia" name="notificar_asistencia" value="1"
                        {{ old('notificar_asistencia', $configuracion->notificar_asistencia ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="notificar_asistencia" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enviar notificaciones de asistencia</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="notificar_eventos" name="notificar_eventos" value="1"
                        {{ old('notificar_eventos', $configuracion->notificar_eventos ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="notificar_eventos" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enviar notificaciones de eventos</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="resumen_semanal_padres" name="resumen_semanal_padres" value="1"
                        {{ old('resumen_semanal_padres', $configuracion->resumen_semanal_padres ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="resumen_semanal_padres" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enviar resumen semanal a padres</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="resumen_mensual_docentes" name="resumen_mensual_docentes" value="1"
                        {{ old('resumen_mensual_docentes', $configuracion->resumen_mensual_docentes ?? false) ? 'checked' : '' }}
                        class="w-4 h-4 text-theme-primary dark:text-theme-primary-light border-gray-300 dark:border-gray-600 rounded focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                    <label for="resumen_mensual_docentes" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Enviar resumen mensual a docentes</label>
                </div>
            </div>
        </div>

        <!-- Plantilla de Correo -->
        <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Plantilla de Correo</h4>
            <textarea id="plantilla_correo" name="plantilla_correo" rows="10"
                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light font-mono text-sm"
                placeholder="Estimado(a) @{{nombre_destinatario}},&#10;&#10;@{{contenido_mensaje}}&#10;&#10;Atentamente,&#10;@{{nombre_institucion}}">{{ old('plantilla_correo', $configuracion->plantilla_correo ?? '') }}</textarea>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Variables disponibles: @{{nombre_destinatario}}, @{{contenido_mensaje}}, @{{nombre_institucion}}</p>
            @error('plantilla_correo')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botón de prueba -->
        <div class="flex justify-end">
            <button type="button" onclick="enviarCorreoPrueba()"
                class="px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Enviar Prueba
            </button>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('smtp_password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}

function enviarCorreoPrueba() {
    const email = prompt('Ingrese el correo electrónico de destino para la prueba:');
    if (!email) return;

    // Aquí iría la llamada AJAX para enviar el correo de prueba
    fetch('{{ route("configuraciones.test-email") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✓ Correo de prueba enviado exitosamente a ' + email);
        } else {
            alert('✗ Error al enviar el correo: ' + data.message);
        }
    })
    .catch(error => {
        alert('✗ Error al enviar el correo de prueba');
        console.error('Error:', error);
    });
}
</script>
