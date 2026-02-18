<x-modal name="create-mensaje-masivo" :show="false" maxWidth="3xl">
    <form method="POST" action="{{ route('mensajes.store') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <input type="hidden" name="tipo" value="masivo">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Enviar Mensaje Masivo') }}
        </h2>

        <div class="space-y-4">
            <!-- Tipo de Selección de Destinatarios -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Enviar a: <span class="text-red-500">*</span>
                </label>

                <div class="space-y-3">
                    <!-- Opción: Por Rol -->
                    <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                        <input type="radio"
                            name="tipo_destinatarios"
                            value="rol"
                            class="mt-1 rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                            onclick="toggleDestinatariosOptions('rol')"
                        >
                        <div class="ml-3 flex-1">
                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Por Rol</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Enviar a todos los usuarios de un rol específico</p>
                            <select id="rol_destinatario"
                                name="rol_id"
                                disabled
                                class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 text-sm disabled:opacity-50">
                                <option value="">Seleccione un rol...</option>
                                <option value="estudiante">Estudiantes</option>
                                <option value="docente">Docentes</option>
                                <option value="representante">Representantes</option>
                                <option value="administrativo">Administrativos</option>
                            </select>
                        </div>
                    </label>

                    <!-- Opción: Por Curso/Paralelo -->
                    <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                        <input type="radio"
                            name="tipo_destinatarios"
                            value="curso"
                            class="mt-1 rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                            onclick="toggleDestinatariosOptions('curso')"
                        >
                        <div class="ml-3 flex-1">
                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Por Curso/Paralelo</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Enviar a todos los estudiantes de un curso específico</p>
                            <div id="curso_paralelo_selects" class="mt-2 grid grid-cols-2 gap-2" style="display: none;">
                                <div>
                                    <label for="curso_id_masivo" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Curso
                                    </label>
                                    <x-searchable-select
                                        id="curso_id_masivo"
                                        name="curso_id"
                                        placeholder="Seleccione curso..."
                                        :options="isset($cursos) ? $cursos->map(fn($c) => ['id' => $c->id, 'name' => $c->nombre])->toArray() : []"
                                        valueField="id"
                                        labelField="name"
                                    />
                                </div>
                                <div>
                                    <label for="paralelo_id_masivo" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Paralelo
                                    </label>
                                    <x-searchable-select
                                        id="paralelo_id_masivo"
                                        name="paralelo_id"
                                        placeholder="Seleccione paralelo..."
                                        :options="isset($paralelos) ? $paralelos->map(fn($p) => ['id' => $p->id, 'name' => $p->nombre])->toArray() : []"
                                        valueField="id"
                                        labelField="name"
                                    />
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Opción: Selección Manual -->
                    <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                        <input type="radio"
                            name="tipo_destinatarios"
                            value="manual"
                            class="mt-1 rounded-full border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                            onclick="toggleDestinatariosOptions('manual')"
                            checked
                        >
                        <div class="ml-3 flex-1">
                            <span class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selección Manual</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Seleccionar destinatarios específicos de una lista</p>
                        </div>
                    </label>
                </div>

                @error('tipo_destinatarios')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Destinatarios Manuales -->
            <div id="destinatarios_manuales">
                <label for="destinatarios_masivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Destinatarios <span class="text-red-500">*</span>
                </label>
                <select
                    id="destinatarios_masivo"
                    name="destinatarios[]"
                    multiple
                    size="6"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 @error('destinatarios') border-red-500 @enderror"
                >
                    @if(isset($usuarios))
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                        @endforeach
                    @endif
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Mantenga presionado Ctrl (Windows) o Cmd (Mac) para seleccionar múltiples destinatarios
                </p>
                @error('destinatarios')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Asunto -->
            <div>
                <label for="asunto_masivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Asunto <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="asunto_masivo"
                    name="asunto"
                    value="{{ old('asunto') }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 @error('asunto') border-red-500 @enderror"
                    placeholder="Asunto del mensaje masivo"
                >
                @error('asunto')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cuerpo del mensaje -->
            <div>
                <label for="cuerpo_masivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Mensaje <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="cuerpo_masivo"
                    name="cuerpo"
                    rows="8"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 @error('cuerpo') border-red-500 @enderror"
                    placeholder="Escriba el contenido del mensaje masivo..."
                >{{ old('cuerpo') }}</textarea>
                @error('cuerpo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivos Adjuntos -->
            <div>
                <label for="adjuntos_masivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Archivos Adjuntos (Opcional)
                </label>
                <input
                    type="file"
                    id="adjuntos_masivo"
                    name="adjuntos[]"
                    multiple
                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-purple-50 file:text-purple-700
                        hover:file:bg-purple-100
                        dark:file:bg-purple-900 dark:file:text-purple-200
                        dark:hover:file:bg-purple-800
                        @error('adjuntos') border-red-500 @enderror"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                >
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Los archivos se enviarán a todos los destinatarios. Máximo 5MB por archivo.
                </p>
                @error('adjuntos')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Opciones Adicionales -->
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox"
                        name="notificar_email"
                        checked
                        class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                    >
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Notificar por email</span>
                </label>

                <label class="flex items-center">
                    <input type="checkbox"
                        id="programar_envio_masivo"
                        class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                        onclick="document.getElementById('programado_para_masivo').disabled = !this.checked"
                    >
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Programar envío</span>
                </label>
            </div>

            <!-- Fecha programada -->
            <div id="programado_container">
                <input
                    type="datetime-local"
                    id="programado_para_masivo"
                    name="programado_para"
                    disabled
                    value="{{ old('programado_para') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 disabled:opacity-50 @error('programado_para') border-red-500 @enderror"
                >
                @error('programado_para')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button"
                @click="$dispatch('close-modal', 'create-mensaje-masivo')"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Cancelar
            </button>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
                Enviar Mensaje Masivo
            </button>
        </div>
    </form>

    <script>
        function toggleDestinatariosOptions(tipo) {
            // Deshabilitar todos los campos
            document.getElementById('rol_destinatario').disabled = true;
            document.getElementById('curso_paralelo_selects').style.display = 'none';
            document.getElementById('destinatarios_manuales').style.display = 'none';

            // Deshabilitar searchable-selects de curso/paralelo
            const cursoSelect = document.getElementById('curso_id_masivo');
            const paraleloSelect = document.getElementById('paralelo_id_masivo');
            if (cursoSelect) cursoSelect.disabled = true;
            if (paraleloSelect) paraleloSelect.disabled = true;

            // Habilitar el seleccionado
            if (tipo === 'rol') {
                document.getElementById('rol_destinatario').disabled = false;
            } else if (tipo === 'curso') {
                document.getElementById('curso_paralelo_selects').style.display = 'grid';
                // Habilitar searchable-selects de curso/paralelo
                if (cursoSelect) cursoSelect.disabled = false;
                if (paraleloSelect) paraleloSelect.disabled = false;
            } else if (tipo === 'manual') {
                document.getElementById('destinatarios_manuales').style.display = 'block';
            }
        }

        // Inicializar con manual seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            toggleDestinatariosOptions('manual');
        });
    </script>
</x-modal>
