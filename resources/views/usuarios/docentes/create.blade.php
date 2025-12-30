{{-- Modal para crear docente --}}
<x-modal name="create-docente" maxWidth="4xl" :show="$errors->any() && !session('editing')" focusable>
    <form method="POST" action="{{ route('docentes.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
            {{ __('Crear Nuevo Docente') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Información Personal -->
            <div class="col-span-2">
                <h3 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-3 border-b pb-2">
                    Información Personal
                </h3>
            </div>

            <!-- Nombre Completo -->
            <div class="mb-4">
                <x-input-label for="nombre_completo" :value="__('Nombre Completo')" />
                <x-text-input id="nombre_completo" class="block mt-1 w-full" type="text" name="nombre_completo" :value="old('nombre_completo')" required maxlength="255" placeholder="Juan Pérez García" />
                <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2" />
            </div>

            <!-- Cédula -->
            <div class="mb-4">
                <x-input-label for="cedula" :value="__('Cédula')" />
                <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required maxlength="10" placeholder="1234567890" />
                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                <p class="text-xs text-gray-500 mt-1">La cédula será la contraseña inicial</p>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required maxlength="255" placeholder="docente@ejemplo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Teléfono -->
            <div class="mb-4">
                <x-input-label for="telefono" :value="__('Teléfono')" />
                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" maxlength="20" placeholder="0987654321" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            <!-- Fecha Nacimiento -->
            <div class="mb-4">
                <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                <x-text-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" />
                <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
            </div>

            <!-- Dirección -->
            <div class="mb-4 col-span-2">
                <x-input-label for="direccion" :value="__('Dirección')" />
                <textarea id="direccion" name="direccion" rows="2"
                          class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-theme-primary dark:focus:border-theme-primary focus:ring-theme-primary dark:focus:ring-theme-primary rounded-md shadow-sm"
                          placeholder="Av. Principal 123 y Secundaria">{{ old('direccion') }}</textarea>
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
                <x-input-label for="titulo_profesional" :value="__('Título Profesional')" />
                <x-text-input id="titulo_profesional" class="block mt-1 w-full" type="text" name="titulo_profesional" :value="old('titulo_profesional')" maxlength="255" placeholder="Licenciado en Educación" />
                <x-input-error :messages="$errors->get('titulo_profesional')" class="mt-2" />
            </div>

            <!-- Especialidad -->
            <div class="mb-4">
                <x-input-label for="especialidad" :value="__('Especialidad')" />
                <x-text-input id="especialidad" class="block mt-1 w-full" type="text" name="especialidad" :value="old('especialidad')" maxlength="100" placeholder="Matemáticas" />
                <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
            </div>

            <!-- Fecha Ingreso -->
            <div class="mb-4">
                <x-input-label for="fecha_ingreso" :value="__('Fecha de Ingreso')" />
                <x-text-input id="fecha_ingreso" class="block mt-1 w-full" type="date" name="fecha_ingreso" :value="old('fecha_ingreso')" />
                <x-input-error :messages="$errors->get('fecha_ingreso')" class="mt-2" />
            </div>

            <!-- Tipo Contrato -->
            <div class="mb-4">
                <x-input-label for="tipo_contrato" :value="__('Tipo de Contrato')" />
                <x-searchable-select
                    id="tipo_contrato"
                    name="tipo_contrato"
                    :options="[
                        ['id' => 'nombramiento', 'name' => 'Nombramiento'],
                        ['id' => 'contrato', 'name' => 'Contrato']
                    ]"
                    :selected="old('tipo_contrato')"
                    placeholder="Seleccione un tipo de contrato..."
                    :allow-clear="true"
                />
                <x-input-error :messages="$errors->get('tipo_contrato')" class="mt-2" />
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <x-input-label for="estado" :value="__('Estado')" />
                <x-searchable-select
                    id="estado"
                    name="estado"
                    :options="[
                        ['id' => 'activo', 'name' => 'Activo'],
                        ['id' => 'inactivo', 'name' => 'Inactivo'],
                        ['id' => 'licencia', 'name' => 'Licencia']
                    ]"
                    :selected="old('estado', 'activo')"
                    placeholder="Seleccione un estado..."
                    :allow-clear="false"
                    :required="true"
                />
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" @click="$dispatch('close-modal', 'create-docente')"
                    class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Cancelar') }}
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-theme-primary dark:bg-theme-third border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-theme-primary-dark dark:hover:bg-theme-secondary focus:bg-theme-primary-dark active:bg-theme-primary-dark focus:outline-none focus:ring-2 focus:ring-theme-primary focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Crear Docente') }}
            </button>
        </div>
    </form>
</x-modal>
