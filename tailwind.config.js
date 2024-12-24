import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                  },
            },
            animation: {
                float: 'float 4s ease-in-out infinite',
              },
                colors: {
                    primary: {
                        default: '#3D4877',
                    },
                    secondary: {
                        default: '#BF0404',
                    },
                    neutral: {
                        default: '#F5F5F5',
                    }
                }
            },
        },

        plugins: [
            forms,
            require('daisyui'),
            require('tailwindcss-primeui'),
            require('flowbite/plugin'),
        ],

        // Configurações específicas do DaisyUI
        daisyui: {
            themes: ["light"],
        },
    };
