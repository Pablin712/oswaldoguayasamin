import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // ===== PALETA 1: Colores originales de la escuela =====
                style1: {
                    primary: {
                        DEFAULT: '#62ff6d', // Verde brillante
                        light: '#9dffa3',
                        dark: '#1a5d1f', // Verde oscuro suave para dark mode
                    },
                    secondary: {
                        DEFAULT: '#fffa3f', // Amarillo brillante
                        light: '#fffb7f',
                        dark: '#7a7600', // Amarillo oscuro apagado
                    },
                    third: {
                        DEFAULT: '#112405', // Verde oscuro
                        light: '#2a4d12',
                        dark: '#0a1503', // Casi negro
                    },
                    fourth: {
                        DEFAULT: '#868679', // Gris
                        light: '#a8a89f',
                        dark: '#3d3d36', // Gris muy oscuro
                    },
                    five: {
                        DEFAULT: '#fffaf2', // Crema claro
                        light: '#ffffff',
                        dark: '#2d2a26', // Fondo oscuro neutral
                    },
                },

                // ===== PALETA 2: Tonos verdes y amarillos =====
                style2: {
                    primary: {
                        DEFAULT: '#008c00', // Verde oscuro
                        light: '#00b800',
                        dark: '#004500', // Verde muy oscuro
                    },
                    secondary: {
                        DEFAULT: '#6eb003', // Verde lima
                        light: '#8fd428',
                        dark: '#3d5c00', // Verde oliva oscuro
                    },
                    third: {
                        DEFAULT: '#d9db58', // Amarillo verdoso
                        light: '#e8ea87',
                        dark: '#5c5d00', // Amarillo verdoso muy oscuro
                    },
                    fourth: {
                        DEFAULT: '#ffffa9', // Amarillo claro
                        light: '#ffffdd',
                        dark: '#6b6b45', // Amarillo muy apagado
                    },
                    five: {
                        DEFAULT: '#fffff4', // Casi blanco
                        light: '#ffffff',
                        dark: '#2b2b26', // Fondo oscuro neutral
                    },
                },
            },
        },
    },

    plugins: [forms],
};
