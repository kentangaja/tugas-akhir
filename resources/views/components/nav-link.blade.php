@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-black dark:text-white bg-[#d4e9d4] dark:bg-green-500 rounded-full transition duration-150 ease-in-out'
            : 'inline-flex items-center px-2 py-2 bg-gray-100 dark:bg-gray-500 rounded-full transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
