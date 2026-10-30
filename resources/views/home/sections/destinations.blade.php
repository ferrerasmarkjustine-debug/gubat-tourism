<section class="section-padding bg-light" id="resorts-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <h2 class="section-title text-start mb-0">Featured Beach Resorts & Hotels</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('resorts') }}" class="btn btn-tourism-outline rounded-pill">
                    View All Accommodations <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredResorts as $resort)
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
                    $resortAmenities = [];
                    if (isset($resort->accommodations) && $resort->accommodations->isNotEmpty()) {
                        $uniqueAmenities = $resort->accommodations->flatMap(function($acc) {
                            return $acc->amenities ?? [];
                        })->unique('id')->take(5);
                        foreach($uniqueAmenities as $am) {
                            $resortAmenities[] = ['name' => $am->name, 'icon' => $am->icon_class];
                        }
                    }
                    if (empty($resortAmenities)) {
                        $resortAmenities = [
                            ['name' => 'Free WiFi', 'icon' => 'bi-wifi'],
                            ['name' => 'Free Parking', 'icon' => 'bi-p-circle']
                        ];
                    }
                    $coverPhoto = str_starts_with($resort->image_url ?? '', 'http')
                        ? $resort->image_url
                        : asset($resort->image_url ?? 'images/resorts/gubat_bay_beach_resort.jpg');
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100 home-resort-card-clickable"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $resort->id }}"
                         data-title="{{ $resort->name }}"
                         data-category="{{ ucfirst($resort->category) }}"
                         data-location="Brgy. {{ $resort->barangay->name ?? 'Rizal' }}, Gubat"
                         data-desc="{{ $resort->description }}"
                         data-rating="{{ number_format($resort->rating, 1) }}"
                         data-reviews="{{ $resort->reviews_count }}"
                         data-min-price="{{ number_format($minPrice) }}"
                         data-max-guests="{{ $maxGuests }}"
                         data-units="{{ $unitsCount }}"
                         data-cover="{{ $coverPhoto }}"
                         data-gallery="{{ json_encode($resort->gallery_images ?? []) }}"
                         data-amenities="{{ json_encode($resortAmenities) }}"
                         data-map="{{ $resort->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($resort->name . ' Gubat Sorsogon') }}"
                         data-book="{{ route('booking.create', ['resort_id' => $resort->id]) }}">
                        <div class="card-tourism-img-wrapper position-relative">
                            <span class="badge bg-success text-white card-badge">From ₱{{ number_format($minPrice) }} / night</span>
                            @if(!empty($resort->gallery_images) && count($resort->gallery_images) > 0)
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 3;">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                        <i class="bi bi-images me-1"></i> {{ count($resort->gallery_images) + 1 }} Photos
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $coverPhoto . '?v=2' }}" alt="{{ $resort->name }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $resort->barangay->name ?? 'Rizal' }}, Gubat</span>
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-1">{{ $resort->name }}</h5>
                            <p class="small text-muted mb-3">{{ $resort->description }}</p>

                            <!-- Capacity & Key Features -->
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-people me-1"></i> Max {{ $maxGuests }} Guests</span>
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-house-door me-1"></i> {{ $unitsCount }} Units Available</span>
                            </div>

                            <!-- Amenities Icons -->
                            <div class="d-flex gap-3 mb-4 text-primary fs-5 border-top border-bottom py-2">
                                @forelse($resortAmenities as $amenity)
                                    <span title="{{ $amenity['name'] }}"><i class="bi {{ $amenity['icon'] }}"></i></span>
                                @empty
                                    <span title="Free High-speed WiFi"><i class="bi bi-wifi"></i></span>
                                    <span title="Free Parking"><i class="bi bi-p-circle"></i></span>
                                @endforelse
                            </div>

                            <!-- Ratings -->
                            <div class="d-flex align-items-center gap-2 mb-4 mt-auto">
                                <div class="text-warning">
                                    @php
                                        $ratingVal = round($resort->rating);
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $ratingVal)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="small fw-bold text-dark">{{ number_format($resort->rating, 1) }}</span>
                                <span class="small text-muted">({{ $resort->reviews_count }} reviews)</span>
                            </div>

                            <!-- Action buttons -->
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ $resort->google_map_url }}" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                        <i class="bi bi-geo-alt me-1"></i> Location
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center text-white fw-bold view-resort-details-btn">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
