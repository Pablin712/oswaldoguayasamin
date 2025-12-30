{{-- Modal de Confirmación de Eliminación --}}
<div x-show="showDeleteModal"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">

    {{-- Overlay --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

    {{-- Modal Content --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div @click.away="showDeleteModal = false"
             class="relative bg-white rounded-lg shadow-xl max-w-md w-full">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">
                            Confirmar Eliminación
                        </h3>
                        <p class="text-sm text-gray-500">Esta acción no se puede deshacer</p>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-4">
                <div class="space-y-3">
                    <p class="text-sm text-gray-700">
                        ¿Está seguro que desea eliminar esta asignación?
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Docente</p>
                                <p class="text-sm text-gray-600" x-text="deleteInfo.docente"></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Materia</p>
                                <p class="text-sm text-gray-600" x-text="deleteInfo.materia"></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Paralelo</p>
                                <p class="text-sm text-gray-600" x-text="deleteInfo.paralelo"></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex gap-2">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div class="text-sm text-amber-800">
                                <p class="font-medium">Advertencia:</p>
                                <p>Se eliminarán también todos los horarios asociados a esta asignación.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <button @click="showDeleteModal = false"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    Cancelar
                </button>
                <button @click="deleteAsignacion()"
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                    Eliminar Asignación
                </button>
            </div>

        </div>
    </div>
</div>
