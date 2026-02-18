<x-app-layout>
    @canany(['gestionar tareas', 'ver tareas'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Tareas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Alerta temporal -->
            <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-6 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-200">
                            Vista en construcción
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>El backend de este módulo está completamente funcional (rutas, controlador, modelos, permisos).</p>
                            <p class="mt-1">La interfaz de usuario está pendiente de desarrollo.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del módulo -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Módulo: Gestión de Tareas</h3>

                    <div class="space-y-3">
                        <p><strong>Estado del Backend:</strong> ✅ Completado</p>
                        <p><strong>Controlador:</strong> TareaController</p>

                        <div class="mt-6">
                            <h4 class="font-semibold mb-2">Funcionalidades implementadas en el backend:</h4>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>CRUD completo de tareas</li>
                                <li>Sistema de entregas de estudiantes con archivos</li>
                                <li>Calificación de tareas entregadas</li>
                                <li>Vista de tareas próximas a vencer</li>
                                <li>Gestión de archivos adjuntos</li>
                                <li>Seguimiento de estado (pendiente/entregada/calificada/vencida)</li>
                            </ul>
                        </div>

                        <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm"><strong>Datos cargados:</strong></p>
                            <p class="text-sm">Tareas registradas: {{ isset($tareas) ? $tareas->count() : 0 }}</p>
                            <p class="text-sm">Materias disponibles: {{ isset($materias) ? $materias->count() : 0 }}</p>
                            <p class="text-sm">Paralelos: {{ isset($paralelos) ? $paralelos->count() : 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
