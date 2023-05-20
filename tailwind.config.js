const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
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
            gridTemplateColumns: {
                '2fr': '2fr 0fr',
                '20-80': '20% 80%',
              },
            gridTemplateRows: {
            // Simple 8 row grid
            '7': 'repeat(7, minmax(0, 1fr))',
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
