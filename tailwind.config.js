import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                primary: '#0f766e',
                primaryLight: '#14b8a6',
                primaryDark: '#134e4a',

                danger: '#dc2626',
                dangerDark: '#991b1b',

                info: '#2563eb',

                // ⭐ NEW: modern UI support colors
                background: '#f3f4f6',
                card: '#ffffff',
                muted: '#64748b',
            },

            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },

            borderRadius: {
                xl: '1rem',
                '2xl': '1.5rem',
            },

            boxShadow: {
                soft: '0 10px 25px rgba(0,0,0,0.08)',
                card: '0 4px 12px rgba(0,0,0,0.06)',
            },
        },
    },

    plugins: [forms],
};