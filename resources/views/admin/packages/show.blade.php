@extends('layouts.admin')

@section('title', $package->name)
@section('header', $package->name)

@section('admin-content')
    <x-dashboard.page-header
        :title="$package->name"
        :description="__('Membership plan details')"
    >
        <x-slot:actions>
            @can('update', $package)
                <a
                    href="{{ route('admin.packages.edit', $package) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gym-primary px-4 py-2 text-sm font-medium text-white hover:bg-gym-primary-hover transition-colors"
                >
                    {{ __('Edit Membership') }}
                </a>
            @endcan
            <a
                href="{{ route('admin.packages.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('All Memberships') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-6">
            <x-card>
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gym-primary/10">
                        <svg class="h-10 w-10 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-bold text-gym-text">{{ $package->name }}</h2>
                    <div class="mt-2">
                        <x-badge :variant="$package->is_active ? 'success' : 'default'">
                            {{ $package->is_active ? __('Active') : __('Inactive') }}
                        </x-badge>
                    </div>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Pricing') }}</h3>
                <div class="mt-4 text-center">
                    <p class="text-4xl font-bold text-gym-text">{{ number_format($package->price, 2) }} <span class="text-lg font-medium text-gym-muted">KWD</span></p>
                    <p class="mt-1 text-sm text-gym-muted">{{ __('per :days days', ['days' => $package->duration_days]) }}</p>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if($package->description)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Description') }}</h3>
                    <p class="mt-2 text-sm text-gym-text">{{ $package->description }}</p>
                </x-card>
            @endif

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Details') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-2xl font-bold text-gym-primary">{{ $package->duration_days }}</p>
                        <p class="text-sm text-gym-muted">{{ __('Days') }}</p>
                    </div>
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-2xl font-bold text-gym-primary">{{ $package->number_of_sessions ?: '∞' }}</p>
                        <p class="text-sm text-gym-muted">{{ __('Sessions') }}</p>
                    </div>
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-2xl font-bold text-gym-primary">{{ $package->sort_order }}</p>
                        <p class="text-sm text-gym-muted">{{ __('Sort Order') }}</p>
                    </div>
                </div>
            </x-card>

            @if($package->features)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Features') }}</h3>
                    <ul class="mt-4 space-y-2">
                        @foreach($package->features as $feature)
                            <li class="flex items-center gap-2 text-sm text-gym-text">
                                <svg class="h-4 w-4 shrink-0 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            @endif

            <x-card>
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gym-text">{{ __('Subscriptions') }}</h3>
                    <p class="mt-1 text-sm text-gym-muted">{{ __('Subscription details will appear here once implemented.') }}</p>
                </div>
            </x-card>
        </div>
    </div>
@endsection
