@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variants = [
        'primary' => 'bg-gym-primary text-white hover:bg-gym-primary-hover focus:ring-gym-primary focus:ring-offset-white',
        'secondary' => 'bg-gym-white text-gym-text border border-gym-border hover:bg-gym-light focus:ring-gym-primary focus:ring-offset-white',
        'danger' => 'bg-gym-danger text-white hover:bg-gym-danger-text focus:ring-gym-danger focus:ring-offset-white',
        'ghost' => 'text-gym-muted hover:bg-gym-light focus:ring-gym-divider',
        'success' => 'bg-gym-primary text-white hover:bg-gym-primary-hover focus:ring-gym-primary focus:ring-offset-white',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-sm',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
