<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Solicitar Matrícula') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Header Info -->
            <div class="bg-blue-50 dark:bg-gray-800 rounded-lg p-6 mb-6 border border-blue-100 dark:border-gray-700">
                <div class="flex">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <p class="font-semibold text-blue-900 dark:text-blue-300">Información sobre su solicitud</p>
                        <ul class="space-y-1 list-disc list-inside ml-1">
                            <li>Complete todos los campos requeridos para enviar su solicitud</li>
                            <li>Adjunte documentos legibles que no excedan los 2 MB</li>
                            <li>Su solicitud será revisada por el personal administrativo</li>
                            <li>Recibirá notificaciones sobre el estado de su solicitud</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <form method="POST" action="{{ route('solicitudes-matricula.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <!-- Datos Personales -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Información Personal
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <x-input-label for="nombres" value="Nombres *" />
                                    <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', auth()->user()->name ?? '')" required autofocus />
                                    <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="apellidos" value="Apellidos *" />
                                    <x-text-input id="apellidos" name="apellidos" type="text" class="mt-1 block w-full" :value="old('apellidos')" required />
                                    <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="cedula" value="Cédula *" />
                                    <x-text-input id="cedula" name="cedula" type="text" maxlength="10" class="mt-1 block w-full" :value="old('cedula')" required />
                                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="email" value="Correo Electrónico *" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', auth()->user()->email ?? '')" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="telefono" value="Teléfono de Contacto" />
                                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" placeholder="0987654321" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="institucion_origen" value="Institución de Origen" />
                                    <x-text-input id="institucion_origen" name="institucion_origen" type="text" class="mt-1 block w-full" :value="old('institucion_origen')" placeholder="Ej: Escuela Fiscal N° 5" />
                                    <x-input-error :messages="$errors->get('institucion_origen')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="observaciones" value="Observaciones Adicionales" />
                                <textarea id="observaciones" name="observaciones" rows="3"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Información adicional que desee compartir...">{{ old('observaciones') }}</textarea>
                                <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Datos Académicos -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Datos Académicos
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="periodo_academico_id" value="Institución y Período Académico *" />
                                    <select id="periodo_academico_id" name="periodo_academico_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="">Seleccione la institución y período</option>
                                        @foreach($periodos as $periodo)
                                            <option value="{{ $periodo->id }}" {{ old('periodo_academico_id') == $periodo->id ? 'selected' : '' }}>
                                                {{ $periodo->institucion->nombre }} - {{ $periodo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Seleccione la institución y el período académico al que desea aplicar</p>
                                    <x-input-error :messages="$errors->get('periodo_academico_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="curso_solicitado_id" value="Curso o Grado Solicitado *" />
                                    <select id="curso_solicitado_id" name="curso_solicitado_id"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="">Seleccione el curso</option>
                                        @foreach($cursos as $curso)
                                            <option value="{{ $curso->id }}" {{ old('curso_solicitado_id') == $curso->id ? 'selected' : '' }}>
                                                {{ $curso->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">Grado o nivel educativo al que desea ingresar</p>
                                    <x-input-error :messages="$errors->get('curso_solicitado_id')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Documentos Adjuntos -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-3">
                                <div class="w-1 h-6 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Documentos Requeridos
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <x-input-label for="adjunto_cedula" value="Cédula de Identidad (PDF o Imagen) *" />
                                    <input id="adjunto_cedula" name="adjunto_cedula" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600"
                                        required />
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Máximo 2 MB - Formatos permitidos: PDF, JPG, PNG</p>
                                    <x-input-error :messages="$errors->get('adjunto_cedula')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="adjunto_certificado" value="Certificado de Notas (PDF o Imagen) *" />
                                    <input id="adjunto_certificado" name="adjunto_certificado" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                        class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600"
                                        required />
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Máximo 2 MB - Formatos permitidos: PDF, JPG, PNG</p>
                                    <x-input-error :messages="$errors->get('adjunto_certificado')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-md shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Enviar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
