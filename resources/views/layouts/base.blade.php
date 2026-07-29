<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Forma Gym'))</title>

    {{-- SEO Meta --}}
    <meta name="description" content="@yield('meta_description', __('messages.site_description'))">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', config('app.name', 'Forma Gym'))">
    <meta property="og:description" content="@yield('meta_description', __('messages.site_description'))">
    <meta property="og:url" content="@yield('canonical', url()->current())">
    <meta property="og:image" content="{{ asset('images/gym-reg.jpg') }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_KW' : 'en_US' }}">
    <meta property="og:site_name" content="{{ config('app.name', 'Forma Gym') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'Forma Gym'))">
    <meta name="twitter:description" content="@yield('meta_description', __('messages.site_description'))">
    <meta name="twitter:image" content="{{ asset('images/gym-reg.jpg') }}">

    {{-- Hreflang --}}
    @php
        $currentUrl = url()->current();
        $separator = str_contains($currentUrl, '?') ? '&' : '?';
    @endphp
    <link rel="alternate" hreflang="ar" href="{{ $currentUrl . $separator . 'locale=ar' }}">
    <link rel="alternate" hreflang="en" href="{{ $currentUrl . $separator . 'locale=en' }}">
    <link rel="alternate" hreflang="x-default" href="{{ $currentUrl }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    {{-- SEO — JSON-LD --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HealthClub",
        "name": "{{ config('app.name', 'Forma Gym') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('favicon.svg') }}",
        "image": "{{ asset('images/gym-reg.jpg') }}",
        "description": "{{ __('messages.site_description') }}",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "KW"
        }
    }
    </script>
    @stack('jsonld')
</head>
<body class="h-full font-sans antialiased text-gym-text bg-gym-light overflow-x-hidden">
    @yield('body')
    @stack('scripts')
</body>
</html>
