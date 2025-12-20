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

            <!-- Demo con Variables CSS (cambia según paleta activa) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Demo con Variables CSS Dinámicas</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">Estos colores cambian automáticamente según la paleta seleccionada en el navbar:</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-theme-primary-dark p-6 rounded-lg text-white shadow-lg">
                        <h4 class="font-bold text-lg">Primary Color</h4>
                        <p class="text-sm opacity-90">Este se adapta a la paleta activa</p>
                    </div>
                    <div class="bg-theme-secondary-dark p-6 rounded-lg text-white shadow-lg">
                        <h4 class="font-bold text-lg">Secondary Color</h4>
                        <p class="text-sm opacity-90">Cambia con el selector</p>
                    </div>
                    <div class="bg-theme-third p-6 rounded-lg text-white shadow-lg">
                        <h4 class="font-bold text-lg">Third Color</h4>
                        <p class="text-sm opacity-90">Dinámico según tema</p>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-theme-five dark:bg-theme-third rounded-lg border-2 border-theme-primary">
                    <p class="text-theme-third dark:text-theme-five">
                        <strong>Ejemplo combinado:</strong> Este texto y fondo usan variables CSS y también responden al modo oscuro.
                    </p>
                </div>
            </div>

            <!-- Tarjetas de ejemplo con hover -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-theme-five dark:bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-theme-primary-dark hover:shadow-2xl transition">
                    <h3 class="text-theme-primary-dark dark:text-theme-primary-light font-bold text-xl mb-2">Tarjeta 1</h3>
                    <p class="text-gray-600 dark:text-gray-400">Usa colores de la paleta activa</p>
                    <button class="mt-4 bg-theme-primary-dark hover:bg-theme-primary text-gray-900 font-semibold px-4 py-2 rounded shadow hover:shadow-lg transition">
                        Botón Primary
                    </button>
                </div>

                <div class="bg-theme-five dark:bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-theme-secondary-dark hover:shadow-2xl transition">
                    <h3 class="text-theme-secondary-dark dark:text-theme-secondary-light font-bold text-xl mb-2">Tarjeta 2</h3>
                    <p class="text-gray-600 dark:text-gray-400">Los colores cambian dinámicamente</p>
                    <button class="mt-4 bg-theme-secondary-dark hover:bg-theme-secondary text-white font-semibold px-4 py-2 rounded shadow hover:shadow-lg transition">
                        Botón Secondary
                    </button>
                </div>

                <div class="bg-theme-five dark:bg-gray-800 p-6 rounded-lg shadow-lg border-2 border-theme-fourth-dark hover:shadow-2xl transition">
                    <h3 class="text-theme-fourth-dark dark:text-theme-fourth-light font-bold text-xl mb-2">Tarjeta 3</h3>
                    <p class="text-gray-600 dark:text-gray-400">Prueba cambiar de paleta arriba</p>
                    <button class="mt-4 bg-theme-fourth-dark hover:bg-theme-fourth text-gray-900 font-semibold px-4 py-2 rounded shadow hover:shadow-lg transition">
                        Botón Fourth
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
