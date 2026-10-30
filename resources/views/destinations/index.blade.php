@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO: THE WONDERS OF GUBAT
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 420px; background: linear-gradient(135deg, #072e54 0%, #0a5275 45%, #0f766e 80%, #15803d 100%);">

    {{-- Decorative wave divider --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 60px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:relative;display:block;width:calc(100% + 1.3px);height:60px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z"
                  style="fill:#F4F7FA;"></path>
        </svg>
    </div>

    {{-- Floating ambient glow circles --}}
    <div class="position-absolute" style="width:360px;height:360px;background:rgba(255,193,7,0.08);border-radius:50%;top:-100px;right:-40px;filter:blur(40px);"></div>
    <div class="position-absolute" style="width:260px;height:260px;background:rgba(20,184,166,0.12);border-radius:50%;bottom:-50px;left:5%;filter:blur(40px);"></div>

    <div class="container position-relative py-5" style="z-index:3;">
        <div class="row align-items-center">
            <div class="col-lg-9">
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none small">
                                <i class="bi bi-house-door me-1"></i>Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Destinations Directory</li>
                    </ol>
                </nav>

                <div class="d-inline-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase shadow-sm" style="font-size:0.8rem; letter-spacing:0.5px;">
                        <i class="bi bi-compass-fill me-1"></i> Official Tourism Directory
                    </span>
                    <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill fw-semibold shadow-sm" style="font-size:0.8rem;">
                        <i class="bi bi-patch-check-fill text-warning me-1"></i> 21 Verified Wonders
                    </span>
                </div>

                <h1 class="display-4 fw-bold font-outfit text-white mb-3" style="line-height:1.15; text-shadow:0 4px 18px rgba(0,0,0,0.4);">
                    Experience the Wonders of <br class="d-none d-md-inline">
                    <span class="text-warning">Gubat, Sorsogon</span>
                </h1>
                <p class="lead text-white-50 mb-4" style="max-width:720px; font-size:1.15rem; text-shadow:0 2px 8px rgba(0,0,0,0.3);">
                    From untamed Pacific surfing swells and a 20-meter towering coastal pine cathedral to mystical turquoise caves, hilltop shrines, and delicious seafood feasts.
                </p>

                {{-- Fast Quick Stats Pills --}}
                <div class="d-flex flex-wrap gap-2 pt-1">
                    <span class="badge bg-dark bg-opacity-40 border border-white-10 text-white rounded-pill px-3 py-2 small">
                        <i class="bi bi-tsunami text-info me-1"></i> 6 Surf & Beaches
                    </span>
                    <span class="badge bg-dark bg-opacity-40 border border-white-10 text-white rounded-pill px-3 py-2 small">
                        <i class="bi bi-tree-fill text-success me-1"></i> 4 Nature Reserves
                    </span>
                    <span class="badge bg-dark bg-opacity-40 border border-white-10 text-white rounded-pill px-3 py-2 small">
                        <i class="bi bi-bank text-warning me-1"></i> 5 Shrines & Churches
                    </span>
                    <span class="badge bg-dark bg-opacity-40 border border-white-10 text-white rounded-pill px-3 py-2 small">
                        <i class="bi bi-flower1 text-danger me-1"></i> 3 Agri-Farms
                    </span>
                    <span class="badge bg-dark bg-opacity-40 border border-white-10 text-white rounded-pill px-3 py-2 small">
                        <i class="bi bi-palette-fill text-light me-1"></i> 3 Traditional Crafts
                    </span>
                </div>
            </div>

            <div class="col-lg-3 d-none d-lg-flex justify-content-end">
                <div class="text-center p-4 rounded-4" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); box-shadow: 0 15px 35px rgba(0,0,0,0.25);">
                    <i class="bi bi-sun text-warning mb-2" style="font-size:3.5rem;"></i>
                    <h5 class="text-white fw-bold mb-1">Pacific Gateway</h5>
                    <p class="text-white-50 small mb-0">Clean Air &bull; Golden Waves &bull; Warm Smiles</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SPOTLIGHT: SIGNATURE GEMS OF GUBAT
================================================================ --}}
<section class="py-5" style="background: #F4F7FA;">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-md-8">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase mb-2 shadow-sm" style="font-size:0.75rem;">
                    <i class="bi bi-stars me-1"></i> Must-Visit Spotlights
                </span>
                <h3 class="fw-bold font-outfit text-dark mb-1">Signature Highlights of Gubat</h3>
                <p class="text-muted small mb-0">Two premier wonders that define our Pacific coastline and natural heritage.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Spotlight 1: Buenavista Tourism Hub & Beach --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100 position-relative text-white" style="background: #0f172a; min-height: 320px;">
                    <img src="{{ asset('images/destinations/buenavista_tourism_hub.jpg') }}" 
                         alt="Buenavista Tourism Hub and Beach" 
                         class="position-absolute top-0 start-0 w-100 h-100" 
                         style="object-fit:cover; opacity:0.45; transition: transform 0.6s ease;"
                         onmouseover="this.style.transform='scale(1.05)'" 
                         onmouseout="this.style.transform='scale(1)'">
                    <div class="card-body p-4 p-md-5 d-flex flex-column position-relative justify-content-end" style="z-index:2;">
                        <div class="mb-2">
                            <span class="badge bg-warning text-dark fw-bold rounded-pill px-3 py-1">
                                <i class="bi bi-tsunami me-1"></i> Beach & Food Hub
                            </span>
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-1 ms-1">
                                <i class="bi bi-geo-alt-fill me-1"></i> Brgy. Buenavista
                            </span>
                        </div>
                        <h4 class="fw-bold text-white mb-2 font-outfit">Buenavista Tourism Hub & Beach</h4>
                        <p class="text-white-50 small mb-3">
                            A lively 5-kilometer powdery beach bordered by a palm-lined baywalk promenade. Savor fresh coastal delicacies like <em>alimango</em> and <em>kuracha</em> crab, paired with authentic Bicolano <em>hinagom</em> and <em>timitim</em>.
                        </p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <a href="https://maps.google.com/?q=Buenavista+Beach+Gubat+Sorsogon" target="_blank" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark">
                                <i class="bi bi-map me-1"></i> Open in Maps
                            </a>
                            <span class="text-white-50 small">Surfing Season: Oct – Mar</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Spotlight 2: Agoho Forest Reserve --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-4 overflow-hidden h-100 position-relative text-white" style="background: #064e3b; min-height: 320px;">
                    <img src="{{ asset('images/destinations/agoho_forest_reserve.jpg') }}" 
                         alt="Agoho Forest Reserve" 
                         class="position-absolute top-0 start-0 w-100 h-100" 
                         style="object-fit:cover; opacity:0.42; transition: transform 0.6s ease;"
                         onmouseover="this.style.transform='scale(1.05)'" 
                         onmouseout="this.style.transform='scale(1)'">
                    <div class="card-body p-4 p-md-5 d-flex flex-column position-relative justify-content-end" style="z-index:2;">
                        <div class="mb-2">
                            <span class="badge bg-success text-white fw-bold rounded-pill px-3 py-1">
                                <i class="bi bi-tree-fill me-1"></i> Coastal Cathedral
                            </span>
                            <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-3 py-1 ms-1">
                                <i class="bi bi-geo-alt-fill me-1"></i> Ariman Road
                            </span>
                        </div>
                        <h4 class="fw-bold text-white mb-2 font-outfit">Agoho Forest Reserve</h4>
                        <p class="text-white-50 small mb-3">
                            A breathtaking coastal pine cathedral of towering 20-meter agoho trees that kiss the Pacific tide. Features footbridges, hanging canopy walks, picnic huts, and tranquil camping in pure nature.
                        </p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <a href="https://maps.google.com/?q=Agoho+Forest+Ariman+Gubat+Sorsogon" target="_blank" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">
                                <i class="bi bi-map me-1"></i> Open in Maps
                            </a>
                            <span class="text-white-50 small">20-Meter Tree Canopy &bull; Direct Ocean Access</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     INTERACTIVE DIRECTORY EXPLORER (SEARCH + FILTER TABS)
