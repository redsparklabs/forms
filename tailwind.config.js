const defaultTheme = require('tailwindcss/defaultTheme');


module.exports = {
    mode: 'jit',
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php',
        './safelist.txt'
    ],

    theme: {

        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('tailwind-safelist-generator')({
            patterns: [
                'text-{colors}',
                'bg-{colors}',
                'row-span-2',
                'row-span-1',
                'row-span-3',
                'row-col-1',
                'row-col-2',
                'row-col-3',
                'h-8',
                'h-9',
                'h-10',
                'h-11',
                'h-12',
                'h-14',
                'h-16',
                'h-20',
                'h-24',
                'h-28',
                'h-32',
                'h-36',
                'h-40',
                'h-44',
                'h-48',
                'h-52',
            ],
        }),
    ],
};
