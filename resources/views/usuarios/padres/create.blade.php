<x-modal name="create-padre-modal" maxWidth="4xl">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Crear Nuevo Padre/Representante
        </h2>

        <form method="POST" action="{{ route('padres.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información Personal -->
            <div class="space-y-4">
                <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Personal</h3>

                <div>
                    <x-input-label for="nombre_completo" :value="__('Nombre Completo *')" />
                    <x-text-input id="nombre_completo" name="nombre_completo" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="cedula" :value="__('Cédula *')" />
                    <x-text-input id="cedula" name="cedula" type="text" class="mt-1 block w-full" maxlength="10" required />
                    <p class="mt-1 text-xs text-gray-500">La cédula será la contraseña inicial</p>
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico *')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono" :value="__('Teléfono Personal')" />
                    <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="direccion" :value="__('Dirección')" />
                    <textarea id="direccion" name="direccion" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>
            </div>

            <!-- Información Laboral -->
            <div class="space-y-4">
                <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Laboral</h3>

                <div>
                    <x-input-label for="ocupacion" :value="__('Ocupación')" />
                    <x-text-input id="ocupacion" name="ocupacion" type="text" class="mt-1 block w-full" maxlength="100" />
                    <x-input-error :messages="$errors->get('ocupacion')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="lugar_trabajo" :value="__('Lugar de Trabajo')" />
                    <x-text-input id="lugar_trabajo" name="lugar_trabajo" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('lugar_trabajo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_trabajo" :value="__('Teléfono de Trabajo')" />
                    <x-text-input id="telefono_trabajo" name="telefono_trabajo" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('telefono_trabajo')" class="mt-2" />
                </div>

                <div class="p-4 bg-blue-50 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Información
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Después de crear el padre/representante, podrá asignarle estudiantes desde la gestión de estudiantes o matrículas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t">
            <button type="button" @click="$dispatch('close-modal', 'create-padre-modal')" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Cancelar
            </button>
            <x-primary-button>
                Crear Padre/Representante
            </x-primary-button>
        </div>
    </form>
    </div>
</x-modal>
