@extends('layouts.admin')

@section('title', __('Check In Member'))
@section('header', __('Check In Member'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Check In Member')"
        :description="__('Record a member check-in.')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.attendance.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('Back to Attendance') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.attendance.store') }}" class="space-y-6">
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

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Date')" type="date" name="date" :value="old('date', date('Y-m-d'))" />
                    <x-input :label="__('Check In Time')" name="checked_in_at" :value="old('checked_in_at', date('Y-m-d H:i:s'))" :placeholder="'YYYY-MM-DD HH:MM:SS'" />
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
                        href="{{ route('admin.attendance.index') }}"
                        class="inline-flex items-center rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
                    >
                        {{ __('Cancel') }}
                    </a>
                    <x-button type="submit" variant="primary">{{ __('Check In') }}</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
