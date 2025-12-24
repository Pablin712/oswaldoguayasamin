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
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <x-color-sistema />
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
    </body>
</html>
