@extends('layouts.guest')

@section('content')
    <div class="mx-auto flex min-h-[80vh] max-w-md items-center px-4">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-white">{{ __('Welcome Back') }}</h1>
                <p class="mt-2 text-sm text-gym-muted">{{ __('Sign in to your account') }}</p>
            </div>

            <x-card>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <x-input
                        :label="__('Email')"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <x-input
                        :label="__('Password')"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    />

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gym-muted">
                            <input type="checkbox" name="remember" class="rounded border-gym-border bg-gym-card text-gym-primary focus:ring-gym-primary/20">
                            {{ __('Remember me') }}
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-gym-primary-light hover:text-gym-primary">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <x-button type="submit" variant="primary" class="w-full">
                        {{ __('Sign In') }}
                    </x-button>

                    <p class="text-center text-sm text-gym-muted">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}" class="font-medium text-gym-primary-light hover:text-gym-primary">
                            {{ __('Register') }}
                        </a>
                    </p>
                </form>
            </x-card>
        </div>
    </div>
@endsection
