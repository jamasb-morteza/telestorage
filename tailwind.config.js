import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, require("daisyui")],

    daisyui: {
        themes: [
            {
                light: {
                    "primary": "#2563eb",
                    "secondary": "#6b7280", 
                    "accent": "#f59e0b",
                    "neutral": "#374151",
                    "base-100": "#ffffff",
                    "info": "#3b82f6",
                    "success": "#22c55e",
                    "warning": "#f59e0b",
                    "error": "#ef4444",
                },
                dark: {
                    "primary": "#3b82f6",
                    "secondary": "#9ca3af",
                    "accent": "#fbbf24",
                    "neutral": "#1f2937",
                    "base-100": "#111827",
                    "info": "#60a5fa", 
                    "success": "#34d399",
                    "warning": "#fbbf24",
                    "error": "#f87171",
                }
            }
        ],
        darkTheme: "dark", // name of one of the included themes for dark mode
        base: true, // applies background color and foreground color for root element
        styled: true, // include daisyUI colors and design decisions for all components
        utils: true, // adds responsive and modifier utility classes
    }
};
