<x-modal name="delete-tarea-{{ $tarea->id }}" maxWidth="md">
    <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="p-6">
        @csrf
        @method('DELETE')

        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>

            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                Eliminar Tarea
            </h3>

            <div class="mt-3 text-sm text-gray-600 dark:text-gray-400 space-y-2">
                <p>¿Está seguro que desea eliminar la tarea:</p>
                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $tarea->titulo }}</p>

                @if($tarea->tareaEstudiantes->count() > 0)
                <div class="mt-4 border-l-4 border-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded">
                    <p class="text-yellow-800 dark:text-yellow-200">
                        <strong>Advertencia:</strong> Esta tarea tiene {{ $tarea->tareaEstudiantes->count() }}
                        {{ $tarea->tareaEstudiantes->count() == 1 ? 'entrega asociada' : 'entregas asociadas' }}.
                    </p>
                    <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                        Al eliminar la tarea se eliminarán todas las entregas y calificaciones relacionadas.
                    </p>
                </div>
                @endif

                <p class="mt-3 text-red-600 dark:text-red-400 font-medium">
                    Esta acción no se puede deshacer.
                </p>
            </div>
        </div>

        <div class="mt-6 flex justify-center space-x-3">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                Cancelar
            </x-secondary-button>
            <x-danger-button>
                Eliminar Tarea
            </x-danger-button>
        </div>
    </form>
</x-modal>
