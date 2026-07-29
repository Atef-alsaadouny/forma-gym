@extends('layouts.admin')

@section('title', __('Edit Member'))
@section('header', __('Edit Member'))

@section('admin-content')
    @php
        $nameParts = explode(' ', $member->user->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
    @endphp

    <x-dashboard.page-header
        :title="__('Edit Member')"
        :description="__('Editing') . ' ' . $member->user->name"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.members.show', $member) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('View Profile') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.members.update', $member) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('First Name') . ' *'" name="first_name" :value="old('first_name', $firstName)" required />
                    <x-input :label="__('Last Name') . ' *'" name="last_name" :value="old('last_name', $lastName)" required />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Email') . ' *'" type="email" name="email" :value="old('email', $member->user->email)" required />
                    <x-input :label="__('Phone')" type="text" name="phone" :value="old('phone', $member->user->phone)" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Gender') }}</label>
                        <select
                            name="gender"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="">{{ __('Select') }}</option>
                            <option value="male" @selected(old('gender', $member->gender) === 'male')>{{ __('Male') }}</option>
                            <option value="female" @selected(old('gender', $member->gender) === 'female')>{{ __('Female') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Date of Birth')" type="date" name="date_of_birth" :value="old('date_of_birth', $member->date_of_birth?->format('Y-m-d'))" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Status') }}</label>
                        <select
                            name="status"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="active" @selected(old('status', $member->status?->value) === 'active')>{{ __('Active') }}</option>
                            <option value="inactive" @selected(old('status', $member->status?->value) === 'inactive')>{{ __('Inactive') }}</option>
                            <option value="suspended" @selected(old('status', $member->status?->value) === 'suspended')>{{ __('Suspended') }}</option>
                            <option value="expired" @selected(old('status', $member->status?->value) === 'expired')>{{ __('Expired') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Joined Date')" type="date" name="joined_at" :value="old('joined_at', $member->joined_at?->format('Y-m-d'))" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Emergency Contact')" name="emergency_contact" :value="old('emergency_contact', $member->emergency_contact)" />
                    <x-input :label="__('Emergency Phone')" name="emergency_phone" :value="old('emergency_phone', $member->emergency_phone)" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Notes') }}</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('notes', $member->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.members.index') }}"
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
