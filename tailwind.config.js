/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php"
  ],
  theme: {
    extend: {
      backgroundImage: {
        'mesarem': "url('/public/img/mesa-reempaque.jpg')"
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
      }
    },
  },
  plugins: [],
}

