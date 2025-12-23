<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Mensaje de bienvenida -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <!-- Demo de Paletas - Usando clases estáticas de Tailwind -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Demo de Paletas con Clases Estáticas</h3>

                <!-- Style 1 -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">Paleta 1 (Style1)</h4>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <div class="bg-style1-primary p-4 rounded text-gray-900 font-semibold text-center shadow">Primary</div>
                        <div class="bg-style1-secondary p-4 rounded text-gray-900 font-semibold text-center shadow">Secondary</div>
                        <div class="bg-style1-third p-4 rounded text-white font-semibold text-center shadow">Third</div>
                        <div class="bg-style1-fourth p-4 rounded text-white font-semibold text-center shadow">Fourth</div>
                        <div class="bg-style1-five p-4 rounded text-gray-900 font-semibold text-center border-2 border-gray-300 shadow">Five</div>
                    </div>
                </div>

                <!-- Style 2 -->
                <div class="mb-6">
                    <h4 class="font-semibold mb-2 text-gray-700 dark:text-gray-300">Paleta 2 (Style2)</h4>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <div class="bg-style2-primary p-4 rounded text-white font-semibold text-center shadow">Primary</div>
                        <div class="bg-style2-secondary p-4 rounded text-white font-semibold text-center shadow">Secondary</div>
                        <div class="bg-style2-third p-4 rounded text-gray-900 font-semibold text-center shadow">Third</div>
                        <div class="bg-style2-fourth p-4 rounded text-gray-900 font-semibold text-center shadow">Fourth</div>
                        <div class="bg-style2-five p-4 rounded text-gray-900 font-semibold text-center border-2 border-gray-300 shadow">Five</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
