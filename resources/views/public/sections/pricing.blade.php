@php
    $subscriptions = [
        ['name' => 'شهر', 'label_key' => 'messages.plan_month', 'price' => '29', 'period_key' => 'messages.pricing_monthly', 'popular' => false, 'duration' => 30],
        ['name' => 'شهرين', 'label_key' => 'messages.plan_2months', 'price' => '49', 'period_key' => 'messages.pricing_monthly', 'popular' => false, 'duration' => 60],
        ['name' => '3 أشهر', 'label_key' => 'messages.plan_3months', 'price' => '69', 'period_key' => 'messages.pricing_monthly', 'popular' => true, 'duration' => 90],
        ['name' => '6 أشهر', 'label_key' => 'messages.plan_6months', 'price' => '99', 'period_key' => 'messages.pricing_monthly', 'popular' => false, 'duration' => 180],
        ['name' => 'سنة', 'label_key' => 'messages.plan_year', 'price' => '149', 'period_key' => 'messages.pricing_monthly', 'popular' => false, 'duration' => 365],
    ];
@endphp

<section id="pricing" class="bg-gym-surface px-4 py-10 sm:px-6 lg:px-8 reveal scroll-mt-24">
    <div class="mx-auto max-w-7xl">
        <div class="text-center reveal">
            <h2 class="text-3xl font-bold text-gym-text sm:text-4xl">{{ __('messages.pricing_title') }}</h2>
            <p class="mt-4 text-lg text-gym-muted">{{ __('messages.pricing_subtitle') }}</p>
        </div>

        <div id="pricing-skeleton" class="hidden mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach (range(1, 5) as $i)
                <div class="rounded-2xl border border-gym-border bg-gym-white p-6">
                    <div class="skeleton h-5 w-24 mx-auto mb-6"></div>
                    <div class="skeleton h-10 w-32 mx-auto mb-4"></div>
                    <div class="skeleton h-4 w-20 mx-auto mb-6"></div>
                    <div class="skeleton h-11 w-full"></div>
                </div>
            @endforeach
        </div>

        <div id="pricing-content" class="mt-16 grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($subscriptions as $index => $sub)
                <div class="pricing-card relative flex flex-col rounded-2xl border bg-gym-white p-6 shadow-sm reveal stagger-delay-{{ $index + 1 }} {{ $sub['popular'] ? 'popular border-gym-primary ring-2 ring-gym-primary/20 scale-105 z-10' : 'border-gym-border hover:border-gym-primary/30' }}">
                    @if ($sub['popular'])
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                            <span class="rounded-full bg-gym-primary px-4 py-1 text-xs font-bold text-gym-dark">{{ __('messages.pricing_popular') }}</span>
                        </div>
                    @endif

                    <div class="mb-6 text-center">
                        <h3 class="text-lg font-bold text-gym-text">{{ __($sub['label_key']) }}</h3>
                        <div class="mt-3">
                            <span class="text-4xl font-bold text-gym-primary">{{ $sub['price'] }}</span>
                            <span class="text-sm text-gym-muted"> {{ __('messages.pricing_kwd_per') }} {{ __($sub['period_key']) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('subscription.register', ['plan' => $sub['name'], 'price' => $sub['price'], 'duration' => $sub['duration']]) }}"
                        class="pricing-btn block w-full rounded-xl py-3 text-sm font-bold text-center {{ $sub['popular'] ? 'bg-gym-primary text-gym-dark hover:bg-gym-primary-hover' : 'bg-gym-light text-gym-text hover:bg-gym-border' }}">
                        {{ __('messages.hero_cta_subscribe') }}
                    </a>
                </div>
            @endforeach
        </div>

        <div class="offer-card mx-auto mt-12 max-w-4xl rounded-2xl bg-gym-card p-8 reveal">
            <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gym-primary/20">
                        <svg class="h-7 w-7 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-white">{{ __('messages.pricing_offer_title') }}</p>
                        <p class="text-sm text-white/60">{{ __('messages.pricing_offer_desc') }}</p>
                    </div>
                </div>
                <a href="{{ route('subscription.register', ['plan' => 'سنة', 'price' => '149', 'duration' => 365]) }}"
                    class="pricing-btn inline-flex items-center gap-2 rounded-xl bg-gym-primary px-6 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover">
                    {{ __('messages.pricing_offer_cta') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            const skeleton = document.getElementById('pricing-skeleton');
            const content = document.getElementById('pricing-content');
            if (skeleton && content) {
                skeleton.classList.add('hidden');
                content.style.display = 'grid';
            }
        })();
    </script>
    @endpush
</section>
