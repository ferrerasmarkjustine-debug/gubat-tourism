@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 320px; background: linear-gradient(135deg, #0f4c81 0%, #1565a8 60%, #0e7490 100%);">

    {{-- Decorative wave --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 50px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:relative;display:block;width:calc(100% + 1.3px);height:50px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z"
                  style="fill:#F4F7FA;"></path>
        </svg>
    </div>

    {{-- Floating decorative circles --}}
    <div class="position-absolute" style="width:300px;height:300px;background:rgba(255,255,255,0.04);border-radius:50%;top:-80px;right:-60px;"></div>
    <div class="position-absolute" style="width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;bottom:-40px;left:10%;"></div>

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
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Resorts</li>
                    </ol>
                </nav>

                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm" style="font-size:0.8rem;">
                    <i class="bi bi-building me-1"></i> Where To Stay
                </span>
                <h1 class="display-5 fw-bold font-outfit text-white mb-3" style="line-height:1.2;text-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    Beach Resorts &amp; <span class="text-warning">Accommodations</span>
                </h1>
                <p class="lead text-white-50 mb-0" style="max-width:600px;">
                    Find your perfect stay in Gubat — from luxury beachfront suites and eco-lodges to cozy surf cabins and family villas.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div class="text-center" style="opacity:0.15;">
                    <i class="bi bi-building" style="font-size:9rem; color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     ACCOMMODATION SEARCH PANEL — always open
================================================================ --}}
<div class="bg-light py-5" id="search-section">
    <div class="container">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: visible;">
            <div class="card-body p-4 p-md-5 bg-white" style="border-radius: 20px;">
                <h4 class="fw-bold mb-4 d-flex align-items-center text-gradient">
                    <i class="bi bi-search-heart-fill text-primary me-2"></i>
                    Find Your Perfect Stay in Gubat
                </h4>

                <form action="{{ route('search') }}" method="GET" id="smartSearchForm">
                    <div class="row g-3">
                        {{-- Location / Barangay --}}
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-bold text-muted">
                                <i class="bi bi-geo-alt-fill text-primary me-1"></i> Destination Barangay
                            </label>
                            <select class="form-select border-2 py-2" name="barangay" style="border-radius: 10px;">
                                <option value="">All Barangays (Gubat)</option>
                                <option value="Buenavista">Buenavista</option>
                                <option value="Rizal">Rizal</option>
                                <option value="Luna-Candol">Luna-Candol</option>
                                <option value="Ariman">Ariman</option>
                                <option value="Bagacay">Bagacay</option>
                                <option value="Panganiban">Panganiban</option>
                                <option value="Pinontingan">Pinontingan</option>
                                <option value="Cogon">Cogon</option>
                                <option value="Tiris">Tiris</option>
                                <option value="Paco">Paco</option>
                            </select>
                        </div>

                        {{-- Date Range --}}
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label small fw-bold text-muted">
                                <i class="bi bi-calendar-range-fill text-primary me-1"></i> Check-in &amp; Check-out Dates
                            </label>
                            <div class="input-group date-range-wrapper">
                                <span class="input-group-text bg-white border-2 border-end-0 py-2 px-3 text-primary"
                                      style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; cursor: pointer;">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <input type="text" class="form-control border-2 border-start-0 py-2 flatpickr-input-custom"
                                       id="resort_date_range" placeholder="Select dates (Check-in → Check-out)" readonly
                                       style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; padding-right: 40px;">
                                <button type="button" class="date-range-clear-btn" id="resort_clear_date_range" title="Clear selection">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                                <input type="hidden" name="check_in"  id="resort_check_in"  value="{{ request('check_in') }}">
                                <input type="hidden" name="check_out" id="resort_check_out" value="{{ request('check_out') }}">
                            </div>
                        </div>

                        {{-- Guests & Rooms --}}
                        <div class="col-lg-4 col-md-12">
                            @include('components.guest-room-selector', ['prefix' => 'resorts_search'])
                        </div>
                    </div>

                    {{-- Advanced Filters — always visible, no toggle --}}
                    <div class="mt-4">
                        <div class="card card-body border-0 bg-light p-4" style="border-radius: 15px;">
                            <p class="small fw-bold text-muted mb-3"><i class="bi bi-sliders me-2 text-primary"></i>Custom Filters (Budget &amp; Amenities)</p>
                            <div class="row g-4">
                                {{-- Budget Slider --}}
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted mb-2">
                                        <i class="bi bi-wallet2 text-primary me-1"></i> Max Nightly Budget (₱)
                                    </label>
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="range" class="form-range flex-grow-1" id="budgetRange"
                                               min="500" max="15000" step="500" value="5000" name="budget">
                                        <span class="badge bg-primary fs-6 p-2" id="budgetValue"
                                              style="min-width: 80px; border-radius: 8px;">₱5,000</span>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted mb-2">
                                        <i class="bi bi-tag text-primary me-1"></i> Resort Category
                                    </label>
                                    <select class="form-select border-0 shadow-sm" name="category" style="border-radius: 8px;">
                                        <option value="">All Categories</option>
                                        <option value="luxury">Luxury Beach Resort</option>
                                        <option value="eco">Eco Surf Camp</option>
                                        <option value="homestay">Homestay &amp; Villa</option>
                                        <option value="budget">Budget Lodging</option>
                                    </select>
                                </div>

                                {{-- Accommodation Type --}}
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted mb-2">
                                        <i class="bi bi-house-gear text-primary me-1"></i> Accommodation Type
                                    </label>
                                    <select class="form-select border-0 shadow-sm" name="type" style="border-radius: 8px;">
                                        <option value="">All Types</option>
                                        <option value="room">Private Room</option>
                                        <option value="cottage">Nipa Cottage</option>
                                        <option value="villa">Entire Villa</option>
                                        <option value="dorm">Dormitory Bed</option>
                                    </select>
                                </div>

                                {{-- Amenities Checkboxes --}}
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted mb-2">
                                        <i class="bi bi-check-circle-fill text-primary me-1"></i> Desired Amenities
                                    </label>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_wifi" name="amenities[]" value="wifi">
                                            <label class="form-check-label small" for="resort_wifi"><i class="bi bi-wifi me-1 text-muted"></i> Free WiFi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_ac" name="amenities[]" value="ac">
                                            <label class="form-check-label small" for="resort_ac"><i class="bi bi-wind me-1 text-muted"></i> Air Conditioning</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_pool" name="amenities[]" value="pool">
                                            <label class="form-check-label small" for="resort_pool"><i class="bi bi-water me-1 text-muted"></i> Swimming Pool</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_parking" name="amenities[]" value="parking">
                                            <label class="form-check-label small" for="resort_parking"><i class="bi bi-p-circle me-1 text-muted"></i> Free Parking</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_restaurant" name="amenities[]" value="restaurant">
                                            <label class="form-check-label small" for="resort_restaurant"><i class="bi bi-egg-fried me-1 text-muted"></i> On-site Restaurant</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="resort_pet" name="amenities[]" value="pet">
                                            <label class="form-check-label small" for="resort_pet"><i class="bi bi-heart-pulse me-1 text-muted"></i> Pet Friendly</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Search Button at the End of the Search Panel --}}
                    <div class="mt-4 pt-3 d-flex flex-column flex-sm-row justify-content-end align-items-sm-center gap-3">
                        <button type="submit" class="btn btn-tourism-primary px-5 py-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="border-radius: 50px; font-size: 1.05rem;">
                            <i class="bi bi-search me-2"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Search Panel JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const budgetRange = document.getElementById('budgetRange');
    const budgetValue = document.getElementById('budgetValue');
    if (budgetRange && budgetValue) {
        budgetRange.addEventListener('input', function () {
            budgetValue.textContent = new Intl.NumberFormat('en-PH', {
                style: 'currency', currency: 'PHP', maximumFractionDigits: 0
            }).format(this.value);
        });
    }

    const dateInput   = document.getElementById('resort_date_range');
    const clearBtn    = document.getElementById('resort_clear_date_range');
    const checkIn     = document.getElementById('resort_check_in');
    const checkOut    = document.getElementById('resort_check_out');

    if (dateInput && window.flatpickr) {
        let defaultDates = [];
        if (checkIn && checkIn.value && checkOut && checkOut.value) {
            defaultDates = [checkIn.value, checkOut.value];
        }

        const fp = window.flatpickr(dateInput, {
            mode: 'range',
            minDate: 'today',
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'F j, Y',
            altInputClass: 'form-control border-2 border-start-0 py-2 flatpickr-input-custom',
            defaultDate: defaultDates,
            locale: { rangeSeparator: ' → ' },
            onChange: function (selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    if (checkIn)  checkIn.value  = instance.formatDate(selectedDates[0], 'Y-m-d');
                    if (checkOut) checkOut.value = instance.formatDate(selectedDates[1], 'Y-m-d');
                    instance.close();
                    if (clearBtn) clearBtn.style.display = 'flex';
                } else if (selectedDates.length === 1) {
                    if (checkIn)  checkIn.value  = instance.formatDate(selectedDates[0], 'Y-m-d');
                    if (checkOut) checkOut.value = '';
                    if (clearBtn) clearBtn.style.display = 'flex';
                } else {
                    if (checkIn)  checkIn.value  = '';
                    if (checkOut) checkOut.value = '';
                    if (clearBtn) clearBtn.style.display = 'none';
                }
            }
        });

        if (defaultDates.length === 2 && clearBtn) clearBtn.style.display = 'flex';

        if (clearBtn) {
            clearBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                fp.clear();
                if (checkIn)  checkIn.value  = '';
                if (checkOut) checkOut.value = '';
                clearBtn.style.display = 'none';
            });
        }

        const calIcon = document.querySelector('.date-range-wrapper .input-group-text');
        if (calIcon) calIcon.addEventListener('click', function () { fp.open(); });
    }
});
</script>

