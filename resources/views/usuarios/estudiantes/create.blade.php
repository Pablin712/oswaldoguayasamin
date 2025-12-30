<x-modal name="create-estudiante-modal" maxWidth="4xl">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            Crear Nuevo Estudiante
        </h2>

        <form method="POST" action="{{ route('estudiantes.store') }}" class="space-y-6">
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
                    <x-input-label for="telefono" :value="__('Teléfono')" />
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

            <!-- Información Académica y Médica -->
            <div class="space-y-4">
                <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Académica y Médica</h3>

                <div>
                    <x-input-label for="fecha_ingreso" :value="__('Fecha de Ingreso')" />
                    <x-text-input id="fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tipo_sangre" :value="__('Tipo de Sangre')" />
                    <x-searchable-select
                        id="tipo_sangre"
                        name="tipo_sangre"
                        :options="[
                            ['id' => 'O+', 'name' => 'O+'],
                            ['id' => 'O-', 'name' => 'O-'],
                            ['id' => 'A+', 'name' => 'A+'],
                            ['id' => 'A-', 'name' => 'A-'],
                            ['id' => 'B+', 'name' => 'B+'],
                            ['id' => 'B-', 'name' => 'B-'],
                            ['id' => 'AB+', 'name' => 'AB+'],
                            ['id' => 'AB-', 'name' => 'AB-']
                        ]"
                        placeholder="Seleccione un tipo de sangre..."
                        :allow-clear="true"
                    />
                    <x-input-error :messages="$errors->get('tipo_sangre')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="alergias" :value="__('Alergias')" />
                    <textarea id="alergias" name="alergias" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Indique si tiene alguna alergia"></textarea>
                    <x-input-error :messages="$errors->get('alergias')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="contacto_emergencia" :value="__('Contacto de Emergencia')" />
                    <x-text-input id="contacto_emergencia" name="contacto_emergencia" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('contacto_emergencia')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="telefono_emergencia" :value="__('Teléfono de Emergencia')" />
                    <x-text-input id="telefono_emergencia" name="telefono_emergencia" type="text" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('telefono_emergencia')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="estado" :value="__('Estado *')" />
                    <x-searchable-select
                        id="estado"
                        name="estado"
                        :options="[
                            ['id' => 'activo', 'name' => 'Activo'],
                            ['id' => 'inactivo', 'name' => 'Inactivo'],
                            ['id' => 'retirado', 'name' => 'Retirado']
                        ]"
                        selected="activo"
                        placeholder="Seleccione un estado..."
                        :allow-clear="false"
                        :required="true"
                    />
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t">
            <button type="button" @click="$dispatch('close-modal', 'create-estudiante-modal')" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                Cancelar
            </button>
            <x-primary-button>
                Crear Estudiante
            </x-primary-button>
        </div>
    </form>
    </div>
</x-modal>
