@extends('layouts.admin')

@section('title', $member->user->name)
@section('header', $member->user->name)

@section('admin-content')
    <x-dashboard.page-header
        :title="$member->user->name"
        :description="__('Member since :date', ['date' => $member->joined_at?->format('Y-m-d') ?? 'N/A'])"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.members.edit', $member) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gym-primary px-4 py-2 text-sm font-medium text-white hover:bg-gym-primary-hover transition-colors"
            >
                {{ __('Edit Member') }}
            </a>
            <a
                href="{{ route('admin.members.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('All Members') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-6">
            <x-card>
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gym-primary/10 text-2xl font-bold text-gym-primary">
                        {{ substr($member->user->name, 0, 2) }}
                    </div>
                    <h2 class="mt-4 text-xl font-bold text-gym-text">{{ $member->user->name }}</h2>
                    <div class="mt-2">
                        <x-badge :variant="$member->status?->badgeVariant() ?? 'default'">
                            {{ $member->status?->label() ?? 'Unknown' }}
                        </x-badge>
                    </div>
                    <p class="mt-1 text-sm text-gym-muted capitalize">{{ $member->gender ?? '—' }}</p>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Contact Info') }}</h3>
                <div class="mt-4 space-y-3 text-sm">
                    <div>
                        <p class="text-gym-muted">{{ __('Email') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gym-muted">{{ __('Phone') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->user->phone ?? '—' }}</p>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Profile Details') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Date of Birth') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->date_of_birth?->format('Y-m-d') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Joined Date') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->joined_at?->format('Y-m-d') ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Status') }}</p>
                        <p class="font-medium text-gym-text capitalize">{{ $member->status?->label() ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Gender') }}</p>
                        <p class="font-medium text-gym-text capitalize">{{ $member->gender ?? '—' }}</p>
                    </div>
                </div>

                @if($member->notes)
                    <div class="mt-4">
                        <p class="text-sm text-gym-muted">{{ __('Notes') }}</p>
                        <p class="mt-1 text-sm text-gym-text">{{ $member->notes }}</p>
                    </div>
                @endif
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Emergency Contact') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Name') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->emergency_contact ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Phone') }}</p>
                        <p class="font-medium text-gym-text">{{ $member->emergency_phone ?? '—' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gym-text">{{ __('Subscription') }}</h3>
                    <p class="mt-1 text-sm text-gym-muted">{{ __('Subscription details will appear here once implemented.') }}</p>
                </div>
            </x-card>

            <div class="grid gap-6 sm:grid-cols-3">
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-text">{{ __('Attendance') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-text">{{ __('Measurements') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
                <x-card>
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gym-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-gym-text">{{ __('Workout Plan') }}</p>
                        <p class="text-xs text-gym-muted">{{ __('Coming soon') }}</p>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection
