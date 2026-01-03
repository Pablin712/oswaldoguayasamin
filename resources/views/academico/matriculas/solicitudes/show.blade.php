<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Solicitud') }}
            </h2>
            <a href="{{ route('solicitudes-matricula.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Encabezado -->
                    <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ $solicitudMatricula->nombre_completo }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Cédula: {{ $solicitudMatricula->cedula }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Fecha de Solicitud: {{ $solicitudMatricula->created_at ? $solicitudMatricula->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($solicitudMatricula->estado === 'pendiente') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @elseif($solicitudMatricula->estado === 'aprobada') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                {{ ucfirst($solicitudMatricula->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Información Personal
                            </h4>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombres</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->nombres }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Apellidos</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->apellidos }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->email }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->telefono ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <!-- Información Académica -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Información Académica
                            </h4>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Curso Solicitado</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->cursoSolicitado?->nombre ?? 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Período Académico</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->periodoAcademico?->nombre ?? 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Institución de Origen</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->institucion_origen ?? 'No especificada' }}</p>
                            </div>

                            @if($solicitudMatricula->observaciones)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Observaciones</label>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $solicitudMatricula->observaciones }}</p>
                                </div>
                            @endif
                        </div>

                    </div>

                    <!-- Documentos Adjuntos -->
                    <div class="mt-6 space-y-4">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Documentos Adjuntos
                        </h4>

                            <div class="flex flex-wrap gap-4">
                                @if($solicitudMatricula->adjunto_cedula_path)
                                    <a href="{{ route('solicitudes-matricula.download', ['solicitudMatricula' => $solicitudMatricula, 'tipo' => 'cedula']) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Descargar Cédula
                                    </a>
                                @endif

                                @if($solicitudMatricula->adjunto_certificado_path)
                                    <a href="{{ route('solicitudes-matricula.download', ['solicitudMatricula' => $solicitudMatricula, 'tipo' => 'certificado']) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Descargar Certificado
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    @if($solicitudMatricula->estado === 'pendiente')
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                            @canany(['aprobar solicitudes matricula', 'gestionar solicitudes matricula'])
                                <button type="button"
                                    @click="$dispatch('open-modal', 'aprobar-solicitud-{{ $solicitudMatricula->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Aprobar Solicitud
                                </button>
                            @endcanany

                            @canany(['rechazar solicitudes matricula', 'gestionar solicitudes matricula'])
                                <button type="button"
                                    @click="$dispatch('open-modal', 'rechazar-solicitud-{{ $solicitudMatricula->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Rechazar Solicitud
                                </button>
                            @endcanany
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('academico.matriculas.solicitudes.modal-aprobar')
    @include('academico.matriculas.solicitudes.modal-rechazar')
</x-app-layout>


