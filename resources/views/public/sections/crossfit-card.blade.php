<section id="crossfit-card" class="bg-gym-surface px-4 py-10 sm:px-6 lg:px-8 reveal">
    <div class="mx-auto max-w-7xl">
        <div class="offer-card mx-auto max-w-4xl rounded-2xl bg-gym-card p-8 reveal">
            <div class="flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gym-primary/20">
                        <svg class="h-7 w-7 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-white">{{ __('messages.crossfit_card_title') }}</p>
                        <p class="mt-1 text-sm text-white/60">{{ __('messages.crossfit_card_desc') }}</p>
                    </div>
                </div>
                <a href="{{ route('crossfit') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-gym-primary px-6 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover">
                    {{ __('messages.crossfit_card_cta') }}
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>
