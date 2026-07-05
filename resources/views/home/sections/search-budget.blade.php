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
                        <label class="form-label small fw-bold text-muted">
                            <i class="bi bi-calendar-range-fill text-primary me-1"></i> Check-in & Check-out Dates
                        </label>
                        <div class="input-group date-range-wrapper">
                            <span class="input-group-text bg-white border-2 border-end-0 py-2 px-3 text-primary" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px; cursor: pointer;">
                                <i class="bi bi-calendar3"></i>
                            </span>
                            <input type="text" class="form-control border-2 border-start-0 py-2 flatpickr-input-custom" id="date_range" placeholder="Select dates (Check-in → Check-out)" readonly style="border-top-right-radius: 10px; border-bottom-right-radius: 10px; padding-right: 40px;">
                            
                            <!-- Clear Selection Button -->
                            <button type="button" class="date-range-clear-btn" id="clear_date_range" title="Clear selection">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                            
                            <!-- Hidden inputs for check_in and check_out -->
                            <input type="hidden" name="check_in" id="check_in" value="{{ request('check_in') }}">
                            <input type="hidden" name="check_out" id="check_out" value="{{ request('check_out') }}">
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

        // Flatpickr Date Range Picker Initialization
        const dateRangeInput = document.getElementById('date_range');
        const clearBtn = document.getElementById('clear_date_range');
        const checkInHidden = document.getElementById('check_in');
        const checkOutHidden = document.getElementById('check_out');
        
        if (dateRangeInput && window.flatpickr) {
            const initialCheckIn = checkInHidden ? checkInHidden.value : '';
            const initialCheckOut = checkOutHidden ? checkOutHidden.value : '';
            let defaultDates = [];
            
            if (initialCheckIn && initialCheckOut) {
                defaultDates = [initialCheckIn, initialCheckOut];
            }
            
            const fp = window.flatpickr(dateRangeInput, {
                mode: 'range',
                minDate: 'today',
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                altInputClass: 'form-control border-2 border-start-0 py-2 flatpickr-input-custom',
                defaultDate: defaultDates,
                locale: {
                    rangeSeparator: ' → '
                },
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const checkInDate = instance.formatDate(selectedDates[0], 'Y-m-d');
                        const checkOutDate = instance.formatDate(selectedDates[1], 'Y-m-d');
                        
                        if (checkInHidden) checkInHidden.value = checkInDate;
                        if (checkOutHidden) checkOutHidden.value = checkOutDate;
                        
                        // Close calendar popup automatically after selection of second date
                        instance.close();
                        
                        // Show clear button
                        if (clearBtn) clearBtn.style.display = 'flex';
                    } else if (selectedDates.length === 1) {
                        const checkInDate = instance.formatDate(selectedDates[0], 'Y-m-d');
                        if (checkInHidden) checkInHidden.value = checkInDate;
                        if (checkOutHidden) checkOutHidden.value = '';
                        
                        // Show clear button during selection
                        if (clearBtn) clearBtn.style.display = 'flex';
                    } else {
                        if (checkInHidden) checkInHidden.value = '';
                        if (checkOutHidden) checkOutHidden.value = '';
                        if (clearBtn) clearBtn.style.display = 'none';
                    }
                }
            });

            // Show clear button if dates were pre-filled
            if (defaultDates.length === 2 && clearBtn) {
                clearBtn.style.display = 'flex';
            }

            // Bind Clear Selection Action
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Avoid triggering flatpickr open
                    fp.clear();
                    if (checkInHidden) checkInHidden.value = '';
                    if (checkOutHidden) checkOutHidden.value = '';
                    clearBtn.style.display = 'none';
                });
            }

            // Open Flatpickr when clicking the calendar icon
            const calendarIcon = document.querySelector('.date-range-wrapper .input-group-text');
            if (calendarIcon) {
                calendarIcon.addEventListener('click', function() {
                    fp.open();
                });
            }
        }
    });
</script>