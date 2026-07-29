@extends('layouts.admin')

@section('title', __('Edit Trainer'))
@section('header', __('Edit Trainer'))

@section('admin-content')
    @php
        $nameParts = explode(' ', $trainer->user->name, 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';
    @endphp

    <x-dashboard.page-header
        :title="__('Edit Trainer')"
        :description="__('Editing') . ' ' . $trainer->user->name"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.trainers.show', $trainer) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-card px-4 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors"
            >
                {{ __('View Profile') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.trainers.update', $trainer) }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('First Name') . ' *'" name="first_name" :value="old('first_name', $firstName)" required />
                    <x-input :label="__('Last Name') . ' *'" name="last_name" :value="old('last_name', $lastName)" required />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Email') . ' *'" type="email" name="email" :value="old('email', $trainer->user->email)" required />
                    <x-input :label="__('Phone')" type="text" name="phone" :value="old('phone', $trainer->user->phone)" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Gender') }}</label>
                        <select
                            name="gender"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="">{{ __('Select') }}</option>
                            <option value="male" @selected(old('gender', $trainer->gender) === 'male')>{{ __('Male') }}</option>
                            <option value="female" @selected(old('gender', $trainer->gender) === 'female')>{{ __('Female') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Date of Birth')" type="date" name="date_of_birth" :value="old('date_of_birth', $trainer->date_of_birth?->format('Y-m-d'))" />
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="sm:col-span-2">
                        <x-input :label="__('Specialization')" name="specialization" :value="old('specialization', $trainer->specialization)" />
                    </div>
                    <x-input :label="__('Experience (years)')" type="number" name="experience_years" :value="old('experience_years', $trainer->experience_years)" min="0" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Bio') }}</label>
                    <textarea
                        name="bio"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('bio', $trainer->bio) }}</textarea>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Certifications') }}</label>
                    <input
                        type="text"
                        name="certifications"
                        value="{{ old('certifications', is_array($trainer->certifications) ? implode(', ', $trainer->certifications) : $trainer->certifications) }}"
                        placeholder="{{ __('Comma-separated list') }}"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Status') }}</label>
                        <select
                            name="status"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="active" @selected(old('status', $trainer->status?->value) === 'active')>{{ __('Active') }}</option>
                            <option value="inactive" @selected(old('status', $trainer->status?->value) === 'inactive')>{{ __('Inactive') }}</option>
                            <option value="suspended" @selected(old('status', $trainer->status?->value) === 'suspended')>{{ __('Suspended') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Joined Date')" type="date" name="joined_at" :value="old('joined_at', $trainer->joined_at?->format('Y-m-d'))" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Available') }}</label>
                        <select
                            name="is_available"
                            class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        >
                            <option value="1" @selected(old('is_available', $trainer->is_available))>{{ __('Yes') }}</option>
                            <option value="0" @selected(!old('is_available', $trainer->is_available))>{{ __('No') }}</option>
                        </select>
                    </div>
                    <x-input :label="__('Rating') . ' (0-5)'" type="number" name="rating" :value="old('rating', $trainer->rating)" step="0.1" min="0" max="5" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Profile Photo') }}</label>
                    @if($trainer->profile_photo_path)
                        <div class="mb-2">
                            <img
                                src="{{ Storage::url($trainer->profile_photo_path) }}"
                                alt="{{ $trainer->user->name }}"
                                class="h-20 w-20 rounded-full object-cover"
                            >
                        </div>
                    @endif
                    <input
                        type="file"
                        name="profile_photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors file:ms-0 file:me-3 file:rounded file:border-0 file:bg-gym-primary file:px-3 file:py-1 file:text-sm file:font-medium file:text-white focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >
                    <p class="mt-1 text-xs text-gym-muted">JPEG, PNG, or WebP. Max 2MB. {{ __('Leave empty to keep current photo.') }}</p>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Notes') }}</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('notes', $trainer->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.trainers.index') }}"
                        class="inline-flex items-center rounded-lg border border-gym-border bg-gym-card px-4 py-2 text-sm font-medium text-gym-muted hover:bg-gym-dark-hover transition-colors"
                    >
                        {{ __('Cancel') }}
                    </a>
                    <x-button type="submit" variant="primary">{{ __('Update') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
