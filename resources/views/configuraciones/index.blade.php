<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Configuración del Sistema') }}
        </h2>
    </x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    <!-- Mensajes de éxito/error -->
    @if (session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 dark:border-green-600 p-4 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 dark:text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-green-700 dark:text-green-300 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 dark:border-red-600 p-4 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 dark:text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Errores de validación -->
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 dark:border-red-600 p-4 rounded">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-400 dark:text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-300 mb-2">Hay errores en el formulario:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if ($configuracion)
        <form action="{{ route('configuraciones.update') }}" method="POST" id="configuracionForm">
            @csrf
            @method('PUT')

            <!-- Pestañas -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 mb-6">
                <!-- Tabs Header -->
                <div class="flex border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
                    <button type="button" onclick="switchTab('academico')" data-tab="academico"
                        class="tab-button flex-1 py-4 px-6 text-center font-medium transition-colors duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-tl-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Académico
                        </span>
                    </button>
                    <button type="button" onclick="switchTab('calificaciones')" data-tab="calificaciones"
                        class="tab-button flex-1 py-4 px-6 text-center font-medium transition-colors duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Calificaciones
                        </span>
                    </button>
                    <button type="button" onclick="switchTab('horarios')" data-tab="horarios"
                        class="tab-button flex-1 py-4 px-6 text-center font-medium transition-colors duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Horarios
                        </span>
                    </button>
                    <button type="button" onclick="switchTab('correo')" data-tab="correo"
                        class="tab-button flex-1 py-4 px-6 text-center font-medium transition-colors duration-200 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-tr-lg">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Correo
                        </span>
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-6">
                    @include('configuraciones.tabs.academico')
                    @include('configuraciones.tabs.calificaciones')
                    @include('configuraciones.tabs.horarios')
                    @include('configuraciones.tabs.correo')
                </div>

                <!-- Footer con botón Guardar -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-6 flex justify-end">
                    @canany(['editar configuraciones', 'gestionar configuraciones'])
                        <button type="submit"
                            class="px-6 py-3 bg-theme-primary dark:bg-theme-primary-light text-white rounded-lg hover:bg-theme-primary-dark dark:hover:bg-theme-primary transition duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Guardar Cambios
                        </button>
                    @endcanany
                </div>
            </div>
        </form>
    @else
        <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 dark:border-yellow-600 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                        No se han configurado las opciones del sistema.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function switchTab(tabName) {
    // Ocultar todos los tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });

    // Mostrar el tab seleccionado
    document.getElementById('tab-' + tabName).classList.remove('hidden');

    // Actualizar estilos de los botones
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-theme-primary', 'dark:bg-theme-primary-light', 'text-white', 'text-gray-900');
        button.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');
    });

    // Activar el botón seleccionado
    const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
    activeButton.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-600');
    activeButton.classList.add('bg-theme-primary', 'dark:bg-theme-primary-light', 'text-white');
}

// Activar el primer tab al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    switchTab('academico');
});

// Validación de ponderaciones
document.getElementById('configuracionForm')?.addEventListener('submit', function(e) {
    const ponderacionExamen = parseFloat(document.getElementById('ponderacion_examen')?.value || 0);
    const ponderacionParciales = parseFloat(document.getElementById('ponderacion_parciales')?.value || 0);
    const suma = ponderacionExamen + ponderacionParciales;

    // Log para depuración
    console.log('Enviando formulario de configuraciones');
    console.log('Ponderación Examen:', ponderacionExamen);
    console.log('Ponderación Parciales:', ponderacionParciales);
    console.log('Suma:', suma);

    if (suma !== 100 && (ponderacionExamen > 0 || ponderacionParciales > 0)) {
        e.preventDefault();
        alert('La suma de las ponderaciones debe ser 100%. Actualmente es: ' + suma + '%');
        switchTab('calificaciones');
        return false;
    }
});
</script>
</x-app-layout>
