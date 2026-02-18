<x-modal name="create-mensaje" :show="false" maxWidth="2xl">
    <form method="POST" action="{{ route('mensajes.store') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <input type="hidden" name="tipo" value="individual">

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Nuevo Mensaje') }}
        </h2>

        <div class="space-y-4">
            <!-- Destinatario -->
            <div>
                <label for="destinatario_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Destinatario <span class="text-red-500">*</span>
                </label>
                <x-searchable-select
                    id="destinatario_id"
                    name="destinatario_id"
                    placeholder="Buscar usuario por nombre..."
                    :options="isset($usuarios) ? $usuarios->map(fn($u) => ['id' => $u->id, 'name' => $u->name . ' (' . $u->email . ')'])->toArray() : []"
                    :selected="old('destinatario_id')"
                    valueField="id"
                    labelField="name"
                />
                @error('destinatario_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Asunto -->
            <div>
                <label for="asunto_individual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Asunto <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="asunto_individual"
                    name="asunto"
                    value="{{ old('asunto') }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 @error('asunto') border-red-500 @enderror"
                    placeholder="Ingrese el asunto del mensaje"
                >
                @error('asunto')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cuerpo del mensaje -->
            <div>
                <label for="cuerpo_individual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Mensaje <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="cuerpo_individual"
                    name="cuerpo"
                    rows="6"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 @error('cuerpo') border-red-500 @enderror"
                    placeholder="Escriba su mensaje aquí..."
                >{{ old('cuerpo') }}</textarea>
                @error('cuerpo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Archivos Adjuntos -->
            <div>
                <label for="adjuntos_individual" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Archivos Adjuntos (Opcional)
                </label>
                <input
                    type="file"
                    id="adjuntos_individual"
                    name="adjuntos[]"
                    multiple
                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                        dark:file:bg-blue-900 dark:file:text-blue-200
                        dark:hover:file:bg-blue-800
                        @error('adjuntos') border-red-500 @enderror"
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                >
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Formatos permitidos: PDF, Word, Excel, Imágenes. Máximo 5MB por archivo.
                </p>
                @error('adjuntos')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Programar Envío (opcional) -->
            <div>
                <label class="flex items-center">
                    <input type="checkbox"
                        id="programar_envio_individual"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600"
                        onclick="document.getElementById('programado_para_individual').disabled = !this.checked"
                    >
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Programar envío</span>
                </label>
                <input
                    type="datetime-local"
                    id="programado_para_individual"
                    name="programado_para"
                    disabled
                    value="{{ old('programado_para') }}"
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 disabled:opacity-50 @error('programado_para') border-red-500 @enderror"
                >
                @error('programado_para')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button"
                @click="$dispatch('close-modal', 'create-mensaje')"
                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Cancelar
            </button>
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Enviar Mensaje
            </button>
        </div>
    </form>
</x-modal>
