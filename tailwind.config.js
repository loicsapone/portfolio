const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    mode: 'jit',
    purge: [
        './assets/**/*.js',
        './templates/**/*.{twig,svg}',
    ],
    darkMode: false,
    theme: {
        extend: {
            colors: {
                primary: {
                    light: '#112240',
                    DEFAULT: '#0a192f'
                },
            },
            fontFamily: {
                arvo: ['Arvo'],
                sans: ['Roboto', ...defaultTheme.fontFamily.sans]
            }
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/forms'),
    ],
}