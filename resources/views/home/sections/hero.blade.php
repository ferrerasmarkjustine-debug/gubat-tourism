<section class="position-relative overflow-hidden text-white d-flex align-items-center" style="min-height: 80vh; background: linear-gradient(rgba(15, 76, 129, 0.4), rgba(10, 37, 64, 0.85)), url('https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;">
    
    <!-- Animated Wave Shape Divider -->
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 60px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position: relative; display: block; width: calc(100% + 1.3px); height: 60px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z" style="fill: #F4F7FA;"></path>
        </svg>
    </div>

    <!-- Hero Content -->
    <div class="container position-relative py-5" style="z-index: 3;">
        <div class="row align-items-center g-5">
            <div class="col-lg-8 text-center text-lg-start">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm tracking-wider animate-float" style="font-size: 0.85rem;">
                    <i class="bi bi-star-fill me-1"></i> Ride the Wild Pacific Waves
                </span>
                <h1 class="display-3 fw-bold mb-3 font-outfit text-white" style="line-height: 1.15; text-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                    Discover the Untamed <br class="d-none d-md-inline">
                    Beauty of <span class="text-warning">Gubat, Sorsogon</span>
                </h1>
                <p class="lead text-white-50 fs-5 mb-4" style="max-width: 650px; text-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                    Welcome to the surfing sanctuary of South Luzon. Home to Lola Sayong Surf Camp, pristine sandy coastlines, historical sights, and traditional Bicolano hospitality.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="#search-widget" class="btn btn-warning btn-lg rounded-pill px-4 py-3 fw-bold text-dark d-flex align-items-center shadow">
                        <i class="bi bi-calendar-check me-2"></i> Book Accommodation
                    </a>
                    <a href="{{ route('destinations') }}" class="btn btn-outline-light btn-lg rounded-pill px-4 py-3 fw-bold d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i> Explore Attractions
                    </a>
                </div>
            </div>
            
            <!-- Side Card with Weather Preview or Quick Stat -->
            <div class="col-lg-4 d-none d-lg-block">
                <div class="card glass-panel text-white p-4 animate-float" style="background: rgba(255, 255, 255, 0.1); border-radius: 24px; border: 1px solid rgba(255,255,255,0.2);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small fw-semibold text-warning"><i class="bi bi-clock"></i> LIVE FORECAST</span>
                        <span class="badge bg-success rounded-pill">Gubat, Sorsogon</span>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-sun-fill text-warning display-4 me-3"></i>
                        <div>
                            <h2 class="mb-0 fw-bold">31°C</h2>
                            <p class="mb-0 text-white-50 small">Sunny & Perfect for Surfing</p>
                        </div>
                    </div>
                    <div class="border-top border-white-10 pt-3">
                        <div class="row text-center">
                            <div class="col-6 border-end border-white-10">
                                <small class="text-white-50 d-block">Surf Swell</small>
                                <span class="fw-bold text-warning">1.8m - Strong</span>
                            </div>
                            <div class="col-6">
                                <small class="text-white-50 d-block">Water Temp</small>
                                <span class="fw-bold text-warning">28°C</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