================================================================ --}}
<section class="py-4 bg-white border-bottom shadow-sm sticky-top" style="top:70px; z-index:100;">
    <div class="container">
        <div class="row g-3 align-items-center">
            {{-- Quick Search Input --}}
            <div class="col-lg-4 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           id="spotSearchInput" 
                           class="form-control border-start-0 bg-light" 
                           placeholder="Search spots, barangay, or keywords..."
                           aria-label="Search destinations">
                </div>
            </div>

            {{-- Filter Pills --}}
            <div class="col-lg-8 col-md-7">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end align-items-center" id="categoryFilterContainer">
                    <button class="btn rounded-pill btn-sm px-3 fw-bold filter-pill active" data-filter="all">
                        <i class="bi bi-grid-fill me-1"></i> All Wonders (<span id="count-all">{{ count($allDestinations) }}</span>)
                    </button>
                    <button class="btn rounded-pill btn-sm px-3 filter-pill" data-filter="beach">
                        <i class="bi bi-tsunami me-1"></i> Surf & Beaches
                    </button>
                    <button class="btn rounded-pill btn-sm px-3 filter-pill" data-filter="nature">
                        <i class="bi bi-tree-fill me-1"></i> Nature & Eco
                    </button>
                    <button class="btn rounded-pill btn-sm px-3 filter-pill" data-filter="faith">
                        <i class="bi bi-bank me-1"></i> Shrines & Faith
                    </button>
                    <button class="btn rounded-pill btn-sm px-3 filter-pill" data-filter="agri">
                        <i class="bi bi-flower1 me-1"></i> Agri & Parks
                    </button>
                    <button class="btn rounded-pill btn-sm px-3 filter-pill" data-filter="craft">
                        <i class="bi bi-palette-fill me-1"></i> Crafts & Heritage
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     DESTINATIONS GRID: ALL 21 SPOTS
================================================================ --}}
<section class="section-padding bg-light" id="wonders-grid-section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold font-outfit text-dark mb-0" id="resultsHeading">All Tourist Spots & Attractions</h4>
                <p class="text-muted small mb-0" id="resultsSubheading">Showing all verified destinations in Gubat, Sorsogon</p>
            </div>
            <span class="badge bg-white text-muted border px-3 py-2 rounded-pill small shadow-sm" id="visibleCountBadge">
                Showing {{ count($allDestinations) }} spots
            </span>
        </div>

        <div class="row g-4" id="destinationsContainer">
            @foreach($allDestinations as $dest)
                @php
                    $catLower = strtolower($dest->category ?? '');
                    
                    // Classify into filter groups
                    if (str_contains($catLower, 'surf') || str_contains($catLower, 'beach') || str_contains($catLower, 'wave')) {
                        $group = 'beach';
                        $badgeBg = '#0284c7'; // Sky/Ocean Blue
                        $badgeIcon = 'bi-tsunami';
                    } elseif (str_contains($catLower, 'nature') || str_contains($catLower, 'forest') || str_contains($catLower, 'cave') || str_contains($catLower, 'ecotourism') || str_contains($catLower, 'boardwalk') || str_contains($catLower, 'spring')) {
                        $group = 'nature';
                        $badgeBg = '#16a34a'; // Emerald Green
                        $badgeIcon = 'bi-tree-fill';
                    } elseif (str_contains($catLower, 'church') || str_contains($catLower, 'chapel') || str_contains($catLower, 'parish') || str_contains($catLower, 'grotto') || str_contains($catLower, 'shrine') || str_contains($catLower, 'pilgrimage') || str_contains($catLower, 'religious')) {
                        $group = 'faith';
                        $badgeBg = '#d97706'; // Amber/Gold
                        $badgeIcon = 'bi-bank';
                    } elseif (str_contains($catLower, 'farm') || str_contains($catLower, 'agri') || str_contains($catLower, 'park') || str_contains($catLower, 'boulevard') || str_contains($catLower, 'promenade')) {
                        $group = 'agri';
                        $badgeBg = '#0d9488'; // Teal
                        $badgeIcon = 'bi-flower1';
                    } else {
                        $group = 'craft';
                        $badgeBg = '#854d0e'; // Bronze / Brown
                        $badgeIcon = 'bi-palette-fill';
                    }

                    // Smart Image URL resolution
                    $imgUrl = \Illuminate\Support\Str::startsWith($dest->image_url ?? '', ['http://', 'https://']) 
                        ? $dest->image_url 
                        : asset($dest->image_url ?? 'images/destinations/rizal_beach.jpg') . '?v=2';
                @endphp

                <div class="col-lg-4 col-md-6 destination-item" 
                     data-group="{{ $group }}" 
                     data-name="{{ strtolower($dest->name) }}" 
                     data-desc="{{ strtolower($dest->description) }}"
                     data-category="{{ strtolower($dest->category) }}"
                     data-barangay="{{ strtolower($dest->barangay->name ?? '') }}">
                    <div class="card card-tourism h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div class="card-tourism-img-wrapper position-relative overflow-hidden" style="height: 230px;">
                            {{-- Category Badge --}}
                            <span class="badge text-white card-badge shadow-sm px-3 py-2" style="background-color: {{ $badgeBg }}; font-size: 0.75rem;">
                                <i class="bi {{ $badgeIcon }} me-1"></i> {{ $dest->category }}
                            </span>
                            
                            @if($dest->featured)
                                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm" style="z-index: 2;">
                                    <i class="bi bi-star-fill text-dark me-1"></i> Featured
                                </span>
                            @endif

                            <img src="{{ $imgUrl }}" 
                                 alt="{{ $dest->name }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover; transition: transform 0.4s ease;"
                                 loading="lazy"
                                 onerror="this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80'">
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            {{-- Location Tag --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted fw-semibold">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $dest->barangay->name ?? 'Gubat' }}, {{ $dest->municipality->name ?? 'Sorsogon' }}
                                </span>
                                <span class="badge bg-light text-secondary border small">
                                    <i class="bi bi-shield-check text-success me-1"></i> LGU Verified
                                </span>
                            </div>

                            <h5 class="card-title fw-bold text-dark mb-2 font-outfit">{{ $dest->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1 mb-3" style="line-height:1.5;">
                                {{ \Illuminate\Support\Str::limit($dest->description, 140) }}
                            </p>

                            {{-- Rating & Reviews --}}
                            <div class="d-flex align-items-center gap-2 mb-3 pt-2 border-top">
                                <div class="text-warning small">
                                    @php $rating = round($dest->rating ?? 4.8); @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="small fw-bold text-dark">{{ number_format($dest->rating ?? 4.8, 1) }}</span>
                                <span class="small text-muted">({{ $dest->reviews_count ?? 50 }} reviews)</span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ $dest->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($dest->name . ' Gubat Sorsogon') }}" 
                                       target="_blank" 
                                       class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2 text-truncate">
                                        <i class="bi bi-map me-1"></i> Maps
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="button" 
                                            class="btn btn-primary btn-sm w-100 rounded-pill py-2 text-center text-truncate btn-quick-view fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#spotQuickViewModal"
                                            style="background: var(--primary-color, #0F4C81); border:none;"
                                            data-title="{{ $dest->name }}"
                                            data-category="{{ $dest->category }}"
                                            data-badge-bg="{{ $badgeBg }}"
                                            data-badge-icon="{{ $badgeIcon }}"
                                            data-desc="{{ $dest->description }}"
                                            data-img="{{ $imgUrl }}"
                                            data-location="{{ $dest->barangay->name ?? 'Gubat' }}, {{ $dest->municipality->name ?? 'Sorsogon' }}"
                                            data-rating="{{ number_format($dest->rating ?? 4.8, 1) }}"
                                            data-reviews="{{ $dest->reviews_count ?? 50 }}"
                                            data-map="{{ $dest->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($dest->name . ' Gubat Sorsogon') }}">
                                        Explore <i class="bi bi-arrow-right-short ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- No Results State --}}
        <div id="noResultsAlert" class="text-center py-5 d-none">
            <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block" style="max-width: 500px;">
                <i class="bi bi-compass text-muted" style="font-size: 3rem;"></i>
                <h5 class="fw-bold text-dark mt-3 mb-2">No Matching Destinations Found</h5>
                <p class="text-muted small mb-3">Try adjusting your search keywords or choosing another category filter.</p>
                <button type="button" id="resetFiltersBtn" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold">
                    Reset Filters
                </button>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     QUICK VIEW MODAL FOR DETAILED HISTORY & STORY
================================================================ --}}
<div class="modal fade" id="spotQuickViewModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
            <div class="position-relative" style="height: 280px; background: #0F4C81;">
                <img id="modalImg" src="" alt="" class="w-100 h-100" style="object-fit: cover;">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, transparent 100%);">
                    <span id="modalCategoryBadge" class="badge text-white px-3 py-1 rounded-pill mb-2 shadow-sm small"></span>
                    <h3 id="modalTitle" class="text-white fw-bold mb-0 font-outfit"></h3>
                </div>
            </div>
            <div class="modal-body p-4 p-md-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-2">
                    <span class="text-muted small">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> <span id="modalLocation"></span>
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-warning small">
                            <i class="bi bi-star-fill"></i>
                        </span>
                        <span id="modalRating" class="fw-bold text-dark small"></span>
                        <span id="modalReviews" class="text-muted small"></span>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-2">About this Destination</h6>
                <p id="modalDesc" class="text-secondary mb-4" style="line-height: 1.7; font-size: 0.95rem;"></p>

                <div class="p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="fw-bold text-dark d-block small">Plan Your Visit</span>
                        <small class="text-muted">Coordinate with local tourism desks in Gubat for guiding services & transportation.</small>
                    </div>
                    <a id="modalMapBtn" href="#" target="_blank" class="btn btn-primary rounded-pill px-4 fw-bold btn-sm shadow-sm">
                        <i class="bi bi-compass me-1"></i> Open in Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Style for Filter Pills --}}
