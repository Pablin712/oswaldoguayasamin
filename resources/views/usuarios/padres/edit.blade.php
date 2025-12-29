<div x-data="{
    editData: {
        id: null,
        nombre_completo: '',
        cedula: '',
        email: '',
        telefono: '',
        direccion: '',
        fecha_nacimiento: '',
        ocupacion: '',
        lugar_trabajo: '',
        telefono_trabajo: ''
    }
}"
@open-edit-modal.window="
    editData = $event.detail;
    $dispatch('open-modal', 'edit-padre-modal');
">
    <x-modal name="edit-padre-modal" maxWidth="4xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Editar Padre/Representante
            </h2>

            <form method="POST" :action="`{{ route('padres.index') }}/${editData.id}`" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información Personal -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Personal</h3>

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
                        <x-input-label for="edit_telefono" :value="__('Teléfono Personal')" />
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

                <!-- Información Laboral -->
                <div class="space-y-4">
                    <h3 class="font-semibold text-lg text-gray-900 border-b pb-2">Información Laboral</h3>

                    <div>
                        <x-input-label for="edit_ocupacion" :value="__('Ocupación')" />
                        <x-text-input id="edit_ocupacion" name="ocupacion" type="text" class="mt-1 block w-full" maxlength="100" x-model="editData.ocupacion" />
                        <x-input-error :messages="$errors->get('ocupacion')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_lugar_trabajo" :value="__('Lugar de Trabajo')" />
                        <x-text-input id="edit_lugar_trabajo" name="lugar_trabajo" type="text" class="mt-1 block w-full" x-model="editData.lugar_trabajo" />
                        <x-input-error :messages="$errors->get('lugar_trabajo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_telefono_trabajo" :value="__('Teléfono de Trabajo')" />
                        <x-text-input id="edit_telefono_trabajo" name="telefono_trabajo" type="text" class="mt-1 block w-full" x-model="editData.telefono_trabajo" />
                        <x-input-error :messages="$errors->get('telefono_trabajo')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <button type="button" @click="$dispatch('close-modal', 'edit-padre-modal')" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Cancelar
                </button>
                <x-primary-button>
                    Actualizar Padre/Representante
                </x-primary-button>
            </div>
        </form>
        </div>
    </x-modal>
</div>
