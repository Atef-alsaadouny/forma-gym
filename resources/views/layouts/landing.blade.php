@extends('layouts.base')

@section('body')
    <div class="flex min-h-screen flex-col">
        <nav id="navbar" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gym-primary text-sm font-bold text-white">F</div>
                    <span class="text-xl font-bold">
                        <span class="text-gym-primary">{{ __('Forma') }}</span>
                        <span class="text-white">{{ __('GYM') }}</span>
                    </span>
                </a>

                <div class="hidden items-center gap-1 md:flex">
                    <a href="#hero" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_home') }}</a>
                    <a href="#about" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_about') }}</a>
                    <a href="#tour" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_tour') }}</a>
                    <a href="#trainers" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_trainers') }}</a>
                    <a href="#pricing" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_pricing') }}</a>
                    <a href="#schedule" class="nav-link relative px-3 py-2 text-sm font-medium text-white/80 transition-colors hover:text-gym-primary after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gym-primary after:transition-all after:duration-300 hover:after:w-full">{{ __('messages.nav_schedule') }}</a>

                    <div class="ms-3 border-s border-white/20 ps-3">
                        @if (app()->getLocale() === 'ar')
                            <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-medium text-white/60 transition-colors hover:text-gym-primary" style="margin: 0 10px;">EN</a>
                        @else
                            <a href="{{ route('locale.switch', 'ar') }}" class="text-xs font-medium text-white/60 transition-colors hover:text-gym-primary" style="margin: 0 10px;">عربي</a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 md:hidden">
                    <div class="flex items-center">
                        @if (app()->getLocale() === 'ar')
                            <a href="{{ route('locale.switch', 'en') }}" class="text-xs font-semibold text-white/50 transition-colors duration-200 hover:text-gym-primary px-2 py-1 rounded-lg border border-white/10 hover:border-gym-primary/30">EN</a>
                        @else
                            <a href="{{ route('locale.switch', 'ar') }}" class="text-xs font-semibold text-white/50 transition-colors duration-200 hover:text-gym-primary px-2 py-1 rounded-lg border border-white/10 hover:border-gym-primary/30">عربي</a>
                        @endif
                    </div>
                    <button id="mobile-menu-btn" class="text-white">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden border-t border-white/10 bg-gym-dark/98 backdrop-blur-md md:hidden">
                <div class="space-y-1 px-4 py-3">
                    <a href="#hero" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_home') }}</a>
                    <a href="#about" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_about') }}</a>
                    <a href="#tour" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_tour') }}</a>
                    <a href="#trainers" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_trainers') }}</a>
                    <a href="#pricing" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_pricing') }}</a>
                    <a href="#schedule" class="nav-link block rounded-md px-3 py-2 text-sm font-medium text-white/80 hover:bg-white/5">{{ __('messages.nav_schedule') }}</a>
                </div>
            </div>
        </nav>

        <main class="flex-1">
            @yield('content')
        </main>

        @push('scripts')
        <script>
            document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
                anchor.addEventListener('click', function(e) {
                    var target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        e.preventDefault();
                        var navbar = document.getElementById('navbar');
                        var offset = navbar ? navbar.offsetHeight : 0;
                        var targetPos = target.getBoundingClientRect().top + window.pageYOffset - offset - 16;
                        window.scrollTo({ top: Math.max(targetPos, 0), behavior: 'smooth' });
                    }
                });
            });
        </script>
        @endpush

        <footer id="contact" class="bg-gym-dark">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 reveal" style="transition-duration: 1.6s;">
                <div class="flex flex-col gap-6 md:flex-row md:items-start">

                    <div class="w-full shrink-0 sm:w-56">
                        <div class="max-h-40 aspect-[4/3] overflow-hidden rounded-2xl shadow-xl shadow-gym-dark/50 sm:aspect-square sm:max-h-none">
                            <iframe
                                src="https://www.openstreetmap.org/export/embed.html?bbox=48.0504112,29.3915440,48.0604112,29.4015440&layer=mapnik&marker=29.3965440,48.0554112"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="{{ __('messages.footer_map_title') }}">
                            </iframe>
                        </div>
                        <a href="https://maps.app.goo.gl/zYjqk3HsW5YxEMXy8?g_st=ic"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="mt-2 inline-flex items-center gap-1.5 text-sm text-gym-primary transition-colors hover:text-gym-primary-hover">
                            {{ __('messages.footer_open_in_maps') }}
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gym-primary text-sm font-bold text-white">F</div>
                            <span class="text-xl font-bold">
                                <span class="text-gym-primary">{{ __('Forma') }}</span>
                                <span class="text-white">{{ __('GYM') }}</span>
                            </span>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="mb-2 text-sm font-bold text-white/60 uppercase tracking-wider">{{ __('messages.footer_quick_links') }}</h4>
                                <ul class="space-y-1.5">
                                    <li><a href="{{ route('subscription.register') }}" class="text-sm text-white/60 transition-colors hover:text-gym-primary">{{ __('messages.footer_subscribe_now') }}</a></li>
                                    <li><a href="{{ route('subscription.lookup') }}" class="text-sm text-white/60 transition-colors hover:text-gym-primary">{{ __('messages.footer_subscription_lookup') }}</a></li>
                                    <li><a href="{{ route('rules') }}" class="text-sm text-white/60 transition-colors hover:text-gym-primary">{{ __('messages.footer_policies') }}</a></li>
                                    <li><a href="{{ route('faq') }}" class="text-sm text-white/60 transition-colors hover:text-gym-primary">{{ __('messages.footer_faq') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="mb-2 text-sm font-bold text-white/60 uppercase tracking-wider">{{ __('messages.footer_contact_us') }}</h4>
                                <ul class="space-y-1.5">
                                    <li class="flex items-center gap-2 text-sm text-white/60">
                                        <svg class="h-4 w-4 shrink-0 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        info@formagym.com
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-white/60">
                                        <svg class="h-4 w-4 shrink-0 text-gym-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        <span dir="ltr">+965 0000 0000</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-6 border-t border-white/10 pt-4 text-center sm:text-right">
                            <p class="text-sm text-white/40">
                                {{ __('messages.footer_copyright') }} &copy; {{ date('Y') }} {{ __('messages.footer_gym_name') }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
    </div>
@endsection
