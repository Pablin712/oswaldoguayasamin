{{-- Modal único para rechazar --}}
<x-modal name="rechazar-orden" maxWidth="md" focusable>
    <div class="p-6">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                <svg class="h-6 w-6 text-red-600 dark:text-red-200" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Rechazar Orden de Pago') }}
            </h2>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            {{ __('¿Estás seguro de que deseas rechazar esta orden de pago? El estudiante deberá cargar un nuevo comprobante.') }}
        </p>

        <form method="POST" id="form-rechazar-orden">
            @csrf
            <div class="flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'rechazar-orden')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Rechazar') }}
                </button>
            </div>
        </form>
    </div>
</x-modal>
