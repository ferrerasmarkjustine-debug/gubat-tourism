<section class="section-padding bg-white" id="nature-ecotourism-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(25, 135, 84, 0.15); color: #198754; font-size: 0.8rem;">
                    <i class="bi bi-tree-fill me-1"></i> Pristine Coastal Sanctuaries
                </span>
                <h2 class="section-title text-start mb-0">Nature & Ecotourism</h2>
                <p class="text-muted mt-2 mb-0">Explore lush mangrove corridors, marine protected reefs, and serene biodiversity parks in Gubat.</p>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('destinations') }}?category=ecotourism" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold">
                    View Eco Attractions <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($natureSpots as $spot)
                <div class="col-lg-6">
                    <div class="card card-tourism h-100 p-2">
                        <div class="row g-0 align-items-center h-100">
                            <div class="col-md-5 h-100" style="min-height: 200px;">
                                <img src="{{ $spot->image_url }}" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="{{ $spot->name }}">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    <span class="badge mb-2 fw-bold shadow-sm" style="background-color: #198754; color: #ffffff;">
                                        <i class="bi bi-tree-fill me-1"></i> {{ $spot->category }}
                                    </span>
                                    <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                                    <p class="text-muted small mb-3">{{ $spot->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $spot->barangay_name ?? 'Gubat' }}, Sorsogon</span>
                                        <a href="{{ $spot->google_map_url }}" target="_blank" class="btn btn-link text-success p-0 btn-sm fw-bold">
                                            Location Map <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
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
