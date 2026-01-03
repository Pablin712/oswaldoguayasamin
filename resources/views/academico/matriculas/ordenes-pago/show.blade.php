<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Orden de Pago') }}
            </h2>
            <a href="{{ route('ordenes-pago.index') }}"
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
                                    Orden #{{ $ordenPago->codigo_orden }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Fecha: {{ $ordenPago->created_at ? $ordenPago->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($ordenPago->estado === 'pendiente') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                @elseif($ordenPago->estado === 'aprobada') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                {{ ucfirst($ordenPago->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información del Estudiante -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Información del Estudiante
                            </h4>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $ordenPago->matricula?->estudiante?->user?->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Cédula</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $ordenPago->matricula?->estudiante?->user?->cedula ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Curso</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $ordenPago->matricula?->paralelo?->curso?->nombre ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Periodo Académico</label>
                                <p class="text-gray-900 dark:text-gray-100">{{ $ordenPago->matricula?->periodoAcademico?->nombre ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Información de Pago -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Información de Pago
                            </h4>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Pago</label>
                                <p class="text-gray-900 dark:text-gray-100">
                                    @if($ordenPago->tipo_pago === 'primera_matricula')
                                        Primera Matrícula
                                    @else
                                        Segunda Matrícula
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto</label>
                                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($ordenPago->monto, 2) }}</p>
                            </div>

                            @if($ordenPago->monto == 0)
                                <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <p class="text-sm text-green-800 dark:text-green-200 font-medium">
                                        ✓ Esta matrícula es GRATUITA
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Comprobante de Pago -->
                        <div class="col-span-full space-y-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 pb-2">
                                Comprobante de Pago
                            </h4>

                            @if($ordenPago->comprobante_path)
                                <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Comprobante cargado</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ordenPago->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('ordenes-pago.download-comprobante', $ordenPago) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Descargar
                                    </a>
                                </div>
                            @elseif($ordenPago->monto > 0 && $ordenPago->estado === 'pendiente')
                                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200 mb-4">
                                        ⚠ Aún no se ha cargado el comprobante de pago
                                    </p>

                                    <form method="POST" action="{{ route('ordenes-pago.upload-comprobante', $ordenPago) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="flex gap-4">
                                            <div class="flex-1">
                                                <input type="file" name="comprobante" accept="image/*,application/pdf" required
                                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-md file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-blue-50 file:text-blue-700
                                                    hover:file:bg-blue-100
                                                    dark:file:bg-blue-900 dark:file:text-blue-200
                                                    dark:hover:file:bg-blue-800">
                                                <x-input-error :messages="$errors->get('comprobante')" class="mt-2" />
                                            </div>
                                            <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                Subir Comprobante
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones -->
                    @if($ordenPago->estado === 'pendiente' && $ordenPago->comprobante_path)
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                            @canany(['aprobar ordenes pago', 'gestionar ordenes pago'])
                                <button type="button"
                                    @click="$dispatch('open-modal', 'aprobar-orden-{{ $ordenPago->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Aprobar Orden
                                </button>
                            @endcanany

                            @canany(['rechazar ordenes pago', 'gestionar ordenes pago'])
                                <button type="button"
                                    @click="$dispatch('open-modal', 'rechazar-orden-{{ $ordenPago->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Rechazar Orden
                                </button>
                            @endcanany
                        </div>
                    @endif

                    @if($ordenPago->monto == 0 && $ordenPago->estado === 'pendiente')
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-4">
                            @canany(['aprobar ordenes pago', 'gestionar ordenes pago'])
                                <button type="button"
                                    @click="$dispatch('open-modal', 'aprobar-orden-{{ $ordenPago->id }}')"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Aprobar Matrícula Gratuita
                                </button>
                            @endcanany
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('academico.matriculas.ordenes-pago.modal-aprobar')
    @include('academico.matriculas.ordenes-pago.modal-rechazar')
</x-app-layout>



