@extends('layouts.admin')

@section('title', __('Add Member'))
@section('header', __('Add Member'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Add Member')"
        :description="__('Create a new member profile.')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.members.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('Back to Members') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.members.store') }}" class="space-y-6">
                @csrf

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('First Name') . ' *'" name="first_name" :value="old('first_name')" required />
                    <x-input :label="__('Last Name') . ' *'" name="last_name" :value="old('last_name')" required />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Email') . ' *'" type="email" name="email" :value="old('email')" required />
                    <x-input :label="__('Phone')" type="text" name="phone" :value="old('phone')" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Gender') }}</label>
                        <select
                            name="gender"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="">{{ __('Select') }}</option>
                            <option value="male" @selected(old('gender') === 'male')>{{ __('Male') }}</option>
                            <option value="female" @selected(old('gender') === 'female')>{{ __('Female') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Date of Birth')" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Emergency Contact')" name="emergency_contact" :value="old('emergency_contact')" />
                    <x-input :label="__('Emergency Phone')" name="emergency_phone" :value="old('emergency_phone')" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Joined Date')" type="date" name="joined_at" :value="old('joined_at', date('Y-m-d'))" />
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
                        href="{{ route('admin.members.index') }}"
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
