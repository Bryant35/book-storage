import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './node_modules/flowbite/**/*.js',
  ],
  safelist: [
    'bg-black/50',
    'dark:bg-black/80',
    'fixed',
    'inset-0',
    'z-40',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('flowbite-typography'),
    forms,
    flowbite,
  ],

};
