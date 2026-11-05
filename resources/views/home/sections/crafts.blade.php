<section class="section-padding bg-light" id="local-crafts-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(141, 110, 99, 0.15); color: #8D6E63; font-size: 0.8rem;">
                    <i class="bi bi-tools me-1"></i> Artisan Guilds &amp; Indigenous Livelihood
                </span>
                <h2 class="section-title text-start mb-0">Local Crafts &amp; Livelihood</h2>
                <p class="text-muted mt-2 mb-0">Witness the enduring artistry of Gubat's master weavers, pottery artisans, and traditional makers.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex align-items-center gap-2 mt-2">
                        <a href="{{ route('admin.crafts.index') }}" class="btn btn-sm btn-warning rounded-pill px-3 shadow-sm fw-semibold text-dark">
                            <i class="bi bi-plus-circle me-1"></i> Add Craft
                        </a>
                        <a href="{{ route('admin.crafts.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Crafts
                        </a>
                        <span class="badge bg-secondary rounded-pill px-3 py-2 fw-semibold" style="font-size:0.75rem;">
                            {{ $craftSpots->count() }} Featured
                        </span>
                    </div>
                @endif
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('crafts') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold shadow-sm text-dark">
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
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100 p-2 home-craft-card-clickable"
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
                        <div class="card-tourism-img-wrapper" style="height: 200px; border-radius: 14px; overflow: hidden; position: relative;">
                            @if(Auth::check() && Auth::user()->isLguAdmin() && isset($spot->id))
                                <div class="admin-card-overlay">
                                    <a href="{{ route('admin.crafts.index') }}" class="admin-card-btn admin-card-btn-warning text-decoration-none" onclick="event.stopPropagation();" title="Edit this craft in Admin Portal">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <button type="button" class="admin-card-btn admin-card-btn-danger" onclick="event.stopPropagation(); unfeatureHomepageCard('{{ route('admin.crafts.toggle-featured', $spot->id) }}', this.closest('.col-lg-4'), '{{ addslashes($spot->name) }}')" title="Remove from Homepage">
                                        <i class="bi bi-x-circle-fill"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <img src="{{ $craftImg }}" class="h-100 w-100" style="object-fit: cover;" alt="{{ $spot->name }}">
                            <span class="badge position-absolute top-0 start-0 m-3 shadow-sm fw-bold px-3 py-1.5 rounded-pill" style="background-color: {{ $spot->badge_color ?? '#8D6E63' }}; color: #ffffff;">
                                <i class="bi bi-tools me-1"></i> {{ $catName }}
                            </span>
                            @if(!empty($cGallery) && count($cGallery) > 0)
                                <div class="position-absolute top-0 end-0 m-3" style="z-index: 3;">
                                    <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                        <i class="bi bi-images me-1"></i> {{ count($cGallery) + 1 }} Photos
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($spot->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                <span class="small text-muted">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $bgyName }}
                                </span>
                                <div class="d-flex gap-2">
                                    <a href="{{ $spot->google_map_url }}" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline-secondary btn-sm rounded-pill px-2 py-1" style="font-size: 0.75rem;" title="Location Map">
                                        <i class="bi bi-geo-alt"></i> Map
                                    </a>
                                    <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 py-1 text-dark fw-bold view-craft-details-btn" style="font-size: 0.75rem;">
                                        Enlarge <i class="bi bi-arrows-fullscreen ms-1"></i>
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
