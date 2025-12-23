<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestión de Roles') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 border border-red-400 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-enhanced-table
                        id="rolesTable"
                        :headers="[
                            ['label' => 'ID', 'type' => 'number'],
                            ['label' => 'Nombre', 'type' => 'string'],
                            ['label' => 'Permisos', 'type' => 'string'],
                            ['label' => 'Fecha de Creación', 'type' => 'date'],
                            ['label' => 'Acciones', 'type' => 'actions'],
                        ]"
                        :csv="auth()->user()->canany(['generar reporte roles y permisos', 'generar reportes'])"
                        :excel="auth()->user()->canany(['generar reporte roles y permisos', 'generar reportes'])"
                        :pdf="auth()->user()->canany(['generar reporte roles y permisos', 'generar reportes'])"
                        :print="auth()->user()->canany(['generar reporte roles y permisos', 'generar reportes'])"
                        :json="auth()->user()->canany(['generar reporte roles y permisos', 'generar reportes'])"
                    >
                        <x-slot name="buttons">
                            @canany(['gestionar roles y permisos', 'crear roles'])
                                <button x-data
                                        @click="$dispatch('open-modal', 'create-role')"
                                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Nuevo Rol
                                </button>
                            @endcanany
                        </x-slot>

                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($roles as $role)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $role->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-medium">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($role->permissions as $permission)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                    {{ $permission->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 dark:text-gray-500 text-xs">Sin permisos asignados</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        {{ $role->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('roles.show', $role) }}"
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                               title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            @canany(['gestionar roles', 'editar roles'])
                                                <button x-data
                                                        @click="$dispatch('open-edit-modal', {
                                                            id: {{ $role->id }},
                                                            name: '{{ addslashes($role->name) }}',
                                                            permissions: {{ json_encode($role->permissions->pluck('name')->toArray()) }}
                                                        })"
                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors"
                                                        title="Editar rol">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                            @endcanany
                                            @canany(['gestionar roles y permisos', 'eliminar roles'])
                                                <button x-data
                                                        @click="$dispatch('open-delete-modal', {
                                                            id: {{ $role->id }},
                                                            name: '{{ addslashes($role->name) }}'
                                                        })"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors"
                                                        title="Eliminar rol">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            @endcanany
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No hay roles registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-enhanced-table>
                </div>
            </div>
        </div>
    </div>

    {{-- Incluir modales --}}
    @canany(['gestionar roles y permisos', 'crear roles'])
        @include('admin.roles.create')
    @endcanany
    @canany(['gestionar roles y permisos', 'editar roles'])
        @include('admin.roles.edit')
    @endcanany
    @canany(['gestionar roles y permisos', 'eliminar roles'])
        @include('admin.roles.delete')
    @endcanany
</x-app-layout>
