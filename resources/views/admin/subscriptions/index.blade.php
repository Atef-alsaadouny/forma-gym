@extends('layouts.admin')

@section('title', __('Subscriptions'))
@section('header', __('Subscriptions'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Subscriptions')"
        :description="__('Manage member subscriptions.')"
    >
        <x-slot:actions>
            @can('create', App\Models\Subscription::class)
                <x-dashboard.action-button
                    variant="primary"
                    href="{{ route('admin.subscriptions.create') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Subscription') }}
                </x-dashboard.action-button>
            @endcan
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mb-6 rounded-xl border border-gym-border bg-gym-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by member name or email...') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <select
                    name="status"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="pending" @selected(request('status') === 'pending')>{{ __('Pending') }}</option>
                    <option value="active" @selected(request('status') === 'active')>{{ __('Active') }}</option>
                    <option value="expired" @selected(request('status') === 'expired')>{{ __('Expired') }}</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>{{ __('Cancelled') }}</option>
                </select>
            </div>
            <div class="w-full sm:w-48">
                <select
                    name="package_id"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All Packages') }}</option>
                    @foreach($packages as $package)
                        <option value="{{ $package->id }}" @selected((int) request('package_id') === $package->id)>{{ $package->name }}</option>
                    @endforeach
                </select>
            </div>
            <x-button type="submit" variant="primary" size="md">{{ __('Search') }}</x-button>
            @if(request()->hasAny(['search', 'status', 'package_id']))
                <a href="{{ route('admin.subscriptions.index') }}" class="text-sm text-gym-muted hover:text-gym-text">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    @if(request('source') === 'public')
        <div class="mb-4 rounded-lg bg-gym-primary/10 border border-gym-primary/30 px-4 py-3 text-sm text-gym-primary">
            {{ __('Showing only registrations from the public website.') }}
            <a href="{{ route('admin.subscriptions.index') }}" class="underline hover:no-underline">{{ __('Show all') }}</a>
        </div>
    @endif

    <x-dashboard.data-table
        :headers="[__('Member'), __('Package'), __('Start Date'), __('End Date'), __('Status'), __('Source'), __('Actions')]"
        :rows="$subscriptions->map(fn ($subscription) => [
            $subscription->member->user->name,
            $subscription->package->name,
            $subscription->start_date->format('Y-m-d'),
            $subscription->end_date->format('Y-m-d'),
            view('components.badge', [
                'variant' => $subscription->status->value === 'active' ? 'success' : ($subscription->status->value === 'expired' ? 'warning' : ($subscription->status->value === 'cancelled' ? 'danger' : 'default')),
                'slot' => $subscription->status->label(),
            ])->render(),
            view('components.badge', [
                'variant' => $subscription->source === 'public' ? 'info' : 'default',
                'slot' => $subscription->source === 'public' ? __('Website') : __('Admin'),
            ])->render(),
            view('admin.subscriptions._actions', ['subscription' => $subscription])->render(),
        ])->toArray()"
        :empty="false"
    >
        <x-slot:emptyTitle>{{ __('No subscriptions found') }}</x-slot>
        <x-slot:emptyMessage>
            @if(request()->hasAny(['search', 'status', 'package_id']))
                {{ __('Try adjusting your search or filter.') }}
            @else
                {{ __('No subscriptions have been added yet.') }}
            @endif
        </x-slot>
    </x-dashboard.data-table>

    @if($subscriptions->hasPages())
        <div class="mt-6">
            {{ $subscriptions->links() }}
        </div>
    @endif
@endsection
