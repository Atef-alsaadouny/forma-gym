@extends('layouts.base')

@section('title', __('messages.crossfit_title') . ' - ' . config('app.name', 'Forma Gym'))

@section('meta_description', __('messages.crossfit_description'))

@push('styles')
<style>
    .cf-table-wrapper {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .cf-table-wrapper table {
        min-width: 680px;
    }
    .cf-table-wrapper th,
    .cf-table-wrapper td {
        text-align: center;
        padding: 10px 8px;
        font-size: 0.8125rem;
        white-space: nowrap;
    }
    .cf-table-wrapper th:first-child,
    .cf-table-wrapper td:first-child {
        text-align: right;
        position: sticky;
        right: 0;
        z-index: 2;
    }
</style>
@endpush

@section('body')
    <div class="relative min-h-screen flex flex-col"
        style="background-image: url('{{ asset('images/gym-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-gym-dark/70 via-gym-dark/40 to-gym-dark/70"></div>

        <div class="wall-logo" style="position:absolute;right:5%;top:28%;transform:translateY(-50%);z-index:5;pointer-events:none;opacity:52%;">
            <span style="font-family:sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:3px;color:#8BC53F;text-shadow:0 0 7px #8BC53F,0 0 14px #8BC53F,0 0 28px #8BC53F,0 0 56px #8BC53F;">FORMA GYM</span>
        </div>

        <div class="relative z-10 flex flex-1 items-start justify-center px-4 py-12">
            <div class="mx-auto w-full max-w-4xl">
                <div class="glass-card backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl p-6 sm:p-8 shadow-2xl">

                    {{-- Header --}}
                    <div class="mb-6 text-center">
                        <div class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-gym-primary/20">
                            <svg class="h-7 w-7 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">{{ __('messages.crossfit_title') }}</h1>
                        <p class="mt-1 text-sm text-white/40">{{ __('messages.crossfit_subtitle') }}</p>
                    </div>

                    {{-- Welcome Message --}}
                    <div class="mb-6 rounded-xl border border-white/5 bg-white/5 p-5">
                        <p class="text-sm leading-relaxed text-white/70">
                            {{ __('messages.crossfit_welcome_title') }}
                            <span class="text-gym-primary">🏋️</span>
                        </p>
                        <p class="mt-3 text-sm leading-relaxed text-white/50">
                            {{ __('messages.crossfit_welcome_p1') }}
                        </p>
                        <p class="mt-2 text-sm leading-relaxed text-white/50">
                            {{ __('messages.crossfit_welcome_p2') }}
                        </p>
                    </div>

                    {{-- Schedule Section --}}
                    <div class="mb-6">
                        <h2 class="mb-4 text-center text-base font-bold text-white">{{ __('messages.crossfit_schedule_heading') }}</h2>

                        @php
                            $cf_day_keys = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس'];
                            $cf_day_labels = [
                                'السبت' => __('messages.day_saturday'),
                                'الأحد' => __('messages.day_sunday'),
                                'الاثنين' => __('messages.day_monday'),
                                'الثلاثاء' => __('messages.day_tuesday'),
                                'الأربعاء' => __('messages.day_wednesday'),
                                'الخميس' => __('messages.day_thursday'),
                            ];
                            $cf_times = ['02:00 ' . __('messages.pm'), '04:00 ' . __('messages.pm'), '05:00 ' . __('messages.pm'), '06:00 ' . __('messages.pm'), '08:00 ' . __('messages.pm'), '09:00 ' . __('messages.pm')];

                            $cf_class_map = [
                                'cf_spin'   => ['color' => '#3B82F6', 'bg' => 'bg-[#3B82F6]/15', 'text' => 'text-[#3B82F6]', 'label' => __('messages.cf_spin')],
                                'cf_hiit'   => ['color' => '#EF4444', 'bg' => 'bg-[#EF4444]/15', 'text' => 'text-[#EF4444]', 'label' => __('messages.cf_hiit')],
                                'cf_fitness'=> ['color' => '#22C55E', 'bg' => 'bg-[#22C55E]/15', 'text' => 'text-[#22C55E]', 'label' => __('messages.cf_fitness')],
                                'cf_lower'  => ['color' => '#8B5CF6', 'bg' => 'bg-[#8B5CF6]/15', 'text' => 'text-[#8B5CF6]', 'label' => __('messages.cf_lower')],
                                'cf_steps'  => ['color' => '#F59E0B', 'bg' => 'bg-[#F59E0B]/15', 'text' => 'text-[#F59E0B]', 'label' => __('messages.cf_steps')],
                                'cf_back'   => ['color' => '#14B8A6', 'bg' => 'bg-[#14B8A6]/15', 'text' => 'text-[#14B8A6]', 'label' => __('messages.cf_back')],
                                'cf_abs'    => ['color' => '#EC4899', 'bg' => 'bg-[#EC4899]/15', 'text' => 'text-[#EC4899]', 'label' => __('messages.cf_abs')],
                            ];

                            $cf_slots = [
                                'السبت'    => ['cf_spin', 'cf_hiit', 'cf_hiit', 'cf_hiit', 'cf_hiit', 'cf_hiit'],
                                'الأحد'    => ['cf_fitness', 'cf_spin', 'cf_fitness', 'cf_fitness', 'cf_fitness', 'cf_fitness'],
                                'الاثنين'  => ['cf_lower', 'cf_lower', 'cf_spin', 'cf_lower', 'cf_lower', 'cf_lower'],
                                'الثلاثاء' => ['cf_steps', 'cf_steps', 'cf_steps', 'cf_spin', 'cf_steps', 'cf_steps'],
                                'الأربعاء' => ['cf_back', 'cf_back', 'cf_back', 'cf_back', 'cf_spin', 'cf_back'],
                                'الخميس'   => ['cf_abs', 'cf_abs', 'cf_abs', 'cf_abs', 'cf_abs', 'cf_spin'],
                            ];
                        @endphp

                        <div class="cf-table-wrapper rounded-xl border border-white/10 bg-gym-card/80">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b border-l border-white/10 bg-gym-card p-2.5 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-bold text-white/90">{{ __('messages.crossfit_day') }}</th>
                                        @foreach ($cf_times as $time)
                                            <th class="border-b border-white/10 bg-gym-card p-2.5 text-center text-xs font-bold text-white/90">{{ $time }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cf_day_keys as $day)
                                        <tr class="transition-colors hover:bg-white/[0.03]">
                                            <td class="border-b border-l border-white/10 bg-gym-card p-2.5 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-xs font-bold text-white/80">{{ $cf_day_labels[$day] }}</td>
                                            @foreach ($cf_slots[$day] as $ci => $class)
                                                @php $m = $cf_class_map[$class]; @endphp
                                                <td class="border-b border-white/10 p-1.5 text-center">
                                                    <span class="cf-cell inline-block w-full rounded-lg px-1.5 py-2 text-[11px] font-bold leading-tight {{ $m['bg'] }} {{ $m['text'] }}">
                                                        {{ $m['label'] }}
                                                    </span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Legend --}}
                        <div class="mt-4 flex flex-wrap items-center justify-center gap-3">
                            @foreach ($cf_class_map as $key => $m)
                                <div class="flex items-center gap-1.5">
                                    <span class="inline-block h-2.5 w-2.5 rounded-full" style="background-color:{{ $m['color'] }}"></span>
                                    <span class="text-[11px] text-white/50">{{ $m['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Instructions --}}
                    <div class="mt-6 space-y-4">
                        {{-- Training Notes --}}
                        <div class="rounded-2xl border border-white/5 bg-white/5 p-5 sm:p-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gym-primary/10">
                                    <svg class="h-5 w-5 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-bold text-white">{{ __('messages.crossfit_notes_title') }}</h3>
                            </div>

                            {{-- Critical: No solo training --}}
                            <div class="mb-4 rounded-xl border border-red-500/20 bg-red-500/5 p-4">
                                <div class="flex items-start gap-2.5">
                                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    <p class="text-sm leading-relaxed text-red-300">
                                        {{ __('messages.crossfit_critical') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Regular notes --}}
                            <ul class="space-y-2.5">
                                @php
                                    $notes = [
                                        __('messages.crossfit_note_1'),
                                        __('messages.crossfit_note_2'),
                                        __('messages.crossfit_note_3'),
                                        __('messages.crossfit_note_4'),
                                        __('messages.crossfit_note_5'),
                                        __('messages.crossfit_note_6'),
                                        __('messages.crossfit_note_7'),
                                        __('messages.crossfit_note_8'),
                                        __('messages.crossfit_note_9'),
                                        __('messages.crossfit_note_10'),
                                        __('messages.crossfit_note_11'),
                                        __('messages.crossfit_note_12'),
                                    ];
                                @endphp
                                @foreach ($notes as $note)
                                    <li class="flex items-start gap-2.5">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                        <span class="text-sm leading-relaxed text-white/60">{{ __($note) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Session structure --}}
                        <div class="rounded-2xl border border-white/5 bg-white/5 p-5 sm:p-6">
                            <h4 class="mb-4 text-base font-bold text-white">{{ __('messages.crossfit_session_structure') }}</h4>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 rounded-xl bg-white/[0.03] px-4 py-3">
                                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gym-primary/20 text-xs font-bold text-gym-primary">1</span>
                                    <span class="text-sm text-white/70">{{ __('messages.crossfit_warmup') }}</span>
                                    <span class="text-xs text-white/30 ml-auto">(10 {{ __('messages.minutes') }})</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-xl bg-white/[0.03] px-4 py-3">
                                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gym-primary/20 text-xs font-bold text-gym-primary">2</span>
                                    <span class="text-sm text-white/70">{{ __('messages.crossfit_core') }}</span>
                                    <span class="text-xs text-white/30 ml-auto">(30 {{ __('messages.minutes') }})</span>
                                </div>
                                <div class="flex items-center gap-3 rounded-xl bg-white/[0.03] px-4 py-3">
                                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gym-primary/20 text-xs font-bold text-gym-primary">3</span>
                                    <span class="text-sm text-white/70">{{ __('messages.crossfit_cooldown') }}</span>
                                    <span class="text-xs text-white/30 ml-auto">(5-10 {{ __('messages.minutes') }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Back Button --}}
                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-gym-primary px-8 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25 active:scale-95">
                            <svg class="h-4 w-4 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                            {{ __('messages.crossfit_back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
