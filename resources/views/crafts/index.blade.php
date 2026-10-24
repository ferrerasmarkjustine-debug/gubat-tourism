@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 330px; background: linear-gradient(135deg, #4E342E 0%, #6D4C41 50%, #8D6E63 80%, #B45309 100%);">

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
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Crafts &amp; Livelihood</li>
                    </ol>
                </nav>

                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm" style="font-size:0.8rem;">
                    <i class="bi bi-tools me-1"></i> Indigenous Livelihood &amp; Heritage
                </span>
                <h1 class="display-5 fw-bold font-outfit text-white mb-3" style="line-height:1.2;text-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    Traditional <span class="text-warning">Crafts &amp; Livelihood</span>
                </h1>
                <p class="lead text-white-50 mb-0" style="max-width:620px;">
                    Experience the timeless artistry of Gubat. From resilient handwoven abaca products and ancestral terracotta clay pottery to artisanal delicacies and seaside woodwork.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div class="text-center" style="opacity:0.18;">
                    <i class="bi bi-tools" style="font-size:8.5rem; color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CATEGORY FILTER BAR
================================================================ --}}
<section class="py-4 bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-muted"></i>
                <span class="fw-bold small text-uppercase text-muted">Filter by Craft:</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($categories as $slug => $label)
                    <a href="{{ route('crafts', ['category' => $slug]) }}"
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold transition-all {{ $selectedCategory === $slug ? 'btn-dark text-white shadow-sm' : 'btn-outline-secondary' }}">
                        @if($slug === 'all')
                            <i class="bi bi-grid-fill me-1"></i>
                        @elseif($slug === 'abaca')
                            <i class="bi bi-bag-check-fill me-1" style="color: #8D6E63;"></i>
                        @elseif($slug === 'pottery')
                            <i class="bi bi-cup-hot-fill me-1 text-warning"></i>
                        @elseif($slug === 'culinary')
                            <i class="bi bi-heart-fill me-1 text-success"></i>
                        @else
                            <i class="bi bi-hammer me-1 text-info"></i>
                        @endif
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CRAFTS SHOWCASE GRID
================================================================ --}}
<section class="section-padding bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($crafts as $craft)
                <div class="col-lg-6">
                    <div class="card card-tourism h-100 p-3 shadow-sm border-0" style="border-radius: 18px;">
                        <div class="row g-0 h-100">
                            <div class="col-md-5 position-relative" style="min-height: 240px; border-radius: 14px; overflow: hidden;">
                                <img src="{{ asset($craft->image_url) }}" alt="{{ $craft->name }}" class="w-100 h-100" style="object-fit: cover;">
                                <span class="badge position-absolute top-0 start-0 m-3 shadow-sm fw-bold px-3 py-2 rounded-pill" style="background-color: {{ $craft->badge_color }}; color: #ffffff;">
                                    {{ $craft->category_name }}
                                </span>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-3 p-md-4 d-flex flex-column h-100">
                                    <div class="mb-1">
                                        <span class="badge bg-light text-dark border small fw-semibold">
                                            <i class="bi bi-patch-check-fill text-warning me-1"></i> {{ $craft->highlight }}
                                        </span>
                                    </div>
                                    <h4 class="fw-bold font-outfit text-dark mb-2">{{ $craft->name }}</h4>
                                    <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.6;">
                                        {{ $craft->description }}
                                    </p>

                                    {{-- Product highlights --}}
                                    @if(!empty($craft->products) && is_array($craft->products))
                                        <div class="mb-3">
                                            <small class="fw-bold text-uppercase text-muted d-block mb-1" style="font-size: 0.72rem;">Signature Products:</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($craft->products as $prod)
                                                    <span class="badge bg-white text-secondary border small px-2 py-1">
                                                        • {{ $prod }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div class="border-top pt-3 mt-auto d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $craft->address }}
                                            </small>
                                            @if(!empty($craft->contact))
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-telephone-fill text-primary me-1"></i> {{ $craft->contact }}
                                                </small>
                                            @endif
                                        </div>
                                        <a href="{{ $craft->google_map_url }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold">
                                            Directions <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block">
                        <i class="bi bi-search display-3 text-muted mb-3 d-block"></i>
                        <h4 class="fw-bold text-dark">No crafts found in this category</h4>
                        <p class="text-muted small mb-3">Try choosing a different filter above.</p>
                        <a href="{{ route('crafts') }}" class="btn btn-primary rounded-pill px-4">View All Crafts</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- LGU Community Artisan Support Callout --}}
        <div class="card mt-5 border-0 shadow-sm text-white overflow-hidden" style="background: linear-gradient(135deg, #0b2545 0%, #154c79 100%); border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-3">Community Partnership</span>
                        <h3 class="fw-bold font-outfit text-white mb-2">Support Gubat's Local Producers &amp; Weavers</h3>
                        <p class="text-white-50 mb-0" style="max-width: 650px;">
                            By purchasing directly from Gubat's artisan associations, you empower local families, sustain traditional craft techniques passed through generations, and take home authentic handmade heritage pieces.
                        </p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                        <a href="https://maps.google.com/?q=Gubat+Sorsogon" target="_blank" class="btn btn-warning btn-lg rounded-pill px-4 py-3 fw-bold text-dark shadow">
                            <i class="bi bi-compass-fill me-2"></i> Visit Artisan Studios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
