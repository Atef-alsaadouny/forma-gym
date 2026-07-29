@extends('layouts.admin')

@section('title', __('Edit Attendance Record'))
@section('header', __('Edit Attendance Record'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Edit Attendance Record')"
        :description="($attendance->member?->user?->name ?? '—') . ' — ' . $attendance->date->format('Y-m-d')"
    >
        <x-slot:actions>
            <a
                href="{{ route('admin.attendance.show', $attendance) }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('View Details') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="mx-auto max-w-2xl">
        <x-card>
            <form method="POST" action="{{ route('admin.attendance.update', $attendance) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Member') }}</label>
                    <p class="text-sm text-gym-text">{{ $attendance->member?->user?->name ?? '—' }} ({{ $attendance->member?->user?->email ?? '—' }})</p>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Date') }}</label>
                    <p class="text-sm text-gym-text">{{ $attendance->date->format('Y-m-d') }}</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-input :label="__('Check In Time') . ' *'" name="checked_in_at" :value="old('checked_in_at', $attendance->checked_in_at->format('Y-m-d H:i:s'))" :placeholder="'YYYY-MM-DD HH:MM:SS'" />
                    <x-input :label="__('Check Out Time')" name="checked_out_at" :value="old('checked_out_at', $attendance->checked_out_at?->format('Y-m-d H:i:s'))" :placeholder="'YYYY-MM-DD HH:MM:SS'" />
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-gym-text">{{ __('Notes') }}</label>
                    <textarea
                        name="notes"
                        rows="3"
                        class="block w-full rounded-lg border border-gym-border bg-gym-white px-3 py-2 text-sm text-gym-text shadow-sm transition-colors placeholder:text-gym-muted focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/20 focus:ring-offset-0"
                    >{{ old('notes', $attendance->notes) }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('admin.attendance.index') }}"
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