{{-- ================================================================
     CATEGORY FILTER TABS
================================================================ --}}
<div class="bg-white border-bottom shadow-sm py-3 sticky-top" style="top:76px; z-index:100;">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="text-muted small fw-semibold me-1 d-none d-md-inline">Filter by:</span>
            <button class="btn rounded-pill btn-sm px-4 fw-bold resort-filter-btn active" data-filter="all" id="filter-all">
                <i class="bi bi-grid-fill me-1"></i> All Resorts
            </button>
            <button class="btn rounded-pill btn-sm px-3 resort-filter-btn" data-filter="luxury" id="filter-luxury">
                <i class="bi bi-gem me-1"></i> Luxury
            </button>
            <button class="btn rounded-pill btn-sm px-3 resort-filter-btn" data-filter="eco" id="filter-eco">
                <i class="bi bi-tree-fill me-1"></i> Eco-Friendly
            </button>
            <button class="btn rounded-pill btn-sm px-3 resort-filter-btn" data-filter="budget" id="filter-budget">
                <i class="bi bi-wallet2 me-1"></i> Budget
            </button>
            <button class="btn rounded-pill btn-sm px-3 resort-filter-btn" data-filter="homestay" id="filter-homestay">
                <i class="bi bi-house-heart me-1"></i> Homestay
            </button>
            <span class="ms-auto text-muted small d-none d-md-inline" id="resort-count-label">
                Showing <strong>{{ count($resorts) }}</strong> properties
            </span>
        </div>
    </div>
