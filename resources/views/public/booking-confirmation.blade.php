@php
    $b = $booking;

    $planLabels = [
        'شهر' => __('messages.plan_month'),
        'شهرين' => __('messages.plan_2months'),
        '3 أشهر' => __('messages.plan_3months'),
        '6 أشهر' => __('messages.plan_6months'),
        'سنة' => __('messages.plan_year'),
    ];

    $trainerLabels = [
        'أحمد محمد' => __('messages.trainer_ahmed'),
        'سارة علي' => __('messages.trainer_sara'),
        'محمد حسن' => __('messages.trainer_mohamed'),
        'ليلى خالد' => __('messages.trainer_laila'),
    ];

    $planLabel = $planLabels[$b['plan_name']] ?? $b['plan_name'];
    $trainerLabel = isset($b['trainer_name']) ? ($trainerLabels[$b['trainer_name']] ?? $b['trainer_name']) : null;
@endphp

<div class="text-center">
    {{-- Main Glass Card --}}
    <div class="animate-fade-in-up glass-card backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl p-5 sm:p-6 shadow-2xl">
        {{-- Booking Reference Badge --}}
        <div class="mb-5 text-center">
            <p class="mb-1.5 text-xs text-white/30">{{ __('messages.booking_ref') }}</p>
            <div class="inline-flex items-center gap-2 rounded-xl bg-gym-primary/10 px-5 py-3">
                <span class="text-3xl font-bold tracking-[0.15em] text-gym-primary sm:text-4xl" dir="ltr">{{ $b['booking_ref'] }}</span>
            </div>
        </div>

        <div class="mb-5 border-t border-white/5"></div>

        {{-- Member Details --}}
        <div class="space-y-2 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
            @if (app()->getLocale() === 'ar')
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-sm font-medium text-white/70">{{ $b['name'] }}</span>
                    <span class="text-xs text-white/40">{{ __('messages.booking_name') }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-sm font-medium text-white/70" dir="ltr">+965 {{ $b['phone'] }}</span>
                    <span class="text-xs text-white/40">{{ __('messages.booking_phone') }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-sm font-medium text-white/70">{{ $planLabel }}</span>
                    <span class="text-xs text-white/40">{{ __('messages.booking_plan') }}</span>
                </div>
                @if ($trainerLabel)
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-sm font-medium text-white/70">{{ $trainerLabel }}</span>
                    <span class="text-xs text-white/40">{{ __('messages.booking_trainer') }}</span>
                </div>
                @endif
                @if ($b['locker'])
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-sm font-medium text-gym-primary/70">{{ __('messages.booking_yes') }}</span>
                    <span class="text-xs text-white/40">{{ __('messages.booking_locker') }}</span>
                </div>
                @endif
            @else
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-xs text-white/40">{{ __('messages.booking_name') }}</span>
                    <span class="text-sm font-medium text-white/70">{{ $b['name'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-xs text-white/40">{{ __('messages.booking_phone') }}</span>
                    <span class="text-sm font-medium text-white/70" dir="ltr">+965 {{ $b['phone'] }}</span>
                </div>
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-xs text-white/40">{{ __('messages.booking_plan') }}</span>
                    <span class="text-sm font-medium text-white/70">{{ $planLabel }}</span>
                </div>
                @if ($trainerLabel)
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-xs text-white/40">{{ __('messages.booking_trainer') }}</span>
                    <span class="text-sm font-medium text-white/70">{{ $trainerLabel }}</span>
                </div>
                @endif
                @if ($b['locker'])
                <div class="flex items-center justify-between rounded-xl bg-white/[0.03] px-4 py-3">
                    <span class="text-xs text-white/40">{{ __('messages.booking_locker') }}</span>
                    <span class="text-sm font-medium text-gym-primary/70">{{ __('messages.booking_yes') }}</span>
                </div>
                @endif
            @endif

            {{-- Dates side by side --}}
            <div class="grid grid-cols-2 gap-2 pt-1">
                <div class="rounded-xl bg-white/[0.03] px-4 py-3 text-center">
                    <p class="mb-0.5 text-xs text-white/30">{{ __('messages.booking_start_date') }}</p>
                    <p class="text-sm font-medium text-white/70">{{ $b['start_date'] }}</p>
                </div>
                <div class="rounded-xl bg-white/[0.03] px-4 py-3 text-center">
                    <p class="mb-0.5 text-xs text-white/30">{{ __('messages.booking_end_date') }}</p>
                    <p class="text-sm font-medium text-white/70">{{ $b['end_date'] }}</p>
                </div>
            </div>
        </div>

        <div class="mb-5 mt-5 border-t border-white/5"></div>

        {{-- Price Breakdown --}}
        <div class="rounded-xl border border-white/5 bg-white/5 p-4">
            <h4 class="mb-3 text-sm font-medium text-white/50">{{ __('messages.booking_details') }}</h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-white/60">{{ $planLabel }}</span>
                    <span class="font-medium text-white">{{ number_format($b['base_price'], 0) }} {{ __('messages.kwd') }}</span>
                </div>
                @if ($trainerLabel)
                <div class="flex justify-between text-sm">
                    <span class="text-white/60">{{ __('messages.booking_personal_trainer') }} ({{ $trainerLabel }})</span>
                    <span class="font-medium text-white">{{ number_format($b['trainer_price'], 0) }} {{ __('messages.kwd') }}</span>
                </div>
                @endif
                @if ($b['locker'])
                <div class="flex justify-between text-sm">
                    <span class="text-white/60">{{ __('messages.booking_locker') }}</span>
                    <span class="font-medium text-white">{{ number_format($b['locker_price'], 0) }} {{ __('messages.kwd') }}</span>
                </div>
                @endif
                <div class="flex justify-between border-t border-white/10 pt-2">
                    <span class="text-sm font-bold text-gym-primary">{{ __('messages.booking_total') }}</span>
                    <span class="text-lg font-bold text-gym-primary">{{ number_format($b['total_price'], 0) }} {{ __('messages.kwd') }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Method Badge --}}
        <div class="mt-4 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-lg bg-gym-primary/5 px-3 py-1.5">
                <span class="text-[11px] text-white/40">{{ __('messages.booking_payment_method') }}:</span>
                <span class="text-[11px] font-medium text-gym-primary">{{ __('messages.payment_cash') }}</span>
            </span>
        </div>
    </div>

    {{-- Contact Footer --}}
    <div class="animate-fade-in mt-2 text-center">
        <div class="flex items-center justify-center gap-2 text-xs text-white/40">
            <span>info@formagym.com</span>
            <span class="text-white/20">|</span>
            <span dir="ltr">+965 2222 2213</span>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="animate-fade-in mt-3">
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-gym-primary px-8 py-4 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25 active:scale-95">
            <svg class="h-4 w-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
            {{ __('messages.booking_back_home') }}
        </a>
    </div>
</div>
