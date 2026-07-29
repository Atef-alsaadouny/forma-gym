@props([
    'title' => '',
    'description' => null,
    'actions' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-gym-text">{{ $title }}</h1>
            @if($description)
                <p class="text-sm text-gym-muted">{{ $description }}</p>
            @endif
        </div>
        @if($actions)
            <div class="flex items-center gap-3">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
