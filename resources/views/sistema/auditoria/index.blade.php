<x-app-layout>
    @canany(['ver auditoria', 'gestionar auditoria'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Auditoría del Sistema') }}
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
                    <form method="GET" action="{{ route('auditoria.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Usuario -->
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Usuario
                                </label>
                                <x-searchable-select
                                    id="user_id"
                                    name="user_id"
                                    :options="$usuarios"
                                    :selected="request('user_id')"
                                    placeholder="Todos los usuarios"
                                    valueField="id"
                                    labelField="name"
                                />
                            </div>

                            <!-- Acción -->
                            <div>
                                <label for="accion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Acción
                                </label>
                                <select name="accion" id="accion" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="">Todas</option>
                                    <option value="login" {{ request('accion') == 'login' ? 'selected' : '' }}>Login</option>
                                    <option value="logout" {{ request('accion') == 'logout' ? 'selected' : '' }}>Logout</option>
                                    <option value="create" {{ request('accion') == 'create' ? 'selected' : '' }}>Crear</option>
                                    <option value="update" {{ request('accion') == 'update' ? 'selected' : '' }}>Actualizar</option>
                                    <option value="delete" {{ request('accion') == 'delete' ? 'selected' : '' }}>Eliminar</option>
                                </select>
                            </div>

                            <!-- Tabla -->
                            <div>
                                <label for="tabla_afectada" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Tabla
                                </label>
                                <select name="tabla_afectada" id="tabla_afectada" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <option value="">Todas</option>
                                    @foreach($tablas as $tabla)
                                        <option value="{{ $tabla }}" {{ request('tabla_afectada') == $tabla ? 'selected' : '' }}>
                                            {{ ucfirst($tabla) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- IP Address -->
                            <div>
                                <label for="ip_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Dirección IP
                                </label>
                                <input type="text" name="ip_address" id="ip_address" value="{{ request('ip_address') }}" placeholder="Ej: 192.168.1.1" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>

                            <!-- Fecha Inicio -->
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Desde
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>

                            <!-- Fecha Fin -->
                            <div>
                                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Hasta
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('auditoria.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Limpiar Filtros
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Aplicar Filtros
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Auditorías -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="auditoriaTable"
                        :headers="[
                            ['label' => 'Fecha/Hora', 'type' => 'datetime'],
                            ['label' => 'Usuario', 'type' => 'string'],
                            ['label' => 'Acción', 'type' => 'string'],
                            ['label' => 'Tabla/Registro', 'type' => 'string'],
                            ['label' => 'IP', 'type' => 'string'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :excel="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :pdf="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :print="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                        :json="auth()->user()->canany(['generar reporte auditoria', 'gestionar auditoria'])"
                    >
                        <x-slot name="buttons">
                            <a href="{{ route('auditoria.estadisticas') }}" class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Estadísticas
                            </a>
                            @can('limpiar auditoria')
                            <button x-data @click="$dispatch('open-modal', 'limpiar-auditoria-modal')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Limpiar Registros
                            </button>
                            @endcan
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($auditorias as $auditoria)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                    {{ $auditoria->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $auditoria->user->name ?? 'Sistema' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $auditoria->user->email ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($auditoria->accion == 'login')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Login
                                        </span>
                                    @elseif($auditoria->accion == 'logout')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            Logout
                                        </span>
                                    @elseif($auditoria->accion == 'create')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            Crear
                                        </span>
                                    @elseif($auditoria->accion == 'update')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Actualizar
                                        </span>
                                    @elseif($auditoria->accion == 'delete')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Eliminar
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            {{ ucfirst($auditoria->accion) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    <div>{{ ucfirst($auditoria->tabla_afectada ?? 'N/A') }}</div>
                                    @if($auditoria->registro_id)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $auditoria->registro_id }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $auditoria->ip_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('auditoria.show', $auditoria) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors" title="Ver detalles">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No se encontraron registros de auditoría.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Limpiar Registros -->
    @can('limpiar auditoria')
    <x-modal name="limpiar-auditoria-modal" maxWidth="lg">
        <form method="POST" action="{{ route('auditoria.limpiar') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Limpiar Registros de Auditoría
            </h2>

            <div class="mt-4">
                <label for="dias" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Eliminar registros anteriores a (días):
                </label>
                <input type="number" name="dias" id="dias" min="30" max="365" value="90" required
                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Se eliminarán los registros con más de la cantidad de días especificada (mínimo 30, máximo 365).
                </p>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button type="submit">
                    {{ __('Eliminar') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    @endcan
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
