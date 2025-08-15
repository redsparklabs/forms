// const defaultTheme = require('tailwindcss/defaultTheme');


module.exports = {
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],
    safelist: [
        'text-karban-green-1',
        'text-karban-green-2',
        'text-karban-green-3',
        'text-karban-green-4',
        'text-karban-green-5',
        'text-karban-green-6',
        'bg-karban-green-1',
        'bg-karban-green-2',
        'bg-karban-green-3',
        'bg-karban-green-4',
        'bg-karban-green-5',
        'bg-karban-green-6',
    ],
    theme: {
        extend: {
            gridTemplateColumns: {
                '7': 'repeat(7, minmax(0, 1fr))',
                '9': 'repeat(9, minmax(0, 1fr))',
                '11': 'repeat(11, minmax(0, 1fr))',
            },
            colors: {
                karban: {
                    red: '#ff3c32',
                    green: {
                        1: '#67cc58',
                        2: '#b8d99b',
                        3: '#93c66e',
                        4: '#6a9e4a',
                        5: '#11af3b',
                        6: '#00c241'
                    },
                },
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
