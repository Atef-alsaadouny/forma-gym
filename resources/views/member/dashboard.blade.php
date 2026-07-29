@extends('layouts.auth')

@section('title', __('Dashboard'))
@section('header', __('Dashboard'))

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-white">{{ __('Welcome, :name!', ['name' => auth()->user()->name]) }}</h2>
            <p class="mt-1 text-sm text-gym-muted">{{ __("Here's your fitness overview.") }}</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <x-dashboard.stats-card
                :label="__('Membership')"
                :value="__('Active')"
                icon="credit-card"
                color="success"
            />

            <x-dashboard.stats-card
                :label="__('Attendance')"
                :value="__('0 this month')"
                icon="clipboard-check"
                color="info"
            />

            <x-dashboard.stats-card
                :label="__('Workout Plan')"
                :value="__('Not assigned')"
                icon="collection"
                color="warning"
            />
        </div>

        <x-card>
            <div class="text-center">
                <x-empty-state
                    :title="__('Welcome to Forma Gym')"
                    :message="__('Your dashboard will show your subscription, attendance, and workout progress once you start your journey.')"
                />
            </div>
        </x-card>
    </div>
@endsection
