@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variants = [
        'primary' => 'bg-gym-primary text-white hover:bg-gym-primary-hover focus:ring-gym-primary focus:ring-offset-white',
        'secondary' => 'bg-gym-light text-gym-text hover:bg-gym-inactive-bg focus:ring-gym-divider focus:ring-offset-white',
        'danger' => 'bg-gym-danger text-white hover:bg-gym-danger-text focus:ring-gym-danger focus:ring-offset-white',
        'ghost' => 'text-gym-muted hover:bg-gym-light focus:ring-gym-divider',
        'outline' => 'border border-gym-border text-gym-text hover:bg-gym-light focus:ring-gym-primary focus:ring-offset-white',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
