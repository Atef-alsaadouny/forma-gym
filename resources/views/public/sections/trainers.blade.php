@php
    $trainers = [
        ['name_key' => 'messages.trainer_ahmed', 'specialty_key' => 'messages.trainer_specialty_strength', 'rating' => 4.9, 'exp' => 8, 'image' => '1.jpg'],
        ['name_key' => 'messages.trainer_sara', 'specialty_key' => 'messages.trainer_specialty_fitness', 'rating' => 4.8, 'exp' => 6, 'image' => '2.jpg'],
        ['name_key' => 'messages.trainer_mohamed', 'specialty_key' => 'messages.trainer_specialty_nutrition', 'rating' => 4.9, 'exp' => 10, 'image' => '3.jpg'],
        ['name_key' => 'messages.trainer_laila', 'specialty_key' => 'messages.trainer_specialty_yoga', 'rating' => 4.7, 'exp' => 5, 'image' => '4.jpg'],
    ];
@endphp

<section id="trainers" class="bg-gym-light px-4 py-10 sm:px-6 lg:px-8 reveal scroll-mt-24">
    <div class="mx-auto max-w-7xl">
        <div class="text-center reveal">
            <h2 class="text-3xl font-bold text-gym-text sm:text-4xl">{{ __('messages.trainers_title') }}</h2>
            <p class="mt-4 text-lg text-gym-muted">{{ __('messages.trainers_subtitle') }}</p>
        </div>

        <div class="swiper mt-16 reveal" id="trainers-swiper">
            <div class="swiper-wrapper">
                @foreach ($trainers as $trainer)
                    <div class="swiper-slide">
                        <div class="trainer-card group overflow-hidden rounded-2xl bg-gym-white shadow-sm transition-all duration-200">
                            <div class="relative overflow-hidden bg-gym-card aspect-[3/4]">
                                <img src="{{ asset('images/' . $trainer['image']) }}"
                                    alt="{{ __($trainer['name_key']) }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover object-[50%_15%] transition-transform duration-200 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-gym-dark/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-4 left-4">
                                    <span class="rounded-full bg-gym-primary/20 px-3 py-1 text-xs font-medium text-gym-primary backdrop-blur-sm">
                                        {{ __($trainer['specialty_key']) }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 text-center">
                                <h3 class="text-lg font-bold" style="color: #F59E0B">{{ __($trainer['name_key']) }}</h3>
                                <div class="mt-2 flex items-center justify-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="h-4 w-4" fill="{{ $i <= floor($trainer['rating']) ? '#F59E0B' : '#E5E7EB' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                    <span class="mr-1 text-sm font-bold" style="color: #F59E0B">{{ $trainer['rating'] }}</span>
                                </div>
                                <p class="mt-3 text-sm text-gym-muted">
                                    {{ $trainer['exp'] }} {{ __('messages.trainers_years_exp') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination !relative !mt-8"></div>
        </div>
    </div>
</section>
