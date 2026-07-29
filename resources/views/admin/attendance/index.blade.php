@extends('layouts.admin')

@section('title', __('Attendance'))
@section('header', __('Attendance'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Attendance')"
        :description="__('Track member check-ins and check-outs.')"
    >
        <x-slot:actions>
            @can('create', App\Models\AttendanceRecord::class)
                <x-dashboard.action-button
                    variant="primary"
                    href="{{ route('admin.attendance.create') }}"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Check In Member') }}
                </x-dashboard.action-button>
            @endcan
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mb-6 rounded-xl border border-gym-border bg-gym-white p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.attendance.index') }}" class="flex flex-col gap-4 sm:flex-row sm:items-end">
            <div class="flex-1">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search by member name or email...') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <input
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    placeholder="{{ __('From') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <input
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    placeholder="{{ __('To') }}"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
            </div>
            <div class="w-full sm:w-40">
                <select
                    name="checked_in"
                    class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                >
                    <option value="">{{ __('All') }}</option>
                    <option value="1" @selected(request('checked_in') === '1')>{{ __('Checked In') }}</option>
                    <option value="0" @selected(request('checked_in') === '0')>{{ __('Checked Out') }}</option>
                </select>
            </div>
            <x-button type="submit" variant="primary" size="md">{{ __('Search') }}</x-button>
            @if(request()->hasAny(['search', 'date_from', 'date_to', 'checked_in']))
                <a href="{{ route('admin.attendance.index') }}" class="text-sm text-gym-muted hover:text-gym-text">{{ __('Clear') }}</a>
            @endif
        </form>
    </div>

    <x-dashboard.data-table
        :headers="[__('Member'), __('Date'), __('Check In'), __('Check Out'), __('Duration'), __('Actions')]"
        :rows="$records->map(fn ($record) => [
            $record->member?->user?->name ?? '—',
            $record->date->format('Y-m-d'),
            $record->checked_in_at->format('H:i'),
            $record->checked_out_at?->format('H:i') ?? __('Active'),
            $record->checked_out_at
                ? $record->checked_in_at->diffInMinutes($record->checked_out_at) . ' ' . __('min')
                : '—',
            view('admin.attendance._actions', ['record' => $record])->render(),
        ])->toArray()"
        :empty="false"
    >
        <x-slot:emptyTitle>{{ __('No attendance records found') }}</x-slot>
        <x-slot:emptyMessage>
            @if(request()->hasAny(['search', 'date_from', 'date_to', 'checked_in']))
                {{ __('Try adjusting your search or filter.') }}
            @else
                {{ __('No attendance records have been added yet.') }}
            @endif
        </x-slot>
    </x-dashboard.data-table>

    @if($records->hasPages())
        <div class="mt-6">
            {{ $records->links() }}
        </div>
    @endif
@endsection
