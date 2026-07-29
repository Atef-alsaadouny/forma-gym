<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — {{ __('messages.not_found') }}</title>
    @vite(['resources/css/app.css'])
    <style>
        .error-bg {
            background: linear-gradient(135deg, #0B1115 0%, #141C22 100%);
            min-height: 100vh;
        }
        .error-glow {
            text-shadow: 0 0 60px rgba(139, 197, 63, 0.3), 0 0 120px rgba(139, 197, 63, 0.1);
        }
        .error-code {
            font-size: clamp(6rem, 15vw, 10rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #8BC53F 0%, #6ba82f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="error-bg font-sans antialiased flex items-center justify-center">
    <div class="text-center px-6">
        <div class="error-code error-glow">404</div>
        <h1 class="mt-4 text-2xl font-bold text-white sm:text-3xl">
            {{ __('messages.not_found') }}
        </h1>
        <p class="mt-3 text-base text-white/50 sm:text-lg">
            {{ __('messages.not_found_desc') }}
        </p>
        <a href="/"
           class="mt-8 inline-flex items-center gap-2 rounded-xl bg-gym-primary px-8 py-3 text-sm font-bold text-gym-dark transition-all duration-200 hover:bg-gym-primary-hover hover:shadow-lg hover:shadow-gym-primary/25 active:scale-95">
            <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('messages.back_home') }}
        </a>
    </div>
</body>
</html>
