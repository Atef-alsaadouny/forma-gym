@extends('layouts.admin')

@section('title', __('Subscription Details'))
@section('header', __('Subscription Details'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Subscription Details')"
        :description="$subscription->member->user->name . ' — ' . $subscription->package->name"
    >
        <x-slot:actions>
            @can('update', $subscription)
                <a
                    href="{{ route('admin.subscriptions.edit', $subscription) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gym-primary px-4 py-2 text-sm font-medium text-white hover:bg-gym-primary-hover transition-colors"
                >
                    {{ __('Edit Subscription') }}
                </a>
            @endcan
            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('All Subscriptions') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-6">
            <x-card>
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gym-primary/10 text-2xl font-bold text-gym-primary">
                        {{ substr($subscription->member->user->name, 0, 2) }}
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-gym-text">{{ $subscription->member->user->name }}</h2>
                    <p class="text-sm text-gym-muted">{{ $subscription->member->user->email }}</p>
                    <div class="mt-2">
                        <x-badge :variant="$subscription->status->value === 'active' ? 'success' : ($subscription->status->value === 'expired' ? 'warning' : ($subscription->status->value === 'cancelled' ? 'danger' : 'default'))">
                            {{ $subscription->status->label() }}
                        </x-badge>
                    </div>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Package') }}</h3>
                <div class="mt-4 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gym-primary/10">
                        <svg class="h-7 w-7 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="mt-3 text-lg font-bold text-gym-text">{{ $subscription->package->name }}</h3>
                    @if($subscription->price_paid)
                        <p class="text-sm text-gym-muted">{{ number_format($subscription->price_paid, 2) }} KWD</p>
                    @endif
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Subscription Period') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('Start Date') }}</p>
                        <p class="mt-1 text-lg font-bold text-gym-text">{{ $subscription->start_date->format('Y-m-d') }}</p>
                    </div>
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('End Date') }}</p>
                        <p class="mt-1 text-lg font-bold text-gym-text">{{ $subscription->end_date->format('Y-m-d') }}</p>
                    </div>
                </div>
                <div class="mt-4 rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                    <p class="text-sm text-gym-muted">{{ __('Duration') }}</p>
                    <p class="mt-1 text-lg font-bold text-gym-text">{{ $subscription->start_date->diffInDays($subscription->end_date) }} {{ __('Days') }}</p>
                </div>
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Details') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Price Paid') }}</p>
                        <p class="font-medium text-gym-text">{{ $subscription->price_paid ? number_format($subscription->price_paid, 2) . ' KWD' : '—' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gym-muted">{{ __('Status') }}</p>
                        <p class="font-medium text-gym-text capitalize">{{ $subscription->status->label() }}</p>
                    </div>
                </div>

                @if($subscription->notes)
                    <div class="mt-4">
                        <p class="text-sm text-gym-muted">{{ __('Notes') }}</p>
                        <p class="mt-1 text-sm text-gym-text">{{ $subscription->notes }}</p>
                    </div>
                @endif
            </x-card>

            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Package Features') }}</h3>
                @if($subscription->package->features)
                    <ul class="mt-4 space-y-2">
                        @foreach($subscription->package->features as $feature)
                            <li class="flex items-center gap-2 text-sm text-gym-text">
                                <svg class="h-4 w-4 shrink-0 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-2 text-sm text-gym-muted">{{ __('No features listed.') }}</p>
                @endif
            </x-card>
        </div>
    </div>
@endsection
