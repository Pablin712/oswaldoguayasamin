<nav x-data="{
    open: false,
    darkMode: localStorage.getItem('darkMode') === 'true',
    currentTheme: localStorage.getItem('theme') || 'style1',
    toggleDark() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    changeTheme(theme) {
        this.currentTheme = theme;
        localStorage.setItem('theme', theme);
        document.documentElement.setAttribute('data-theme', theme);
    },
    init() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        }
        document.documentElement.setAttribute('data-theme', this.currentTheme);
    }
}" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-30">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Breadcrumb o título de página -->
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    <!-- Page Heading -->
                    @isset($header)
                        {{ $header }}
                    @endisset
                </h1>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Theme Selector -->
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Apariencia</p>

                            <!-- Dark Mode Toggle -->
                            <button @click="toggleDark()"
                                    class="w-full flex items-center justify-between px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                                <span class="flex items-center gap-2">
                                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span x-text="darkMode ? 'Modo Claro' : 'Modo Oscuro'"></span>
                                </span>
                            </button>

                            <!-- Palette Selector -->
                            <div class="mt-2 space-y-1">
                                <button @click="changeTheme('style1')"
                                        :class="currentTheme === 'style1' ? 'bg-gray-100 dark:bg-gray-700 ring-2 ring-blue-500' : ''"
                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                                    <div class="flex gap-1">
                                        <span class="w-3 h-3 rounded-full bg-[#62ff6d] ring-1 ring-gray-300"></span>
                                        <span class="w-3 h-3 rounded-full bg-[#fffa3f] ring-1 ring-gray-300"></span>
                                        <span class="w-3 h-3 rounded-full bg-[#112405] ring-1 ring-gray-300"></span>
                                    </div>
                                    <span>Paleta 1</span>
                                    <svg x-show="currentTheme === 'style1'" class="w-4 h-4 ml-auto text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <button @click="changeTheme('style2')"
                                        :class="currentTheme === 'style2' ? 'bg-gray-100 dark:bg-gray-700 ring-2 ring-blue-500' : ''"
                                        class="w-full flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                                    <div class="flex gap-1">
                                        <span class="w-3 h-3 rounded-full bg-[#008c00] ring-1 ring-gray-300"></span>
                                        <span class="w-3 h-3 rounded-full bg-[#6eb003] ring-1 ring-gray-300"></span>
                                        <span class="w-3 h-3 rounded-full bg-[#d9db58] ring-1 ring-gray-300"></span>
                                    </div>
                                    <span>Paleta 2</span>
                                    <svg x-show="currentTheme === 'style2'" class="w-4 h-4 ml-auto text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
            <!-- Mobile Theme Selector -->
            <div class="px-4 pb-3 border-b border-gray-200 dark:border-gray-700 mb-3">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase mb-2">Apariencia</p>

                <!-- Dark Mode Toggle -->
                <button @click="toggleDark()"
                        class="w-full flex items-center justify-between px-3 py-2 mb-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-md border border-gray-300 dark:border-gray-600 transition">
                    <span class="flex items-center gap-2">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span x-text="darkMode ? 'Modo Claro' : 'Modo Oscuro'"></span>
                    </span>
                </button>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Paleta de Colores</label>
                <div class="flex gap-2">
                    <button @click="changeTheme('style1')"
                            :class="currentTheme === 'style1' ? 'ring-2 ring-blue-500' : ''"
                            class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                        <div class="flex gap-1 justify-center mb-1">
                            <span class="w-3 h-3 rounded-full bg-[#62ff6d]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#fffa3f]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#112405]"></span>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Paleta 1</span>
                    </button>
                    <button @click="changeTheme('style2')"
                            :class="currentTheme === 'style2' ? 'ring-2 ring-blue-500' : ''"
                            class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                        <div class="flex gap-1 justify-center mb-1">
                            <span class="w-3 h-3 rounded-full bg-[#008c00]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#6eb003]"></span>
                            <span class="w-3 h-3 rounded-full bg-[#d9db58]"></span>
                        </div>
                        <span class="text-gray-700 dark:text-gray-300">Paleta 2</span>
                    </button>
                </div>
            </div>

            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
