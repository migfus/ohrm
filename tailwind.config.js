/** @type {import('tailwindcss').Config} */

const colors = require('tailwindcss/colors')
const defaultTheme = require('tailwindcss/defaultTheme')

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.{vue,ts,js}',
  ],
  darkMode: 'media',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        brand: {
          '50': '#f5f8f7',
          '100': '#dee9e5',
          '200': '#bcd3cb',
          '300': '#93b5aa',
          '400': '#6d9489',
          '500': '#527a6f',
          '600': '#3c5a53',
          '700': '#364f49',
          '800': '#2e413c',
          '900': '#293835',
          '950': '#141f1c',
        },
      }
    },
  },
  plugins: [require('@tailwindcss/forms')],
}

