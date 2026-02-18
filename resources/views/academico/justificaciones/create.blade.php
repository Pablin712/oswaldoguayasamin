<x-modal name="create-justificacion-modal" maxWidth="2xl">
    <form method="POST" action="{{ route('justificaciones.store') }}" enctype="multipart/form-data" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
            Nueva Justificación
        </h2>

        <div class="space-y-4">
            <!-- Asistencia a justificar -->
            <div>
                <label for="asistencia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Asistencia a Justificar <span class="text-red-500">*</span>
                </label>
                <select name="asistencia_id" id="asistencia_id" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Seleccione una asistencia</option>
                    <!-- Las opciones se cargarán dinámicamente según el usuario -->
                </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Solo se muestran asistencias ausentes sin justificación aprobada o pendiente
                </p>
                @error('asistencia_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motivo -->
            <div>
                <label for="motivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Motivo <span class="text-red-500">*</span>
                </label>
                <textarea name="motivo" id="motivo" rows="4" required
                          class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                          placeholder="Describa el motivo de la ausencia...">{{ old('motivo') }}</textarea>
                @error('motivo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivo adjunto -->
            <div>
                <label for="archivo_adjunto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Archivo Adjunto
                </label>
                <input type="file" name="archivo_adjunto" id="archivo_adjunto" accept=".pdf,.jpg,.jpeg,.png"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Formatos permitidos: PDF, JPG, PNG (máx. 2MB)
                </p>
                @error('archivo_adjunto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Enviar Justificación') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
