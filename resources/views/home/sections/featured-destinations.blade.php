<section class="section-padding bg-white" id="destinations-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <span class="text-uppercase text-primary fw-bold small tracking-wider">Top Attractions</span>
                <h2 class="section-title text-start mb-0">Featured Destinations</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="{{ route('destinations') }}" class="btn btn-tourism-outline rounded-pill">
                    View All Attractions <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Lola Sayong Surf Camp -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-tourism h-100">
                    <div class="card-tourism-img-wrapper">
                        <span class="badge bg-warning text-dark card-badge"><i class="bi bi-tsunami me-1"></i> Surf Haven</span>
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" alt="Lola Sayong Surf Camp">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Rizal, Gubat</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold"><i class="bi bi-patch-check-fill me-1"></i> Verified</span>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-2">Lola Sayong Surf Camp</h5>
                        <p class="card-text text-muted small flex-grow-1">A community-run surfing paradise with cottages, boards, and certified instructors. Excellent for beginners and advanced surfers alike.</p>
                        
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span class="small fw-bold text-dark">4.7</span>
                            <span class="small text-muted">(240 reviews)</span>
                        </div>

                        <div class="row g-2 mt-auto">
                            <div class="col-6">
                                <a href="https://maps.google.com/?q=Lola+Sayong+Surf+Camp+Gubat+Sorsogon" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                    <i class="bi bi-map me-1"></i> Google Maps
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('destinations') }}?id=lolasayong" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rizal Beach -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-tourism h-100">
                    <div class="card-tourism-img-wrapper">
                        <span class="badge bg-info text-dark card-badge"><i class="bi bi-water me-1"></i> Public Beach</span>
                        <img src="https://images.unsplash.com/photo-1473186578172-c141e6798cf4?auto=format&fit=crop&w=600&q=80" alt="Rizal Beach">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Rizal, Gubat</span>
                            <span class="badge bg-secondary-subtle text-secondary fw-bold">Public Space</span>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-2">Rizal Beach</h5>
                        <p class="card-text text-muted small flex-grow-1">A wide, scenic sandy beach stretching along the Pacific Ocean, famous for picnic cottages, beach volleyball, and surfing.</p>
                        
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <span class="small fw-bold text-dark">4.3</span>
                            <span class="small text-muted">(180 reviews)</span>
                        </div>

                        <div class="row g-2 mt-auto">
                            <div class="col-6">
                                <a href="https://maps.google.com/?q=Rizal+Beach+Gubat+Sorsogon" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                    <i class="bi bi-map me-1"></i> Google Maps
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('destinations') }}?id=rizalbeach" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barcelona Church (Heritage Expansion Highlight) -->
            <div class="col-lg-4 col-md-6">
                <div class="card card-tourism h-100">
                    <div class="card-tourism-img-wrapper">
                        <span class="badge bg-danger text-white card-badge"><i class="bi bi-bank me-1"></i> Heritage Landmark</span>
                        <img src="https://images.unsplash.com/photo-1590073844006-33379778ae09?auto=format&fit=crop&w=600&q=80" alt="Barcelona Church">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Barcelona, Sorsogon</span>
                            <span class="badge bg-primary-subtle text-primary fw-bold"><i class="bi bi-patch-check-fill me-1"></i> Historical</span>
                        </div>
                        <h5 class="card-title fw-bold text-dark mb-2">Barcelona Old Church</h5>
                        <p class="card-text text-muted small flex-grow-1">Built in 1874 by the Franciscans, this stone church features coral walls constructed using egg whites as a binding mortar.</p>
                        
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <span class="small fw-bold text-dark">4.9</span>
                            <span class="small text-muted">(320 reviews)</span>
                        </div>

                        <div class="row g-2 mt-auto">
                            <div class="col-6">
                                <a href="https://maps.google.com/?q=Barcelona+Church+Sorsogon" target="_blank" class="btn btn-outline-secondary btn-sm w-100 rounded-pill py-2">
                                    <i class="bi bi-map me-1"></i> Google Maps
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('destinations') }}?id=barcelonachurch" class="btn btn-tourism-primary btn-sm w-100 rounded-pill py-2 text-center">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
