@props([
    'label' => null,
    'error' => null,
    'id' => null,
    'type' => 'text',
])

@php
    $inputId = $id ?? $attributes->get('name');
    $hasError = $error || $errors->has($attributes->get('name'));
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:')->only('class') }}>
    @if($label)
        <label for="{{ $inputId }}" class="mb-1 block text-sm font-medium text-gym-text">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $inputId }}"
        type="{{ $type }}"
        {{ $attributes->except('class')->merge(['class' => 'block w-full rounded-lg border px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-gym-muted focus:outline-none focus:ring-2 focus:ring-offset-0 bg-gym-white text-gym-text ' . ($hasError ? 'border-gym-danger focus:border-gym-danger focus:ring-gym-danger' : 'border-gym-divider focus:border-gym-primary focus:ring-gym-primary/20')]) }}
    />

    @if($hasError)
        <p class="mt-1 text-sm text-gym-danger">
            {{ $error ?? $errors->first($attributes->get('name')) }}
        </p>
    @endif
</div>
