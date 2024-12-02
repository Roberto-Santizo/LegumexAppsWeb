import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                'mesarem': "url('/public/img/mesa-reempaque.jpg')",
              },
              fontSize:{
                'xxs': '8.5px', 
              },
              backgroundColor:{
                'green-meadow': '#598234',
                'green-moss' : '#AEBD38',
                'green-waterfall' : '#68829E',
                'green-thunder': '#505160'
        
              },
              scale:{
                '1025': '1.025'
              },
              animation:{
                'blink-colors': 'blink-colors 3s infinite',
              },
              keyframes: {
                'blink-colors': {
                  '0%': { backgroundColor: colors.green[500] },
                  '50%': { backgroundColor: colors.green[700] },
                  '100%': { backgroundColor: colors.green[500] },
              },
            },
        },
    },

    plugins: [forms],
};
