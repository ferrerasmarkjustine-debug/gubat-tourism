<section class="section-padding bg-white" id="spots-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Churches, History & Local Crafts</h2>
                <p class="text-muted">Uncover Gubat's deep-rooted history, religious heritage, and the enduring livelihood of local abaca weavers and potters.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($heritageSpots as $spot)
                <div class="col-lg-6">
                    <div class="card card-tourism h-100 p-2">
                        <div class="row g-0 align-items-center h-100">
                            <div class="col-md-5 h-100" style="min-height: 200px;">
                                <img src="{{ asset($spot->image_url) }}" class="img-fluid rounded-start h-100 w-100" style="object-fit: cover; min-height: 200px;" alt="{{ $spot->name }}">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-4">
                                    @php
                                        $catLower = strtolower($spot->category ?? '');
                                        if (str_contains($catLower, 'surf') || str_contains($catLower, 'beach')) {
                                            $badgeStyle = 'background-color: var(--primary-color, #0F4C81); color: #ffffff;';
                                            $badgeIcon = 'bi-tsunami';
                                        } elseif (str_contains($catLower, 'heritage') || str_contains($catLower, 'church') || str_contains($catLower, 'history')) {
                                            $badgeStyle = 'background-color: #f59e0b; color: #1e293b;';
                                            $badgeIcon = 'bi-bank';
                                        } elseif (str_contains($catLower, 'nature') || str_contains($catLower, 'eco')) {
                                            $badgeStyle = 'background-color: #198754; color: #ffffff;';
                                            $badgeIcon = 'bi-tree-fill';
                                        } elseif (str_contains($catLower, 'livelihood') || str_contains($catLower, 'pottery') || str_contains($catLower, 'craft')) {
                                            $badgeStyle = 'background-color: #8D6E63; color: #ffffff;';
                                            $badgeIcon = 'bi-tools';
                                        } else {
                                            $badgeStyle = 'background-color: #f59e0b; color: #1e293b;';
                                            $badgeIcon = 'bi-bank';
                                        }
                                    @endphp
                                    <span class="badge mb-2 fw-bold shadow-sm" style="{{ $badgeStyle }}">
                                        <i class="bi {{ $badgeIcon }} me-1"></i> {{ $spot->category }}
                                    </span>
                                    <h5 class="fw-bold text-dark mb-2">{{ $spot->name }}</h5>
                                    <p class="text-muted small mb-3">{{ $spot->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Brgy. {{ $spot->barangay->name ?? $spot->barangay_name ?? 'Poblacion' }}, {{ $spot->municipality->name ?? 'Gubat' }}</span>
                                        <a href="{{ $spot->google_map_url }}" target="_blank" class="btn btn-link text-primary p-0 btn-sm fw-bold">
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
