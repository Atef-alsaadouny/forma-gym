@extends('layouts.base')

@section('title', __('messages.lookup_title') . ' - ' . config('app.name', 'Forma Gym'))

@section('meta_description', __('messages.lookup_description'))

@section('body')
    <div class="relative flex min-h-screen flex-col"
        style="background-image: url('{{ asset('images/gym-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-gym-dark/70 via-gym-dark/40 to-gym-dark/70"></div>

        <div class="wall-logo" style="position:absolute;right:11%;top:19%;transform:translateY(-50%);z-index:5;pointer-events:none;opacity:52%;">
            <span style="font-family:sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:3px;color:#8BC53F;text-shadow:0 0 7px #8BC53F,0 0 14px #8BC53F,0 0 28px #8BC53F,0 0 56px #8BC53F;">FORMA GYM</span>
        </div>

        <div class="relative z-10 flex flex-1 items-center justify-center px-4">
            <div class="mx-auto w-full max-w-[320px]">
                @if (!empty($success) && isset($booking))
                    @include('public.booking-confirmation')
                @else
                    <div id="lookup-form"
                        class="glass-card content-fade-in backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl p-6 sm:p-8 shadow-2xl">
                        <div class="mb-6 text-center">
                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-gym-primary/20">
                                <svg class="h-6 w-6 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold text-white">{{ __('messages.lookup_title') }}</h1>
                            <p class="mt-1 text-sm text-white/40">{{ __('messages.lookup_subtitle') }}</p>
                        </div>

                        <form method="POST" action="{{ route('subscription.lookup.store') }}" novalidate>
                            @csrf

                            <div class="space-y-4">
                                <div>
                                    <input type="text" id="booking_ref" name="booking_ref"
                                        value="{{ old('booking_ref') }}" required
                                        dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
                                        class="input-field w-full rounded-xl border border-white/5 bg-white/5 px-3 py-2.5 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-white placeholder-white/50 backdrop-blur-sm transition-all duration-200 focus:border-gym-primary focus:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gym-primary/40"
                                        placeholder="{{ __('messages.lookup_ref_placeholder') }}"
                                        oninvalid="this.setCustomValidity(document.documentElement.dir === 'rtl' ? 'هذا الحقل مطلوب' : 'This field is required')"
                                        oninput="this.setCustomValidity('')">
                                    @error('booking_ref')
                                        <p class="error-message mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <input type="tel" id="phone" name="phone"
                                        value="{{ old('phone') }}" required dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
                                        class="input-field w-full rounded-xl border border-white/5 bg-white/5 px-3 py-2.5 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-white placeholder-white/50 backdrop-blur-sm transition-all duration-200 focus:border-gym-primary focus:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gym-primary/40"
                                        placeholder="{{ __('messages.lookup_phone_placeholder') }}"
                                        oninvalid="this.setCustomValidity(document.documentElement.dir === 'rtl' ? 'هذا الحقل مطلوب' : 'This field is required')"
                                        oninput="normalizePhone(this); this.setCustomValidity('')">
                                    @error('phone')
                                        <p class="error-message mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="submit-btn w-full rounded-xl bg-gym-primary px-6 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25">
                                    {{ __('messages.lookup_btn') }}
                                </button>
                            </div>
                        </form>

                        @if (!empty($error))
                            <div class="error-message mt-4 rounded-xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-center text-sm text-red-400">
                                {{ $error }}
                            </div>
                        @endif

                        <div class="mt-6 text-center">
                            <a href="{{ route('home') }}" class="text-sm text-white/30 transition-all duration-200 hover:text-white/50">
                                {{ __('messages.lookup_back_home') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="preload" href="{{ asset('images/gym-reg.jpg') }}" as="image">
    @endpush

    @push('scripts')
    <script>
        function normalizePhone(input) {
            const arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            const english = ['0','1','2','3','4','5','6','7','8','9'];
            let val = input.value;
            arabic.forEach((a, i) => { val = val.replace(new RegExp(a, 'g'), english[i]); });
            if (val !== input.value) input.value = val;
        }

        document.querySelectorAll('.input-field').forEach(function(input) {
            input.addEventListener('focus', function() {
                var wrapper = this.closest('div');
                if (wrapper) {
                    var err = wrapper.querySelector('.error-message');
                    if (err) err.remove();
                }
                this.classList.remove('border-red-500/50');

                var card = document.getElementById('lookup-form');
                if (card) {
                    var generalErr = card.querySelector(':scope > .error-message');
                    if (generalErr) generalErr.remove();
                }
            });
        });
    </script>
    @endpush
@endsection
