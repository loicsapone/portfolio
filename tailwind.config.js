const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    purge: ['./templates/**/*.html.twig'],
    darkMode: false,
    theme: {
        extend: {
            colors: {
                github: {
                    DEFAULT: '#090c10',
                    box: '#0d1117',
                    text: '#ffffff',
                    alt: '#8b949e'
                },
                twitter: {
                    DEFAULT: '#ffffff',
                    box: '#ffffff',
                    text: '#0f1419',
                    alt: '#5b7083'
                }
            },
            fontFamily: {
                sans: [...defaultTheme.fontFamily.sans]
            }
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/typography'),
    ],
}