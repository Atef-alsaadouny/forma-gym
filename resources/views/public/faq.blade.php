@extends('layouts.base')

@section('title', __('messages.faq_title') . ' - ' . config('app.name', 'Forma Gym'))

@section('meta_description', __('messages.faq_description'))

@section('body')
    <div class="relative min-h-screen flex flex-col"
        style="background-image: url('{{ asset('images/gym-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-gym-dark/70 via-gym-dark/40 to-gym-dark/70"></div>

        <div class="wall-logo" style="position:absolute;right:11%;top:19%;transform:translateY(-50%);z-index:5;pointer-events:none;opacity:52%;">
            <span style="font-family:sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:3px;color:#8BC53F;text-shadow:0 0 7px #8BC53F,0 0 14px #8BC53F,0 0 28px #8BC53F,0 0 56px #8BC53F;">FORMA GYM</span>
        </div>

        <div class="relative z-10 flex flex-1 items-center justify-center px-4">
            <div class="mx-auto w-full max-w-lg">
                <div class="glass-card backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl p-6 sm:p-8 shadow-2xl">
                    <div class="mb-6 text-center">
                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-gym-primary/20">
                            <svg class="h-6 w-6 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-white">{{ __('messages.faq_title') }}</h1>
                        <p class="mt-1 text-sm text-white/40">{{ __('messages.faq_subtitle') }}</p>
                    </div>

                    @php
                        $faqs = [
                            ['q' => __('messages.faq_q1'), 'a' => __('messages.faq_a1')],
                            ['q' => __('messages.faq_q2'), 'a' => __('messages.faq_a2')],
                            ['q' => __('messages.faq_q3'), 'a' => __('messages.faq_a3')],
                            ['q' => __('messages.faq_q4'), 'a' => __('messages.faq_a4')],
                            ['q' => __('messages.faq_q5'), 'a' => __('messages.faq_a5')],
                            ['q' => __('messages.faq_q6'), 'a' => __('messages.faq_a6')],
                        ];
                    @endphp

                    <div class="space-y-2">
                        @foreach ($faqs as $index => $faq)
                            <div class="faq-item overflow-hidden rounded-xl border border-white/5 bg-white/5 transition-all duration-200">
                                <button onclick="toggleFaq(this)"
                                    class="faq-btn flex w-full items-center justify-between px-4 py-3 text-right transition-all duration-200 hover:bg-white/[0.03]">
                                    <span class="text-sm font-medium text-white/80">{{ $faq['q'] }}</span>
                                    <svg class="faq-icon h-4 w-4 shrink-0 text-white/30 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="faq-answer max-h-0 overflow-hidden px-4 transition-all duration-300 ease-out">
                                    <p class="pb-3 text-sm leading-relaxed text-white/50">{{ $faq['a'] }}</p>
                                </div>
                            </div>
                        @endforeach
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

    @push('scripts')
    <script>
        function toggleFaq(btn) {
            const item = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            const isOpen = answer.style.maxHeight && answer.style.maxHeight !== '0px';

            document.querySelectorAll('.faq-item').forEach(el => {
                const a = el.querySelector('.faq-answer');
                const i = el.querySelector('.faq-icon');
                if (el !== item) {
                    a.style.maxHeight = '0';
                    i.classList.remove('rotate-180');
                    el.querySelector('.faq-btn').classList.remove('text-gym-primary');
                }
            });

            if (isOpen) {
                answer.style.maxHeight = '0';
                icon.classList.remove('rotate-180');
                btn.classList.remove('text-gym-primary');
            } else {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.classList.add('rotate-180');
                btn.classList.add('text-gym-primary');
            }
        }
    </script>
    @endpush
@endsection

@push('jsonld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        @php
            $faqJson = [
                ['q' => __('messages.faq_q1'), 'a' => __('messages.faq_a1')],
                ['q' => __('messages.faq_q2'), 'a' => __('messages.faq_a2')],
                ['q' => __('messages.faq_q3'), 'a' => __('messages.faq_a3')],
                ['q' => __('messages.faq_q4'), 'a' => __('messages.faq_a4')],
                ['q' => __('messages.faq_q5'), 'a' => __('messages.faq_a5')],
                ['q' => __('messages.faq_q6'), 'a' => __('messages.faq_a6')],
            ];
        @endphp
        @foreach($faqJson as $i => $faq)
        {
            "@@type": "Question",
            "name": @json($faq['q']),
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": @json($faq['a'])
            }
        }{{ $i < 5 ? ',' : '' }}
        @endforeach
    ]
}
</script>
@endpush
