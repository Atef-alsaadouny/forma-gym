@props(['collapsed' => false])

@php
    $role = auth()->user()->role?->value;
    $navItems = collect(config('navigation.sidebar', []))
        ->filter(fn ($item) => in_array($role, $item['roles'], true));
    $currentRoute = request()->route()?->getName();
@endphp

<aside
    x-data="{ collapsed: @js($collapsed) }"
    :class="collapsed ? 'w-16' : 'w-64'"
    class="hidden flex-col border-s border-gym-card bg-gym-dark transition-all duration-200 md:flex"
>
    <div class="flex h-16 items-center border-b border-gym-card px-4">
        <a href="{{ route('home') }}" :class="collapsed ? 'justify-center' : 'px-2'" class="flex items-center gap-2">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gym-primary text-sm font-bold text-white">F</div>
            <span x-show="!collapsed" class="text-lg font-bold text-white whitespace-nowrap">
                {{ config('app.name') }}
            </span>
        </a>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto p-3">
        @foreach($navItems as $item)
            <a
                href="{{ route($item['route']) }}"
                @class([
                    'flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors',
                    'bg-gym-primary/20 text-gym-primary' => $currentRoute === $item['route'],
                    'text-gym-muted hover:bg-gym-dark-hover hover:text-white' => $currentRoute !== $item['route'],
                ])
                x-data
                :title="collapsed ? '{{ __($item['label']) }}' : ''"
            >
                <x-dynamic-component
                    :component="'icons.' . $item['icon']"
                    class="h-5 w-5 shrink-0"
                />
                <span x-show="!collapsed" class="truncate">{{ __($item['label']) }}</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-gym-card p-3">
        <button
            @click="collapsed = !collapsed"
            class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover hover:text-white transition-colors"
        >
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span x-show="!collapsed">{{ __('Collapse') }}</span>
        </button>

        <form method="POST" action="{{ route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover hover:text-white transition-colors">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span x-show="!collapsed">{{ __('Logout') }}</span>
            </button>
        </form>
    </div>
</aside>
