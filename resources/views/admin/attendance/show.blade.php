@extends('layouts.admin')

@section('title', __('Attendance Record'))
@section('header', __('Attendance Record'))

@section('admin-content')
    <x-dashboard.page-header
        :title="__('Attendance Record')"
        :description="($attendance->member?->user?->name ?? '—') . ' — ' . $attendance->date->format('Y-m-d')"
    >
        <x-slot:actions>
            @can('update', $attendance)
                @if(!$attendance->checked_out_at)
                    <form
                        method="POST"
                        action="{{ route('admin.attendance.check-out', $attendance) }}"
                        class="inline"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-gym-warning text-white hover:opacity-90 transition-colors"
                        >
                            {{ __('Check Out') }}
                        </button>
                    </form>
                @endif
                <a
                    href="{{ route('admin.attendance.edit', $attendance) }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-gym-primary px-4 py-2 text-sm font-medium text-white hover:bg-gym-primary-hover transition-colors"
                >
                    {{ __('Edit') }}
                </a>
            @endcan
            <a
                href="{{ route('admin.attendance.index') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-gym-border bg-gym-white px-4 py-2 text-sm font-medium text-gym-text hover:bg-gym-light transition-colors"
            >
                {{ __('Back to Attendance') }}
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1 space-y-6">
            <x-card>
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gym-primary/10 text-2xl font-bold text-gym-primary">
                        {{ substr($attendance->member?->user?->name ?? '—', 0, 2) }}
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-gym-text">{{ $attendance->member?->user?->name ?? '—' }}</h2>
                    <p class="text-sm text-gym-muted">{{ $attendance->member?->user?->email ?? '—' }}</p>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Session Details') }}</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('Date') }}</p>
                        <p class="mt-1 text-lg font-bold text-gym-text">{{ $attendance->date->format('Y-m-d') }}</p>
                    </div>
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('Check In') }}</p>
                        <p class="mt-1 text-lg font-bold text-gym-text">{{ $attendance->checked_in_at->format('H:i') }}</p>
                    </div>
                    <div class="rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('Check Out') }}</p>
                        @if($attendance->checked_out_at)
                            <p class="mt-1 text-lg font-bold text-gym-text">{{ $attendance->checked_out_at->format('H:i') }}</p>
                        @else
                            <p class="mt-1 text-lg font-bold text-gym-primary">{{ __('Active') }}</p>
                        @endif
                    </div>
                </div>
                @if($attendance->checked_out_at)
                    <div class="mt-4 rounded-lg border border-gym-border bg-gym-light p-4 text-center">
                        <p class="text-sm text-gym-muted">{{ __('Duration') }}</p>
                        <p class="mt-1 text-lg font-bold text-gym-text">{{ $attendance->checked_in_at->diffInMinutes($attendance->checked_out_at) }} {{ __('min') }}</p>
                    </div>
                @endif
            </x-card>

            @if($attendance->notes)
                <x-card>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-gym-muted">{{ __('Notes') }}</h3>
                    <p class="mt-2 text-sm text-gym-text">{{ $attendance->notes }}</p>
                </x-card>
            @endif
        </div>
    </div>
@endsection
