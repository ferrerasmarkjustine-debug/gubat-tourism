<section class="section-padding bg-light" id="categories-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <span class="text-uppercase text-primary fw-bold small tracking-wider">Plan Your Adventure</span>
                <h2 class="section-title">Explore Gubat By Category</h2>
                <p class="text-muted">Whether you are chasing ocean swells, tracking heritage trails, or immersing in local crafts, Gubat offers a sanctuary for every wanderer.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Surf & Beaches Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('destinations') }}?category=surfing" class="card card-tourism h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-4" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-tsunami"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Surfing & Beaches</h5>
                        <p class="text-muted small mb-0">Experience world-class Pacific swells and long stretches of pristine cream sand.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-primary fw-bold small">
                        Explore Spots <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- Heritage & History Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('destinations') }}?category=heritage" class="card card-tourism h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-4" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-bank"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Heritage & History</h5>
                        <p class="text-muted small mb-0">Walk down memory lane with centuries-old churches and landmark sites.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-success fw-bold small">
                        Explore Spots <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- Nature & Eco Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('destinations') }}?category=ecotourism" class="card card-tourism h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-4" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-tree-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Nature & Ecotourism</h5>
                        <p class="text-muted small mb-0">Reconnect with rich mangrove forests, marine preservation parks, and rivers.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-warning fw-bold small">
                        Explore Spots <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>

            <!-- Crafts & Local Food Card -->
            <div class="col-xl-3 col-md-6">
                <a href="{{ route('destinations') }}?category=livelihood" class="card card-tourism h-100 border-0 text-center p-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle mb-4" style="width: 70px; height: 70px; font-size: 2rem;">
                            <i class="bi bi-tools"></i>
                        </div>
                        <h5 class="fw-bold mb-2 text-dark">Livelihood & Crafts</h5>
                        <p class="text-muted small mb-0">Discover traditional abaca weavers, pottery, and authentic Bicolano delicacies.</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-4 text-danger fw-bold small">
                        Explore Spots <i class="bi bi-arrow-right ms-1"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
