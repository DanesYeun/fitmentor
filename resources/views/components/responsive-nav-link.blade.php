@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-black hover:text-black hover:bg-sky-500 focus:outline-none focus:text-black underline transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-black hover:text-black hover:bg-sky-500 hover:border-blue-300 focus:outline-none focus:text-blue-800 focus:bg-blue-50 focus:border-blue-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
