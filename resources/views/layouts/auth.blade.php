@extends('layouts.base')

@section('body')
    <div class="flex h-screen overflow-hidden bg-gym-light">
        <x-dashboard.sidebar />

        <div class="flex flex-1 flex-col overflow-hidden">
            <header class="flex h-16 items-center justify-between border-b border-gym-border bg-gym-white px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <button
                        x-data
                        @click="$dispatch('toggle-sidebar')"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-gym-muted hover:bg-gym-light md:hidden"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gym-text">
                        @yield('header', __('Dashboard'))
                    </h1>
                </div>

                <div class="flex items-center gap-4">
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm text-gym-muted hover:bg-gym-light transition-colors"
                        >
                            <div class="flex h-7 w-7 items-center justify-center rounded-full bg-gym-primary text-xs font-semibold text-white">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute start-0 z-50 mt-2 w-56 rounded-xl border border-gym-border bg-gym-white py-1 shadow-lg"
                            style="display: none;"
                        >
                            <div class="border-b border-gym-border px-4 py-3">
                                <p class="text-sm font-medium text-gym-text">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gym-muted">{{ auth()->user()->email }}</p>
                                <p class="mt-1">
                                    <x-badge variant="primary">{{ auth()->user()->role?->label() ?? 'Member' }}</x-badge>
                                </p>
                            </div>
                            <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gym-muted hover:bg-gym-light transition-colors">{{ __('Visit Website') }}</a>
                            <div class="border-t border-gym-border">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full px-4 py-2 text-sm text-gym-danger hover:bg-gym-danger-bg transition-colors">{{ __('Sign Out') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gym-light p-6">
                @yield('content')
            </main>
        </div>
    </div>
@endsection
