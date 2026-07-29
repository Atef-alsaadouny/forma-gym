@props([
    'align' => 'start',
    'width' => '48',
])

@php
    $alignmentClasses = [
        'start' => 'start-0',
        'end' => 'end-0',
    ][$align] ?? 'start-0';

    $widthClasses = [
        '48' => 'w-48',
    ][$width] ?? 'w-48';
@endphp

<div x-data="{ open: false }" class="relative">
    <div x-on:click="open = !open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-on:click.away="open = false"
        x-transition
        class="{{ $alignmentClasses }} {{ $widthClasses }} absolute z-50 mt-2 rounded-lg border border-gym-border bg-gym-white py-1 shadow-lg"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
