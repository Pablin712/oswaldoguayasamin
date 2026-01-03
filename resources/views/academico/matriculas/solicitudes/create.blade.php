<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    Solicitud de Matrícula
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Complete el formulario para solicitar matrícula como estudiante nuevo/externo
                </p>
            </div>

            <!-- Formulario -->
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">Datos del Solicitante</h2>
                </div>

                <form method="POST" action="{{ route('solicitudes-matricula.store') }}" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf

                    <!-- Datos Personales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nombres" value="Nombres *" />
                            <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres')" required autofocus />
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
                            <x-input-label for="email" value="Email *" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="telefono" value="Teléfono" />
                            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="institucion_origen" value="Institución de Origen" />
                            <x-text-input id="institucion_origen" name="institucion_origen" type="text" class="mt-1 block w-full" :value="old('institucion_origen')" placeholder="Ej: Escuela Fiscal N° 5" />
                            <x-input-error :messages="$errors->get('institucion_origen')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="observaciones" value="Observaciones" />
                        <textarea id="observaciones" name="observaciones" rows="3"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Información adicional que desee compartir...">{{ old('observaciones') }}</textarea>
                        <x-input-error :messages="$errors->get('observaciones')" class="mt-2" />
                    </div>

                    <!-- Datos del Padre/Representante -->
                    <!-- ELIMINADO - No está en la migración actual -->

                    <!-- Datos Académicos -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Datos Académicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="periodo_academico_id" value="Institución / Período Académico *" />
                                <select id="periodo_academico_id" name="periodo_academico_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                    <option value="">Seleccione institución y período</option>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ old('periodo_academico_id') == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->institucion->nombre }} - {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('periodo_academico_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="curso_solicitado_id" value="Curso Solicitado *" />
                                <select id="curso_solicitado_id" name="curso_solicitado_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                    <option value="">Seleccione un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ old('curso_solicitado_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('curso_solicitado_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Documentos Adjuntos -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Documentos Requeridos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="adjunto_cedula" value="Cédula de Identidad (PDF/Imagen) *" />
                                <input id="adjunto_cedula" name="adjunto_cedula" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none"
                                    required />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 2 MB</p>
                                <x-input-error :messages="$errors->get('adjunto_cedula')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="adjunto_certificado" value="Certificado de Notas (PDF/Imagen) *" />
                                <input id="adjunto_certificado" name="adjunto_certificado" type="file" accept=".pdf,.jpg,.jpeg,.png"
                                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-700 rounded-md cursor-pointer bg-gray-50 dark:bg-gray-900 focus:outline-none"
                                    required />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Máximo 2 MB</p>
                                <x-input-error :messages="$errors->get('adjunto_certificado')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('welcome') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            ← Volver al inicio
                        </a>
                        <x-primary-button class="px-8 py-3">
                            Enviar Solicitud
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Nota Informativa -->
            <div class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                <p>* Campos obligatorios</p>
                <p class="mt-2">Su solicitud será revisada por el personal administrativo. Recibirá una notificación por email.</p>
            </div>
        </div>
    </div>
</x-guest-layout>
