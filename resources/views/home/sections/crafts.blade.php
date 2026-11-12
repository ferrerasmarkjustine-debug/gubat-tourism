<section class="section-padding bg-light" id="local-crafts-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(141, 110, 99, 0.15); color: #8D6E63; font-size: 0.8rem;">
                    <i class="bi bi-tools me-1"></i> Artisan Guilds &amp; Indigenous Livelihood
                </span>
                <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                    <h2 class="section-title text-start mb-0">Local Crafts &amp; Livelihood</h2>
                    @if(Auth::check() && Auth::user()->isLguAdmin())
                        <span class="badge bg-secondary text-white px-3 py-1.5 rounded-pill fw-bold small admin-section-controls">
                            <i class="bi bi-tools me-1"></i> {{ $craftSpots->count() }} Featured
                        </span>
                    @endif
                </div>
                <p class="text-muted mt-2 mb-0">Witness the enduring artistry of Gubat's master weavers, pottery artisans, and traditional makers.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex align-items-center gap-2 mt-2">
                        <a href="{{ route('admin.crafts.index') }}" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold text-white">
                            <i class="bi bi-plus-circle me-1"></i> Add Craft
                        </a>
                        <a href="{{ route('admin.crafts.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Crafts
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('crafts') }}" class="btn btn-tourism-outline rounded-pill">
                    Explore All Crafts <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($craftSpots as $spot)
                @php
                    $craftImg = str_starts_with($spot->image_url ?? '', 'http') 
                        ? $spot->image_url 
                        : asset($spot->image_url ?? 'images/crafts/craft_1793363252_ybYdopUBMG.jpg');
                    $bgyName = is_object($spot->barangay) ? $spot->barangay->name : ($spot->barangay ?? $spot->barangay_name ?? 'Poblacion');
                    $cGallery = is_array($spot->gallery_images) ? $spot->gallery_images : [];
                    $cProducts = is_array($spot->products) ? $spot->products : [];
                    $catName = $spot->category_name ?? $spot->craft_type ?? $spot->category ?? 'Crafts';
                @endphp
                <div class="col-lg-4 col-md-6" id="craft-card-{{ $spot->id ?? '' }}">
                    <div class="card card-tourism h-100 home-craft-card-clickable"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $spot->id }}"
                         data-title="{{ $spot->name }}"
                         data-category="{{ $catName }}"
                         data-badge-color="{{ $spot->badge_color ?? '#8D6E63' }}"
                         data-highlight="{{ $spot->highlight ?? 'Handcrafted Artisan Guild' }}"
                         data-location="Brgy. {{ $bgyName }}, Gubat"
                         data-desc="{{ $spot->description }}"
                         data-cover="{{ $craftImg }}"
                         data-gallery="{{ json_encode($cGallery) }}"
                         data-products="{{ json_encode($cProducts) }}"
                         data-map="{{ $spot->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($spot->name . ' Gubat Sorsogon') }}">
                        <div class="card-tourism-img-wrapper position-relative">
                            @if(Auth::check() && Auth::user()->isLguAdmin() && isset($spot->id))
                                <div class="admin-card-overlay">
                                    <a href="{{ route('admin.crafts.index') }}" class="admin-card-btn admin-card-btn-warning text-decoration-none" onclick="event.stopPropagation();" title="Edit this craft in Admin Portal">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <button type="button" class="admin-card-btn admin-card-btn-danger" onclick="event.stopPropagation(); unfeatureHomepageCard('{{ route('admin.crafts.toggle-featured', $spot->id) }}', this);" title="Remove from Homepage">
                                        <i class="bi bi-x-circle-fill"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <span class="badge card-badge shadow-sm fw-bold" style="background-color: {{ $spot->badge_color ?? '#8D6E63' }}; color: #ffffff;">
                                <i class="bi bi-tools me-1"></i> {{ $catName }}
                            </span>
                            @if(!empty($cGallery) && count($cGallery) > 0)
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 3;">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                        <i class="bi bi-images me-1"></i> {{ count($cGallery) + 1 }} Photos
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $craftImg . '?v=2' }}" alt="{{ $spot->name }}">
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $bgyName }}, Gubat
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
                                    <button type="button" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center text-white fw-bold view-craft-details-btn">
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
