@php
    $features = [
        [
            'title' => __('messages.feature_1_title'),
            'desc' => __('messages.feature_1_desc'),
            'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
        ],
        [
            'title' => __('messages.feature_2_title'),
            'desc' => __('messages.feature_2_desc'),
            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
        ],
        [
            'title' => __('messages.feature_3_title'),
            'desc' => __('messages.feature_3_desc'),
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        ],
        [
            'title' => __('messages.feature_4_title'),
            'desc' => __('messages.feature_4_desc'),
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        [
            'title' => __('messages.feature_5_title'),
            'desc' => __('messages.feature_5_desc'),
            'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        ],
        [
            'title' => __('messages.feature_6_title'),
            'desc' => __('messages.feature_6_desc'),
            'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
@endphp

<section id="about" class="bg-gym-white px-4 py-10 sm:px-6 lg:px-8 reveal scroll-mt-24">
    <div class="mx-auto max-w-7xl">
        <div class="text-center reveal">
            <h2 class="text-3xl font-bold text-gym-text sm:text-4xl">{{ __('messages.features_title') }}</h2>
            <p class="mt-4 text-lg text-gym-muted">{{ __('messages.features_subtitle') }}</p>
        </div>

        <div id="features-skeleton" class="hidden mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach (range(1, 6) as $i)
                <div class="rounded-2xl border border-gym-border bg-gym-white p-8">
                    <div class="skeleton mx-auto mb-6 h-16 w-16 rounded-2xl"></div>
                    <div class="skeleton mx-auto mb-3 h-5 w-32"></div>
                    <div class="skeleton mx-auto h-4 w-48"></div>
                </div>
            @endforeach
        </div>

        <div id="features-content" class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($features as $index => $feature)
                <div class="feature-card group rounded-2xl border border-gym-border bg-gym-white p-8 text-center shadow-sm reveal stagger-delay-{{ min($index + 1, 5) }}">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-gym-primary/10 transition-all duration-200 group-hover:bg-gym-primary/20">
                        <svg class="h-8 w-8 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="mt-6 text-lg font-bold text-gym-text">{{ $feature['title'] }}</h3>
                    <p class="mt-3 text-sm leading-relaxed text-gym-muted">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            const skeleton = document.getElementById('features-skeleton');
            const content = document.getElementById('features-content');
            if (skeleton && content) {
                content.style.display = 'none';
                skeleton.classList.remove('hidden');
                setTimeout(function() {
                    skeleton.classList.add('hidden');
                    content.style.display = 'grid';
                }, 350);
            }
        })();
    </script>
    @endpush
</section>
