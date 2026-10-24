<section class="section-padding bg-light" id="local-crafts-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(141, 110, 99, 0.15); color: #8D6E63; font-size: 0.8rem;">
                    <i class="bi bi-tools me-1"></i> Artisan Guilds & Indigenous Livelihood
                </span>
                <h2 class="section-title text-start mb-0">Local Crafts & Livelihood</h2>
                <p class="text-muted mt-2 mb-0">Witness the enduring artistry of Gubat’s master weavers, pottery artisans, and traditional makers.</p>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('crafts') }}" class="btn btn-warning rounded-pill px-4 py-2 fw-bold shadow-sm text-dark">
                    Explore All Crafts <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($craftSpots as $spot)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100 p-2">
                        <div class="card-tourism-img-wrapper" style="height: 200px; border-radius: 14px; overflow: hidden; position: relative;">
                            <img src="{{ asset($spot->image_url) }}" class="h-100 w-100" style="object-fit: cover;" alt="{{ $spot->name }}">
                            <span class="badge position-absolute top-0 start-0 m-3 shadow-sm fw-bold" style="background-color: {{ $spot->badge_color ?? '#8D6E63' }}; color: #ffffff;">
                                <i class="bi bi-tools me-1"></i> {{ $spot->category_name ?? $spot->craft_type ?? $spot->category ?? 'Crafts' }}
                            </span>
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ $spot->description }}</p>
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                                <span class="small text-muted">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ is_object($spot->barangay) ? $spot->barangay->name : ($spot->barangay ?? $spot->barangay_name ?? 'Poblacion') }}
                                </span>
                                <a href="{{ $spot->google_map_url }}" target="_blank" class="btn btn-link text-primary p-0 btn-sm fw-bold">
                                    Location Map <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
