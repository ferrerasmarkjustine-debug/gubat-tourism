@extends('layouts.guest')

@section('content')

<!-- Hero Sub-header Section -->
<div class="bg-gradient py-5 text-white" style="background: linear-gradient(135deg, var(--dark-color), var(--primary-color)); border-bottom: 4px solid var(--accent-color);">
    <div class="container py-3 text-center">
        <h1 class="fw-bold font-outfit text-white mb-2">Search Results</h1>
        <p class="text-white-50 mb-0">Browse through handpicked properties and book your ideal stay in Sorsogon</p>
    </div>
</div>

<!-- Sticky Search Widget Container -->
<div class="bg-light py-4 border-bottom">
    @include('home.sections.search-budget')
</div>

<!-- Search Results & Filters Section -->
<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Quick Filters Info -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="border-radius: 15px; top: 100px; z-index: 5;">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-funnel-fill text-primary me-2"></i> Search Summary</h5>
                
                <ul class="list-unstyled mb-4 small text-muted">
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Location:</span>
                        <strong class="text-dark">{{ $municipality }}{{ $barangay ? ' - ' . $barangay : '' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Check-in:</span>
                        <strong class="text-dark">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('M j, Y') : 'Anytime' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Check-out:</span>
                        <strong class="text-dark">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('M j, Y') : 'Anytime' }}</strong>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Guests:</span>
                        <strong class="text-dark">
                            {{ $adults }} {{ Str::plural('adult', $adults) }}{{ $children > 0 ? ', ' . $children . ' ' . Str::plural('child', $children) : '' }}
                        </strong>
                    </li>
                    @if($children > 0 && !empty($childAges))
                        @php
                            $validAges = array_filter($childAges, fn($a) => $a !== '' && $a !== null);
                            $ageLabels = array_map(function($a) {
                                return ($a === '0' || $a === 0) ? 'Under 1' : $a . ' yrs';
                            }, $validAges);
                        @endphp
                        @if(!empty($ageLabels))
                            <li class="mb-2 d-flex justify-content-between">
                                <span>Child Ages:</span>
                                <strong class="text-dark">{{ implode(', ', $ageLabels) }}</strong>
                            </li>
                        @endif
                    @endif
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Rooms:</span>
                        <strong class="text-dark">{{ $roomsRequested }} {{ Str::plural('room', $roomsRequested) }}</strong>
                    </li>
                </ul>

                <hr class="my-3 text-muted">

                <div class="bg-light p-3" style="border-radius: 10px;">
                    <h6 class="fw-bold text-primary mb-2"><i class="bi bi-shield-check me-1"></i> LGU Tourism Seal</h6>
                    <p class="small text-muted mb-0" style="font-size: 0.75rem;">All resorts listed on this portal undergo regular inspections to ensure safety, fair pricing, and compliance with ecological guidelines.</p>
                </div>
            </div>
        </div>

        <!-- Accommodations Results Listing -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0 font-outfit">
                    Available Stays
                    <span class="badge bg-primary fs-6 ms-2 rounded-pill">{{ $accommodations->count() }} found</span>
                </h4>
            </div>

            @if($accommodations->isEmpty())
                <!-- No Results Screen -->
                <div class="card border-0 shadow-sm p-5 text-center" style="border-radius: 20px;">
                    <div class="mb-4">
                        <i class="bi bi-emoji-frown display-1 text-muted"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-2">No Stays Found</h4>
                    <p class="text-muted max-width-md mx-auto mb-4">No accommodations match your selected criteria. Try adjusting your filters or selecting different dates.</p>
                    <a href="{{ route('home') }}" class="btn btn-tourism-primary rounded-pill px-4">
                        Back to Homepage
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($accommodations as $accommodation)
                        <div class="col-12">
                            <div class="card card-tourism border-0 p-3 h-100 bg-white" style="transition: var(--transition-smooth);">
                                <div class="row g-0 align-items-stretch h-100">
                                    <!-- Image Column -->
                                    <div class="col-md-4 position-relative" style="min-height: 200px;">
                                        <img src="{{ asset($accommodation->image_url ?? $accommodation->resort->image_url) }}" class="rounded h-100 w-100" style="object-fit: cover;" alt="{{ $accommodation->name }}">
                                        <span class="badge bg-success text-white card-badge" style="top: 15px; left: 15px; right: auto;">
                                            ₱{{ number_format($accommodation->price_per_night) }} / night
                                        </span>
                                    </div>
                                    <!-- Details Column -->
                                    <div class="col-md-8">
                                        <div class="card-body p-3 p-md-4 d-flex flex-column h-100">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <span class="badge bg-primary-subtle text-primary small fw-semibold text-uppercase mb-1" style="font-size: 0.7rem;">
                                                        {{ $accommodation->type }}
                                                    </span>
                                                    <h4 class="fw-bold text-dark mb-0 font-outfit">{{ $accommodation->name }}</h4>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                        <strong>{{ $accommodation->resort->name }}</strong> • Brgy. {{ $accommodation->resort->barangay->name }}, {{ $accommodation->resort->barangay->municipality->name }}
                                                    </small>
                                                </div>
                                            </div>

                                            <p class="text-muted small my-3 flex-grow-1">
                                                {{ $accommodation->description ?? $accommodation->resort->description }}
                                            </p>

                                            <!-- Capacity & Availability Highlights -->
                                            <div class="d-flex flex-wrap gap-2 mb-3">
                                                <span class="badge bg-light text-dark border small py-2 px-3">
                                                    <i class="bi bi-people me-1"></i> Up to {{ $accommodation->max_guests }} Guests
                                                </span>
                                                
                                                @if(isset($accommodation->available_units))
                                                    @if($accommodation->available_units <= 2)
                                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small py-2 px-3 fw-bold">
                                                            <i class="bi bi-exclamation-triangle me-1"></i> Only {{ $accommodation->available_units }} left for your dates!
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success-subtle text-success border border-success-subtle small py-2 px-3">
                                                            <i class="bi bi-check-circle me-1"></i> {{ $accommodation->available_units }} units available
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-light text-dark border small py-2 px-3">
                                                        <i class="bi bi-house me-1"></i> {{ $accommodation->total_units }} Total Units
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Amenities icons list -->
                                            <div class="d-flex flex-wrap gap-2 border-top pt-3 mt-3 align-items-center">
                                                <span class="small fw-semibold text-muted me-2">Amenities:</span>
                                                @forelse($accommodation->amenities as $amenity)
                                                    <span class="badge bg-light text-primary border p-2" title="{{ $amenity->name }}" style="font-size: 0.75rem; border-radius: 8px;">
                                                        <i class="bi {{ $amenity->icon_class }} me-1"></i> {{ $amenity->name }}
                                                    </span>
                                                @empty
                                                    <span class="small text-muted">WiFi, Parking</span>
                                                @endforelse
                                            </div>

                                            <hr class="my-3 text-muted">

                                            <!-- Booking CTA -->
                                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <div>
                                                    @if($checkIn && $checkOut)
                                                        @php
                                                            $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
                                                            if ($nights < 1) $nights = 1;
                                                            $totalEst = $accommodation->price_per_night * $nights * $roomsRequested;
                                                        @endphp
                                                        <span class="small text-muted d-block">Estimated Total ({{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}, {{ $roomsRequested }} {{ $roomsRequested === 1 ? 'room' : 'rooms' }}):</span>
                                                        <h5 class="fw-bold text-success mb-0">₱{{ number_format($totalEst) }}</h5>
                                                    @else
                                                        <span class="small text-muted">Base Price per night:</span>
                                                        <h5 class="fw-bold text-success mb-0">₱{{ number_format($accommodation->price_per_night) }}</h5>
                                                    @endif
                                                </div>
                                                <a href="{{ route('resorts') }}?id={{ $accommodation->resort->id }}&room={{ $accommodation->id }}&check_in={{ $checkIn }}&check_out={{ $checkOut }}&rooms={{ $roomsRequested }}&adults={{ $adults }}&children={{ $children }}&guests={{ $adults + $children }}" class="btn btn-tourism-primary rounded-pill px-4 fw-bold">
                                                    Reserve Stay <i class="bi bi-chevron-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection