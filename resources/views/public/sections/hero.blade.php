<section id="hero" class="hero-section flex min-h-screen items-center justify-center overflow-hidden">
    <div class="hidden md:block absolute inset-0 overflow-hidden pointer-events-none">
        <video autoplay muted loop playsinline preload="metadata"
            class="h-full w-full object-cover">
            <source src="{{ asset('video/gym-1.mp4') }}" type="video/mp4">
        </video>
    </div>
    <div class="block md:hidden absolute inset-0 bg-cover bg-center pointer-events-none"
        style="background-image: url('{{ asset('images/gym-bg-phone.jpg') }}');"></div>
    <div class="relative z-10 mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
        <h1 class="animate-fade-in-up text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
            {{ __('messages.hero_title') }}
            <span class="text-gym-primary">{{ __('messages.hero_highlight') }}</span>
        </h1>
        <p class="animate-fade-in-up-delay-1 mx-auto mt-6 max-w-2xl text-lg text-white/60 sm:text-xl">
            {{ __('messages.hero_subtitle') }}
        </p>
        <div class="animate-fade-in-up-delay-2 mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('subscription.register') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gym-primary px-8 py-4 text-base font-bold text-gym-dark transition-all hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25">
                {{ __('messages.hero_cta_subscribe') }}
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="{{ route('subscription.lookup') }}"
                class="inline-flex items-center gap-2 rounded-xl border-2 border-white px-8 py-4 text-base font-bold text-white transition-all hover:bg-white/10">
                {{ __('messages.hero_cta_lookup') }}
            </a>
        </div>
    </div>

    <a href="#about" class="animate-fade-in transition-all duration-200 hover:opacity-60 z-10" style="animation-duration:1.6s;position:absolute;bottom:0;left:0;width:100%;text-align:center;padding:25px 0">
        <div class="inline-flex h-10 w-10 items-center justify-center rounded-full border-2 border-white/30" cursorshover="true">
            <svg class="h-5 w-5 animate-bounce text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" cursorshover="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </a>
</section>
