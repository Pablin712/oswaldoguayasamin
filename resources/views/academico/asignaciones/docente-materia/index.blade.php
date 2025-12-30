<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📚 {{ __('Asignación Docente-Materia') }}
            </h2>
            @can('crear asignaciones docentes')
            <button @click="$dispatch('open-assign-modal')"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Nueva Asignación') }}
            </button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12" x-data="docenteMateriaManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('docente-materia.index') }}" class="flex flex-wrap items-end gap-4"
                          x-data="filtrosParalelo()">
                        {{-- Período Académico --}}
                        <div class="flex-1 min-w-[200px]">
                            <label for="periodo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Período Académico
                            </label>
                            <x-searchable-select
                                id="periodo_id"
                                name="periodo_id"
                                :options="$periodos"
                                :selected="$periodoId"
                                placeholder="Seleccione período"
                                label-field="nombre"
                                value-field="id"
                                :allow-clear="false"
                            />
                        </div>

                        {{-- Curso --}}
                        <div class="flex-1 min-w-[200px]">
                            <label for="curso_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Curso
                            </label>
                            <x-searchable-select
                                id="curso_id"
                                name="curso_id"
                                :options="$cursos"
                                :selected="$cursoId"
                                placeholder="Todos los cursos"
                                label-field="nombre"
                                value-field="id"
                                x-on:change="filtrarParalelos($event.target.value)"
                            />
                        </div>

                        {{-- Paralelo --}}
                        <div class="flex-1 min-w-[200px]">
                            <label for="paralelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Paralelo
                            </label>
                            <select
                                id="paralelo_id"
                                name="paralelo_id"
                                class="searchable-select block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                data-placeholder="Todos los paralelos"
                                data-allow-clear="true"
                            >
                                <option value="">Todos los paralelos</option>
                                <template x-for="paralelo in paralelosFiltrados" :key="paralelo.id">
                                    <option :value="paralelo.id"
                                            :selected="paralelo.id == {{ $paraleloId ?? 'null' }}"
                                            x-text="paralelo.nombre_completo">
                                    </option>
                                </template>
                            </select>
                        </div>

                        {{-- Botón Buscar --}}
                        <div>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Buscar
                            </button>
                        </div>

                        {{-- Botón Limpiar --}}
                        <div>
                            <a href="{{ route('docente-materia.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition">
                                Limpiar Filtros
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lista de Materias con Asignaciones --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($materias->isEmpty())
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="mt-2">No hay asignaciones docentes para mostrar</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($materias as $materia)
                                <div class="border rounded-lg p-4 hover:shadow-md transition">
                                    {{-- Encabezado Materia --}}
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $materia->nombre }}</h3>
                                            <p class="text-sm text-gray-500">{{ $materia->area->nombre }} • Código: {{ $materia->codigo }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full"
                                              style="background-color: {{ $materia->color }}20; color: {{ $materia->color }};">
                                            {{ $materia->docenteMaterias->count() }} asignación(es)
                                        </span>
                                    </div>

                                    {{-- Asignaciones --}}
                                    <div class="space-y-3">
                                        @foreach($materia->docenteMaterias as $asignacion)
                                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                <div class="flex justify-between items-start">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                </svg>
                                                                <span class="font-medium text-gray-900">{{ $asignacion->docente->user->name }}</span>
                                                            </div>
                                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                                                {{ $asignacion->rol }}
                                                            </span>
                                                        </div>
                                                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                            </svg>
                                                            <span>{{ $asignacion->paralelo->nombre_completo }}</span>
                                                            @if($asignacion->paralelo->aula)
                                                                <span class="text-gray-400">•</span>
                                                                <span>Aula: {{ $asignacion->paralelo->aula->nombre }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- Horarios --}}
                                                        @if($asignacion->horarios->isNotEmpty())
                                                            <div class="flex flex-wrap gap-2">
                                                                @foreach($asignacion->horarios as $horario)
                                                                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-white rounded-md border border-gray-300 text-xs">
                                                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        <span class="font-medium">{{ $horario->dia_semana }}</span>
                                                                        <span class="text-gray-600">{{ substr($horario->hora_inicio, 0, 5) }} - {{ substr($horario->hora_fin, 0, 5) }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <p class="text-sm text-amber-600">⚠️ Sin horarios asignados</p>
                                                        @endif
                                                    </div>

                                                    {{-- Botón Eliminar --}}
                                                    @can('eliminar asignaciones docentes')
                                                    <button @click="confirmDelete({{ $asignacion->id }}, '{{ $asignacion->docente->user->name }}', '{{ $materia->nombre }}', '{{ $asignacion->paralelo->nombre_completo }}')"
                                                            class="ml-4 text-red-600 hover:text-red-800 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                    @endcan
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Modal de Asignación --}}
        @include('academico.asignaciones.docente-materia.partials.assign-modal')

        {{-- Modal de Confirmación de Eliminación --}}
        @include('academico.asignaciones.docente-materia.partials.delete-modal')
    </div>

    @push('scripts')
    <script>
        // Función para manejar el filtrado de paralelos según el curso
        function filtrosParalelo() {
            return {
                todosParalelos: @json($todosParalelosFiltro),
                paralelosFiltrados: @json($todosParalelosFiltro),

                init() {
                    // Si ya hay un curso seleccionado, filtrar los paralelos
                    const cursoId = '{{ $cursoId }}';
                    if (cursoId) {
                        this.filtrarParalelos(cursoId);
                    }
                },

                filtrarParalelos(cursoId) {
                    if (cursoId && cursoId !== '') {
                        this.paralelosFiltrados = this.todosParalelos.filter(p => p.curso_id == cursoId);
                    } else {
                        this.paralelosFiltrados = this.todosParalelos;
                    }

                    // Reinicializar el select después del filtrado
                    this.$nextTick(() => {
                        if (typeof $('#paralelo_id').select2 !== 'undefined') {
                            $('#paralelo_id').select2('destroy');
                            $('#paralelo_id').select2({
                                placeholder: 'Todos los paralelos',
                                allowClear: true
                            });
                        }
                    });
                }
            }
        }

        function docenteMateriaManager() {
            return {
                // Estado del modal de asignación
                showAssignModal: false,
                currentStep: 1,
                validationErrors: [],

                // Datos del formulario
                form: {
                    docente_id: '',
                    materia_id: '',
                    paralelo_id: '',
                    periodo_academico_id: '{{ $periodoActual?->id }}',
                    rol: 'Principal',
                    horarios: []
                },

                // Estado de eliminación
                deleteId: null,
                deleteInfo: {},
                showDeleteModal: false,

                // Disponibilidad del docente
                disponibilidad: null,

                // Horarios ocupados del paralelo
                horariosOcupados: [],

                init() {
                    window.addEventListener('open-assign-modal', () => {
                        this.openAssignModal();
                    });
                },

                openAssignModal() {
                    this.resetForm();
                    this.validationErrors = [];
                    this.showAssignModal = true;
                },

                closeAssignModal() {
                    this.showAssignModal = false;
                    this.currentStep = 1;
                    this.validationErrors = [];
                },

                resetForm() {
                    this.form = {
                        docente_id: '',
                        materia_id: '',
                        paralelo_id: '',
                        periodo_academico_id: '{{ $periodoActual?->id }}',
                        rol: 'Principal',
                        horarios: []
                    };
                    this.disponibilidad = null;
                    this.horariosOcupados = [];
                },

                async nextStep() {
                    if (this.currentStep === 1) {
                        if (!this.form.docente_id || !this.form.materia_id || !this.form.paralelo_id) {
                            this.showNotification('Por favor complete todos los campos requeridos', 'error');
                            return;
                        }

                        // Cargar disponibilidad del docente
                        await this.loadDisponibilidad();
                        // Cargar horarios ocupados del paralelo
                        await this.loadHorariosOcupados();

                        this.currentStep = 2;
                    }
                },

                prevStep() {
                    if (this.currentStep === 2) {
                        this.currentStep = 1;
                    }
                },

                async loadDisponibilidad() {
                    try {
                        const response = await fetch(`/docente-materia/disponibilidad?docente_id=${this.form.docente_id}&periodo_academico_id=${this.form.periodo_academico_id}`);
                        const data = await response.json();
                        this.disponibilidad = data;
                    } catch (error) {
                        console.error('Error al cargar disponibilidad:', error);
                    }
                },

                async loadHorariosOcupados() {
                    try {
                        const response = await fetch(`/docente-materia/horarios-ocupados?paralelo_id=${this.form.paralelo_id}&periodo_academico_id=${this.form.periodo_academico_id}`);
                        const data = await response.json();
                        this.horariosOcupados = data.horarios || [];
                    } catch (error) {
                        console.error('Error al cargar horarios ocupados:', error);
                    }
                },

                addHorario() {
                    this.form.horarios.push({
                        dia_semana: 'Lunes',
                        hora_inicio: '08:00',
                        hora_fin: '08:40'
                    });
                },

                removeHorario(index) {
                    this.form.horarios.splice(index, 1);
                },

                async submitForm() {
                    if (this.form.horarios.length === 0) {
                        this.validationErrors = ['Debe agregar al menos un horario'];
                        return;
                    }

                    this.validationErrors = [];

                    try {
                        const response = await fetch('{{ route("docente-materia.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.showNotification(data.message, 'success');
                            this.closeAssignModal();
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            // Capturar errores de validación y mostrarlos en el modal
                            if (data.errors) {
                                this.validationErrors = [];
                                Object.values(data.errors).forEach(errors => {
                                    errors.forEach(error => this.validationErrors.push(error));
                                });
                            } else {
                                this.validationErrors = [data.message || 'Error al crear la asignación'];
                            }
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.validationErrors = ['Error de conexión con el servidor'];
                    }
                },

                confirmDelete(id, docente, materia, paralelo) {
                    this.deleteId = id;
                    this.deleteInfo = { docente, materia, paralelo };
                    this.showDeleteModal = true;
                },

                async deleteAsignacion() {
                    try {
                        const response = await fetch(`/docente-materia/${this.deleteId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            this.showNotification(data.message, 'success');
                            this.showDeleteModal = false;
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            this.showNotification(data.message || 'Error al eliminar', 'error');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showNotification('Error de conexión', 'error');
                    }
                },

                showNotification(message, type = 'info') {
                    // Implementar sistema de notificaciones (puedes usar toast, alert, etc.)
                    if (type === 'error') {
                        alert('❌ ' + message);
                    } else {
                        alert('✅ ' + message);
                    }
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
