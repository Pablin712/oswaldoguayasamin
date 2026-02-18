<x-app-layout>
    @canany(['gestionar asistencias', 'registrar asistencias'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Registro Masivo de Asistencia') }}
            </h2>
            <a href="{{ route('asistencias.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="py-12" x-data="registroMasivo()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtros -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Seleccionar Paralelo y Fecha</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Curso y Paralelo <span class="text-red-500">*</span>
                            </label>
                            <x-searchable-select
                                id="paralelo_id"
                                name="paralelo_id"
                                :options="$paralelos"
                                valueField="id"
                                labelField="nombre_completo"
                                placeholder="Seleccione un curso y paralelo"
                                required
                                x-model="form.paralelo_id"
                                @change="cargarEstudiantes()"
                            />
                        </div>

                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Fecha <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="fecha" name="fecha"
                                x-model="form.fecha"
                                @change="cargarEstudiantes()"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                max="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label for="materia_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Materia
                            </label>
                            <x-searchable-select
                                id="materia_id"
                                name="materia_id"
                                :options="$materias"
                                valueField="id"
                                labelField="nombre"
                                placeholder="Seleccione una materia (opcional)"
                                x-model="form.materia_id"
                                @change="cargarEstudiantes()"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Estudiantes -->
            <div x-show="estudiantes.length > 0" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Estudiantes del Paralelo</h3>
                        <div class="flex gap-2">
                            <button type="button" @click="marcarTodos('presente')" class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-md hover:bg-green-700 transition">
                                Marcar Todos Presente
                            </button>
                            <button type="button" @click="marcarTodos('ausente')" class="px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-700 transition">
                                Marcar Todos Ausente
                            </button>
                        </div>
                    </div>

                    <form @submit.prevent="guardarAsistencias()">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Estudiante
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Estado
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Observaciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-for="(estudiante, index) in estudiantes" :key="estudiante.id">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" x-text="index + 1"></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" x-text="estudiante.nombre"></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <select x-model="estudiante.estado" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                                                    <option value="presente">Presente</option>
                                                    <option value="ausente">Ausente</option>
                                                    <option value="atrasado">Atrasado</option>
                                                    <option value="justificado">Justificado</option>
                                                </select>
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" x-model="estudiante.observaciones" placeholder="Observaciones opcionales" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('asistencias.index') }}" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Cancelar
                            </a>
                            <button type="submit" :disabled="loading" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition disabled:opacity-50">
                                <span x-show="!loading">Guardar Asistencias</span>
                                <span x-show="loading">Guardando...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mensaje cuando no hay estudiantes -->
            <div x-show="estudiantes.length === 0 && !loading" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <p>Seleccione un paralelo y una fecha para cargar los estudiantes</p>
                </div>
            </div>

            <!-- Loading -->
            <div x-show="loading" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Cargando estudiantes...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function registroMasivo() {
            return {
                form: {
                    paralelo_id: '',
                    fecha: '{{ now()->format("Y-m-d") }}',
                    materia_id: ''
                },
                estudiantes: [],
                loading: false,

                async cargarEstudiantes() {
                    if (!this.form.paralelo_id || !this.form.fecha) {
                        this.estudiantes = [];
                        return;
                    }

                    this.loading = true;
                    try {
                        const params = new URLSearchParams({
                            paralelo_id: this.form.paralelo_id,
                            fecha: this.form.fecha
                        });

                        if (this.form.materia_id) {
                            params.append('materia_id', this.form.materia_id);
                        }

                        const response = await fetch(`/asistencias/cargar-estudiantes?${params.toString()}`);
                        const data = await response.json();

                        this.estudiantes = data.map(estudiante => ({
                            id: estudiante.id,
                            nombre: estudiante.nombre,
                            estado: estudiante.asistencia?.estado || 'presente',
                            observaciones: estudiante.asistencia?.observaciones || ''
                        }));
                    } catch (error) {
                        console.error('Error al cargar estudiantes:', error);
                        alert('Error al cargar estudiantes');
                    } finally {
                        this.loading = false;
                    }
                },

                marcarTodos(estado) {
                    this.estudiantes.forEach(estudiante => {
                        estudiante.estado = estado;
                    });
                },

                async guardarAsistencias() {
                    if (!this.form.paralelo_id || !this.form.fecha) {
                        alert('Debe seleccionar un paralelo y una fecha');
                        return;
                    }

                    if (this.estudiantes.length === 0) {
                        alert('No hay estudiantes para registrar');
                        return;
                    }

                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("asistencias.registro-masivo") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                paralelo_id: this.form.paralelo_id,
                                fecha: this.form.fecha,
                                materia_id: this.form.materia_id || null,
                                asistencias: this.estudiantes.map(e => ({
                                    estudiante_id: e.id,
                                    estado: e.estado,
                                    observaciones: e.observaciones || null
                                }))
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert('Asistencias registradas exitosamente');
                            window.location.href = '{{ route("asistencias.index") }}';
                        } else {
                            alert(result.message || 'Error al guardar asistencias');
                        }
                    } catch (error) {
                        console.error('Error al guardar asistencias:', error);
                        alert('Error al guardar asistencias');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
    @endcanany
</x-app-layout>
