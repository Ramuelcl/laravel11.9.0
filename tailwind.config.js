import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class', // Usa la clase 'dark' para activar el modo oscuro

  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      fontFamily: {
        // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
        'noto': ["'Noto Sans', sans-serif"],
      },
      colors: {
        darkBg: '#1a202c',
        darkText: '#ffffff',
        lightBg: '#ffffff',
        lightText: '#1a202c',
        success: '#16A34A',
        danger: '#FF0000',
        warning: '#FFFF00',
        info: '#0000FF'
      },
    },
  },
  plugins: [
    // ...
    require('@tailwindcss/forms'),
  ],
};
