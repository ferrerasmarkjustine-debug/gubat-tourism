<section class="section-padding bg-white" id="nature-ecotourism-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(25, 135, 84, 0.15); color: #198754; font-size: 0.8rem;">
                    <i class="bi bi-tree-fill me-1"></i> Pristine Coastal Sanctuaries
                </span>
                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                    <h2 class="section-title text-start mb-0">Nature &amp; Ecotourism</h2>
                    @if(Auth::check() && Auth::user()->isLguAdmin())
                        <span class="badge bg-success text-white px-3 py-1.5 rounded-pill fw-bold small admin-section-controls">
                            <i class="bi bi-tree-fill me-1"></i> {{ $natureSpots->count() }} Featured
                        </span>
                    @endif
                </div>
                <p class="text-muted mt-2 mb-0">Explore lush mangrove corridors, marine protected reefs, and serene biodiversity parks in Gubat.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex align-items-center gap-2 mt-2">
                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold text-white" onclick="openFeaturePicker('nature')">
                            <i class="bi bi-plus-circle me-1"></i> Add Nature Spot
                        </button>
                        <a href="{{ route('admin.destinations') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Destinations
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('destinations') }}?category=ecotourism" class="btn btn-tourism-outline rounded-pill">
                    View Eco Attractions <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($natureSpots as $spot)
                @php
                    $coverUrl = str_starts_with($spot->image_url ?? '', 'http')
                        ? $spot->image_url
                        : asset($spot->image_url ?? 'images/destinations/rizal_beach.jpg');
                    $bgyName = $spot->barangay->name ?? $spot->barangay_name ?? 'Gubat';
                    $munName = $spot->municipality->name ?? 'Gubat';
                    $gallery = is_array($spot->gallery_images) ? $spot->gallery_images : [];
                @endphp
                <div class="col-lg-4 col-md-6" id="dest-card-{{ $spot->id ?? '' }}">
                    <div class="card card-tourism h-100 home-spot-card-clickable"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $spot->id }}"
                         data-title="{{ $spot->name }}"
                         data-category="{{ $spot->category ?? 'Nature & Ecotourism' }}"
                         data-location="Brgy. {{ $bgyName }}, {{ $munName }}"
                         data-desc="{{ $spot->description }}"
                         data-rating="{{ number_format($spot->rating ?? 4.9, 1) }}"
                         data-reviews="{{ $spot->reviews_count ?? 18 }}"
                         data-cover="{{ $coverUrl }}"
                         data-gallery="{{ json_encode($gallery) }}"
                         data-map="{{ $spot->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($spot->name . ' Gubat Sorsogon') }}"
                         data-featured="{{ ($spot->featured ?? false) ? 1 : 0 }}"
                         data-spotlight="{{ ($spot->is_spotlight ?? false) ? 1 : 0 }}">
                        <div class="card-tourism-img-wrapper position-relative">
                            @if(Auth::check() && Auth::user()->isLguAdmin() && isset($spot->id))
                                <div class="admin-card-overlay">
                                    <button type="button" class="admin-card-btn admin-card-btn-warning" onclick="event.stopPropagation(); openAdminEditDestination(this);" title="Quick Edit this nature spot">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </button>
                                    <button type="button" class="admin-card-btn admin-card-btn-danger" onclick="event.stopPropagation(); unfeatureHomepageCard('{{ route('admin.destinations.toggle-featured', $spot->id) }}', this);" title="Remove from Homepage">
                                        <i class="bi bi-x-circle-fill"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <span class="badge card-badge shadow-sm fw-bold" style="background-color: #198754; color: #ffffff;">
                                <i class="bi bi-tree-fill me-1"></i> {{ $spot->category ?? 'Nature & Ecotourism' }}
                            </span>
                            @if(!empty($gallery) && count($gallery) > 0)
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 3;">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                        <i class="bi bi-images me-1"></i> {{ count($gallery) + 1 }} Photos
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $coverUrl . '?v=2' }}" alt="{{ $spot->name }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $bgyName }}, {{ $munName }}
                                </span>
                            </div>
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($spot->description, 110) }}</p>

                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ $spot->google_map_url }}" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
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
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-4 rounded-4 bg-white border shadow-sm d-inline-block text-center" style="max-width: 480px;">
                        <i class="bi bi-tree-fill display-6 text-muted mb-2 d-block opacity-50"></i>
                        <h6 class="fw-bold text-dark mb-1">No Nature Spots Currently Featured</h6>
                        <p class="text-muted small mb-0">Browse all ecotourism spots in the public directory or feature sites from the Admin Portal.</p>
                        @if(Auth::check() && Auth::user()->isLguAdmin())
                            <button type="button" class="btn btn-sm btn-success rounded-pill px-4 mt-3 shadow-sm fw-semibold" onclick="openFeaturePicker('nature')">
                                <i class="bi bi-plus-circle me-1"></i> Add Nature Spot to Homepage
                            </button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
