import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class', // Ensure dark mode is enabled

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            // ADD THIS SECTION
            colors: {
                midnight: {
                    900: '#0f111a', // Main App Background
                    800: '#161b22', // Secondary / Sidebar
                    700: '#1f242e', // Active States
                },
                accent: {
                    500: '#6366f1', // Primary Brand Color
                    600: '#4f46e5',
                },
                line: '#2d3039', // Subtle Borders
            }
        },
    },

    plugins: [forms],
};


