@extends('layouts.guest')

@section('content')
    <div class="mx-auto flex min-h-[80vh] max-w-md items-center px-4">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-white">{{ __('Forgot Password') }}</h1>
                <p class="mt-2 text-sm text-gym-muted">{{ __('No worries. We\'ll send you a reset link.') }}</p>
            </div>

            <x-card>
                @if (session('status'))
                    <x-alert variant="success" class="mb-4">
                        {{ session('status') }}
                    </x-alert>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <x-input
                        :label="__('Email')"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                    />

                    <x-button type="submit" variant="primary" class="w-full">
                        {{ __('Send Reset Link') }}
                    </x-button>

                    <p class="text-center text-sm text-gym-muted">
                        <a href="{{ route('login') }}" class="font-medium text-gym-primary-light hover:text-gym-primary">
                            {{ __('Back to login') }}
                        </a>
                    </p>
                </form>
            </x-card>
        </div>
    </div>
@endsection
