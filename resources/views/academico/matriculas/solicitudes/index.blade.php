<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Solicitudes de Matrícula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="{{ route('solicitudes-matricula.index') }}" class="flex flex-wrap gap-4 items-end">
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
                        <label for="curso_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Curso
                        </label>
                        <select id="curso_id" name="curso_id"
                            class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $cursoId == $curso->id ? 'selected' : '' }}>{{ $curso->nombre }}</option>
                            @endforeach
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

            <!-- Tabla de Solicitudes -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="solicitudesMatriculaTable"
                        :headers="[
                            ['label' => 'Solicitante', 'type' => 'string'],
                            ['label' => 'Curso', 'type' => 'string'],
                            ['label' => 'Estado', 'type' => 'string'],
                            ['label' => 'Fecha Solicitud', 'type' => 'date'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])"
                        :excel="auth()->user()->canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])"
                        :pdf="auth()->user()->canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])"
                        :print="auth()->user()->canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])"
                        :json="auth()->user()->canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])">

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($solicitudesMatricula as $solicitud)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="font-medium text-gray-900 dark:text-gray-200">
                                            {{ $solicitud->nombre_completo }}
                                        </div>
                                        <div class="text-gray-500 dark:text-gray-400">
                                            {{ $solicitud->cedula }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                        {{ $solicitud->cursoSolicitado->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($solicitud->estado === 'pendiente') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                            @elseif($solicitud->estado === 'aprobada') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @else bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 @endif">
                                            {{ ucfirst($solicitud->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                        {{ $solicitud->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            @canany(['ver solicitudes matricula', 'gestionar solicitudes matricula'])
                                                <a href="{{ route('solicitudes-matricula.show', $solicitud) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                                    title="Ver detalles">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                            @endcanany

                                            @if($solicitud->estado === 'pendiente')
                                                @canany(['aprobar solicitudes matricula', 'gestionar solicitudes matricula'])
                                                    <button type="button"
                                                        onclick="openAprobarModal({{ $solicitud->id }}, '{{ addslashes($solicitud->nombre_completo) }}')"
                                                        class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                                                        title="Aprobar">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                @endcanany

                                                @canany(['rechazar solicitudes matricula', 'gestionar solicitudes matricula'])
                                                    <button type="button"
                                                        onclick="openRechazarModal({{ $solicitud->id }}, '{{ addslashes($solicitud->nombre_completo) }}')"
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
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                        No se encontraron solicitudes de matrícula.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    @canany(['aprobar solicitudes matricula', 'gestionar solicitudes matricula'])
        @include('academico.matriculas.solicitudes.modal-aprobar')
    @endcanany

    @canany(['rechazar solicitudes matricula', 'gestionar solicitudes matricula'])
        @include('academico.matriculas.solicitudes.modal-rechazar')
    @endcanany

    @push('scripts')
    <script>
        function openAprobarModal(solicitudId, nombre) {
            const form = document.getElementById('form-aprobar-solicitud');
            form.action = `/academico/solicitudes-matricula/${solicitudId}/aprobar`;
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'aprobar-solicitud' }));
        }

        function openRechazarModal(solicitudId, nombre) {
            const form = document.getElementById('form-rechazar-solicitud');
            form.action = `/academico/solicitudes-matricula/${solicitudId}/rechazar`;
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'rechazar-solicitud' }));
        }
    </script>
    @endpush
</x-app-layout>
