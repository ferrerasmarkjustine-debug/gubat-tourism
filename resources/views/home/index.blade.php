@extends('layouts.guest')

@section('content')

    <!-- 1. Hero Banner -->
    @include('home.sections.hero')

    <!-- 2. Smart Search Component -->
    @include('home.sections.search-budget')

    <!-- 3. Explore Categories -->
    @include('home.sections.categories')

    <!-- 4. Featured Destinations (Beach & Surfing) -->
    @include('home.sections.featured-destinations')

    <!-- 5. Featured Resorts & Accommodations -->
    @include('home.sections.destinations')

    <!-- 6. Historic Churches -->
    @include('home.sections.churches')

    <!-- 7. History & Heritage Landmarks -->
    @include('home.sections.history')

    <!-- 8. Nature & Ecotourism -->
    @include('home.sections.nature')

    <!-- 8. Traditional Crafts & Local Livelihood -->
    @include('home.sections.crafts')

    <!-- 9. Upcoming Events -->
    @include('home.sections.events')

    <!-- 10. Interactive Map -->
    @include('home.sections.map')

    <!-- 11. LGU Announcements -->
    @include('home.sections.announcements')

    <!-- 12. Weather & Travel Tips -->
    @include('home.sections.weather')

    <!-- 13. Testimonials -->
    @include('home.sections.testimonials')

    <!-- Floating Navigation Capsule (Bottom Right Corner) -->
    @include('home.partials.floating-nav')

    <!-- Enlarged Quick View Modal for Homepage Cards -->
    @include('home.partials.quick-view-modal')

@endsection