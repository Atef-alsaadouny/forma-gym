@props([
    'padding' => true,
])

<div {{ $attributes->merge(['class' => 'rounded-xl border border-gym-border bg-gym-white shadow-sm']) }}>
    @if(isset($header))
        <div class="border-b border-gym-border px-6 py-4">
            {{ $header }}
        </div>
    @endif

    <div @class(['px-6 py-5' => $padding])>
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="border-t border-gym-border px-6 py-4">
            {{ $footer }}
        </div>
    @endif
</div>
