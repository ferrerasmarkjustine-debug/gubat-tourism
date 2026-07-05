<div class="container" id="search-widget" style="position: relative; z-index: 10; margin-top: -60px;">
    <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: visible;">
        <div class="card-body p-4 p-md-5 bg-white" style="border-radius: 20px;">
            <h4 class="fw-bold mb-4 d-flex align-items-center text-gradient">
                <i class="bi bi-search-heart-fill text-primary me-2"></i>
                Find Your Perfect Stay in Gubat
            </h4>
            
            <form action="{{ route('search') }}" method="GET" id="smartSearchForm">
                <div class="row g-3">
                    <!-- Location / Barangay Selection -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="bi bi-geo-alt-fill text-primary me-1"></i> Destination Barangay</label>
                        <select class="form-select border-2 py-2" name="barangay" style="border-radius: 10px;">
                            <option value="">All Barangays (Gubat)</option>
                            <option value="Rizal">Rizal (Surfing Hub)</option>
                            <option value="Pinontingan">Pinontingan</option>
                            <option value="Panganiban">Panganiban</option>
                            <option value="Cota-na-daco">Cota-na-daco</option>
                            <option value="Ariman">Ariman</option>
                            <option value="Bulacao">Bulacao</option>
                            <option value="Tigkiw">Tigkiw</option>
                            <option value="Paco">Paco</option>
                        </select>
                    </div>

                    <!-- Dates Selection -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="bi bi-calendar-range-fill text-primary me-1"></i> Check-in & Check-out Dates</label>
                        <div class="input-group">
                            <input type="date" class="form-control border-2 py-2" name="checkin" id="checkin" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;" min="{{ date('Y-m-d') }}">
                            <span class="input-group-text bg-light border-2 px-2"><i class="bi bi-arrow-right"></i></span>
                            <input type="date" class="form-control border-2 py-2" name="checkout" id="checkout" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                        </div>
                    </div>

                    <!-- Guests & Rooms Selector -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-bold text-muted"><i class="bi bi-people-fill text-primary me-1"></i> Guests & Rooms</label>
                        <div class="input-group">
                            <input type="number" class="form-control border-2 py-2" name="guests" placeholder="Guests" min="1" max="20" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">
                            <span class="input-group-text bg-light border-2 px-2"><i class="bi bi-house"></i></span>
                            <input type="number" class="form-control border-2 py-2" name="rooms" placeholder="Rooms" min="1" max="10" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                        </div>
                    </div>

                    <!-- Search Button -->
                    <div class="col-lg-2 col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-tourism-primary w-100 py-2 d-flex align-items-center justify-content-center" style="height: 48px; border-radius: 10px;">
                            <i class="bi bi-search me-2"></i> Search
                        </button>
                    </div>
                </div>

                <!-- Toggle for Advanced Filters -->
                <div class="mt-4">
                    <button class="btn btn-link text-decoration-none p-0 d-flex align-items-center fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#advancedFilters" aria-expanded="false" aria-controls="advancedFilters">
                        <i class="bi bi-sliders me-2"></i> Custom Filters (Budget & Amenities)
                        <i class="bi bi-chevron-down ms-2 small"></i>
                    </button>
                </div>

                <!-- Collapsible Advanced Filters Drawer -->
                <div class="collapse mt-4" id="advancedFilters">
                    <div class="card card-body border-0 bg-light p-4" style="border-radius: 15px;">
                        <div class="row g-4">
                            <!-- Budget Slider / Selector -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted mb-2">
                                    <i class="bi bi-wallet2 text-primary me-1"></i> Max Nightly Budget (₱)
                                </label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="range" class="form-range flex-grow-1" id="budgetRange" min="500" max="15000" step="500" value="5000" name="budget">
                                    <span class="badge bg-primary fs-6 p-2" id="budgetValue" style="min-width: 80px; border-radius: 8px;">₱5,000</span>
                                </div>
                            </div>

                            <!-- Category Selection -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted mb-2">
                                    <i class="bi bi-tag text-primary me-1"></i> Resort Category
                                </label>
                                <select class="form-select border-0 shadow-sm" name="category" style="border-radius: 8px;">
                                    <option value="">All Categories</option>
                                    <option value="luxury">Luxury Beach Resort</option>
                                    <option value="eco">Eco Surf Camp</option>
                                    <option value="homestay">Homestay & Villa</option>
                                    <option value="budget">Budget Lodging</option>
                                </select>
                            </div>

                            <!-- Accommodation Type -->
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted mb-2">
                                    <i class="bi bi-house-gear text-primary me-1"></i> Accommodation Type
                                </label>
                                <select class="form-select border-0 shadow-sm" name="type" style="border-radius: 8px;">
                                    <option value="">All Types</option>
                                    <option value="room">Private Room</option>
                                    <option value="cottage">Nipa Cottage</option>
                                    <option value="villa">Entire Villa</option>
                                    <option value="dorm">Dormitory Bed</option>
                                </select>
                            </div>

                            <!-- Amenities Checkboxes -->
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted mb-2"><i class="bi bi-check-circle-fill text-primary me-1"></i> Desired Amenities</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="wifi" name="amenities[]" value="wifi">
                                        <label class="form-check-label small" for="wifi"><i class="bi bi-wifi me-1 text-muted"></i> Free WiFi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="ac" name="amenities[]" value="ac">
                                        <label class="form-check-label small" for="ac"><i class="bi bi-wind me-1 text-muted"></i> Air Conditioning</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pool" name="amenities[]" value="pool">
                                        <label class="form-check-label small" for="pool"><i class="bi bi-water me-1 text-muted"></i> Swimming Pool</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="parking" name="amenities[]" value="parking">
                                        <label class="form-check-label small" for="parking"><i class="bi bi-p-circle me-1 text-muted"></i> Free Parking</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="restaurant" name="amenities[]" value="restaurant">
                                        <label class="form-check-label small" for="restaurant"><i class="bi bi-egg-fried me-1 text-muted"></i> On-site Restaurant</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="pet" name="amenities[]" value="pet">
                                        <label class="form-check-label small" for="pet"><i class="bi bi-heart-pulse me-1 text-muted"></i> Pet Friendly</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Smart Search Event Handlers -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dynamic Budget Slider Value Indicator
        const budgetRange = document.getElementById('budgetRange');
        const budgetValue = document.getElementById('budgetValue');
        
        if (budgetRange && budgetValue) {
            budgetRange.addEventListener('input', function() {
                const formatted = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP', maximumFractionDigits: 0 }).format(this.value);
                budgetValue.textContent = formatted;
            });
        }

        // Date verification: Check-out must be after check-in
        const checkinInput = document.getElementById('checkin');
        const checkoutInput = document.getElementById('checkout');
        
        if (checkinInput && checkoutInput) {
            checkinInput.addEventListener('change', function() {
                checkoutInput.min = this.value;
                if (checkoutInput.value && checkoutInput.value < this.value) {
                    checkoutInput.value = this.value;
                }
            });
        }
    });
</script>