</div>


{{-- ================================================================
     ALL RESORTS GRID
================================================================ --}}
<section class="section-padding bg-light" id="all-resorts-section">
    <div class="container">

        <div class="row g-4" id="resortsGrid">
            @foreach($resorts as $resort)
                @php
                    $minPrice = isset($resort->accommodations) && $resort->accommodations->isNotEmpty()
                        ? $resort->accommodations->min('price_per_night')
                        : 1200;
                    $maxGuests = isset($resort->accommodations) && $resort->accommodations->isNotEmpty()
                        ? $resort->accommodations->max('max_guests')
                        : 4;
                    $unitsCount = isset($resort->accommodations) && $resort->accommodations->isNotEmpty()
                        ? $resort->accommodations->sum('total_units')
                        : 5;
                @endphp
                <div class="col-lg-4 col-md-6 resort-card" data-category="{{ $resort->category }}">
                    <div class="card card-tourism h-100">
                        <div class="card-tourism-img-wrapper">
                            <span class="badge bg-success text-white card-badge">From ₱{{ number_format($minPrice) }} / night</span>
                            <img src="{{ asset($resort->image_url) }}" alt="{{ $resort->name }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. {{ $resort->barangay->name ?? 'Rizal' }}, Gubat</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-1">{{ $resort->name }}</h5>
                            <p class="small text-muted mb-3">{{ $resort->description }}</p>

                            {{-- Capacity --}}
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-people me-1"></i>Max {{ $maxGuests }} Guests</span>
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-house-door me-1"></i>{{ $unitsCount }} Units</span>
                                <span class="badge bg-{{ $resort->category === 'luxury' ? 'warning' : ($resort->category === 'eco' ? 'success' : ($resort->category === 'budget' ? 'info' : 'secondary')) }}-subtle text-{{ $resort->category === 'luxury' ? 'warning' : ($resort->category === 'eco' ? 'success' : ($resort->category === 'budget' ? 'info' : 'secondary')) }} small text-capitalize">
                                    {{ ucfirst($resort->category) }}
                                </span>
                            </div>

                            {{-- Amenity Icons --}}
                            <div class="d-flex gap-3 mb-4 text-primary fs-5 border-top border-bottom py-2">
                                @if(isset($resort->accommodations) && $resort->accommodations->isNotEmpty())
                                    @php
                                        $uniqueAmenities = $resort->accommodations->flatMap(fn($acc) => $acc->amenities)->unique('id')->take(5);
                                    @endphp
                                    @forelse($uniqueAmenities as $amenity)
                                        <span title="{{ $amenity->name }}"><i class="bi {{ $amenity->icon_class }}"></i></span>
                                    @empty
                                        <span title="WiFi"><i class="bi bi-wifi"></i></span>
                                        <span title="Parking"><i class="bi bi-p-circle"></i></span>
                                    @endforelse
                                @else
                                    <span title="WiFi"><i class="bi bi-wifi"></i></span>
                                    <span title="Parking"><i class="bi bi-p-circle"></i></span>
                                @endif
                            </div>

                            {{-- Rating --}}
                            <div class="d-flex align-items-center gap-2 mb-4 mt-auto">
                                <div class="text-warning">
                                    @php $ratingVal = round($resort->rating); @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $ratingVal ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="small fw-bold text-dark">{{ number_format($resort->rating, 1) }}</span>
                                <span class="small text-muted">({{ $resort->reviews_count }} reviews)</span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ $resort->google_map_url }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                        <i class="bi bi-geo-alt me-1"></i> Location
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('booking.create', ['resort_id' => $resort->id]) }}" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center text-white fw-bold">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty state for filtered results --}}
        <div class="text-center py-5 d-none" id="noResortsFound">
            <i class="bi bi-building-slash display-1 text-muted"></i>
            <h5 class="fw-bold text-muted mt-3">No resorts found for this category.</h5>
            <button class="btn rounded-pill px-4 mt-2 resort-filter-btn" data-filter="all">Show All Resorts</button>
        </div>
    </div>
