@extends('layouts.base')

@section('title', __('Offline') . ' - ' . config('app.name', 'Forma Gym'))

@section('body')
<div class="flex min-h-screen flex-col items-center justify-center bg-gym-dark px-4 text-center">
    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gym-primary/10 mb-6">
        <svg class="h-8 w-8 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m-2.829-2.829a5 5 0 000-7.07m-4.243 4.243a1 1 0 010-1.414m-4.243 4.243a9 9 0 010-12.728"/>
        </svg>
    </div>
    <h1 class="text-2xl font-bold text-white mb-2">{{ __('You are offline') }}</h1>
    <p class="text-gym-muted max-w-sm">{{ __('Please check your internet connection and try again.') }}</p>
    <a href="{{ route('home') }}" class="mt-6 rounded-xl bg-gym-primary px-6 py-3 font-semibold text-white transition-colors hover:bg-gym-primary-hover">
        {{ __('Try again') }}
    </a>
</div>
@endsection
