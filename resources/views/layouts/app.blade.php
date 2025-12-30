<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Favicon usando el componente logo --}}
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Select2 Dark Mode -->
        <link href="{{ asset('css/select2-dark-mode.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <x-color-sistema />

        <!-- Estilos adicionales por página -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-theme-five dark:bg-gray-900"
             x-data="{
                 sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null,
                 init() {
                     this.$watch('sidebarOpen', value => {
                         localStorage.setItem('sidebarOpen', value);
                     });
                 }
             }"
             @sidebar-toggle.window="sidebarOpen = !sidebarOpen">
            <!-- Sidebar -->
            @include('layouts.sidebar')

            <!-- Main Content Area -->
            <div :class="sidebarOpen ? 'ml-64' : 'ml-20'" class="transition-all duration-300">
                <!-- Top Navigation -->
                @include('layouts.navigation')

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- jQuery (debe cargarse antes que Select2) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Inicializador de searchable-selects -->
        <script src="{{ asset('js/searchable-select.js') }}"></script>

        <!-- Scripts adicionales por página -->
        @stack('scripts')
    </body>
</html>
