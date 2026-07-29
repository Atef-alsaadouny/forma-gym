@extends('layouts.admin')

@section('title', __('Trainers'))
@section('header', __('Trainers'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Trainers')"
        :description="__('Manage all gym trainers.')"
    >
        <x-slot:actions>
            @can('create', App\Models\Trainer::class)
                <x-dashboard.action-button
                    variant="primary"
                    href="{{ route('admin.trainers.create') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Trainer') }}
                </x-dashboard.action-button>
            @endcan
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mb-6 rounded-xl border border-gym-border bg-gym-card p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.trainers.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by name or email...') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-dark px-3 py-2 text-sm text-white shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <select
                    name="status"
                    class="block w-full rounded-lg border border-gym-border bg-gym-dark px-3 py-2 text-sm text-white shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="active" @selected(request('status') === 'active')>{{ __('Active') }}</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>{{ __('Inactive') }}</option>
                    <option value="suspended" @selected(request('status') === 'suspended')>{{ __('Suspended') }}</option>
                </select>
            </div>
            <x-button type="submit" variant="primary" size="md">{{ __('Search') }}</x-button>
            @if(request()->hasAny(['search', 'status', 'specialization']))
                <a href="{{ route('admin.trainers.index') }}" class="text-sm text-gym-muted hover:text-white">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <x-dashboard.data-table
        :headers="[__('Name'), __('Email'), __('Specialization'), __('Experience'), __('Status'), __('Actions')]"
        :rows="$trainers->map(fn ($trainer) => [
            $trainer->user->name,
            $trainer->user->email,
            $trainer->specialization ?? '—',
            $trainer->experience_years ? $trainer->experience_years . ' ' . __('years experience') : '—',
            view('components.badge', [
                'variant' => $trainer->status?->badgeVariant() ?? 'default',
                'slot' => $trainer->status?->label() ?? 'Unknown',
            ])->render(),
            view('admin.trainers._actions', ['trainer' => $trainer])->render(),
        ])->toArray()"
        :empty="false"
    >
        <x-slot:emptyTitle>{{ __('No trainers found') }}</x-slot>
        <x-slot:emptyMessage>
            @if(request()->hasAny(['search', 'status']))
                {{ __('Try adjusting your search or filter.') }}
            @else
                {{ __('No trainers have been added yet.') }}
            @endif
        </x-slot>
    </x-dashboard.data-table>

    @if($trainers->hasPages())
        <div class="mt-6">
            {{ $trainers->links() }}
        </div>
    @endif
@endsection