</section>

{{-- ================================================================
     FILTER BUTTON STYLES & JAVASCRIPT
================================================================ --}}
<style>
/* Filter by Category Buttons */
.resort-filter-btn {
    background-color: #ffffff !important;
    font-weight: 600;
    transition: all 0.25s ease-in-out;
    cursor: pointer;
}

/* 1. All Resorts - Yellow */
.resort-filter-btn[data-filter="all"] {
    border: 2px solid #f59e0b !important;
    color: #d97706 !important;
}
.resort-filter-btn[data-filter="all"]:hover {
    background-color: #f59e0b !important;
    color: #ffffff !important;
}
.resort-filter-btn[data-filter="all"].active {
    background-color: #f59e0b !important;
    border-color: #f59e0b !important;
    color: #ffffff !important;
}

/* 2. Luxury - Primary Ocean Blue */
.resort-filter-btn[data-filter="luxury"] {
    border: 2px solid var(--primary-color, #0F4C81) !important;
    color: var(--primary-color, #0F4C81) !important;
}
.resort-filter-btn[data-filter="luxury"]:hover {
    background-color: var(--primary-color, #0F4C81) !important;
    color: #ffffff !important;
}
.resort-filter-btn[data-filter="luxury"].active {
    background-color: var(--primary-color, #0F4C81) !important;
    border-color: var(--primary-color, #0F4C81) !important;
    color: #ffffff !important;
}

/* 3. Eco-Friendly - Green */
.resort-filter-btn[data-filter="eco"] {
    border: 2px solid #198754 !important;
    color: #198754 !important;
}
.resort-filter-btn[data-filter="eco"]:hover {
    background-color: #198754 !important;
    color: #ffffff !important;
}
.resort-filter-btn[data-filter="eco"].active {
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: #ffffff !important;
}

/* 4. Budget - Grey */
.resort-filter-btn[data-filter="budget"] {
    border: 2px solid #6c757d !important;
    color: #6c757d !important;
}
.resort-filter-btn[data-filter="budget"]:hover {
    background-color: #6c757d !important;
    color: #ffffff !important;
}
.resort-filter-btn[data-filter="budget"].active {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: #ffffff !important;
}

/* 5. Homestay - Orange */
.resort-filter-btn[data-filter="homestay"] {
    border: 2px solid #f97316 !important;
    color: #ea580c !important;
}
.resort-filter-btn[data-filter="homestay"]:hover {
    background-color: #f97316 !important;
    color: #ffffff !important;
}
.resort-filter-btn[data-filter="homestay"].active {
    background-color: #f97316 !important;
    border-color: #f97316 !important;
    color: #ffffff !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.resort-filter-btn');
    const cards      = document.querySelectorAll('.resort-card');
    const noResults  = document.getElementById('noResortsFound');
    const countLabel = document.getElementById('resort-count-label');

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = this.dataset.filter;

            // Sync active class across all filter buttons
            filterBtns.forEach(function (b) {
                b.classList.remove('active');
                if (b.dataset.filter === filter) {
                    b.classList.add('active');
                }
            });

            let visibleCount = 0;

            cards.forEach(function (card) {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (countLabel) {
                countLabel.innerHTML = 'Showing <strong>' + visibleCount + '</strong> ' + (visibleCount === 1 ? 'property' : 'properties');
            }
            if (noResults) {
                noResults.classList.toggle('d-none', visibleCount > 0);
            }
        });
    });
});
</script>

@endsection