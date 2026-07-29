@props([
    'label' => '',
    'value' => '',
    'icon' => null,
    'trend' => null,
    'trendUp' => true,
    'color' => 'primary',
])

@php
    $colors = [
        'primary' => 'bg-gym-primary-light text-gym-primary',
        'success' => 'bg-gym-success-bg text-gym-success-text',
        'warning' => 'bg-gym-warning-bg text-gym-warning-text',
        'danger' => 'bg-gym-danger-bg text-gym-danger-text',
        'info' => 'bg-gym-info-bg text-gym-info-text',
    ];
    $iconBg = $colors[$color] ?? $colors['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-xl border border-gym-card bg-gym-card p-6 shadow-sm']) }}>
    <div class="flex items-start justify-between">
        <div class="space-y-1">
            <p class="text-sm font-medium text-gym-muted">{{ $label }}</p>
            <p class="text-2xl font-bold text-gym-primary">{{ $value }}</p>
            @if($trend)
                <p @class([
                    'inline-flex items-center gap-1 text-sm font-medium',
                    'text-gym-success' => $trendUp,
                    'text-gym-danger' => !$trendUp,
                ])>
                    @if($trendUp)
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    @else
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    @endif
                    {{ $trend }}
                </p>
            @endif
        </div>
        @if($icon)
            <div class="{{ $iconBg }} flex h-10 w-10 items-center justify-center rounded-lg">
                <x-dynamic-component :component="'icons.' . $icon" class="h-5 w-5" />
            </div>
        @endif
    </div>
</div>
