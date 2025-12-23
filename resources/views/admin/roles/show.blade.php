<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detalle del Rol') }}: {{ $role->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('roles.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 dark:bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Volver') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Información del Rol --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                            {{ __('Información del Rol') }}
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Nombre') }}</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $role->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Guard') }}</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $role->guard_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Creado') }}</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $role->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Actualizado') }}</p>
                                <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $role->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Permisos Asignados --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                            {{ __('Permisos Asignados') }} ({{ $role->permissions->count() }})
                        </h3>
                        @if($role->permissions->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($role->permissions as $permission)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-theme-primary/10 text-theme-primary dark:bg-theme-primary/20 dark:text-theme-primary">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Este rol no tiene permisos asignados.') }}
                            </p>
                        @endif
                    </div>

                    {{-- Usuarios con este Rol --}}
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                            {{ __('Usuarios con este Rol') }} ({{ $role->users->count() }})
                        </h3>
                        @if($role->users->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Nombre') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Email') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                {{ __('Registrado') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($role->users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $user->created_at->format('d/m/Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('No hay usuarios asignados a este rol.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
