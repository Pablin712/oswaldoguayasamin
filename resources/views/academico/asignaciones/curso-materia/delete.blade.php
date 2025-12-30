<div x-data="{
    id: null,
    materia_nombre: '',
    curso_nombre: '',
    horas_semanales: 0
}" @open-delete-modal.window="
    id = $event.detail.id;
    materia_nombre = $event.detail.materia_nombre;
    curso_nombre = $event.detail.curso_nombre;
    horas_semanales = $event.detail.horas_semanales;
    $dispatch('open-modal', 'delete-curso-materia-modal');
">
    <x-modal name="delete-curso-materia-modal" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Eliminar Asignación de Materia
                    </h2>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    ¿Está seguro de eliminar esta asignación?
                </p>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-2">
                    <div class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Materia:</span>
                        <span class="text-gray-900 dark:text-white ml-2" x-text="materia_nombre"></span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Curso:</span>
                        <span class="text-gray-900 dark:text-white ml-2" x-text="curso_nombre"></span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Período:</span>
                        <span class="text-gray-900 dark:text-white ml-2">{{ $periodos->firstWhere('id', $periodoId)->nombre ?? 'N/A' }}</span>
                    </div>
                    <div class="text-sm">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Horas semanales:</span>
                        <span class="text-gray-900 dark:text-white ml-2" x-text="horas_semanales"></span>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium mb-2">
                        Esta acción eliminará:
                    </p>
                    <ul class="text-sm text-yellow-700 dark:text-yellow-300 list-disc list-inside space-y-1">
                        <li>Asignaciones de docentes a esta materia</li>
                        <li>Calificaciones relacionadas (si existen)</li>
                        <li>Tareas y actividades (si existen)</li>
                    </ul>
                </div>

                <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <p class="text-sm text-red-800 dark:text-red-200 font-semibold">
                        ⚠️ Esta acción no se puede deshacer
                    </p>
                </div>
            </div>

            <form :action="`{{ route('curso-materia.index') }}/${id}`" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">
                    <button
                        type="button"
                        @click="$dispatch('close')"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-colors duration-200">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</div>
