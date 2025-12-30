<aside x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null,
    dropdowns: {
        configuracion: {{ request()->routeIs(['instituciones.*', 'configuraciones.*']) ? 'true' : 'false' }},
        estructuraAcademica: {{ request()->routeIs(['periodos-academicos.*', 'quimestres.*', 'parciales.*', 'cursos.*', 'materias.*', 'areas.*', 'aulas.*']) ? 'true' : 'false' }},
        administracion: {{ request()->routeIs(['users.*', 'roles.*', 'permissions.*']) ? 'true' : 'false' }},
        usuariosEspecializados: {{ request()->routeIs(['docentes.*', 'estudiantes.*', 'padres.*']) ? 'true' : 'false' }},
        asignaciones: {{ request()->routeIs(['paralelos.*', 'curso-materia.*', 'docente-materia.*', 'matriculas.*']) ? 'true' : 'false' }},
        calificaciones: {{ request()->routeIs(['calificaciones.*', 'componentes.*']) ? 'true' : 'false' }},
        asistencia: {{ request()->routeIs(['asistencias.*', 'justificaciones.*']) ? 'true' : 'false' }},
        tareas: {{ request()->routeIs(['tareas.*', 'entregas.*']) ? 'true' : 'false' }},
        comunicacion: {{ request()->routeIs(['mensajes.*', 'notificaciones.*']) ? 'true' : 'false' }},
        eventos: {{ request()->routeIs(['eventos.*', 'confirmaciones.*']) ? 'true' : 'false' }},
        horarios: {{ request()->routeIs('horarios.*') ? 'true' : 'false' }},
        auditoria: {{ request()->routeIs('auditoria.*') ? 'true' : 'false' }}
    },
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
        $dispatch('sidebar-toggle', { open: this.sidebarOpen });
    },
    toggleDropdown(name) {
        if (!this.sidebarOpen) {
            this.sidebarOpen = true;
            localStorage.setItem('sidebarOpen', true);
        }
        this.dropdowns[name] = !this.dropdowns[name];
    }
}"
:class="sidebarOpen ? 'w-64' : 'w-20'"
class="fixed left-0 top-0 h-screen bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-all duration-300 z-40 flex flex-col">

    <!-- Logo y Toggle Button -->
    <div class="h-16 flex items-center justify-between px-4 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" :class="!sidebarOpen && 'justify-center w-full'">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-900 dark:text-gray-200" />
            <span x-show="sidebarOpen" class="text-lg font-bold text-gray-900 dark:text-white truncate">UEOG</span>
        </a>
        <button @click="toggleSidebar()"
                x-show="sidebarOpen"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
            </svg>
        </button>
    </div>

    <!-- Expand Button (cuando está colapsado) -->
    <div x-show="!sidebarOpen" class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
        <button @click="toggleSidebar()"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation Items -->
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="space-y-1 px-3">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
            </a>

            <!-- Configuración Dropdown -->
            @canany(['gestionar institución', 'ver institución', 'gestionar configuraciones', 'ver configuraciones'])
            <div class="space-y-1">
                <button @click="toggleDropdown('configuracion')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Configuración</span>
                    </div>
                    <svg x-show="sidebarOpen"
                         :class="dropdowns.configuracion ? 'rotate-180' : ''"
                         class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="dropdowns.configuracion && sidebarOpen"
                     x-collapse
                     class="ml-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-700">
                    @canany(['gestionar institución', 'ver institución'])
                        <!-- Institución -->
                        <a href="{{ route('instituciones.show') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('instituciones.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-sm">Institución</span>
                        </a>
                    @endcanany

                    @canany(['gestionar configuraciones', 'ver configuraciones'])
                        <!-- Configuraciones -->
                        <a href="{{ route('configuraciones.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('configuraciones.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm">Parámetros</span>
                        </a>
                    @endcanany
                </div>
            </div>
            @endcanany

            <!-- Estructura Académica Dropdown -->
            @canany(['gestionar periodos académicos', 'ver periodos académicos', 'gestionar quimestres', 'ver quimestres', 'gestionar parciales', 'ver parciales', 'gestionar cursos', 'ver cursos', 'gestionar materias', 'ver materias', 'gestionar areas', 'ver areas', 'gestionar aulas', 'ver aulas'])
            <div class="space-y-1">
                <button @click="toggleDropdown('estructuraAcademica')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Estructura</span>
                    </div>
                    <svg x-show="sidebarOpen"
                         :class="dropdowns.estructuraAcademica ? 'rotate-180' : ''"
                         class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="dropdowns.estructuraAcademica && sidebarOpen"
                     x-collapse
                     class="ml-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-700">
                    @canany(['gestionar periodos académicos', 'ver periodos académicos'])
                        <!-- Periodos Académicos -->
                        <a href="{{ route('periodos-academicos.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('periodos-academicos.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">Periodos Académicos</span>
                        </a>
                    @endcanany

                    @canany(['gestionar quimestres', 'ver quimestres'])
                        <!-- Quimestres -->
                        <a href="{{ route('quimestres.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('quimestres.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm">Quimestres</span>
                        </a>
                    @endcanany

                    @canany(['gestionar parciales', 'ver parciales'])
                        <!-- Parciales -->
                        <a href="{{ route('parciales.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('parciales.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <span class="text-sm">Parciales</span>
                        </a>
                    @endcanany

                    @canany(['gestionar cursos', 'ver cursos'])
                        <!-- Cursos -->
                        <a href="{{ route('cursos.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('cursos.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Cursos</span>
                        </a>
                    @endcanany

                    @canany(['gestionar materias', 'ver materias'])
                        <!-- Materias -->
                        <a href="{{ route('materias.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('materias.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                            <span class="text-sm">Materias</span>
                        </a>
                    @endcanany

                    @canany(['gestionar areas', 'ver areas'])
                        <!-- Áreas -->
                        <a href="{{ route('areas.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('areas.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm">Áreas</span>
                        </a>
                    @endcanany

                    @canany(['gestionar aulas', 'ver aulas'])
                        <!-- Aulas -->
                        <a href="{{ route('aulas.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('aulas.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-sm">Aulas</span>
                        </a>
                    @endcanany
                </div>
            </div>
            @endcanany

            <!-- Usuarios Especializados Dropdown -->
            @canany(['gestionar docentes', 'ver docentes', 'gestionar estudiantes', 'ver estudiantes', 'gestionar padres', 'ver padres'])
            <div class="space-y-1">
                <button @click="toggleDropdown('usuariosEspecializados')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Usuarios</span>
                    </div>
                    <svg x-show="sidebarOpen"
                         :class="dropdowns.usuariosEspecializados ? 'rotate-180' : ''"
                         class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="dropdowns.usuariosEspecializados && sidebarOpen"
                     x-collapse
                     class="ml-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-700">
                    @canany(['gestionar docentes', 'ver docentes'])
                        <!-- Docentes -->
                        <a href="{{ route('docentes.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('docentes.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm">Docentes</span>
                        </a>
                    @endcanany

                    @canany(['gestionar estudiantes', 'ver estudiantes'])
                        <!-- Estudiantes -->
                        <a href="{{ route('estudiantes.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('estudiantes.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Estudiantes</span>
                        </a>
                    @endcanany

                    @canany(['gestionar padres', 'ver padres'])
                        <!-- Padres/Representantes -->
                        <a href="{{ route('padres.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('padres.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-sm">Padres/Representantes</span>
                        </a>
                    @endcanany
                </div>
            </div>
            @endcanany

            <!-- Asignaciones Académicas Dropdown -->
            @canany(['gestionar paralelos', 'ver paralelos', 'gestionar asignaciones', 'ver asignaciones'])
            <div class="space-y-1">
                <button @click="toggleDropdown('asignaciones')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Asignaciones</span>
                    </div>
                    <svg x-show="sidebarOpen"
                         :class="dropdowns.asignaciones ? 'rotate-180' : ''"
                         class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="dropdowns.asignaciones && sidebarOpen"
                     x-collapse
                     class="ml-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-700">
                    @canany(['gestionar paralelos', 'ver paralelos'])
                        <!-- Paralelos -->
                        <a href="{{ route('paralelos.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('paralelos.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <span class="text-sm">Paralelos</span>
                        </a>
                    @endcanany

                    @canany(['gestionar asignaciones', 'ver asignaciones'])
                        <!-- Curso-Materia -->
                        <a href="{{ route('curso-materia.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('curso-materia.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-sm">Curso-Materia</span>
                        </a>
                    @endcanany

                    @canany(['gestionar asignaciones docentes', 'ver asignaciones docentes'])
                        <!-- Docente-Materia -->
                        <a href="{{ route('docente-materia.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('docente-materia.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm">Docente-Materia</span>
                        </a>
                    @endcanany
                </div>
            </div>
            @endcanany

            <!-- Administración Dropdown -->
            <div class="space-y-1">
                <button @click="toggleDropdown('administracion')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="font-medium">Administración</span>
                    </div>
                    <svg x-show="sidebarOpen"
                         :class="dropdowns.administracion ? 'rotate-180' : ''"
                         class="w-4 h-4 flex-shrink-0 transition-transform duration-200"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Submenu Items -->
                <div x-show="dropdowns.administracion && sidebarOpen"
                     x-collapse
                     class="ml-3 space-y-1 border-l-2 border-gray-200 dark:border-gray-700">
                    @canany(['gestionar usuarios', 'ver usuarios'])
                        <!-- Usuarios -->
                        <a href="{{ route('users.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm">Usuarios</span>
                        </a>
                    @endcanany

                    @canany(['gestionar roles y permisos', 'ver roles y permisos'])
                        <!-- Roles -->
                        <a href="{{ route('roles.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('roles.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <span class="text-sm">Roles</span>
                        </a>
                        <a href="{{ route('permissions.index') }}"
                        class="flex items-center gap-3 pl-6 pr-3 py-2 rounded-lg transition-colors {{ request()->routeIs('permissions.*') ? 'bg-theme-primary dark:bg-theme-third text-white shadow-md font-semibold' : 'text-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-gray-300' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-sm">Permisos</span>
                        </a>
                    @endcanany

                    <!-- Ya no necesitamos este enlace individual de Configuración -->
                </div>
            </div>
        </div>
    </nav>

    <!-- User Info Section (parte inferior) -->
    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center gap-3" :class="!sidebarOpen && 'justify-center'">
            @if(Auth::user()->foto)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                     alt="{{ Auth::user()->name }}"
                     class="w-10 h-10 rounded-full object-cover flex-shrink-0 shadow-md ring-2 ring-white dark:ring-gray-800">
            @else
                <div class="w-10 h-10 rounded-full bg-theme-primary dark:bg-gradient-to-br dark:from-theme-secondary dark:to-theme-third text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-md ring-2 ring-white dark:ring-gray-800">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            @endif
            <div x-show="sidebarOpen" class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                {{-- roles con spatie --}}
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->roles()->pluck('name')->join(', ') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
