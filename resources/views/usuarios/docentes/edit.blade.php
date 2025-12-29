{{-- Modal para editar docente --}}
<div x-data="{
    editData: {},
    modalOpen: false
}"
     @open-edit-modal.window="editData = $event.detail; modalOpen = true; $dispatch('open-modal', 'edit-docente')"
     @close-modal.window="if ($event.detail === 'edit-docente') { modalOpen = false; editData = {}; }">

    <x-modal name="edit-docente" maxWidth="4xl" focusable>
        <form method="POST" :action="`{{ route('docentes.index') }}/${editData.id}`" class="p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                {{ __('Editar Docente') }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Información Personal -->
                <div class="col-span-2">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2">
                        Información Personal
                    </h3>
                </div>

                <!-- Código Docente -->
                <div class="mb-4">
                    <x-input-label for="edit_codigo_docente" :value="__('Código Docente')" />
                    <x-text-input id="edit_codigo_docente" class="block mt-1 w-full bg-gray-100 dark:bg-gray-700" type="text" x-model="editData.codigo_docente" readonly />
                    <p class="text-xs text-gray-500 mt-1">El código se genera automáticamente</p>
                </div>

                <!-- Nombre Completo -->
                <div class="mb-4">
                    <x-input-label for="edit_nombre_completo" :value="__('Nombre Completo')" />
                    <x-text-input id="edit_nombre_completo" class="block mt-1 w-full" type="text" name="nombre_completo" x-model="editData.nombre_completo" required maxlength="255" />
                    <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2" />
                </div>

                <!-- Cédula -->
                <div class="mb-4">
                    <x-input-label for="edit_cedula" :value="__('Cédula')" />
                    <x-text-input id="edit_cedula" class="block mt-1 w-full" type="text" name="cedula" x-model="editData.cedula" required maxlength="10" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="edit_email" :value="__('Correo Electrónico')" />
                    <x-text-input id="edit_email" class="block mt-1 w-full" type="email" name="email" x-model="editData.email" required maxlength="255" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Teléfono -->
                <div class="mb-4">
                    <x-input-label for="edit_telefono" :value="__('Teléfono')" />
                    <x-text-input id="edit_telefono" class="block mt-1 w-full" type="text" name="telefono" x-model="editData.telefono" maxlength="20" />
                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                </div>

                <!-- Fecha Nacimiento -->
                <div class="mb-4">
                    <x-input-label for="edit_fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="edit_fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" x-model="editData.fecha_nacimiento" />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                <!-- Dirección -->
                <div class="mb-4 col-span-2">
                    <x-input-label for="edit_direccion" :value="__('Dirección')" />
                    <textarea id="edit_direccion" name="direccion" rows="2" x-model="editData.direccion"
                              class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                </div>

                <!-- Información Profesional -->
                <div class="col-span-2">
                    <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2 mt-2">
                        Información Profesional
                    </h3>
                </div>

                <!-- Título Profesional -->
                <div class="mb-4">
                    <x-input-label for="edit_titulo_profesional" :value="__('Título Profesional')" />
                    <x-text-input id="edit_titulo_profesional" class="block mt-1 w-full" type="text" name="titulo_profesional" x-model="editData.titulo_profesional" maxlength="255" />
                    <x-input-error :messages="$errors->get('titulo_profesional')" class="mt-2" />
                </div>

                <!-- Especialidad -->
                <div class="mb-4">
                    <x-input-label for="edit_especialidad" :value="__('Especialidad')" />
                    <x-text-input id="edit_especialidad" class="block mt-1 w-full" type="text" name="especialidad" x-model="editData.especialidad" maxlength="100" />
                    <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
                </div>

                <!-- Fecha Ingreso -->
                <div class="mb-4">
                    <x-input-label for="edit_fecha_ingreso" :value="__('Fecha de Ingreso')" />
                    <x-text-input id="edit_fecha_ingreso" class="block mt-1 w-full" type="date" name="fecha_ingreso" x-model="editData.fecha_ingreso" />
                    <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
                </div>

                <!-- Tipo Contrato -->
                <div class="mb-4">
                    <x-input-label for="edit_tipo_contrato" :value="__('Tipo de Contrato')" />
                    <select id="edit_tipo_contrato" name="tipo_contrato" x-model="editData.tipo_contrato"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                        <option value="">Seleccione un tipo</option>
                        <option value="nombramiento">Nombramiento</option>
                        <option value="contrato">Contrato</option>
                    </select>
                    <x-input-error :messages="$errors->get('tipo_contrato')" class="mt-2" />
                </div>

                <!-- Estado -->
                <div class="mb-4">
                    <x-input-label for="edit_estado" :value="__('Estado')" />
                    <select id="edit_estado" name="estado" x-model="editData.estado" required
                            class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="licencia">Licencia</option>
                    </select>
                    <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="$dispatch('close-modal', 'edit-docente')"
                        class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Actualizar') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
