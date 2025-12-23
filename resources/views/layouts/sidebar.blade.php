<aside x-data="{
    sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null,
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
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

            <!-- Obras -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Obras</span>
            </a>

            <!-- Artistas -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Artistas</span>
            </a>

            <!-- Exposiciones -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Exposiciones</span>
            </a>

            <!-- Categorías -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Categorías</span>
            </a>

            <!-- Técnicas -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Técnicas</span>
            </a>

            <!-- Divider -->
            <div class="pt-4 pb-2" x-show="sidebarOpen">
                <div class="border-t border-gray-200 dark:border-gray-700"></div>
            </div>

            <!-- Usuarios -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Usuarios</span>
            </a>

            <!-- Configuración -->
            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors text-gray-900 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Configuración</span>
            </a>
        </div>
    </nav>

    <!-- User Info Section (parte inferior) -->
    <div class="border-t border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center gap-3" :class="!sidebarOpen && 'justify-center'">
            <div class="w-10 h-10 rounded-full bg-theme-primary dark:bg-gradient-to-br dark:from-theme-secondary dark:to-theme-third text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-md ring-2 ring-white dark:ring-gray-800">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </div>
            <div x-show="sidebarOpen" class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                {{-- roles con spatie --}}
                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ Auth::user()->roles()->pluck('name')->join(', ') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
