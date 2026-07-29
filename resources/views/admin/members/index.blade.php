@extends('layouts.admin')

@section('title', __('Members'))
@section('header', __('Members'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Members')"
        :description="__('Manage all gym members.')"
    >
        <x-slot:actions>
            @can('create', App\Models\Member::class)
                <x-dashboard.action-button
                    variant="primary"
                    href="{{ route('admin.members.create') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Member') }}
                </x-dashboard.action-button>
            @endcan
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mb-6 rounded-xl border border-gym-border bg-gym-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.members.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by name or email...') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <select
                    name="status"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="active" @selected(request('status') === 'active')>{{ __('Active') }}</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>{{ __('Inactive') }}</option>
                    <option value="suspended" @selected(request('status') === 'suspended')>{{ __('Suspended') }}</option>
                    <option value="expired" @selected(request('status') === 'expired')>{{ __('Expired') }}</option>
                </select>
            </div>
            <x-button type="submit" variant="primary" size="md">{{ __('Search') }}</x-button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.members.index') }}" class="text-sm text-gym-muted hover:text-gym-text">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <x-dashboard.data-table
        :headers="[__('Name'), __('Email'), __('Phone'), __('Status'), __('Joined Date'), __('Actions')]"
        :rows="$members->map(fn ($member) => [
            $member->user->name,
            $member->user->email,
            $member->user->phone ?? '—',
            view('components.badge', [
                'variant' => $member->status?->badgeVariant() ?? 'default',
                'slot' => $member->status?->label() ?? 'Unknown',
            ])->render(),
            $member->joined_at?->format('Y-m-d') ?? '—',
            view('admin.members._actions', ['member' => $member])->render(),
        ])->toArray()"
        :empty="false"
    >
        <x-slot:emptyTitle>{{ __('No members found') }}</x-slot>
        <x-slot:emptyMessage>
            @if(request()->hasAny(['search', 'status']))
                {{ __('Try adjusting your search or filter.') }}
            @else
                {{ __('No members have been added yet.') }}
            @endif
        </x-slot>
    </x-dashboard.data-table>

    @if($members->hasPages())
        <div class="mt-6">
            {{ $members->links() }}
        </div>
    @endif
@endsection
