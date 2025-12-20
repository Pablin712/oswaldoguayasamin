@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-theme-primary-dark dark:focus:border-theme-primary-light focus:ring-theme-primary-dark dark:focus:ring-theme-primary-light rounded-md shadow-sm']) }}>
