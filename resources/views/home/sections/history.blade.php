<section class="section-padding bg-light" id="history-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase mb-2 shadow-sm" style="background-color: rgba(91, 60, 17, 0.12); color: #92400e; font-size: 0.8rem;">
                    <i class="bi bi-hourglass-split me-1"></i> Colonial Legacy &amp; Ancestral Landmarks
                </span>
                <h2 class="section-title">History &amp; Heritage Landmarks</h2>
                <p class="text-muted">Walk through Gubat's storied past — from ancestral Bahay na Bato homes to well-preserved Spanish-era fortifications and historical landmarks.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($historySpots as $spot)
                <div class="col-lg-6">
                    <div class="card card-tourism h-100 p-2">
                        <div class="row g-0 align-items-center h-100">
                            <div class="col-md-5 h-100" style="min-height: 200px;">
                                <img src="{{ str_starts_with($spot->image_url, 'http') ? $spot->image_url : asset($spot->image_url) }}" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="{{ $spot->name }}">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    <span class="badge mb-2 fw-bold shadow-sm" style="background-color: #92400e; color: #ffffff;">
                                        <i class="bi bi-hourglass-split me-1"></i> {{ $spot->category }}
                                    </span>
                                    <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                                    <p class="text-muted small mb-3">{{ $spot->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $spot->barangay->name ?? $spot->barangay_name ?? 'Poblacion' }}, {{ $spot->municipality->name ?? 'Gubat' }}</span>
                                        <a href="{{ $spot->google_map_url }}" target="_blank" class="btn btn-link text-warning p-0 btn-sm fw-bold">
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
