@extends('layouts.admin')

@section('title', __('Edit Subscription'))
@section('header', __('Edit Subscription'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Edit Subscription')"
        :description="$subscription->member->user->name . ' — ' . $subscription->package->name"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.subscriptions.show', $subscription) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('View Details') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.subscriptions.update', $subscription) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Member') }}</label>
                    <p class="text-sm text-gym-text">{{ $subscription->member->user->name }} ({{ $subscription->member->user->email }})</p>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Package') }} *</label>
                    <select
                        name="package_id"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" @selected(old('package_id', $subscription->package_id) == $package->id)>{{ $package->name }} - {{ number_format($package->price, 2) }} KWD</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Start Date') . ' *'" type="date" name="start_date" :value="old('start_date', $subscription->start_date->format('Y-m-d'))" required />
                    <x-input :label="__('End Date') . ' *'" type="date" name="end_date" :value="old('end_date', $subscription->end_date->format('Y-m-d'))" required />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Status') }} *</label>
                        <select
                            name="status"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="pending" @selected(old('status', $subscription->status->value) === 'pending')>{{ __('Pending') }}</option>
                            <option value="active" @selected(old('status', $subscription->status->value) === 'active')>{{ __('Active') }}</option>
                            <option value="expired" @selected(old('status', $subscription->status->value) === 'expired')>{{ __('Expired') }}</option>
                            <option value="cancelled" @selected(old('status', $subscription->status->value) === 'cancelled')>{{ __('Cancelled') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Price Paid')" type="number" name="price_paid" :value="old('price_paid', $subscription->price_paid)" step="0.01" min="0" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Notes') }}</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('notes', $subscription->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.subscriptions.index') }}"
                        class="inline-flex items-center rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
                    >
                        {{ __('Cancel') }}
                    </a>
                    <x-button type="submit" variant="primary">{{ __('Update') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
