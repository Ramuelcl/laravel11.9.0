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
        success: 'bg-green-500',
        danger: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
      },
    },
  },
  plugins: [
    // ...
    require('@tailwindcss/forms'),
  ],
};
