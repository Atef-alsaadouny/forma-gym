@extends('layouts.landing')

@section('title', config('app.name', 'Forma Gym') . ' — ' . __('messages.site_description'))

@section('content')
    @include('public.sections.hero')
    @include('public.sections.features')
    @include('public.sections.tour')
    @include('public.sections.trainers')
    @include('public.sections.pricing')
    @include('public.sections.schedule')
    @include('public.sections.crossfit-card')
@endsection

@push('jsonld')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "LocalBusiness",
    "name": "Forma Gym",
    "alternateName": "فورما جيم",
    "description": "{{ __('messages.site_description') }}",
    "url": "{{ url('/') }}",
    "image": "{{ asset('images/gym-reg.jpg') }}",
    "telephone": "+965-5555-5555",
    "address": {
        "@@type": "PostalAddress",
        "addressCountry": "KW",
        "addressLocality": "Kuwait"
    },
    "openingHoursSpecification": [
        {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Saturday","Sunday"],
            "opens": "06:00",
            "closes": "02:00"
        },
        {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": "Friday",
            "opens": "13:00",
            "closes": "23:00"
        }
    ],
    "priceRange": "$$",
    "sameAs": [],
    "hasOfferCatalog": {
        "@@type": "OfferCatalog",
        "name": "Gym Subscriptions",
        "itemListElement": [
            {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "1 Month"}, "price": "29", "priceCurrency": "KWD"},
            {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "3 Months"}, "price": "69", "priceCurrency": "KWD"},
            {"@@type": "Offer", "itemOffered": {"@@type": "Service", "name": "1 Year"}, "price": "149", "priceCurrency": "KWD"}
        ]
    }
}
</script>
@endpush
