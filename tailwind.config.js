const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: ['./templates/**/*.html.twig'],
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