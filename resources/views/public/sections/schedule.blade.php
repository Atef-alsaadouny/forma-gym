@php
    $days = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
    $times = ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00', '00:00', '02:00'];

    $dayTranslations = [
        'السبت' => __('messages.day_saturday'),
        'الأحد' => __('messages.day_sunday'),
        'الاثنين' => __('messages.day_monday'),
        'الثلاثاء' => __('messages.day_tuesday'),
        'الأربعاء' => __('messages.day_wednesday'),
        'الخميس' => __('messages.day_thursday'),
        'الجمعة' => __('messages.day_friday'),
    ];

    $trainerNames = [
        'أحمد محمد' => __('messages.trainer_ahmed'),
        'سارة علي' => __('messages.trainer_sara'),
        'محمد حسن' => __('messages.trainer_mohamed'),
        'ليلى خالد' => __('messages.trainer_laila'),
    ];

    $isFridayClosed = fn($col) => $col < 4 || $col > 8;

    $slots = [
        'السبت' => [
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 0, 'to' => 2],
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 2, 'to' => 4],
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 4, 'to' => 6],
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 6, 'to' => 8],
        ],
        'الأحد' => [
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 0, 'to' => 2],
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 2, 'to' => 4],
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 4, 'to' => 6],
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 6, 'to' => 8],
        ],
        'الاثنين' => [
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 0, 'to' => 2],
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 2, 'to' => 4],
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 4, 'to' => 6],
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 6, 'to' => 8],
        ],
        'الثلاثاء' => [
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 0, 'to' => 3],
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 3, 'to' => 5],
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 5, 'to' => 7],
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 7, 'to' => 9],
        ],
        'الأربعاء' => [
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 0, 'to' => 2],
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 2, 'to' => 4],
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 4, 'to' => 6],
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 6, 'to' => 8],
        ],
        'الخميس' => [
            ['trainer' => 'ليلى خالد', 'color' => 'bg-gym-schedule-green', 'from' => 0, 'to' => 2],
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 2, 'to' => 4],
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 4, 'to' => 6],
            ['trainer' => 'محمد حسن', 'color' => 'bg-gym-schedule-yellow', 'from' => 6, 'to' => 8],
        ],
        'الجمعة' => [
            ['trainer' => 'سارة علي', 'color' => 'bg-gym-schedule-purple', 'from' => 4, 'to' => 6],
            ['trainer' => 'أحمد محمد', 'color' => 'bg-gym-schedule-blue', 'from' => 6, 'to' => 8],
        ],
    ];
@endphp

