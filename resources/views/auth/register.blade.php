@extends('layouts.guest')

@section('content')
    <div class="mx-auto flex min-h-[80vh] max-w-md items-center px-4">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-white">{{ __('Create Account') }}</h1>
                <p class="mt-2 text-sm text-gym-muted">{{ __('Join Forma Gym today') }}</p>
            </div>

            <x-card>
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <x-input
                        :label="__('Name')"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <x-input
                        :label="__('Email')"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                    />

                    <x-input
                        :label="__('Phone')"
                        type="text"
                        name="phone"
                        :value="old('phone')"
                    />

                    <x-input
                        :label="__('Password')"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    />

                    <x-input
                        :label="__('Confirm Password')"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <x-button type="submit" variant="primary" class="w-full">
                        {{ __('Create Account') }}
                    </x-button>

                    <p class="text-center text-sm text-gym-muted">
                        {{ __('Already have an account?') }}
                        <a href="{{ route('login') }}" class="font-medium text-gym-primary-light hover:text-gym-primary">
                            {{ __('Sign in') }}
                        </a>
                    </p>
                </form>
            </x-card>
        </div>
    </div>
@endsection
