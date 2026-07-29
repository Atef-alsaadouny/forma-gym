@extends('layouts.base')

@section('body')
    <div class="flex min-h-screen flex-col">
        <header class="border-b border-gym-card bg-gym-dark">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gym-primary text-sm font-bold text-white">F</div>
                    <span class="text-xl font-bold text-white">{{ config('app.name') }}</span>
                </a>

                <nav class="hidden items-center gap-6 md:flex">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gym-muted hover:text-white transition-colors">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gym-muted hover:text-white transition-colors">{{ __('About') }}</a>
                    <a href="{{ route('contact') }}" class="text-sm font-medium text-gym-muted hover:text-white transition-colors">{{ __('Contact') }}</a>
                    @auth
                        @php $role = auth()->user()->role?->value; @endphp
                        @if(in_array($role, ['owner', 'admin', 'manager', 'receptionist', 'trainer']))
                            <a href="{{ route('admin.subscriptions.index') }}" class="text-sm font-medium text-gym-primary-light hover:text-gym-primary transition-colors">{{ __('Admin Panel') }}</a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="text-sm font-medium text-gym-primary-light hover:text-gym-primary transition-colors">{{ __('Dashboard') }}</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gym-primary-light hover:text-gym-primary transition-colors">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}">
                            <x-button variant="primary" size="sm">{{ __('Get Started') }}</x-button>
                        </a>
                    @endauth
                </nav>

                <button x-data @click="$refs.mobileMenu.classList.toggle('hidden')" class="md:hidden">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <div x-ref="mobileMenu" class="hidden border-t border-gym-card md:hidden">
                <div class="space-y-1 px-4 py-3">
                    <a href="{{ route('home') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors">{{ __('Home') }}</a>
                    <a href="{{ route('about') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors">{{ __('About') }}</a>
                    <a href="{{ route('contact') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors">{{ __('Contact') }}</a>
                    @auth
                        <a href="{{ route('member.dashboard') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-primary-light hover:bg-gym-dark-hover transition-colors">{{ __('Dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-primary-light hover:bg-gym-dark-hover transition-colors">{{ __('Login') }}</a>
                        <a href="{{ route('register') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-gym-primary-light hover:bg-gym-dark-hover transition-colors">{{ __('Register') }}</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-gym-card bg-gym-dark">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                <div class="grid gap-8 sm:grid-cols-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gym-primary text-xs font-bold text-white">F</div>
                            <span class="text-lg font-bold text-white">{{ config('app.name') }}</span>
                        </div>
                        <p class="mt-3 text-sm text-gym-muted leading-relaxed">
                            {{ __('Your premier fitness destination. Transform your body, transform your life.') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">{{ __('Quick Links') }}</h4>
                        <ul class="mt-3 space-y-2">
                            <li><a href="{{ route('home') }}" class="text-sm text-gym-muted hover:text-white transition-colors">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('about') }}" class="text-sm text-gym-muted hover:text-white transition-colors">{{ __('About') }}</a></li>
                            <li><a href="{{ route('contact') }}" class="text-sm text-gym-muted hover:text-white transition-colors">{{ __('Contact') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-white">{{ __('Contact') }}</h4>
                        <ul class="mt-3 space-y-2">
                            <li class="text-sm text-gym-muted">info@formagym.com</li>
                            <li class="text-sm text-gym-muted">+1 (555) 123-4567</li>
                            <li class="text-sm text-gym-muted">{{ __('123 Fitness Street, Gym City') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 border-t border-gym-card pt-8 text-center">
                    <p class="text-sm text-gym-muted">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                    </p>
                </div>
            </div>
        </footer>
    </div>
@endsection
