<section class="section-padding bg-white" id="beach-surfing-section">
    <span id="destinations-section"></span>
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(245, 158, 11, 0.15); color: #d97706; font-size: 0.8rem;">
                    <i class="bi bi-tsunami me-1"></i> Sun, Surf &amp; Coastal Wonders
                </span>
                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                    <h2 class="section-title text-start mb-0">Featured Destinations</h2>
                    @if(Auth::check() && Auth::user()->isLguAdmin())
                        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold small admin-section-controls">
                            <i class="bi bi-star-fill me-1"></i> {{ $featuredDestinations->count() }} Featured
                        </span>
                    @endif
                </div>
                <p class="text-muted mt-2 mb-0">Discover premier beaches, coastal promenades, and world-class surfing breaks across Gubat.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex align-items-center gap-2 mt-2">
                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold text-white" onclick="openFeaturePicker('beach')">
                            <i class="bi bi-plus-circle me-1"></i> Add Destination
                        </button>
                        <a href="{{ route('admin.destinations') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Destinations
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('destinations') }}" class="btn btn-tourism-outline rounded-pill">
                    View All Attractions <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredDestinations as $dest)
                @php
                    $coverUrl = str_starts_with($dest->image_url ?? '', 'http')
                        ? $dest->image_url
                        : asset($dest->image_url ?? 'images/destinations/rizal_beach.jpg');
                @endphp
                <div class="col-lg-4 col-md-6" id="dest-card-{{ $dest->id ?? '' }}">
                    <div class="card card-tourism h-100 home-spot-card-clickable"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $dest->id }}"
                         data-title="{{ $dest->name }}"
                         data-category="{{ $dest->category }}"
                         data-location="{{ $dest->barangay->name ?? '' }}{{ isset($dest->barangay->name) ? ', ' : '' }}{{ $dest->municipality->name ?? 'Sorsogon' }}"
                         data-desc="{{ $dest->description }}"
                         data-rating="{{ number_format($dest->rating, 1) }}"
                         data-reviews="{{ $dest->reviews_count }}"
                         data-cover="{{ $coverUrl }}"
                         data-gallery="{{ json_encode($dest->gallery_images ?? []) }}"
                         data-map="{{ $dest->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($dest->name . ' Gubat Sorsogon') }}"
                         data-featured="{{ $dest->featured ? 1 : 0 }}"
                         data-spotlight="{{ ($dest->is_spotlight ?? false) ? 1 : 0 }}">
                        <div class="card-tourism-img-wrapper position-relative">
                            @if(Auth::check() && Auth::user()->isLguAdmin() && isset($dest->id))
                                <div class="admin-card-overlay">
                                    <button type="button" class="admin-card-btn admin-card-btn-warning" onclick="event.stopPropagation(); openAdminEditDestination(this);" title="Quick Edit this destination">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </button>
                                    <button type="button" class="admin-card-btn admin-card-btn-danger" onclick="event.stopPropagation(); unfeatureHomepageCard('{{ route('admin.destinations.toggle-featured', $dest->id) }}', this);" title="Remove from Homepage without deleting">
                                        <i class="bi bi-x-circle-fill"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <span class="badge bg-warning text-dark card-badge">
                                <i class="bi bi-tsunami me-1"></i> {{ $dest->category }}
                            </span>
                            @if(!empty($dest->gallery_images) && count($dest->gallery_images) > 0)
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 3;">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                        <i class="bi bi-images me-1"></i> {{ count($dest->gallery_images) + 1 }} Photos
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $coverUrl . '?v=2' }}" alt="{{ $dest->name }}">
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
                                    @php
                                        $rating = round($dest->rating);
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="small fw-bold text-dark">{{ number_format($dest->rating, 1) }}</span>
                                <span class="small text-muted">({{ $dest->reviews_count }} reviews)</span>
                            </div>

                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ $dest->google_map_url }}" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                        <i class="bi bi-map me-1"></i> View Maps
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center text-white fw-bold view-spot-details-btn">
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
