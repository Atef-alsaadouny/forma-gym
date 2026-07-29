@extends('layouts.admin')

@section('title', __('Memberships'))
@section('header', __('Memberships'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Memberships')"
        :description="__('Manage membership plans and pricing.')"
    >
        <x-slot:actions>
            @can('create', App\Models\Package::class)
                <x-dashboard.action-button
                    variant="primary"
                    href="{{ route('admin.packages.create') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Membership') }}
                </x-dashboard.action-button>
            @endcan
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mb-6 rounded-xl border border-gym-border bg-gym-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.packages.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by name...') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <select
                    name="is_active"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="1" @selected(request('is_active') === '1')>{{ __('Active') }}</option>
                    <option value="0" @selected(request('is_active') === '0')>{{ __('Inactive') }}</option>
                </select>
            </div>
            <x-button type="submit" variant="primary" size="md">{{ __('Search') }}</x-button>
            @if(request()->hasAny(['search', 'is_active']))
                <a href="{{ route('admin.packages.index') }}" class="text-sm text-gym-muted hover:text-gym-text">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <x-dashboard.data-table
        :headers="[__('Name'), __('Duration'), __('Price'), __('Sessions'), __('Status'), __('Actions')]"
        :rows="$packages->map(fn ($package) => [
            $package->name,
            __(':days days', ['days' => $package->duration_days]),
            number_format($package->price, 2) . ' KWD',
            $package->number_of_sessions ?: __('Unlimited'),
            view('components.badge', [
                'variant' => $package->is_active ? 'success' : 'default',
                'slot' => $package->is_active ? __('Active') : __('Inactive'),
            ])->render(),
            view('admin.packages._actions', ['package' => $package])->render(),
        ])->toArray()"
        :empty="false"
    >
        <x-slot:emptyTitle>{{ __('No memberships found') }}</x-slot>
        <x-slot:emptyMessage>
            @if(request()->hasAny(['search', 'is_active']))
                {{ __('Try adjusting your search or filter.') }}
            @else
                {{ __('No memberships have been added yet.') }}
            @endif
        </x-slot>
    </x-dashboard.data-table>

    @if($packages->hasPages())
        <div class="mt-6">
            {{ $packages->links() }}
        </div>
    @endif
@endsection
