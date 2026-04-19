import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                'base': '#FAF7F2',
                'surface': '#F0E8D8',
                'on-surface': '#1C0A00',
                'tertiary': '#6B4C35',
                'primary': '#B8924A',
                'primary-dim': '#9A7735',
                'secondary': '#7A9468',
                'neutral': '#E0D0BB',
                'error': '#C0392B',
                'success': '#27664A',
                'dark-base': '#140C05',
                'dark-surface': '#2C1D14',
                'dark-primary': '#EBC073',
                'dark-text': '#F3F0EB',
                'dark-border': '#3A2516',
                'tan': '#A8886A',
            },
            fontFamily: {
                display: ['"Cormorant Garamond"', ...defaultTheme.fontFamily.serif],
                body: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'display': ['56px', { lineHeight: '1.1', fontWeight: '600' }],
                'h1': ['40px', { lineHeight: '1.2', fontWeight: '600' }],
                'h2': ['32px', { lineHeight: '1.25', fontWeight: '500' }],
                'h3': ['24px', { lineHeight: '1.3', fontWeight: '500' }],
                'h4': ['18px', { lineHeight: '1.4', fontWeight: '500' }],
                'body-lg': ['16px', { lineHeight: '1.7', fontWeight: '400' }],
                'body': ['14px', { lineHeight: '1.6', fontWeight: '400' }],
                'caption': ['12px', { lineHeight: '1.5', fontWeight: '400' }],
                'label': ['12px', { lineHeight: '1.5', fontWeight: '700', letterSpacing: '0.08em' }],
                'btn': ['14px', { lineHeight: '1', fontWeight: '500', letterSpacing: '0.04em' }],
            },
            borderRadius: {
                'button': '6px',
                'card': '12px',
                'input': '8px',
                'badge': '4px',
                'modal': '16px',
            },
            boxShadow: {
                'card': '0 2px 12px rgba(28,10,0,0.06)',
                'card-hover': '0 8px 32px rgba(28,10,0,0.12)',
                'navbar': '0 1px 0 #E0D0BB',
                'modal': '0 24px 80px rgba(28,10,0,0.2)',
                'glow-gold': '0 0 0 3px rgba(184,146,74,0.2)',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '128': '32rem',
            },
            maxWidth: {
                'container': '1440px',
            },
            transitionDuration: {
                '400': '400ms',
            },
            keyframes: {
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'shimmer': {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
                'bounce-cart': {
                    '0%, 100%': { transform: 'scale(1)' },
                    '50%': { transform: 'scale(1.2)' },
                },
                'pulse-dot': {
                    '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                    '50%': { opacity: '0.5', transform: 'scale(1.3)' },
                },
            },
            animation: {
                'fade-in-up': 'fade-in-up 0.5s ease-out',
                'shimmer': 'shimmer 2s infinite linear',
                'bounce-cart': 'bounce-cart 0.3s ease-in-out',
                'pulse-dot': 'pulse-dot 2s infinite',
            },
        },
    },

    plugins: [forms],
};
