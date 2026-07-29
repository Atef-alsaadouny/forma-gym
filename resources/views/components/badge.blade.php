@props([
    'variant' => 'default',
])

@php
    $variants = [
        'default' => 'bg-gym-inactive-bg text-gym-muted',
        'success' => 'bg-gym-success-bg text-gym-success-text',
        'warning' => 'bg-gym-warning-bg text-gym-warning-text',
        'danger' => 'bg-gym-danger-bg text-gym-danger-text',
        'info' => 'bg-gym-info-bg text-gym-info-text',
        'primary' => 'bg-gym-primary text-white',
    ];

    $classes = $variants[$variant] ?? $variants['default'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ' . $classes]) }}>
    {{ $slot }}
</span>
