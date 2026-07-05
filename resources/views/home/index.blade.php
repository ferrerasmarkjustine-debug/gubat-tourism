@extends('layouts.guest')

@section('content')

    <!-- 1. Hero Banner -->
    @include('home.sections.hero')

    <!-- 2. Smart Search Component -->
    @include('home.sections.search-budget')

    <!-- 3. Explore Categories -->
    @include('home.sections.categories')

    <!-- 4. Featured Destinations -->
    @include('home.sections.featured-destinations')

    <!-- 5. Featured Resorts & Accommodations -->
    @include('home.sections.destinations')

    <!-- 6. Historical Places, Churches & Livelihood Centers -->
    @include('home.sections.tourist-spots')

    <!-- 7. Upcoming Events -->
    @include('home.sections.events')

    <!-- 8. Interactive Map -->
    @include('home.sections.map')

    <!-- 9. LGU Announcements -->
    @include('home.sections.announcements')

    <!-- 10. Weather & Travel Tips -->
    @include('home.sections.weather')

    <!-- 11. Testimonials -->
    @include('home.sections.testimonials')

@endsection