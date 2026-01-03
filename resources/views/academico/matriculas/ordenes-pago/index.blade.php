<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Órdenes de Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('ordenes-pago.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado
                        </label>
                        <select id="estado" name="estado"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ $estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobada" {{ $estado === 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ $estado === 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <label for="tipo_pago" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tipo de Pago
                        </label>
                        <select id="tipo_pago" name="tipo_pago"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Todos los tipos</option>
                            <option value="primera_matricula" {{ $tipoPago === 'primera_matricula' ? 'selected' : '' }}>Primera Matrícula</option>
                            <option value="segunda_matricula" {{ $tipoPago === 'segunda_matricula' ? 'selected' : '' }}>Segunda Matrícula</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Órdenes de Pago -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="ordenesPagoTable"
                        :headers="[
                            ['label' => 'Código', 'type' => 'string'],
                            ['label' => 'Estudiante', 'type' => 'string'],
                            ['label' => 'Tipo Pago', 'type' => 'string'],
                            ['label' => 'Monto', 'type' => 'currency'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Comprobante', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['ver ordenes pago', 'gestionar ordenes pago'])"
                        :excel="auth()->user()->canany(['ver ordenes pago', 'gestionar ordenes pago'])"
                        :pdf="auth()->user()->canany(['ver ordenes pago', 'gestionar ordenes pago'])"
                        :print="auth()->user()->canany(['ver ordenes pago', 'gestionar ordenes pago'])"
                        :json="auth()->user()->canany(['ver ordenes pago', 'gestionar ordenes pago'])">

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($ordenesPago as $orden)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $orden->codigo_orden }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">
                                            {{ $orden->matricula->estudiante->user->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-gray-500 dark:text-gray-400">
                                            {{ $orden->matricula->paralelo->curso->nombre ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        @if($orden->tipo_pago === 'primera_matricula')
                                            Primera Matrícula
                                        @else
                                            Segunda Matrícula
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        ${{ number_format($orden->monto, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($orden->estado === 'pendiente') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @elseif($orden->estado === 'aprobada') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                            {{ ucfirst($orden->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        @if($orden->adjunto_comprobante)
                                            @canany(['ver ordenes pago', 'gestionar ordenes pago'])
                                                <a href="{{ route('ordenes-pago.download-comprobante', $orden) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                                    title="Descargar comprobante">
                                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            @endcanany
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">Sin comprobante</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @canany(['ver ordenes pago', 'gestionar ordenes pago'])
                                                <a href="{{ route('ordenes-pago.show', $orden) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                                    title="Ver detalles">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                            @endcanany

                                            @if($orden->estado === 'pendiente' && $orden->comprobante_path)
                                                @canany(['aprobar ordenes pago', 'gestionar ordenes pago'])
                                                    <button type="button"
                                                        onclick="openAprobarOrdenModal({{ $orden->id }}, {{ $orden->monto }})"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                                                        title="Aprobar">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                @endcanany

                                                @canany(['rechazar ordenes pago', 'gestionar ordenes pago'])
                                                    <button type="button"
                                                        onclick="openRechazarOrdenModal({{ $orden->id }})"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                        title="Rechazar">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No se encontraron órdenes de pago.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>
    @canany(['aprobar ordenes pago', 'gestionar ordenes pago'])
        @include('academico.matriculas.ordenes-pago.modal-aprobar')
    @endcanany

    @canany(['rechazar ordenes pago', 'gestionar ordenes pago'])
        @include('academico.matriculas.ordenes-pago.modal-rechazar')
    @endcanany

    @push('scripts')
    <script>
        function openAprobarOrdenModal(ordenId, monto) {
            const form = document.getElementById('form-aprobar-orden');
            const mensaje = document.getElementById('aprobar-orden-mensaje');
            form.action = `/academico/ordenes-pago/${ordenId}/aprobar`;

            if (monto > 0) {
                mensaje.textContent = '¿Estás seguro de que deseas aprobar esta orden de pago? La matrícula será marcada como aprobada y se registrará el pago.';
            } else {
                mensaje.textContent = '¿Estás seguro de que deseas aprobar esta matrícula gratuita? La matrícula será marcada como aprobada.';
            }

            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'aprobar-orden' }));
        }

        function openRechazarOrdenModal(ordenId) {
            const form = document.getElementById('form-rechazar-orden');
            form.action = `/academico/ordenes-pago/${ordenId}/rechazar`;
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'rechazar-orden' }));
        }
    </script>
    @endpush
</x-app-layout>
