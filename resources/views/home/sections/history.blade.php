<section class="section-padding bg-light" id="history-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(91, 60, 17, 0.12); color: #92400e; font-size: 0.8rem;">
                    <i class="bi bi-hourglass-split me-1"></i> Colonial Legacy &amp; Ancestral Landmarks
                </span>
                <h2 class="section-title">History &amp; Heritage Landmarks</h2>
                <p class="text-muted">Walk through Gubat's storied past — from ancestral Bahay na Bato homes to well-preserved Spanish-era fortifications and historical landmarks.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex justify-content-center align-items-center gap-2 mt-2">
                        <a href="{{ route('admin.destinations') }}" class="btn btn-sm btn-warning text-dark rounded-pill px-3 shadow-sm fw-semibold">
                            <i class="bi bi-plus-circle me-1"></i> Add Landmark
                        </a>
                        <a href="{{ route('admin.destinations') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Destinations
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            @foreach($historySpots as $spot)
                @php
                    $coverUrl = str_starts_with($spot->image_url ?? '', 'http')
                        ? $spot->image_url
                        : asset($spot->image_url ?? 'images/destinations/rizal_beach.jpg');
                    $bgyName = $spot->barangay->name ?? $spot->barangay_name ?? 'Poblacion';
                    $munName = $spot->municipality->name ?? 'Gubat';
                    $gallery = is_array($spot->gallery_images) ? $spot->gallery_images : [];
                @endphp
                <div class="col-lg-6" id="dest-card-{{ $spot->id ?? '' }}">
                    <div class="card card-tourism h-100 p-2 home-spot-card-clickable"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $spot->id }}"
                         data-title="{{ $spot->name }}"
                         data-category="{{ $spot->category ?? 'Historical Landmark' }}"
                         data-location="Brgy. {{ $bgyName }}, {{ $munName }}"
                         data-desc="{{ $spot->description }}"
                         data-rating="{{ number_format($spot->rating ?? 4.8, 1) }}"
                         data-reviews="{{ $spot->reviews_count ?? 15 }}"
                         data-cover="{{ $coverUrl }}"
                         data-gallery="{{ json_encode($gallery) }}"
                         data-map="{{ $spot->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($spot->name . ' Gubat Sorsogon') }}">
                        <div class="row g-0 align-items-center h-100 position-relative">
                            @if(Auth::check() && Auth::user()->isLguAdmin() && isset($spot->id))
                                <div class="admin-card-overlay">
                                    <button type="button" class="admin-card-btn admin-card-btn-warning" onclick="event.stopPropagation(); openAdminEditDestination('{{ $spot->id }}', '{{ addslashes($spot->name) }}', '{{ addslashes($spot->category ?? '') }}', '{{ addslashes($spot->description ?? '') }}', '{{ addslashes($spot->google_map_url ?? '') }}', '{{ ($spot->featured ?? false) ? 1 : 0 }}')" title="Quick Edit this landmark">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </button>
                                    <button type="button" class="admin-card-btn admin-card-btn-danger" onclick="event.stopPropagation(); unfeatureHomepageCard('{{ route('admin.destinations.toggle-featured', $spot->id) }}', this.closest('.col-lg-6'), '{{ addslashes($spot->name) }}')" title="Remove from Homepage">
                                        <i class="bi bi-x-circle-fill"></i> Remove
                                    </button>
                                </div>
                            @endif
                            <div class="col-md-5 h-100 position-relative" style="min-height: 200px;">
                                <img src="{{ $coverUrl }}" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="{{ $spot->name }}">
                                @if(!empty($gallery) && count($gallery) > 0)
                                    <div class="position-absolute top-0 start-0 m-2" style="z-index: 3;">
                                        <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                            <i class="bi bi-images me-1"></i> {{ count($gallery) + 1 }} Photos
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4 d-flex flex-column h-100">
                                    <span class="badge mb-2 fw-bold shadow-sm align-self-start" style="background-color: #92400e; color: #ffffff;">
                                        <i class="bi bi-hourglass-split me-1"></i> {{ $spot->category }}
                                    </span>
                                    <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($spot->description, 110) }}</p>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                                        <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $bgyName }}</span>
                                        <div class="d-flex gap-2">
                                            <a href="{{ $spot->google_map_url }}" target="_blank" onclick="event.stopPropagation();" class="btn btn-outline-secondary btn-sm rounded-pill px-2 py-1" style="font-size: 0.75rem;" title="View in Google Maps">
                                                <i class="bi bi-geo-alt"></i> Map
                                            </a>
                                            <button type="button" class="btn btn-tourism-primary btn-sm rounded-pill px-3 py-1 text-white fw-semibold view-spot-details-btn" style="font-size: 0.75rem;">
                                                Enlarge <i class="bi bi-arrows-fullscreen ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
