<section class="section-padding bg-light" id="categories-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                
                <h2 class="section-title">Explore Gubat By Category</h2>
                <p class="text-muted">Whether you are chasing ocean swells, booking beachfront stays, tracking heritage trails, or immersing in local crafts, Gubat offers a sanctuary for every wanderer.</p>
            </div>
        </div>

        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-5 justify-content-center">
            <!-- 1. Beach & Surfing Card -->
            <div class="col d-flex">
                <a href="{{ route('destinations') }}?category=surfing" class="card card-tourism w-100 h-100 border-0 text-center p-3 p-xxl-4 d-flex flex-column justify-content-between">
                    <div class="card-body p-0 d-flex flex-column align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-tsunami"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Beach &amp; Surfing</h5>
                        <p class="text-muted small mb-0">Experience world-class Pacific swells and long stretches of pristine cream sand.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-3 pb-3 text-primary fw-bold small">
                        View More <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- 2. Resorts & Hotels Card (Teal) -->
            <div class="col d-flex">
                <a href="{{ route('resorts') }}" class="card card-tourism w-100 h-100 border-0 text-center p-3 p-xxl-4 d-flex flex-column justify-content-between">
                    <div class="card-body p-0 d-flex flex-column align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 2rem; background-color: rgba(13, 148, 136, 0.15); color: #0d9488;">
                            <i class="bi bi-buildings"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Resorts &amp; Hotels</h5>
                        <p class="text-muted small mb-0">Discover beachfront resorts, cozy surf camps, native cottages, and relaxing stays.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-3 pb-3 fw-bold small" style="color: #0d9488;">
                        View More <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- 3. Heritage & History Card (Yellow) -->
            <div class="col d-flex">
                <a href="{{ route('destinations') }}?category=heritage" class="card card-tourism w-100 h-100 border-0 text-center p-3 p-xxl-4 d-flex flex-column justify-content-between">
                    <div class="card-body p-0 d-flex flex-column align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 2rem; background-color: rgba(245, 158, 11, 0.15); color: #d97706;">
                            <i class="bi bi-bank"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Heritage &amp; History</h5>
                        <p class="text-muted small mb-0">Walk down memory lane with centuries-old churches and landmark sites.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-3 pb-3 fw-bold small" style="color: #d97706;">
                         View More <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- 4. Nature & Eco Card (Green) -->
            <div class="col d-flex">
                <a href="{{ route('destinations') }}?category=ecotourism" class="card card-tourism w-100 h-100 border-0 text-center p-3 p-xxl-4 d-flex flex-column justify-content-between">
                    <div class="card-body p-0 d-flex flex-column align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-tree-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Nature &amp; Ecotourism</h5>
                        <p class="text-muted small mb-0">Reconnect with rich mangrove forests, marine preservation parks, and rivers.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-3 pb-3 text-success fw-bold small">
                         View More <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- 5. Crafts & Local Food Card (Light Brown) -->
            <div class="col d-flex">
                <a href="{{ route('crafts') }}" class="card card-tourism w-100 h-100 border-0 text-center p-3 p-xxl-4 d-flex flex-column justify-content-between">
                    <div class="card-body p-0 d-flex flex-column align-items-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 70px; height: 70px; font-size: 2rem; background-color: rgba(141, 110, 99, 0.15); color: #8D6E63;">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Livelihood &amp; Crafts</h5>
                        <p class="text-muted small mb-0">Discover traditional abaca weavers, pottery, and authentic Bicolano delicacies.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pt-3 pb-3 fw-bold small" style="color: #8D6E63;">
                         View More <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
