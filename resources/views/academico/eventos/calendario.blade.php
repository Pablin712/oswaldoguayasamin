<x-app-layout>
    @canany(['gestionar eventos', 'ver calendario eventos'])
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Calendario de Eventos') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('eventos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Vista de Lista
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-session-messages />

            <!-- Leyenda de colores -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tipos de Eventos</h3>
                    <div class="flex flex-wrap gap-4">
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-red-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Exámenes</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-blue-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Reuniones</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-green-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Actividades</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-purple-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Feriados</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-orange-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ceremonias</span>
                        </div>
                        <div class="flex items-center">
                            <span class="inline-block w-4 h-4 rounded-full bg-gray-600 mr-2"></span>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Otros</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p>{{ __('No tiene permisos para acceder a esta sección.') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endcanany

    @push('scripts')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                firstDay: 1,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    const url = '{{ route('eventos.calendario.datos') }}?' + new URLSearchParams({
                        fecha_inicio: fetchInfo.startStr,
                        fecha_fin: fetchInfo.endStr
                    });

                    console.log('Solicitando eventos:', {
                        url: url,
                        fecha_inicio: fetchInfo.startStr,
                        fecha_fin: fetchInfo.endStr
                    });

                    fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la respuesta: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Eventos recibidos:', data.length, 'eventos');
                        console.log('Primeros 3 eventos:', data.slice(0, 3));
                        successCallback(data);
                    })
                    .catch(error => {
                        console.error('Error al cargar eventos:', error);
                        failureCallback(error);
                    });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                },
                eventDidMount: function(info) {
                    // Tooltip con información del evento
                    info.el.title = info.event.title + (info.event.extendedProps.ubicacion ? '\n' + info.event.extendedProps.ubicacion : '');
                },
                height: 'auto',
                contentHeight: 600,
                aspectRatio: 1.8,
                // Estilos para dark mode
                themeSystem: document.documentElement.classList.contains('dark') ? 'bootstrap5' : 'standard'
            });
            calendar.render();

            // Actualizar calendario cuando cambia el tema
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'class') {
                        calendar.destroy();
                        calendarEl.innerHTML = '';
                        calendar = new FullCalendar.Calendar(calendarEl, {
                            ...calendar.currentData.calendarOptions,
                            themeSystem: document.documentElement.classList.contains('dark') ? 'bootstrap5' : 'standard'
                        });
                        calendar.render();
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        });
    </script>
    @endpush
</x-app-layout>
