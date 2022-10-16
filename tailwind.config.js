const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Kadwa','Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'backg': '#EFEFEF',
                'menuColor' : '#A6A6A6',
                'bgHover' : '#4a4a4a'
            },
        },
    },

    plugins: [require('@tailwindcss/forms'),require("daisyui")],

    daisyui: {
        themes: false,
    },
};
