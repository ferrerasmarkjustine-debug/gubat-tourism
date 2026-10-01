@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 320px; background: linear-gradient(135deg, #0a6a3e 0%, #1a9e5c 60%, #0d8a7b 100%);">

    {{-- Decorative wave --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 50px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:relative;display:block;width:calc(100% + 1.3px);height:50px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z"
                  style="fill:#F4F7FA;"></path>
        </svg>
    </div>

    {{-- Floating decorative circles --}}
    <div class="position-absolute" style="width:280px;height:280px;background:rgba(255,255,255,0.04);border-radius:50%;top:-60px;right:-40px;"></div>
    <div class="position-absolute" style="width:180px;height:180px;background:rgba(255,255,255,0.06);border-radius:50%;bottom:-30px;left:8%;"></div>

    <div class="container position-relative py-5" style="z-index:3;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none small">
                                <i class="bi bi-house-door me-1"></i>Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Destinations</li>
                    </ol>
                </nav>

                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm" style="font-size:0.8rem;">
                    <i class="bi bi-geo-alt-fill me-1"></i> Tourist Attractions
                </span>
                <h1 class="display-5 fw-bold font-outfit text-white mb-3" style="line-height:1.2;text-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    Destinations &amp; <span class="text-warning">Attractions</span>
                </h1>
                <p class="lead text-white-50 mb-0" style="max-width:600px;">
                    Explore Gubat's finest tourist spots — from world-class surf breaks and pristine beaches to centuries-old heritage sites and local craft centers.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div class="text-center" style="opacity:0.15;">
                    <i class="bi bi-geo-alt" style="font-size:9rem; color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     BROWSE BY CATEGORY (reused from home/sections/categories)
================================================================ --}}
@include('home.sections.categories')

{{-- ================================================================
     FEATURED TOURIST DESTINATIONS
================================================================ --}}
<section class="section-padding bg-white" id="featured-spots-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <h2 class="section-title text-start mb-0">Featured Tourist Spots</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-patch-check-fill me-1"></i> {{ count($featuredDestinations) }} Verified Spots
                </span>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredDestinations as $dest)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100">
                        <div class="card-tourism-img-wrapper">
                            <span class="badge  text-dark card-badge" style="background-color: #0b3bfaff; color: #1e293b">
                                <i class="bi bi-tsunami me-1"></i> {{ $dest->category }}
                            </span>
                            <img src="{{ asset($dest->image_url) }}" alt="{{ $dest->name }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $dest->barangay->name ?? '' }}{{ isset($dest->barangay->name) ? ', ' : '' }}{{ $dest->municipality->name ?? 'Sorsogon' }}
                                </span>

                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $dest->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $dest->description }}</p>

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="text-warning">
                                    @php $rating = round($dest->rating); @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="small fw-bold text-dark">{{ number_format($dest->rating, 1) }}</span>
                                <span class="small text-muted">({{ $dest->reviews_count }} reviews)</span>
                            </div>

                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ $dest->google_map_url }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                        <i class="bi bi-map me-1"></i> View Maps
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ $dest->google_map_url }}" target="_blank" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================================================================
     HERITAGE & CULTURAL SPOTS (reused from home/sections/tourist-spots)
================================================================ --}}
@include('home.sections.tourist-spots')

@endsection