<style>
    .filter-pill {
        background-color: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
    }
    .filter-pill:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    .filter-pill.active {
        background-color: var(--primary-color, #0F4C81) !important;
        color: #ffffff !important;
        border-color: var(--primary-color, #0F4C81) !important;
        box-shadow: 0 4px 12px rgba(15, 76, 129, 0.25);
    }
    .card-tourism {
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .card-tourism:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(15, 76, 129, 0.12) !important;
    }
</style>

{{-- Interactive Filter & Quick View Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-pill');
    const items = document.querySelectorAll('.destination-item');
    const searchInput = document.getElementById('spotSearchInput');
    const noResultsAlert = document.getElementById('noResultsAlert');
    const visibleCountBadge = document.getElementById('visibleCountBadge');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');

    let currentGroup = 'all';
    let searchQuery = '';

    function applyFilters() {
        let visibleCount = 0;

        items.forEach(function (item) {
            const group = item.getAttribute('data-group');
            const name = item.getAttribute('data-name') || '';
            const desc = item.getAttribute('data-desc') || '';
            const cat = item.getAttribute('data-category') || '';
            const bgy = item.getAttribute('data-barangay') || '';

            const matchesGroup = (currentGroup === 'all' || group === currentGroup);
            const matchesSearch = searchQuery === '' || 
                name.includes(searchQuery) || 
                desc.includes(searchQuery) || 
                cat.includes(searchQuery) || 
                bgy.includes(searchQuery);

            if (matchesGroup && matchesSearch) {
                item.classList.remove('d-none');
                visibleCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        visibleCountBadge.textContent = 'Showing ' + visibleCount + ' spots';

        if (visibleCount === 0) {
            noResultsAlert.classList.remove('d-none');
        } else {
            noResultsAlert.classList.add('d-none');
        }
    }

    // Filter Pill Clicks
    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentGroup = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // Search Input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilters();
        });
    }

    // Reset Button
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function () {
            searchInput.value = '';
            searchQuery = '';
            currentGroup = 'all';
            filterButtons.forEach(b => b.classList.remove('active'));
            document.querySelector('[data-filter="all"]').classList.add('active');
            applyFilters();
        });
    }

    // Quick View Modal Population
    document.querySelectorAll('.btn-quick-view').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('modalTitle').textContent = this.getAttribute('data-title');
            document.getElementById('modalDesc').textContent = this.getAttribute('data-desc');
            document.getElementById('modalImg').src = this.getAttribute('data-img');
            document.getElementById('modalLocation').textContent = this.getAttribute('data-location');
            document.getElementById('modalRating').textContent = this.getAttribute('data-rating');
            document.getElementById('modalReviews').textContent = '(' + this.getAttribute('data-reviews') + ' reviews)';
            document.getElementById('modalMapBtn').href = this.getAttribute('data-map');

            const badge = document.getElementById('modalCategoryBadge');
            badge.textContent = this.getAttribute('data-category');
            badge.style.backgroundColor = this.getAttribute('data-badge-bg');
        });
    });

    // Read URL category parameter if present
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('category');
    if (catParam) {
        let targetFilter = 'all';
        const cp = catParam.toLowerCase();
        if (cp.includes('surf') || cp.includes('beach')) targetFilter = 'beach';
        else if (cp.includes('eco') || cp.includes('nature')) targetFilter = 'nature';
        else if (cp.includes('heritage') || cp.includes('church') || cp.includes('faith')) targetFilter = 'faith';
        else if (cp.includes('craft')) targetFilter = 'craft';
        else if (cp.includes('agri') || cp.includes('farm')) targetFilter = 'agri';

        const matchingPill = document.querySelector('.filter-pill[data-filter="' + targetFilter + '"]');
        if (matchingPill) {
            filterButtons.forEach(b => b.classList.remove('active'));
            matchingPill.classList.add('active');
            currentGroup = targetFilter;
            applyFilters();
        }
    }
});
</script>

@endsection