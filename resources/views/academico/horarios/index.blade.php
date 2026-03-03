<x-app-layout>
    @canany(['gestionar horarios', 'ver horarios'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Horarios') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Filtros</h3>
                    <form method="GET" action="{{ route('horarios.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Período Académico -->
                            <div>
                                <label for="periodo_academico_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Período Académico
                                </label>
                                <x-searchable-select
                                    id="periodo_academico_id"
                                    name="periodo_academico_id"
                                    :options="$periodos"
                                    :selected="request('periodo_academico_id')"
                                    placeholder="Todos los períodos"
                                    valueField="id"
                                    labelField="nombre"
                                />
                            </div>

                            <!-- Paralelo -->
                            <div>
                                <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Paralelo
                                </label>
                                <x-searchable-select
                                    id="paralelo_id"
                                    name="paralelo_id"
                                    :options="$paralelos"
                                    :selected="request('paralelo_id')"
                                    placeholder="Todos los paralelos"
                                    valueField="id"
                                    labelField="nombre_completo"
                                />
                            </div>

                            <!-- Docente -->
                            <div>
                                <label for="docente_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Docente
                                </label>
                                <x-searchable-select
                                    id="docente_id"
                                    name="docente_id"
                                    :options="$docentes"
                                    :selected="request('docente_id')"
                                    placeholder="Todos los docentes"
                                    valueField="id"
                                    labelField="user.name"
                                />
                            </div>

                            <!-- Día de la semana -->
                            <div>
                                <label for="dia_semana" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Día de la Semana
                                </label>
                                <select id="dia_semana" name="dia_semana" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Todos los días</option>
                                    <option value="Lunes" {{ request('dia_semana') == 'Lunes' ? 'selected' : '' }}>Lunes</option>
                                    <option value="Martes" {{ request('dia_semana') == 'Martes' ? 'selected' : '' }}>Martes</option>
                                    <option value="Miércoles" {{ request('dia_semana') == 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                                    <option value="Jueves" {{ request('dia_semana') == 'Jueves' ? 'selected' : '' }}>Jueves</option>
                                    <option value="Viernes" {{ request('dia_semana') == 'Viernes' ? 'selected' : '' }}>Viernes</option>
                                    <option value="Sábado" {{ request('dia_semana') == 'Sábado' ? 'selected' : '' }}>Sábado</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('horarios.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150">
                                Limpiar
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de horarios -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        :headers="[
                            ['label' => 'Paralelo', 'type' => 'string'],
                            ['label' => 'Materia', 'type' => 'string'],
                            ['label' => 'Docente', 'type' => 'string'],
                            ['label' => 'Día', 'type' => 'string'],
                            ['label' => 'Horario', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :data="$horarios"
                        emptyMessage="No se encontraron horarios"
                    >
                    <x-slot name="buttons">
                        @canany(['gestionar horarios', 'crear horarios'])
                        <button @click="$dispatch('open-modal', 'create-horario')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Nuevo Horario
                        </button>
                        @endcanany
                    </x-slot>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($horarios as $horario)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $horario->paralelo->curso->nombre }} {{ $horario->paralelo->nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $horario->materia->nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    {{ $horario->docente->user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $horario->dia_semana }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @canany(['gestionar horarios', 'ver horarios'])
                                    <a href="{{ route('horarios.show', $horario) }}"
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                       title="Ver detalles">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    @endcanany

                                    @canany(['gestionar horarios', 'editar horarios'])
                                    <button @click="$dispatch('open-edit-modal', { id: {{ $horario->id }} })"
                                            class="text-theme-primary hover:text-theme-primary-dark dark:text-theme-primary-light dark:hover:text-theme-secondary transition-colors"
                                            title="Editar horario">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    @endcanany

                                    @canany(['gestionar horarios', 'eliminar horarios'])
                                    <button @click="$dispatch('open-delete-modal', {
                                                id: {{ $horario->id }},
                                                paralelo: '{{ $horario->paralelo->curso->nombre }} {{ $horario->paralelo->nombre }}',
                                                materia: '{{ addslashes($horario->materia->nombre) }}',
                                                dia: '{{ $horario->dia_semana }}',
                                                horario: '{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}'
                                            })"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                            title="Eliminar horario">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No se encontraron horarios.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    </x-enhanced-table>
                </div>
            </div>

            <!-- Accesos rápidos a vistas especiales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <!-- Ver por Paralelo -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Horario por Paralelo
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Ver la distribución semanal de clases de un paralelo específico
                        </p>
                        <form method="GET" action="{{ route('horarios.index') }}" class="space-y-3">
                            <x-searchable-select
                                id="paralelo_grid"
                                name="paralelo_id_grid"
                                :options="$paralelos"
                                placeholder="Seleccione un paralelo"
                                valueField="id"
                                labelField="nombre_completo"
                            />
                            <button type="button" onclick="verHorarioParalelo()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                Ver Grid Semanal
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Ver por Docente -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Horario por Docente
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Ver todas las clases asignadas a un docente
                        </p>
                        <form method="GET" action="{{ route('horarios.index') }}" class="space-y-3">
                            <x-searchable-select
                                id="docente_grid"
                                name="docente_id_grid"
                                :options="$docentes"
                                placeholder="Seleccione un docente"
                                valueField="id"
                                labelField="user.name"
                            />
                            <button type="button" onclick="verHorarioDocente()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                                Ver Grid Semanal
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Ver por Aula -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Horario por Aula
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Ver la ocupación de un aula durante la semana
                        </p>
                        <form method="GET" action="{{ route('horarios.index') }}" class="space-y-3">
                            <x-searchable-select
                                id="aula_grid"
                                name="aula_id_grid"
                                :options="$aulas"
                                placeholder="Seleccione un aula"
                                valueField="id"
                                labelField="nombre"
                            />
                            <button type="button" onclick="verHorarioAula()" class="w-full inline-flex justify-center items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                                Ver Grid Semanal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->
    @canany(['gestionar horarios', 'crear horarios'])
    @include('academico.horarios.create')
    @endcanany

    @canany(['gestionar horarios', 'editar horarios'])
    @include('academico.horarios.edit')
    @endcanany

    @canany(['gestionar horarios', 'eliminar horarios'])
    @include('academico.horarios.delete')
    @endcanany

    @push('scripts')
    <script>
        function verHorarioParalelo() {
            const select = document.getElementById('paralelo_grid');
            const paraleloId = select.value;
            if (!paraleloId) {
                alert('Por favor seleccione un paralelo');
                return;
            }
            window.location.href = `/horarios/paralelo/${paraleloId}`;
        }

        function verHorarioDocente() {
            const select = document.getElementById('docente_grid');
            const docenteId = select.value;
            if (!docenteId) {
                alert('Por favor seleccione un docente');
                return;
            }
            window.location.href = `/horarios/docente/${docenteId}`;
        }

        function verHorarioAula() {
            const select = document.getElementById('aula_grid');
            const aulaId = select.value;
            if (!aulaId) {
                alert('Por favor seleccione un aula');
                return;
            }
            window.location.href = `/horarios/aula/${aulaId}`;
        }
    </script>
    @endpush

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
