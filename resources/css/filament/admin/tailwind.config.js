import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    theme: {
        extend: {
            colors: {
                danger: {
                    50: 'rgb(254 242 242)',
                    100: 'rgb(254 226 226)',
                    200: 'rgb(254 202 202)',
                    300: 'rgb(252 165 165)',
                    400: 'rgb(248 113 113)',
                    500: 'rgb(239 68 68)',
                    600: 'rgb(220 38 38)',
                    700: 'rgb(185 28 28)',
                    800: 'rgb(153 27 27)',
                    900: 'rgb(127 29 29)',
                    950: 'rgb(69 10 10)',
                },
                warning: {
                    50: 'rgb(255 247 237)',
                    100: 'rgb(255 237 213)',
                    200: 'rgb(254 215 170)',
                    300: 'rgb(253 186 116)',
                    400: 'rgb(251 146 60)',
                    500: 'rgb(249 115 22)',
                    600: 'rgb(234 88 12)',
                    700: 'rgb(194 65 12)',
                    800: 'rgb(154 52 18)',
                    900: 'rgb(124 45 18)',
                    950: 'rgb(67 20 7)',
                },
            },
        },
    },
}
