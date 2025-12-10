import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
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
                'inter': ['Inter', 'Arial', 'sans-serif'],
                'roboto': ['Roboto', 'Arial', 'sans-serif'],
                sans: ['Inter', 'Arial', 'sans-serif'],
            },
            colors: {
                'unj': {
                    // Primary Teal Colors
                    'teal-50': '#f0fdfa',
                    'teal-100': '#ccfbf1',
                    'teal-200': '#99f6e4',
                    'teal-300': '#5eead4',
                    'teal-400': '#2dd4bf',
                    'teal-500': '#14b8a6',
                    'teal-600': '#0d9488',
                    'teal-700': '#0f766e',
                    'teal-800': '#115e59',
                    'teal-900': '#134e4a',
                    'teal-950': '#042f2e',
                    
                    // UNJ Brand Colors
                    'primary': '#277177',      // Main navbar color
                    'primary-dark': '#186862', // Mobile navbar color
                    'secondary': '#14b8a6',   // Accent color
                    
                    // Yellow Accent Colors
                    'yellow-50': '#fefce8',
                    'yellow-100': '#fef9c3',
                    'yellow-200': '#fef08a',
                    'yellow-300': '#fde047',
                    'yellow-400': '#facc15',   // Main accent yellow
                    'yellow-500': '#eab308',
                    'yellow-600': '#ca8a04',
                    'yellow-700': '#a16207',
                    'yellow-800': '#854d0e',
                    'yellow-900': '#713f12',
                    'yellow-950': '#422006',
                }
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'fade-in-up': 'fadeInUp 0.8s ease-out',
                'slide-up': 'slideUp 0.3s ease-out',
                'bounce-gentle': 'bounceGentle 2s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': {
                        opacity: '0',
                        transform: 'translateY(30px)'
                    },
                    '100%': {
                        opacity: '1',
                        transform: 'translateY(0)'
                    },
                },
                slideUp: {
                    '0%': { transform: 'translateY(100%)' },
                    '100%': { transform: 'translateY(0)' },
                },
                bounceGentle: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                }
            },
            boxShadow: {
                'unj': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
                'unj-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                'unj-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
            },
            borderRadius: {
                'unj': '0.5rem',
                'unj-lg': '0.75rem',
                'unj-xl': '1rem',
            },
            transitionProperty: {
                'height': 'height',
                'spacing': 'margin, padding',
            },
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
            },
            transitionTimingFunction: {
                'bounce-in': 'cubic-bezier(0.68, -0.55, 0.265, 1.55)',
            }
        },
    },
    plugins: [
        // Plugin for responsive container queries (when supported)
        function({ addUtilities, theme }) {
            const newUtilities = {
                '.text-shadow-unj': {
                    textShadow: '0 2px 4px rgba(0, 0, 0, 0.1)',
                },
                '.text-shadow-unj-lg': {
                    textShadow: '0 4px 8px rgba(0, 0, 0, 0.15)',
                },
            };
            
            addUtilities(newUtilities);
        },
    ],
};
