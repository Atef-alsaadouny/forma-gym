@extends('layouts.guest')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-white">{{ __('About Forma Gym') }}</h1>
        <p class="mt-4 text-lg text-gym-muted">
            {{ __('Forma Gym is a premium fitness facility dedicated to helping you achieve your health and wellness goals. With state-of-the-art equipment, expert trainers, and a motivating environment, we provide everything you need for a successful fitness journey.') }}
        </p>
        <div class="mt-8 space-y-4 text-gym-muted">
            <p>{{ __('Founded in Kuwait, we have been committed to providing the best fitness experience for our members. Our team of certified trainers brings years of experience and passion to every session.') }}</p>
            <p>{{ __('We believe that fitness is not just about looking good; it is about feeling strong, healthy, and confident. Whether you are a beginner or an experienced athlete, we have the programs and support to help you succeed.') }}</p>
        </div>
    </div>
@endsection
