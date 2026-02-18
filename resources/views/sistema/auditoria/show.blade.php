<x-app-layout>
    @can('ver auditoria')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle de Auditoría') }}
            </h2>
            <a href="{{ route('auditoria.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Información General -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha/Hora</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $auditoria->created_at->format('d/m/Y H:i:s') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Usuario</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $auditoria->user->name ?? 'Sistema' }}
                                @if($auditoria->user)
                                <a href="{{ route('auditoria.usuario', $auditoria->user_id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 ml-2">
                                    (Ver actividad)
                                </a>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Acción</label>
                            <p class="mt-1">
                                @if($auditoria->accion == 'login')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Login
                                    </span>
                                @elseif($auditoria->accion == 'logout')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Logout
                                    </span>
                                @elseif($auditoria->accion == 'create')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Crear
                                    </span>
                                @elseif($auditoria->accion == 'update')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Actualizar
                                    </span>
                                @elseif($auditoria->accion == 'delete')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Eliminar
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($auditoria->accion) }}
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tabla Afectada</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ ucfirst($auditoria->tabla_afectada ?? 'N/A') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">ID de Registro</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $auditoria->registro_id ?? 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Dirección IP</label>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $auditoria->ip_address }}
                            </p>
                        </div>
                    </div>

                    @if($auditoria->user_agent)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">User Agent</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 break-all">
                            {{ $auditoria->user_agent }}
                        </p>
                    </div>
                    @endif

                    @if($auditoria->descripcion)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Descripción</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                            {{ $auditoria->descripcion }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Datos Anteriores -->
            @if($auditoria->datos_anteriores && count($auditoria->datos_anteriores) > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos Anteriores</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-sm text-gray-900 dark:text-gray-100">{{ json_encode($auditoria->datos_anteriores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
            @endif

            <!-- Datos Nuevos -->
            @if($auditoria->datos_nuevos && count($auditoria->datos_nuevos) > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Datos Nuevos</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 overflow-x-auto">
                        <pre class="text-sm text-gray-900 dark:text-gray-100">{{ json_encode($auditoria->datos_nuevos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
            @endif

            <!-- Comparación de Cambios -->
            @if($auditoria->datos_anteriores && $auditoria->datos_nuevos && $auditoria->accion == 'update')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Cambios Realizados</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Campo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Valor Anterior
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Valor Nuevo
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($auditoria->datos_nuevos as $campo => $valorNuevo)
                                    @php
                                        $valorAnterior = $auditoria->datos_anteriores[$campo] ?? null;
                                        $cambio = $valorAnterior != $valorNuevo;
                                    @endphp
                                    @if($cambio)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ ucfirst(str_replace('_', ' ', $campo)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-red-600 dark:text-red-400">
                                            {{ is_array($valorAnterior) ? json_encode($valorAnterior) : ($valorAnterior ?? 'N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-green-600 dark:text-green-400">
                                            {{ is_array($valorNuevo) ? json_encode($valorNuevo) : ($valorNuevo ?? 'N/A') }}
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endcan
</x-app-layout>