<section id="schedule" class="bg-gym-light px-4 py-10 sm:px-6 lg:px-8 reveal overflow-hidden scroll-mt-24">
    <div class="mx-auto max-w-7xl">
        <div class="text-center reveal">
            <h2 class="text-3xl font-bold text-gym-text sm:text-4xl">{{ __('messages.schedule_title') }}</h2>
            <p class="mt-4 text-lg text-gym-muted">{{ __('messages.schedule_subtitle') }}</p>
        </div>

        <div id="schedule-skeleton" class="hidden mt-12 space-y-6">
            <div class="flex flex-wrap items-center justify-center gap-4">
                @foreach (range(1, 4) as $i)
                    <div class="skeleton h-4 w-20"></div>
                @endforeach
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <div class="skeleton h-12 w-52 rounded-xl"></div>
                <div class="skeleton h-12 w-52 rounded-xl"></div>
            </div>
            <div class="skeleton h-96 w-full rounded-2xl"></div>
        </div>

        <div id="schedule-content">
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4 reveal">
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-gym-schedule-blue"></div>
                    <span class="text-sm text-gym-text">{{ $trainerNames['أحمد محمد'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-gym-schedule-purple"></div>
                    <span class="text-sm text-gym-text">{{ $trainerNames['سارة علي'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-gym-schedule-yellow"></div>
                    <span class="text-sm text-gym-text">{{ $trainerNames['محمد حسن'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="h-3 w-3 rounded-full bg-gym-schedule-green"></div>
                    <span class="text-sm text-gym-text">{{ $trainerNames['ليلى خالد'] }}</span>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-4 text-center reveal">
                <div class="hours-card rounded-xl border border-gym-border bg-white px-6 py-3 shadow-sm">
                    <p class="text-sm text-gym-text">
                        <span class="font-bold text-gym-primary">{{ __('messages.schedule_hours_label') }}</span>
                        {{ __('messages.schedule_hours_value') }}
                    </p>
                </div>
                <div class="hours-card rounded-xl border border-gym-border bg-white px-6 py-3 shadow-sm">
                    <p class="text-sm text-gym-text">
                        <span class="font-bold text-gym-primary">{{ __('messages.schedule_friday_label') }}</span>
                        {{ __('messages.schedule_friday_value') }}
                    </p>
                </div>
            </div>

            {{-- Trainer Filter Pills --}}
            <div class="mt-10 flex flex-wrap items-center justify-center gap-2 reveal" id="trainer-filter">
                <button type="button" data-filter="all"
                    class="filter-pill active rounded-full border-2 border-gym-primary bg-gym-primary/10 px-4 py-1.5 text-xs font-bold text-gym-primary transition-all duration-200 hover:bg-gym-primary/20">
                    {{ __('messages.schedule_filter_all') }}
                </button>
                <button type="button" data-filter="أحمد محمد"
                    class="filter-pill rounded-full border-2 border-transparent bg-gym-schedule-blue/10 px-4 py-1.5 text-xs font-medium text-gym-schedule-blue transition-all duration-200 hover:border-gym-schedule-blue/40 hover:bg-gym-schedule-blue/20">
                    {{ $trainerNames['أحمد محمد'] }}
                </button>
                <button type="button" data-filter="سارة علي"
                    class="filter-pill rounded-full border-2 border-transparent bg-gym-schedule-purple/10 px-4 py-1.5 text-xs font-medium text-gym-schedule-purple transition-all duration-200 hover:border-gym-schedule-purple/40 hover:bg-gym-schedule-purple/20">
                    {{ $trainerNames['سارة علي'] }}
                </button>
                <button type="button" data-filter="محمد حسن"
                    class="filter-pill rounded-full border-2 border-transparent bg-gym-schedule-yellow/10 px-4 py-1.5 text-xs font-medium text-gym-schedule-yellow transition-all duration-200 hover:border-gym-schedule-yellow/40 hover:bg-gym-schedule-yellow/20">
                    {{ $trainerNames['محمد حسن'] }}
                </button>
                <button type="button" data-filter="ليلى خالد"
                    class="filter-pill rounded-full border-2 border-transparent bg-gym-schedule-green/10 px-4 py-1.5 text-xs font-medium text-gym-schedule-green transition-all duration-200 hover:border-gym-schedule-green/40 hover:bg-gym-schedule-green/20">
                    {{ $trainerNames['ليلى خالد'] }}
                </button>
            </div>

            <div class="schedule-table mt-6 overflow-x-auto rounded-2xl border border-white/10 bg-gym-card shadow-sm reveal">
            <table class="w-full min-w-[1100px]">
                <thead>
                    <tr>
                        <th class="border-l border-b border-white/10 bg-gym-card p-3 text-right">
                            <span class="text-sm font-bold text-white">{{ __('messages.schedule_day_time') }}</span>
                        </th>
                        @foreach ($times as $time)
                            <th class="border-b border-white/10 bg-gym-card p-3 text-center">
                                <span class="text-xs font-bold text-white/90">{{ $time }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($days as $day)
                        <tr class="group transition-colors hover:bg-gym-dark-hover">
                            <td class="border-l border-b border-white/10 bg-gym-card p-3">
                                <span class="text-sm font-bold text-white">{{ $dayTranslations[$day] }}</span>
                            </td>
                            @for ($col = 0; $col < count($times); $col++)
                                @php
                                    $slot = collect($slots[$day])->first(fn($s) => $s['from'] <= $col && $col < $s['to']);
                                    $closed = $day === 'الجمعة' && $isFridayClosed($col);
                                @endphp
                                <td class="border-b border-white/10 p-1 text-center @if ($closed) bg-white/5 @endif"
                                    @if ($slot && $slot['from'] === $col) data-trainer="{{ $slot['trainer'] }}" @endif>
                                    @if ($slot && $slot['from'] === $col)
                                        <div class="{{ $slot['color'] }} mx-0.5 rounded-xl px-1.5 py-2.5 shadow-sm">
                                            <p class="text-xs font-bold text-white">{{ $trainerNames[$slot['trainer']] }}</p>
                                        </div>
                                    @elseif ($closed)
                                        <span class="text-xs text-white/30">{{ __('messages.schedule_closed') }}</span>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function() {
            const skeleton = document.getElementById('schedule-skeleton');
            const content = document.getElementById('schedule-content');
            if (skeleton && content) {
                skeleton.classList.add('hidden');
                content.style.display = 'block';
            }
        })();

        // Trainer filter
        const filterBtns = document.querySelectorAll('#trainer-filter .filter-pill');
        const allCells = document.querySelectorAll('.schedule-table td[data-trainer]');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const trainer = this.dataset.filter;

                filterBtns.forEach(b => {
                    b.classList.remove('active', 'border-gym-primary', 'bg-gym-primary/10');
                    b.classList.add('border-transparent');
                });

                if (trainer === 'all') {
                    this.classList.add('active', 'border-gym-primary', 'bg-gym-primary/10');
                    allCells.forEach(cell => cell.style.opacity = '1');
                } else {
                    this.classList.remove('border-transparent');
                    this.classList.add('border-gym-primary', 'bg-gym-primary/10');
                    allCells.forEach(cell => {
                        cell.style.opacity = cell.dataset.trainer === trainer ? '1' : '0.12';
                    });
                }
            });
        });
    </script>
    @endpush
</section>
