@extends('layouts.admin')

@section('title', __('Edit Membership'))
@section('header', __('Edit Membership'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Edit Membership')"
        :description="$package->name"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.packages.show', $package) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('View Details') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <x-input :label="__('Name') . ' *'" name="name" :value="old('name', $package->name)" required
                    :placeholder="__('e.g. Gold Membership')" />

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Description') }}</label>
                    <textarea
                        name="description"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Duration (days)') . ' *'" type="number" name="duration_days" :value="old('duration_days', $package->duration_days)" required min="1" />
                    <x-input :label="__('Price') . ' *'" type="number" name="price" :value="old('price', $package->price)" required step="0.01" min="0" />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Number of Sessions')" type="number" name="number_of_sessions" :value="old('number_of_sessions', $package->number_of_sessions)" min="1" :placeholder="__('Leave empty for unlimited')" />
                    <x-input :label="__('Sort Order')" type="number" name="sort_order" :value="old('sort_order', $package->sort_order)" min="0" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Features') }}</label>
                    <textarea
                        name="features"
                        rows="4"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                        placeholder="{{ __('One feature per line') }}"
                    >{{ old('features', $package->features ? implode("\n", $package->features) : '') }}</textarea>
                    <p class="mt-1 text-xs text-gym-muted">{{ __('Enter each feature on a new line.') }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="is_active"
                        id="is_active"
                        value="1"
                        {{ old('is_active', $package->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gym-border text-gym-primary focus:ring-gym-primary/20"
                    >
                    <label for="is_active" class="text-sm font-medium text-gym-text">{{ __('Active') }}</label>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.packages.index') }}"
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
