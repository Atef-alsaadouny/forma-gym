@extends('layouts.guest')

@section('content')
    <div class="mx-auto flex min-h-[80vh] max-w-md items-center px-4">
        <div class="w-full">
            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-white">{{ __('Reset Password') }}</h1>
                <p class="mt-2 text-sm text-gym-muted">{{ __('Enter your new password.') }}</p>
            </div>

            <x-card>
                <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-input
                        :label="__('Email')"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required
                        autofocus
                        autocomplete="username"
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
                        {{ __('Reset Password') }}
                    </x-button>
                </form>
            </x-card>
        </div>
    </div>
@endsection
