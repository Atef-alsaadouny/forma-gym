@props([
    'show' => false,
    'maxWidth' => 'lg',
])

@php
    $maxWidthClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ][$maxWidth] ?? 'max-w-lg';
@endphp

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-on:open-modal.window="$event.detail === '{{ $attributes->get('name') }}' ? show = true : null"
    x-on:close-modal.window="show = false"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;"
>
    <div class="fixed inset-0 bg-gym-dark/50" x-on:click="show = false"></div>

    <div class="{{ $maxWidth }} relative w-full mx-4 rounded-xl bg-gym-white shadow-xl">
        @if(isset($header))
            <div class="border-b border-gym-border px-6 py-4">
                {{ $header }}
            </div>
        @endif

        <div class="px-6 py-5">
            {{ $slot }}
        </div>

        @if(isset($footer))
            <div class="border-t border-gym-border px-6 py-4">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
