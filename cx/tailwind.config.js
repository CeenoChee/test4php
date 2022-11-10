const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './resources/**/*.php',
    ],
    variants: {
        backgroundColor: ['even'],
    },
    theme: {

        fontFamily:{
            body: ['"Open Sans"','"sans-serif"'],
            raleway: ['"Raleway"','"sans-serif"'],
        },

        minHeight: {
            85: '85px',
        },
        maxWidth:{
            10: '10rem',
            15: '15rem',
        },

        screens: {
            '2xs': '360px',
            xs: '480px',
            ...defaultTheme.screens,
        },

        extend: {
            fontSize: {
                '2xs': ['0.7rem'],
                '2sm': ['16px'],
                '2lg': ['20px', '16px'],
                '3lg': ['25px', '10px'],
                xl: ['30px', '26px'],
                '2xl': ['34px', '40px'],
                '3xl': ['40px', '50px'],
            },
            boxShadow: {
                logo: '0 1px 1rem rgb(0 0 0 / 50%)',
                search: '0 20px 3rem rgb(0 0 0 / 30%)',
                '2xl': '0 0 4rem rgb(0 0 0 / 5%)',
            },
            blur:{
                xs: '2px',
            },
            colors: {
                'riel-light': '#5ea2d9',
                'riel-dark': '#3169b1',
                'riel-gray': '#777777',
            },
        },
    },
    plugins: [],
}
