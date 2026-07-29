@extends('layouts.base')

@section('title', __('messages.register_title') . ' - ' . config('app.name', 'Forma Gym'))

@section('meta_description', __('messages.register_description'))

@section('body')
    <div class="relative min-h-screen flex flex-col"
        style="background-image: url('{{ asset('images/gym-reg.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-b from-gym-dark/70 via-gym-dark/40 to-gym-dark/70"></div>

        <div class="wall-logo" style="position:absolute;right:11%;top:19%;transform:translateY(-50%);z-index:5;pointer-events:none;opacity:52%;">
            <span style="font-family:sans-serif;font-size:1.75rem;font-weight:800;letter-spacing:3px;color:#8BC53F;text-shadow:0 0 7px #8BC53F,0 0 14px #8BC53F,0 0 28px #8BC53F,0 0 56px #8BC53F;">FORMA GYM</span>
        </div>

        <div class="relative z-10 flex-1 flex items-start justify-center px-4 pt-12 pb-16">
            <div class="w-full max-w-sm mx-auto">
                @if (!empty($success) && isset($booking))
                    @include('public.booking-confirmation')
                @else
                    <div id="form-skeleton" class="hidden space-y-5">
                        <div class="text-center mb-6">
                            <div class="skeleton inline-flex items-center justify-center h-12 w-12 mb-3"></div>
                            <div class="skeleton h-6 w-40 mx-auto mb-3"></div>
                            <div class="skeleton h-6 w-32 mx-auto"></div>
                        </div>
                        <div class="skeleton h-11 w-full"></div>
                        <div class="skeleton h-11 w-full"></div>
                        <div class="skeleton h-11 w-full"></div>
                        <div class="skeleton h-12 w-full"></div>
                        <div class="skeleton h-32 w-full"></div>
                        <div class="grid grid-cols-5 gap-2">
                            <div class="skeleton h-16"></div>
                            <div class="skeleton h-16"></div>
                            <div class="skeleton h-16"></div>
                            <div class="skeleton h-16"></div>
                            <div class="skeleton h-16"></div>
                        </div>
                        <div class="skeleton h-11 w-full"></div>
                    </div>

                    <div id="form-content" class="backdrop-blur-3xl bg-gym-card/[0.12] border border-white/8 rounded-3xl shadow-2xl p-6 sm:p-8 glass-card content-fade-in">
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center h-12 w-12 rounded-2xl bg-gym-primary/20 mb-3">
                                <svg class="h-6 w-6 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold text-white">{{ __('messages.register_title') }}</h1>
                            <p class="mt-1 text-sm text-white/40">{{ __('messages.register_subtitle') }}</p>
                        </div>

                        <form method="POST" action="{{ route('subscription.register.store') }}" id="register-form" class="space-y-5" novalidate>
                            @csrf
                            <input type="hidden" name="plan" id="form-plan" value="{{ $plan ?? 'شهر' }}">
                            <input type="hidden" name="price" id="form-price" value="{{ $price ?? 29 }}">
                            <input type="hidden" name="duration" id="form-duration" value="{{ $duration ?? 30 }}">
                            @php
                                $defaultLabel = __('messages.plan_month');
                                if ($plan) {
                                    $matchedSub = collect($subscriptions)->firstWhere('name', $plan);
                                    $defaultLabel = $matchedSub ? __($matchedSub['label_key']) : $defaultLabel;
                                }
                            @endphp

                            {{-- Plan Selector --}}
                            <div>
                                <div class="grid grid-cols-5 gap-1.5" id="plan-selector">
                                    @foreach ($subscriptions as $sub)
                                        <button type="button"
                                            onclick="selectPlan('{{ $sub['name'] }}', {{ $sub['price'] }}, {{ $sub['duration'] }}, this, '{{ __($sub['label_key']) }}')"
                                            class="plan-option relative flex flex-col items-center gap-0.5 rounded-xl border-2 px-1 py-2 text-center transition-all duration-200
                                            @if (($plan && $plan === $sub['name']) || (!$plan && $loop->first))
                                                border-gym-primary bg-gym-primary/10
                                            @else
                                                border-white/10 bg-white/5 hover:border-gym-primary/40 hover:bg-gym-primary/5
                                            @endif">
                                            @if ($sub['popular'])
                                                <span class="absolute -top-1.5 left-1/2 -translate-x-1/2 rounded-full bg-gym-primary px-1.5 py-[1px] text-[7px] font-bold text-gym-dark leading-tight whitespace-nowrap">{{ __('messages.register_popular') }}</span>
                                            @endif
                                            <span class="text-[10px] font-medium text-white/70 leading-tight @if ($sub['popular']) mt-1.5 @endif">{{ __($sub['label_key']) }}</span>
                                            <span class="text-xs font-bold text-gym-primary leading-tight">{{ $sub['price'] }}</span>
                                            <span class="text-[8px] text-white/40 leading-tight">{{ __('messages.kwd') }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="input-field w-full rounded-xl border border-white/5 bg-white/5 px-3 py-2.5 text-white placeholder-white/50 backdrop-blur-sm transition-all duration-200 focus:border-gym-primary focus:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gym-primary/40"
                                    placeholder="{{ __('messages.register_full_name') }}">
                                @error('name')
                                    <p class="error-message mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
                                    class="input-field w-full rounded-xl border border-white/5 bg-white/5 px-3 py-2.5 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }} text-white placeholder-white/50 backdrop-blur-sm transition-all duration-200 focus:border-gym-primary focus:bg-white/10 focus:outline-none focus:ring-2 focus:ring-gym-primary/40"
                                    placeholder="{{ __('messages.register_phone') }}"
                                    oninput="normalizePhone(this)">
                                @error('phone')
                                    <p class="error-message mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="relative" id="trainer-dropdown">
                                    <button type="button" onclick="toggleTrainerDropdown()"
                                        class="trainer-trigger w-full rounded-xl border border-white/5 bg-white/5 px-3 py-2.5 text-right text-white backdrop-blur-sm transition-all duration-200 hover:border-white/20 focus:border-gym-primary focus:outline-none focus:ring-2 focus:ring-gym-primary/40 flex items-center justify-between">
                                        <span id="trainer-label" class="text-sm text-white/50">{{ __('messages.register_choose_trainer') }}</span>
                                        <svg id="trainer-arrow" class="h-4 w-4 text-white/40 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <input type="hidden" name="trainer_id" id="trainer-id-input" value="{{ old('trainer_id') }}">
                                    <div id="trainer-options" class="hidden absolute z-20 mt-2 w-full rounded-xl border border-white/10 bg-gym-card backdrop-blur-2xl shadow-2xl overflow-hidden">
                                        <div class="max-h-60 overflow-y-auto py-1">
                                            <button type="button" onclick="selectTrainer('', '')"
                                                class="w-full px-4 py-3 text-right text-sm text-white/50 hover:bg-white/5 hover:pr-6 transition-all duration-200">
                                                {{ __('messages.register_no_trainer') }}
                                            </button>
                                            @foreach ($trainers as $t)
                                                <button type="button" onclick="selectTrainer('{{ $t['id'] }}', '{{ __($t['label_key']) }}')"
                                                    class="w-full px-4 py-3 text-right text-sm text-white hover:bg-white/5 hover:pr-6 transition-all duration-200 flex items-center justify-between group">
                                                    <span>{{ __($t['label_key']) }}</span>
                                                    <span class="text-xs text-gym-primary/60 group-hover:text-gym-primary transition-colors duration-200">20 {{ __('messages.kwd') }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('trainer_id')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="relative flex items-center gap-3 rounded-xl border border-white/5 bg-white/5 px-3 py-3 backdrop-blur-sm transition-all duration-200 hover:border-white/20 hover:bg-white/10 cursor-pointer group">
                                    <input type="checkbox" name="locker" value="1" id="locker"
                                        class="checkbox-custom h-5 w-5 rounded-lg border-2 border-white/20 bg-transparent text-gym-primary focus:ring-gym-primary/50 focus:ring-offset-0 cursor-pointer transition-all duration-200 checked:border-gym-primary checked:bg-gym-primary"
                                        onchange="updatePrice()">
                                    <div class="flex-1">
                                        <span class="text-sm text-white">{{ __('messages.register_locker') }}</span>
                                    </div>
                                    <span class="text-xs text-gym-primary/60 group-hover:text-gym-primary transition-colors duration-200">5 {{ __('messages.kwd') }}</span>
                                </label>
                            </div>

                            <div class="rounded-xl bg-white/5 border border-white/5 p-4 backdrop-blur-sm transition-all duration-200 hover:bg-white/10">
                                <h4 class="text-sm font-medium text-white/50 mb-3">{{ __('messages.register_total') }}</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-white/60" id="summary-plan-name">{{ $defaultLabel }}</span>
                                        <span class="price-value text-white font-medium" id="base-price">{{ $price ?? 29 }} {{ __('messages.kwd') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm" id="trainer-row" style="display:none">
                                        <span class="text-white/60">{{ __('messages.register_trainer') }}</span>
                                        <span class="price-value text-white font-medium" id="trainer-price">20 {{ __('messages.kwd') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm" id="locker-row" style="display:none">
                                        <span class="text-white/60">{{ __('messages.register_locker_label') }}</span>
                                        <span class="price-value text-white font-medium" id="locker-price">5 {{ __('messages.kwd') }}</span>
                                    </div>
                                    <div class="border-t border-white/10 pt-2 flex justify-between">
                                        <span class="text-sm font-bold text-gym-primary">{{ __('messages.register_total_label') }}</span>
                                        <span class="price-value text-lg font-bold text-gym-primary" id="total-price">{{ $price ?? 29 }} {{ __('messages.kwd') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="grid grid-cols-5 gap-2" id="payment-methods">
                                    <button type="button" onclick="selectPayment('cash', this)"
                                        class="payment-btn payment-option payment-selected relative flex flex-col items-center gap-1 rounded-xl border-2 border-gym-primary bg-gym-primary/10 px-1 py-2 text-center">
                                        <svg class="h-5 w-5 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-[10px] font-bold text-gym-primary">{{ __('messages.payment_cash') }}</span>
                                    </button>

                                    <button type="button" onclick="showUnavailable(this)"
                                        class="payment-btn payment-option relative flex flex-col items-center gap-1 rounded-xl border border-white/10 bg-white/5 px-1 py-2 text-center">
                                        <svg class="h-5 w-5" viewBox="0 0 30 20" fill="none">
                                            <rect width="30" height="20" rx="3" fill="#1a1a2e"/>
                                            <text x="15" y="13.5" text-anchor="middle" fill="white" font-size="7" font-weight="bold" font-family="system-ui,-apple-system,sans-serif">KNET</text>
                                        </svg>
                                        <span class="text-[10px] font-medium text-white/40">{{ __('KNET') }}</span>
                                    </button>

                                    <button type="button" onclick="showUnavailable(this)"
                                        class="payment-btn payment-option relative flex flex-col items-center gap-1 rounded-xl border border-white/10 bg-white/5 px-1 py-2 text-center">
                                        <svg class="h-5 w-5" viewBox="0 0 30 20" fill="none">
                                            <rect width="30" height="20" rx="3" fill="#000"/>
                                            <text x="15" y="13.5" text-anchor="middle" fill="white" font-size="6" font-weight="bold" font-family="system-ui,-apple-system,sans-serif">Apple Pay</text>
                                        </svg>
                                        <span class="text-[10px] font-medium text-white/40">{{ __('Apple Pay') }}</span>
                                    </button>

                                    <button type="button" onclick="showUnavailable(this)"
                                        class="payment-btn payment-option relative flex flex-col items-center gap-1 rounded-xl border border-white/10 bg-white/5 px-1 py-2 text-center">
                                        <svg class="h-5 w-5" viewBox="0 0 30 20" fill="none">
                                            <rect width="30" height="20" rx="3" fill="white"/>
                                            <text x="15" y="13.5" text-anchor="middle" fill="#4285F4" font-size="6" font-weight="bold" font-family="system-ui,-apple-system,sans-serif">G Pay</text>
                                        </svg>
                                        <span class="text-[10px] font-medium text-white/40">{{ __('Google Pay') }}</span>
                                    </button>

                                    <button type="button" onclick="showUnavailable(this)"
                                        class="payment-btn payment-option relative flex flex-col items-center gap-1 rounded-xl border border-white/10 bg-white/5 px-1 py-2 text-center">
                                        <svg class="h-5 w-5" viewBox="0 0 30 20" fill="none">
                                            <rect width="30" height="20" rx="3" fill="#1A1F71"/>
                                            <text x="15" y="13.5" text-anchor="middle" fill="#F7B600" font-size="7" font-weight="bold" font-family="system-ui,-apple-system,sans-serif">VISA</text>
                                        </svg>
                                        <span class="text-[10px] font-medium text-white/40">{{ __('Visa / MC') }}</span>
                                    </button>
                                </div>
                                <input type="hidden" name="payment_method" id="payment_method" value="cash">
                            </div>

                            <button type="submit" id="submit-btn"
                                class="submit-btn w-full rounded-xl bg-gym-primary px-6 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25">
                                {{ __('messages.register_confirm') }}
                            </button>

                            <div class="text-center">
                                <a href="{{ route('home') }}" class="text-sm text-white/30 transition-all duration-200 hover:text-white/50 hover:tracking-wider">
                                    {{ __('messages.register_back_home') }}
                                </a>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="unavailable-modal" class="fixed inset-0 z-50 flex items-center justify-center px-4 hidden" style="background-color: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
        <div class="w-full max-w-sm rounded-2xl bg-gym-card border border-white/10 p-8 text-center shadow-2xl">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-yellow-500/10 mb-4">
                <svg class="h-7 w-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">{{ __('messages.register_unavailable_title') }}</h3>
            <p class="text-sm text-white/50 mb-6">{{ __('messages.register_unavailable_desc') }}</p>
            <button type="button" onclick="closeModal()"
                class="w-full rounded-xl bg-gym-primary px-6 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover active:scale-95">
                {{ __('messages.register_unavailable_ok') }}
            </button>
        </div>
    </div>

    @if (!empty($success))
    <div class="fixed inset-x-0 top-6 z-50 flex justify-center px-4 pointer-events-none" id="success-toast-wrapper" style="animation: toastIn 0.4s ease-out;">
        <div id="success-toast" class="pointer-events-auto w-full max-w-md rounded-2xl border border-gym-primary/30 bg-gym-dark/95 backdrop-blur-xl px-5 py-4 shadow-2xl shadow-gym-primary/10">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gym-primary/20">
                    <svg class="h-5 w-5 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white">{{ __('messages.subscription_success_title') }}</p>
                    <p class="mt-0.5 text-xs text-white/50">{{ __('messages.subscription_success_desc') }}</p>
                </div>
                <button onclick="dismissToast()" class="shrink-0 text-white/30 hover:text-white/60 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    @push('styles')
    <style>
        @keyframes toastIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        let basePrice = {{ (int) ($price ?? 29) }};
        const trainerPrice = 20;
        const lockerPrice = 5;
        let selectedPayment = 'cash';

        function selectPlan(name, price, duration, btn, label) {
            basePrice = price;
            document.getElementById('form-plan').value = name;
            document.getElementById('form-price').value = price;
            document.getElementById('form-duration').value = duration;
            document.getElementById('base-price').textContent = price + ' {{ __('messages.kwd') }}';
            document.getElementById('summary-plan-name').textContent = label;
            document.querySelectorAll('#plan-selector .plan-option').forEach(el => {
                el.classList.remove('border-gym-primary', 'bg-gym-primary/10');
                el.classList.add('border-white/10', 'bg-white/5');
            });
            btn.classList.remove('border-white/10', 'bg-white/5');
            btn.classList.add('border-gym-primary', 'bg-gym-primary/10');
            updatePrice();
        }

        function normalizePhone(input) {
            const arabic = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            const english = ['0','1','2','3','4','5','6','7','8','9'];
            let val = input.value;
            arabic.forEach((a, i) => { val = val.replace(new RegExp(a, 'g'), english[i]); });
            if (val !== input.value) input.value = val;
        }

        function toggleTrainerDropdown() {
            const menu = document.getElementById('trainer-options');
            const arrow = document.getElementById('trainer-arrow');
            menu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        }

        function selectTrainer(id, name) {
            document.getElementById('trainer-id-input').value = id;
            document.getElementById('trainer-label').textContent = name || '{{ __('messages.register_choose_trainer') }}';
            document.getElementById('trainer-label').className = 'text-sm ' + (id ? 'text-white' : 'text-white/40');
            document.getElementById('trainer-options').classList.add('hidden');
            document.getElementById('trainer-arrow').classList.remove('rotate-180');
            updatePrice();
        }

        function updatePrice() {
            const trainerId = document.getElementById('trainer-id-input')?.value;
            const lockerChecked = document.getElementById('locker')?.checked;
            const trainerRow = document.getElementById('trainer-row');
            const lockerRow = document.getElementById('locker-row');
            const totalEl = document.getElementById('total-price');

            let total = basePrice;

            if (trainerId && trainerId !== '') {
                trainerRow.style.display = 'flex';
                total += trainerPrice;
            } else {
                trainerRow.style.display = 'none';
            }

            if (lockerChecked) {
                lockerRow.style.display = 'flex';
                total += lockerPrice;
            } else {
                lockerRow.style.display = 'none';
            }

            totalEl.textContent = total + ' {{ __('messages.kwd') }}';
        }

        function selectPayment(method, btn) {
            selectedPayment = method;
            document.getElementById('payment_method').value = method;
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('border-gym-primary', 'bg-gym-primary/10', 'payment-selected');
                el.classList.add('border-white/10', 'bg-white/5');
            });
            btn.classList.remove('border-white/10', 'bg-white/5');
            btn.classList.add('border-gym-primary', 'bg-gym-primary/10', 'payment-selected');
        }

        function showUnavailable(btn) {
            document.getElementById('unavailable-modal').classList.remove('hidden');
            document.getElementById('unavailable-modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('unavailable-modal').classList.add('hidden');
            document.getElementById('unavailable-modal').classList.remove('flex');
        }

        document.getElementById('unavailable-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        document.addEventListener('click', function(e) {
            const dd = document.getElementById('trainer-dropdown');
            if (dd && !dd.contains(e.target)) {
                document.getElementById('trainer-options')?.classList.add('hidden');
                document.getElementById('trainer-arrow')?.classList.remove('rotate-180');
            }
        });

        (function() {
            const skeleton = document.getElementById('form-skeleton');
            const content = document.getElementById('form-content');
            if (skeleton && content) {
                content.style.display = 'none';
                skeleton.classList.remove('hidden');
                setTimeout(function() {
                    skeleton.classList.add('hidden');
                    content.style.display = '';
                    content.classList.remove('hidden');
                }, 200);
            }
        })();

        document.querySelectorAll('.input-field').forEach(function(input) {
            input.addEventListener('focus', function() {
                var wrapper = this.closest('div');
                if (wrapper) {
                    var err = wrapper.querySelector('.error-message');
                    if (err) err.remove();
                }
                this.classList.remove('border-red-500/50');
            });
        });

        function dismissToast() {
            var wrapper = document.getElementById('success-toast-wrapper');
            if (wrapper) {
                wrapper.style.transition = 'opacity 0.3s ease-out';
                wrapper.style.opacity = '0';
                setTimeout(function() { wrapper.remove(); }, 300);
            }
        }

        (function() {
            var wrapper = document.getElementById('success-toast-wrapper');
            if (wrapper) {
                setTimeout(dismissToast, 5000);
            }
        })();
    </script>
    @endpush
@endsection
