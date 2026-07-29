@props([
    'variant' => 'info',
])

@php
    $variants = [
        'info' => 'bg-gym-info-bg text-gym-info-text border-gym-info',
        'success' => 'bg-gym-success-bg text-gym-success-text border-gym-success',
        'warning' => 'bg-gym-warning-bg text-gym-warning-text border-gym-warning',
        'danger' => 'bg-gym-danger-bg text-gym-danger-text border-gym-danger',
    ];

    $classes = $variants[$variant] ?? $variants['info'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border p-4 text-sm ' . $classes]) }}>
    {{ $slot }}
</div>
