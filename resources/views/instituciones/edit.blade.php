<!-- Header del Modal -->
<x-modal name="edit-institucion" maxWidth="4xl" focusable>
    <div class="p-6">
    <div class="flex justify-between items-center pb-3 border-b dark:border-gray-600 mb-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
            <svg class="w-6 h-6 mr-2 text-theme-primary dark:text-theme-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Editar Información de la Institución
        </h3>
        <button x-data="{}" @click="$dispatch('close-modal', 'edit-institucion')" type="button"
            class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Alerta de errores de validación -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-500 dark:text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-2">
                        Por favor corrige los siguientes errores:
                    </h3>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulario -->
    <form action="{{ route('instituciones.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        <div class="max-h-[70vh] overflow-y-auto px-1">
            <!-- Logo -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logo Actual</label>
                <div class="flex items-center space-x-4">
                    @if ($institucion && $institucion->logo)
                        <img id="logoPreview" src="{{ Storage::url($institucion->logo) }}" alt="Logo"
                            class="h-24 w-24 object-contain border rounded">
                    @else
                        <div id="logoPreview"
                            class="h-24 w-24 bg-gray-100 dark:bg-gray-700 border dark:border-gray-600 rounded flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <label for="logo"
                            class="cursor-pointer bg-theme-primary dark:bg-theme-primary-light hover:bg-theme-primary-dark dark:hover:bg-theme-primary text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Cambiar Logo
                        </label>
                        <input type="file" id="logo" name="logo" accept="image/jpeg,image/jpg,image/png"
                            class="hidden" onchange="previewLogo(this)">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">JPG, JPEG o PNG. Máx. 2MB</p>
                    </div>
                </div>
                @error('logo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Información General -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-theme-primary dark:text-theme-primary-light" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Información General
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nombre" name="nombre"
                            value="{{ old('nombre', $institucion->nombre ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('nombre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="codigo_amie" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Código AMIE <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="codigo_amie" name="codigo_amie"
                            value="{{ old('codigo_amie', $institucion->codigo_amie ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('codigo_amie')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo <span
                                class="text-red-500">*</span></label>
                        <select id="tipo" name="tipo" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                            <option value="">Seleccione...</option>
                            <option value="Fiscal"
                                {{ old('tipo', $institucion->tipo ?? '') == 'Fiscal' ? 'selected' : '' }}>Fiscal
                            </option>
                            <option value="Fiscomisional"
                                {{ old('tipo', $institucion->tipo ?? '') == 'Fiscomisional' ? 'selected' : '' }}>
                                Fiscomisional</option>
                            <option value="Municipal"
                                {{ old('tipo', $institucion->tipo ?? '') == 'Municipal' ? 'selected' : '' }}>Municipal
                            </option>
                            <option value="Particular"
                                {{ old('tipo', $institucion->tipo ?? '') == 'Particular' ? 'selected' : '' }}>
                                Particular</option>
                        </select>
                        @error('tipo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nivel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nivel <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="nivel" name="nivel"
                            value="{{ old('nivel', $institucion->nivel ?? '') }}" required
                            placeholder="Ej: EGB y BGU"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('nivel')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jornada" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jornada <span
                                class="text-red-500">*</span></label>
                        <select id="jornada" name="jornada" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                            <option value="">Seleccione...</option>
                            <option value="Matutina"
                                {{ old('jornada', $institucion->jornada ?? '') == 'Matutina' ? 'selected' : '' }}>
                                Matutina</option>
                            <option value="Vespertina"
                                {{ old('jornada', $institucion->jornada ?? '') == 'Vespertina' ? 'selected' : '' }}>
                                Vespertina</option>
                            <option value="Nocturna"
                                {{ old('jornada', $institucion->jornada ?? '') == 'Nocturna' ? 'selected' : '' }}>
                                Nocturna</option>
                            <option value="Ambas"
                                {{ old('jornada', $institucion->jornada ?? '') == 'Ambas' ? 'selected' : '' }}>Ambas
                            </option>
                        </select>
                        @error('jornada')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Ubicación -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-theme-primary dark:text-theme-primary-light" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ubicación
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="provincia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provincia <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="provincia" name="provincia"
                            value="{{ old('provincia', $institucion->provincia ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('provincia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ciudad" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ciudad <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="ciudad" name="ciudad"
                            value="{{ old('ciudad', $institucion->ciudad ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('ciudad')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="canton" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cantón</label>
                        <input type="text" id="canton" name="canton"
                            value="{{ old('canton', $institucion->canton ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('canton')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parroquia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parroquia</label>
                        <input type="text" id="parroquia" name="parroquia"
                            value="{{ old('parroquia', $institucion->parroquia ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('parroquia')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="direccion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="direccion" name="direccion"
                            value="{{ old('direccion', $institucion->direccion ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('direccion')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-theme-primary dark:text-theme-primary-light" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contacto
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                        <input type="text" id="telefono" name="telefono"
                            value="{{ old('telefono', $institucion->telefono ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('telefono')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email"
                            value="{{ old('email', $institucion->email ?? '') }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="sitio_web" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sitio Web</label>
                        <input type="url" id="sitio_web" name="sitio_web"
                            value="{{ old('sitio_web', $institucion->sitio_web ?? '') }}"
                            placeholder="https://ejemplo.edu.ec"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('sitio_web')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Autoridades -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-theme-primary dark:text-theme-primary-light" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Autoridades
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="rector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rector</label>
                        <input type="text" id="rector" name="rector"
                            value="{{ old('rector', $institucion->rector ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('rector')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vicerrector"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vicerrector</label>
                        <input type="text" id="vicerrector" name="vicerrector"
                            value="{{ old('vicerrector', $institucion->vicerrector ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('vicerrector')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="inspector" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Inspector</label>
                        <input type="text" id="inspector" name="inspector"
                            value="{{ old('inspector', $institucion->inspector ?? '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:border-theme-primary dark:focus:border-theme-primary-light focus:ring-theme-primary dark:focus:ring-theme-primary-light">
                        @error('inspector')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer del Modal -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-600 mt-4">
            <button type="button" x-data="{}" @click="$dispatch('close-modal', 'edit-institucion')"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200">
                Cancelar
            </button>
            <button type="submit"
                class="px-4 py-2 bg-theme-primary dark:bg-theme-primary-light text-white rounded-lg hover:bg-theme-primary-dark dark:hover:bg-theme-primary transition duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
    </div>

    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logoPreview');
                    preview.innerHTML = '<img src="' + e.target.result +
                        '" alt="Logo Preview" class="h-24 w-24 object-contain border rounded">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Reabrir el modal si hay errores de validación
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                // Esperar a que Alpine.js esté listo
                setTimeout(function() {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-institucion' }));
                }, 100);
            });
        @endif
    </script>
</x-modal>
