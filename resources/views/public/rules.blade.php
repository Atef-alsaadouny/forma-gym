@extends('layouts.base')

@section('title', __('messages.rules_title') . ' - ' . config('app.name', 'Forma Gym'))

@section('meta_description', __('messages.rules_description'))

@section('body')
    <div class="relative min-h-screen flex flex-col"
        style="background-image: url('{{ asset('images/gym-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-gym-dark/70 via-gym-dark/40 to-gym-dark/70"></div>

        <div class="wall-logo" style="position:absolute;right:11%;top:19%;transform:translateY(-50%);z-index:5;pointer-events:none;opacity:52%;">
            <span style="font-family:sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:3px;color:#8BC53F;text-shadow:0 0 7px #8BC53F,0 0 14px #8BC53F,0 0 28px #8BC53F,0 0 56px #8BC53F;">FORMA GYM</span>
        </div>

        <div class="relative z-10 flex flex-1 items-center justify-center px-4">
            <div class="mx-auto w-full max-w-sm">
                <div class="glass-card backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl p-6 sm:p-8 shadow-2xl">
                    <div class="mb-6 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-gym-primary/20">
                            <svg class="h-6 w-6 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('messages.rules_title') }}</h1>
                        <p class="mt-1 text-sm text-white/40">{{ __('messages.rules_subtitle') }}</p>
                    </div>

                    <div class="space-y-3">
                        {{-- Freeze Policy --}}
                        <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gym-primary/10">
                                    <svg class="h-5 w-5 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-white">{{ __('messages.rules_freeze_title') }}</h2>
                                    <p class="mt-1 text-sm leading-relaxed text-white/50">
                                        {{ __('messages.rules_freeze_desc') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Dress Code --}}
                        <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gym-primary/10">
                                    <svg class="h-5 w-5 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-sm font-bold text-white">{{ __('messages.rules_dress_title') }}</h2>
                                    <ul class="mt-2 space-y-2">
                                        @foreach ([
                                            __('messages.rules_dress_1'),
                                            __('messages.rules_dress_2'),
                                            __('messages.rules_dress_3'),
                                            __('messages.rules_dress_4'),
                                            __('messages.rules_dress_5'),
                                            __('messages.rules_dress_6'),
                                        ] as $rule)
                                        <li class="flex items-start gap-2">
                                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-gym-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                            <span class="text-sm leading-relaxed text-white/50">{{ __($rule) }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-gym-primary px-8 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25 active:scale-95">
                            <svg class="h-4 w-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            {{ __('messages.back_to_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
