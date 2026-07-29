@extends('layouts.admin')

@section('title', __('Add Subscription'))
@section('header', __('Add Subscription'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Add Subscription')"
        :description="__('Create a new subscription for a member.')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('Back to Subscriptions') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.subscriptions.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Member') }} *</label>
                    <select
                        name="member_id"
                        required
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                        <option value="">{{ __('Select a member...') }}</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" @selected(old('member_id') == $member->id)>{{ $member->user->name }} ({{ $member->user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Package') }} *</label>
                    <select
                        name="package_id"
                        required
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                        <option value="">{{ __('Select a package...') }}</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" @selected(old('package_id') == $package->id)>{{ $package->name }} - {{ number_format($package->price, 2) }} KWD</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Start Date') . ' *'" type="date" name="start_date" :value="old('start_date', date('Y-m-d'))" required />
                    <x-input :label="__('End Date') . ' *'" type="date" name="end_date" :value="old('end_date')" required />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Status') }} *</label>
                        <select
                            name="status"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="pending" @selected(old('status', 'pending') === 'pending')>{{ __('Pending') }}</option>
                            <option value="active" @selected(old('status') === 'active')>{{ __('Active') }}</option>
                            <option value="expired" @selected(old('status') === 'expired')>{{ __('Expired') }}</option>
                            <option value="cancelled" @selected(old('status') === 'cancelled')>{{ __('Cancelled') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Price Paid')" type="number" name="price_paid" :value="old('price_paid')" step="0.01" min="0" :placeholder="__('Leave empty for package price')" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Notes') }}</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.subscriptions.index') }}"
                        class="inline-flex items-center rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
                    >
                        {{ __('Cancel') }}
                    </a>
                    <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
