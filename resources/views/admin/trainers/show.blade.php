@extends('layouts.admin')

@section('title', $trainer->user->name)
@section('header', $trainer->user->name)

@section('admin-content')
    <x-dashboard.page-header
        :title="$trainer->user->name"
        :description="($trainer->specialization ?? __('Trainer')) . ' — ' . ($trainer->joined_at?->format('Y-m-d') ?? 'N/A')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.trainers.edit', $trainer) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gym-primary px-4 py-2 text-sm font-medium text-white hover:bg-gym-primary-hover transition-colors"
            >
                {{ __('Edit Trainer') }}
            </a>
            <a
                href="{{ route('admin.trainers.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-card px-4 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors"
            >
                {{ __('All Trainers') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-6">
            <x-card>
                <div class="text-center">
                    @if($trainer->profile_photo_path)
                        <img
                            src="{{ Storage::url($trainer->profile_photo_path) }}"
                            alt="{{ $trainer->user->name }}"
                            class="mx-auto h-24 w-24 rounded-full object-cover"
                        >
                    @else
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-gym-primary/20 text-3xl font-bold text-gym-primary-light">
                            {{ substr($trainer->user->name, 0, 2) }}
                        </div>
                    @endif
                    <h2 class="mt-4 text-xl font-bold text-white">{{ $trainer->user->name }}</h2>
                    <div class="mt-2 flex items-center justify-center gap-2">
                        <x-badge :variant="$trainer->status?->badgeVariant() ?? 'default'">
                            {{ $trainer->status?->label() ?? 'Unknown' }}
                        </x-badge>
                        @if($trainer->is_available)
                            <x-badge variant="success">{{ __('Available') }}</x-badge>
                        @else
                            <x-badge variant="warning">{{ __('Not Available') }}</x-badge>
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-gym-muted capitalize">{{ $trainer->specialization ?? '—' }}</p>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Contact Info') }}</h3>
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <p class="text-gym-muted">{{ __('Email') }}</p>
                        <p class="font-medium text-white">{{ $trainer->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gym-muted">{{ __('Phone') }}</p>
                        <p class="font-medium text-white">{{ $trainer->user->phone ?? '—' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Quick Stats') }}</h3>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gym-muted">{{ __('Experience') }}</span>
                        <span class="font-medium text-white">{{ $trainer->experience_years ? $trainer->experience_years . ' ' . __('years experience') : '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gym-muted">{{ __('Rating') }}</span>
                        <span class="font-medium text-white">{{ $trainer->rating ? number_format($trainer->rating, 1) . ' / 5.0' : '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gym-muted">{{ __('Gender') }}</span>
                        <span class="font-medium text-white capitalize">{{ $trainer->gender ?? '—' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gym-muted">{{ __('Joined Date') }}</span>
                        <span class="font-medium text-white">{{ $trainer->joined_at?->format('Y-m-d') ?? '—' }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if($trainer->bio)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('About Me') }}</h3>
                    <p class="mt-3 text-sm text-gym-muted">{{ $trainer->bio }}</p>
                </x-card>
            @endif

            @if($trainer->certifications)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Certifications') }}</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach((array) $trainer->certifications as $cert)
                            <x-badge variant="primary">{{ $cert }}</x-badge>
                        @endforeach
                    </div>
                </x-card>
            @endif

            @if($trainer->notes)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Notes') }}</h3>
                    <p class="mt-3 text-sm text-gym-muted">{{ $trainer->notes }}</p>
                </x-card>
            @endif

            <x-card>
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gym-muted">{{ __('Assigned Members') }}</h3>
                    <p class="mt-1 text-sm text-gym-muted">{{ __('Member assignments will appear here once implemented.') }}</p>
                </div>
            </x-card>

            <div class="grid gap-6 sm:grid-cols-3">
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-muted">{{ __('Schedule') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-muted">{{ __('Workout Programs') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-muted">{{ __('Performance Metrics') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
            </div>

            <x-card>
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gym-muted">{{ __('Performance Metrics') }}</h3>
                    <p class="mt-1 text-sm text-gym-muted">{{ __('Trainer performance metrics will appear here once implemented.') }}</p>
                </div>
            </x-card>
        </div>
    </div>
@endsection
