@extends('layouts.admin')

@section('title', __('Add Trainer'))
@section('header', __('Add Trainer'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Add Trainer')"
        :description="__('Create a new trainer profile.')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.trainers.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-card px-4 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors"
            >
                {{ __('Back to Trainers') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.trainers.store') }}" class="space-y-6" enctype="multipart/form-data">
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

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <x-input :label="__('Specialization')" name="specialization" :value="old('specialization')" />
                    </div>
                    <x-input :label="__('Experience (years)')" type="number" name="experience_years" :value="old('experience_years')" min="0" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Bio') }}</label>
                    <textarea
                        name="bio"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('bio') }}</textarea>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Certifications') }}</label>
                    <input
                        type="text"
                        name="certifications"
                        value="{{ old('certifications') }}"
                        placeholder="{{ __('Comma-separated list') }}"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Profile Photo') }}</label>
                        <input
                            type="file"
                            name="profile_photo"
                            accept="image/jpeg,image/png,image/webp"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors file:ms-0 file:me-3 file:rounded file:border-0 file:bg-gym-primary file:px-3 file:py-1 file:text-sm file:font-medium file:text-white focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                        <p class="mt-1 text-xs text-gym-muted">JPEG, PNG, or WebP. Max 2MB.</p>
                    </div>
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
                        href="{{ route('admin.trainers.index') }}"
                        class="inline-flex items-center rounded-lg border border-gym-border bg-gym-card px-4 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors"
                    >
                        {{ __('Cancel') }}
                    </a>
                    <x-button type="submit" variant="primary">{{ __('Save') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
