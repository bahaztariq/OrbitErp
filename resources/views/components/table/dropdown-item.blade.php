@props(['type' => 'link', 'href' => '#', 'danger' => false])

@php
$classes = 'flex items-center gap-2 w-full px-4 py-2 text-start text-sm leading-5 transition-colors duration-150 ' . 
           ($danger ? 'text-rose-600 hover:bg-rose-50' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600');
@endphp

@if($type === 'link')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
