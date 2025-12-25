<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Por tu seguridad, debes cambiar tu contraseña predeterminada antes de continuar.') }}
    </div>

    @if (session('warning'))
        <div class="mb-4 p-4 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">{{ session('warning') }}</p>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.change') }}">
        @csrf

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" :value="__('Contraseña Actual (Cédula)')" />
            <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Nueva Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Mínimo 8 caracteres, debe incluir mayúsculas, minúsculas y números.
            </p>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Cambiar Contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
