<div x-data="{
    editData: {
        id: null,
        codigo_estudiante: '',
        nombre_completo: '',
        cedula: '',
        email: '',
        telefono: '',
        direccion: '',
        fecha_nacimiento: '',
        fecha_ingreso: '',
        tipo_sangre: '',
        alergias: '',
        contacto_emergencia: '',
        telefono_emergencia: '',
        estado: ''
    }
}"
@open-edit-modal.window="
    editData = $event.detail;
    $dispatch('open-modal', 'edit-estudiante-modal');
">
    <x-modal name="edit-estudiante-modal" maxWidth="4xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Editar Estudiante
            </h2>

            <form method="POST" :action="`{{ route('estudiantes.index') }}/${editData.id}`" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Personal</h3>

                    <div>
                        <x-input-label for="edit_codigo_estudiante" :value="__('Código de Estudiante')" />
                        <x-text-input
                            id="edit_codigo_estudiante"
                            name="codigo_estudiante"
                            type="text"
                            class="mt-1 block w-full bg-gray-100"
                            x-model="editData.codigo_estudiante"
                            readonly
                        />
                        <p class="mt-1 text-xs text-gray-500">El código se genera automáticamente</p>
                    </div>

                    <div>
                        <x-input-label for="edit_nombre_completo" :value="__('Nombre Completo *')" />
                        <x-text-input id="edit_nombre_completo" name="nombre_completo" type="text" class="mt-1 block w-full" x-model="editData.nombre_completo" required />
                        <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_cedula" :value="__('Cédula *')" />
                        <x-text-input id="edit_cedula" name="cedula" type="text" class="mt-1 block w-full" maxlength="10" x-model="editData.cedula" required />
                        <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_email" :value="__('Correo Electrónico *')" />
                        <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" x-model="editData.email" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_telefono" :value="__('Teléfono')" />
                        <x-text-input id="edit_telefono" name="telefono" type="text" class="mt-1 block w-full" x-model="editData.telefono" />
                        <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                        <x-text-input id="edit_fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" x-model="editData.fecha_nacimiento" />
                        <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_direccion" :value="__('Dirección')" />
                        <textarea id="edit_direccion" name="direccion" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="editData.direccion"></textarea>
                        <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                    </div>
                </div>

                <!-- Información Académica y Médica -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Académica y Médica</h3>

                    <div>
                        <x-input-label for="edit_fecha_ingreso" :value="__('Fecha de Ingreso')" />
                        <x-text-input id="edit_fecha_ingreso" name="fecha_ingreso" type="date" class="mt-1 block w-full" x-model="editData.fecha_ingreso" />
                        <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_tipo_sangre" :value="__('Tipo de Sangre')" />
                        <select id="edit_tipo_sangre" name="tipo_sangre" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="editData.tipo_sangre">
                            <option value="">Seleccione...</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                        <x-input-error :messages="$errors->get('tipo_sangre')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_alergias" :value="__('Alergias')" />
                        <textarea id="edit_alergias" name="alergias" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Indique si tiene alguna alergia" x-model="editData.alergias"></textarea>
                        <x-input-error :messages="$errors->get('alergias')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_contacto_emergencia" :value="__('Contacto de Emergencia')" />
                        <x-text-input id="edit_contacto_emergencia" name="contacto_emergencia" type="text" class="mt-1 block w-full" x-model="editData.contacto_emergencia" />
                        <x-input-error :messages="$errors->get('contacto_emergencia')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_telefono_emergencia" :value="__('Teléfono de Emergencia')" />
                        <x-text-input id="edit_telefono_emergencia" name="telefono_emergencia" type="text" class="mt-1 block w-full" x-model="editData.telefono_emergencia" />
                        <x-input-error :messages="$errors->get('telefono_emergencia')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_estado" :value="__('Estado *')" />
                        <select id="edit_estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" x-model="editData.estado" required>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="retirado">Retirado</option>
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <button type="button" @click="$dispatch('close-modal', 'edit-estudiante-modal')" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Cancelar
                </button>
                <x-primary-button>
                    Actualizar Estudiante
                </x-primary-button>
            </div>
        </form>
        </div>
    </x-modal>
</div>
