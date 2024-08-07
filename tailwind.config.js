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
      }
    },
  },
  plugins: [],
}

