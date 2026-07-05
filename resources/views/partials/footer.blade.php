<footer class="text-white py-5" style="background-color: #0A2540; border-top: 5px solid var(--accent-color);">
    <div class="container">
        <div class="row g-4">
            <!-- Brand & Description Column -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-uppercase mb-3 d-flex align-items-center">
                    <i class="bi bi-compass-fill text-warning me-2"></i>
                    <span>Gubat <span class="text-warning">Tourism</span></span>
                </h5>
                <p class="text-white-50 small mb-4">
                    Experience the untamed waves, rich historical churches, local livelihood weaving centers, and natural ecotourism preserves of Gubat, Sorsogon. Explore, reserve, and travel responsibly.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-outline-light btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-warning fw-bold text-uppercase mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 small hover-text-white"><i class="bi bi-chevron-right me-1"></i> Home</a></li>
                    <li class="mb-2"><a href="{{ route('resorts') }}" class="text-white-50 small hover-text-white"><i class="bi bi-chevron-right me-1"></i> Resorts</a></li>
                    <li class="mb-2"><a href="{{ route('destinations') }}" class="text-white-50 small hover-text-white"><i class="bi bi-chevron-right me-1"></i> Destinations</a></li>
                    <li class="mb-2"><a href="{{ route('events') }}" class="text-white-50 small hover-text-white"><i class="bi bi-chevron-right me-1"></i> Events</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-white-50 small hover-text-white"><i class="bi bi-chevron-right me-1"></i> About Us</a></li>
                </ul>
            </div>

            <!-- Attractions Category Column -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-warning fw-bold text-uppercase mb-3">Popular Categories</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white-50 small hover-text-white"><i class="bi bi-tag-fill me-2 text-white-50"></i> Beach & Surf Camps</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 small hover-text-white"><i class="bi bi-tag-fill me-2 text-white-50"></i> Historical Landmarks</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 small hover-text-white"><i class="bi bi-tag-fill me-2 text-white-50"></i> Heritage Parishes</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 small hover-text-white"><i class="bi bi-tag-fill me-2 text-white-50"></i> Ecotourism Preserves</a></li>
                    <li class="mb-2"><a href="#" class="text-white-50 small hover-text-white"><i class="bi bi-tag-fill me-2 text-white-50"></i> Livelihood Centers</a></li>
                </ul>
            </div>

            <!-- Contact & Office Column -->
            <div class="col-lg-3 col-md-6">
                <h6 class="text-warning fw-bold text-uppercase mb-3">Contact Us</h6>
                <p class="text-white-50 small mb-2 d-flex align-items-start">
                    <i class="bi bi-geo-alt-fill text-warning me-2 mt-1"></i>
                    <span>Municipal Tourism Office, Gubat Municipal Hall, Gubat, Sorsogon, 4710 Philippines</span>
                </p>
                <p class="text-white-50 small mb-2 d-flex align-items-center">
                    <i class="bi bi-telephone-fill text-warning me-2"></i>
                    <span>+63 (56) 311-2345</span>
                </p>
                <p class="text-white-50 small mb-2 d-flex align-items-center">
                    <i class="bi bi-envelope-fill text-warning me-2"></i>
                    <span>tourism@gubat.gov.ph</span>
                </p>
                <p class="text-white-50 small mb-0 d-flex align-items-center">
                    <i class="bi bi-clock-fill text-warning me-2"></i>
                    <span>Mon - Fri: 8:00 AM - 5:00 PM</span>
                </p>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <!-- Copyright & Credits -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="small mb-0 text-white-50">
                    &copy; {{ date('Y') }} Municipal Government of Gubat, Sorsogon. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small mb-0 text-white-50">
                    Designed & Maintained by <a href="#" class="text-warning fw-bold">Gubat LGU ICT & Tourism</a>
                </p>
            </div>
        </div>
    </div>
</footer>
