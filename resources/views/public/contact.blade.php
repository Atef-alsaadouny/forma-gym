@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-white">{{ __('Contact Us') }}</h1>
        <p class="mt-4 text-lg text-gym-muted">{{ __('Have a question? We\'d love to hear from you.') }}</p>

        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <x-card>
                <h3 class="font-semibold text-white">{{ __('Visit Us') }}</h3>
                <p class="mt-2 text-sm text-gym-muted">{{ __('Kuwait City, Kuwait') }}</p>
            </x-card>

            <x-card>
                <h3 class="font-semibold text-white">{{ __('Call Us') }}</h3>
                <p class="mt-2 text-sm text-gym-muted">+965 1234 5678</p>
            </x-card>

            <x-card>
                <h3 class="font-semibold text-white">{{ __('Email Us') }}</h3>
                <p class="mt-2 text-sm text-gym-muted">info@powergym.com</p>
            </x-card>

            <x-card>
                <h3 class="font-semibold text-white">{{ __('Hours') }}</h3>
                <p class="mt-2 text-sm text-gym-muted">{{ __('Mon-Sat: 6:00 AM - 11:00 PM') }}</p>
            </x-card>
        </div>
    </div>
@endsection
