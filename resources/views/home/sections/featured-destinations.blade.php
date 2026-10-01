<section class="section-padding bg-white" id="destinations-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                
                <h2 class="section-title text-start mb-0">Featured Destinations</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('destinations') }}" class="btn btn-tourism-outline rounded-pill">
                    View All Attractions <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($featuredDestinations as $dest)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100">
                        <div class="card-tourism-img-wrapper">
                            <span class="badge bg-warning text-dark card-badge">
                                <i class="bi bi-tsunami me-1"></i> {{ $dest->category }}
                            </span>
                            <img src="{{ $dest->image_url }}" alt="{{ $dest->name }}">
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
                                    <a href="{{ $dest->google_map_url }}" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                        <i class="bi bi-map me-1"></i> View Maps
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('destinations') }}?id={{ $dest->id }}" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
