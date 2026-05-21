import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'bg-emerald-600',
        'hover:bg-emerald-700',
        'bg-emerald-700',
        'bg-gray-100',
        'hover:bg-gray-200',
        'text-white',
        'text-gray-800',
        'flex-1',
        'min-w-[120px]',
        'min-w-[140px]',
        'min-w-[110px]',
        'py-3',
        'py-2.5',
        'px-4',
        'px-6',
        'rounded-lg',
        'rounded-2xl',
        'font-semibold',
        'transition-all',
        'shadow-md',
        'hover:shadow-md',
        'hover:shadow-lg',
        'active:scale-95',
        'cursor-pointer',
        'text-sm',
        'text-center',
        'flex',
        'flex-col',
        'sm:flex-row',
        'gap-3',
        'pt-4',
        'pt-6',
        'border-t',
        'border-gray-200',
        'w-full',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
