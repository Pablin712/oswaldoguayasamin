<x-app-layout>
    @canany(['gestionar calificaciones', 'ver calificaciones'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sistema de Calificaciones') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Instrucciones -->
            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Seleccione el contexto para registrar calificaciones
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>Complete los filtros en orden: Período → Quimestre → Parcial → Paralelo → Materia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros de contexto -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Selección de Contexto
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Período Lectivo -->
                        <div>
                            <label for="periodo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Período Lectivo
                            </label>
                            <select id="periodo" name="periodo_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Seleccione...</option>
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoActual && $periodo->id == $periodoActual->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quimestre -->
                        <div>
                            <label for="quimestre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Quimestre
                            </label>
                            <select id="quimestre" name="quimestre_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Seleccione...</option>
                                @foreach($quimestres as $quimestre)
                                    <option value="{{ $quimestre->id }}" {{ $quimestreActual && $quimestre->id == $quimestreActual->id ? 'selected' : '' }}>
                                        {{ $quimestre->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Parcial -->
                        <div>
                            <label for="parcial" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Parcial
                            </label>
                            <select id="parcial" name="parcial_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="">Seleccione...</option>
                                @foreach($parciales as $parcial)
                                    <option value="{{ $parcial->id }}" {{ $parcialActual && $parcial->id == $parcialActual->id ? 'selected' : '' }}>
                                        {{ $parcial->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Curso y Paralelo -->
                        <div>
                            <label for="paralelo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Curso
                            </label>
                            <select id="paralelo" name="paralelo_id" class="searchable-select w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" data-placeholder="Buscar curso...">
                                <option value="">Buscar curso...</option>
                                @foreach($cursosParalelos as $curso)
                                    <option value="{{ $curso['id'] }}">{{ $curso['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Materia -->
                        <div>
                            <label for="materia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Materia
                            </label>
                            <select id="materia" name="curso_materia_id" class="searchable-select w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" disabled data-placeholder="Buscar materia...">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón para cargar calificaciones -->
                    <div class="flex justify-center mt-6">
                        <button id="btnCargarCalificaciones" type="button"
                                class="inline-flex items-center px-8 py-4 border border-transparent rounded-lg font-semibold text-base text-white uppercase tracking-widest transition ease-in-out duration-150 shadow-lg
                                       disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-400
                                       enabled:bg-gradient-to-r enabled:from-blue-600 enabled:to-indigo-600 enabled:hover:from-blue-700 enabled:hover:to-indigo-700 enabled:focus:ring-4 enabled:focus:ring-blue-300 enabled:dark:focus:ring-blue-800"
                                disabled>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span id="btnTexto">Cargar Calificaciones</span>
                        </button>
                    </div>

                    <!-- Indicador de progreso -->
                    <div id="indicadorProgreso" class="mt-3 text-center hidden">
                        <div class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-blue-900 rounded-lg">
                            <svg class="animate-spin h-5 w-5 mr-3 text-blue-600 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-700 dark:text-blue-200">Cargando estudiantes...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de calificaciones (se carga dinámicamente) -->
            <div id="contenedorCalificaciones" class="mt-6 hidden">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                Registro de Calificaciones
                            </h3>
                            <div class="flex space-x-2">
                                <button id="btnEstadisticas" type="button" class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Estadísticas
                                </button>
                                @can('publicar calificaciones')
                                <button id="btnPublicar" type="button" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Publicar
                                </button>
                                @endcan
                            </div>
                        </div>

                        <!-- Tabla -->
                        <div class="overflow-x-auto">
                            <table id="tablaCalificaciones" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estudiante</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tareas (20%)</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lecciones (20%)</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trabajo (20%)</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Examen (40%)</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nota Final</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyCalificaciones" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Se llena dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Estadísticas -->
            <div id="modalEstadisticas" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Estadísticas del Curso</h3>
                        <button id="btnCerrarEstadisticas" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div id="contenidoEstadisticas" class="space-y-4">
                        <!-- Se llena dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let contexto = {
            periodo_id: {{ $periodoActual->id ?? 'null' }},
            quimestre_id: {{ $quimestreActual->id ?? 'null' }},
            parcial_id: {{ $parcialActual->id ?? 'null' }},
            paralelo_id: null,
            curso_materia_id: null
        };

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Select2 para searchable-selects
            if (typeof $ !== 'undefined' && $.fn.select2) {
                $('.searchable-select').each(function() {
                    $(this).select2({
                        theme: 'default',
                        width: '100%',
                        placeholder: $(this).data('placeholder') || 'Seleccione...',
                        allowClear: $(this).data('allow-clear') !== 'false'
                    });
                });

                // Reinicializar Select2 cuando cambie el valor del select de Curso
                $('#paralelo').on('select2:select', function(e) {
                    const paraleloId = e.params.data.id;
                    contexto.paralelo_id = paraleloId;

                    resetearCampo('materia');

                    if (paraleloId && contexto.parcial_id) {
                        cargarMaterias(paraleloId, contexto.parcial_id);
                    }
                });
            }

            // Si hay período actual seleccionado, verificar el contexto
            if (contexto.periodo_id && contexto.quimestre_id && contexto.parcial_id) {
                verificarContextoCompleto();
            }
        });

        // Período change
        document.getElementById('periodo').addEventListener('change', async function() {
            const periodoId = this.value;
            contexto.periodo_id = periodoId;

            // Resetear campos dependientes
            resetearCampo('quimestre');
            resetearCampo('parcial');
            resetearCampo('paralelo');
            resetearCampo('materia');

            if (periodoId) {
                await cargarQuimestres(periodoId);
                await cargarParalelos(periodoId);
            }
        });

        // Quimestre change
        document.getElementById('quimestre').addEventListener('change', async function() {
            const quimestreId = this.value;
            contexto.quimestre_id = quimestreId;

            resetearCampo('parcial');

            if (quimestreId) {
                await cargarParciales(quimestreId);
            }
        });

        // Parcial change
        document.getElementById('parcial').addEventListener('change', function() {
            contexto.parcial_id = this.value;
            verificarContextoCompleto();
        });

        // Nota: El evento de Paralelo (Curso) se maneja en la inicialización de Select2
        // y el de Materia también, para que funcione correctamente con Select2

        // Cargar calificaciones
        document.getElementById('btnCargarCalificaciones').addEventListener('click', async function() {
            await cargarEstudiantes();
        });

        // Funciones de carga
        async function cargarQuimestres(periodoId) {
            try {
                const response = await fetch(`{{ route('calificaciones.contexto') }}?tipo=quimestres&periodo_id=${periodoId}`);
                const quimestres = await response.json();

                const select = document.getElementById('quimestre');
                select.innerHTML = '<option value="">Seleccione...</option>';
                quimestres.forEach(q => {
                    select.innerHTML += `<option value="${q.id}">${q.nombre}</option>`;
                });
                select.disabled = false;
            } catch (error) {
                console.error('Error al cargar quimestres:', error);
            }
        }

        async function cargarParciales(quimestreId) {
            try {
                const response = await fetch(`{{ route('calificaciones.contexto') }}?tipo=parciales&quimestre_id=${quimestreId}`);
                const parciales = await response.json();

                const select = document.getElementById('parcial');
                select.innerHTML = '<option value="">Seleccione...</option>';
                parciales.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.nombre}</option>`;
                });
                select.disabled = false;
            } catch (error) {
                console.error('Error al cargar parciales:', error);
            }
        }

        async function cargarParalelos(periodoId) {
            try {
                const response = await fetch(`{{ route('calificaciones.contexto') }}?tipo=paralelos&periodo_id=${periodoId}`);
                const paralelos = await response.json();

                const select = document.getElementById('paralelo');
                select.innerHTML = '<option value="">Seleccione...</option>';
                paralelos.forEach(p => {
                    select.innerHTML += `<option value="${p.id}">${p.curso.nivel} - ${p.nombre}</option>`;
                });
                select.disabled = false;
            } catch (error) {
                console.error('Error al cargar paralelos:', error);
            }
        }

        async function cargarMaterias(paraleloId, parcialId) {
            try {
                const response = await fetch(`{{ route('calificaciones.contexto') }}?tipo=materias&paralelo_id=${paraleloId}&parcial_id=${parcialId}`);
                const materias = await response.json();

                const select = document.getElementById('materia');

                // Destruir Select2 si existe
                if (typeof $ !== 'undefined' && $.fn.select2 && $(select).data('select2')) {
                    $(select).select2('destroy');
                }

                // Limpiar y llenar opciones
                select.innerHTML = '<option value="">Seleccione...</option>';
                materias.forEach(m => {
                    select.innerHTML += `<option value="${m.id}">${m.materia.nombre}</option>`;
                });
                select.disabled = false;

                // Reinicializar Select2
                if (typeof $ !== 'undefined' && $.fn.select2) {
                    $(select).select2({
                        theme: 'default',
                        width: '100%',
                        placeholder: $(select).data('placeholder') || 'Buscar materia...',
                        allowClear: $(select).data('allow-clear') !== 'false'
                    });

                    // Agregar evento de selección
                    $(select).on('select2:select', function(e) {
                        contexto.curso_materia_id = e.params.data.id;
                        console.log('Materia seleccionada, contexto completo:', contexto);
                        verificarContextoCompleto();
                    });
                }
            } catch (error) {
                console.error('Error al cargar materias:', error);
            }
        }

        async function cargarEstudiantes() {
            const indicador = document.getElementById('indicadorProgreso');
            const boton = document.getElementById('btnCargarCalificaciones');
            const btnTexto = document.getElementById('btnTexto');

            try {
                // Mostrar indicador y deshabilitar botón
                indicador.classList.remove('hidden');
                boton.disabled = true;
                btnTexto.textContent = 'Cargando...';

                const response = await fetch(`{{ route('calificaciones.estudiantes') }}?paralelo_id=${contexto.paralelo_id}&curso_materia_id=${contexto.curso_materia_id}&parcial_id=${contexto.parcial_id}`);
                const estudiantes = await response.json();

                const tbody = document.getElementById('bodyCalificaciones');
                tbody.innerHTML = '';

                estudiantes.forEach(est => {
                    tbody.innerHTML += crearFilaEstudiante(est);
                });

                document.getElementById('contenedorCalificaciones').classList.remove('hidden');

                // Scroll suave a la tabla
                setTimeout(() => {
                    document.getElementById('contenedorCalificaciones').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);

            } catch (error) {
                console.error('Error al cargar estudiantes:', error);
                alert('Error al cargar los estudiantes. Por favor, intente nuevamente.');
            } finally {
                // Ocultar indicador y restaurar botón
                indicador.classList.add('hidden');
                btnTexto.textContent = 'Cargar Calificaciones';
                verificarContextoCompleto();
            }
        }

        function crearFilaEstudiante(estudiante) {
            const color = getColorNota(estudiante.nota_final);
            return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-3 py-4 text-sm text-gray-900 dark:text-gray-100">${estudiante.estudiante_nombre}</td>
                    <td class="px-3 py-4 text-center">-</td>
                    <td class="px-3 py-4 text-center">-</td>
                    <td class="px-3 py-4 text-center">-</td>
                    <td class="px-3 py-4 text-center">-</td>
                    <td class="px-3 py-4 text-center">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${color}">
                            ${estudiante.nota_final ? estudiante.nota_final.toFixed(2) : '-'}
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <span class="px-2 py-1 text-xs rounded-full ${getColorEstado(estudiante.estado)}">
                            ${estudiante.estado}
                        </span>
                    </td>
                    <td class="px-3 py-4 text-center">
                        <button class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                            Ver Detalles
                        </button>
                    </td>
                </tr>
            `;
        }

        function getColorNota(nota) {
            if (!nota) return 'bg-gray-200 text-gray-800';
            if (nota >= 7) return 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
            if (nota >= 5) return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
            return 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
        }

        function getColorEstado(estado) {
            switch(estado) {
                case 'publicada': return 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                case 'modificada': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                case 'pendiente': return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        function resetearCampo(campo) {
            const select = document.getElementById(campo);
            select.innerHTML = '<option value="">Seleccione...</option>';
            select.disabled = true;
        }

        function verificarContextoCompleto() {
            const completo = contexto.periodo_id && contexto.quimestre_id && contexto.parcial_id && contexto.paralelo_id && contexto.curso_materia_id;
            console.log('Verificando contexto:', contexto, 'Completo:', completo);
            document.getElementById('btnCargarCalificaciones').disabled = !completo;
        }

        // Estadísticas
        document.getElementById('btnEstadisticas').addEventListener('click', async function() {
            try {
                const response = await fetch(`{{ route('calificaciones.estadisticas') }}?curso_materia_id=${contexto.curso_materia_id}&parcial_id=${contexto.parcial_id}`);
                const stats = await response.json();

                document.getElementById('contenidoEstadisticas').innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                            <p class="text-sm text-blue-600 dark:text-blue-300">Total Estudiantes</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">${stats.total}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <p class="text-sm text-green-600 dark:text-green-300">Promedio</p>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">${stats.promedio}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg">
                            <p class="text-sm text-green-600 dark:text-green-300">Aprobados</p>
                            <p class="text-2xl font-bold text-green-900 dark:text-green-100">${stats.aprobados}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                            <p class="text-sm text-yellow-600 dark:text-yellow-300">En Riesgo</p>
                            <p class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">${stats.enRiesgo}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                            <p class="text-sm text-red-600 dark:text-red-300">Reprobados</p>
                            <p class="text-2xl font-bold text-red-900 dark:text-red-100">${stats.reprobados}</p>
                        </div>
                    </div>
                `;

                document.getElementById('modalEstadisticas').classList.remove('hidden');
            } catch (error) {
                console.error('Error al cargar estadísticas:', error);
            }
        });

        document.getElementById('btnCerrarEstadisticas').addEventListener('click', function() {
            document.getElementById('modalEstadisticas').classList.add('hidden');
        });
    </script>
    @endpush
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    No tienes permisos para acceder a esta sección.
                </div>
            </div>
        </div>
    </div>
    @endcanany
</x-app-layout>
