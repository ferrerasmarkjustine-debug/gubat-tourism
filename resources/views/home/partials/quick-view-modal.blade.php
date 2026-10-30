<!-- Homepage Quick View Modal for Destinations & Resorts -->
<div class="modal fade" id="homeQuickViewModal" tabindex="-1" aria-labelledby="homeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
            
            {{-- Main Enlarged Photo Hero Area --}}
            <div class="position-relative bg-dark" style="height: 380px; overflow: hidden;">
                <img id="homeModalImg" src="" alt="Photo" class="w-100 h-100" style="object-fit: cover; transition: opacity 0.25s ease;">

                {{-- Close Button --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle shadow" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>

                {{-- Prev / Next Photo Overlay Controls --}}
                <button type="button" id="homeModalPrevBtn" class="btn btn-dark bg-opacity-50 text-white rounded-circle position-absolute top-50 start-0 translate-middle-y ms-3 p-0 d-none align-items-center justify-content-center shadow" style="width: 44px; height: 44px; z-index: 10;" title="Previous Photo">
                    <i class="bi bi-chevron-left fs-5"></i>
                </button>
                <button type="button" id="homeModalNextBtn" class="btn btn-dark bg-opacity-50 text-white rounded-circle position-absolute top-50 end-0 translate-middle-y me-3 p-0 d-none align-items-center justify-content-center shadow" style="width: 44px; height: 44px; z-index: 10;" title="Next Photo">
                    <i class="bi bi-chevron-right fs-5"></i>
                </button>

                {{-- Photo Counter Badge --}}
                <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                    <span id="homeModalPhotoCounter" class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill small fw-semibold shadow-sm d-none">
                        <i class="bi bi-camera-fill me-1"></i> <span id="homeModalCurrentIdx">1</span> / <span id="homeModalTotalCount">1</span>
                    </span>
                </div>

                {{-- Title & Category Gradient Overlay --}}
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.5) 60%, transparent 100%); z-index: 5;">
                    <span id="homeModalCategoryBadge" class="badge text-white px-3 py-1 rounded-pill mb-2 shadow-sm small"></span>
                    <h2 id="homeModalTitle" class="text-white fw-bold mb-0 font-outfit fs-3"></h2>
                </div>
            </div>

            {{-- Horizontal Mini-Tile Thumbnail Strip (Scrollable Left to Right) --}}
            <div id="homeModalGalleryStripContainer" class="p-3 bg-light border-bottom d-none">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-dark">
                        <i class="bi bi-images text-primary me-1"></i> Photo Gallery <small class="text-muted fw-normal">(Click thumbnail to view)</small>
                    </span>
                    <small class="text-muted"><i class="bi bi-arrow-left-right me-1"></i>Scroll left / right</small>
                </div>
                <div id="homeModalGalleryThumbnails" class="d-flex gap-2" style="overflow-x: auto; scroll-behavior: smooth; padding-bottom: 6px;">
                    {{-- Mini tiles dynamically populated here --}}
                </div>
            </div>

            <div class="modal-body p-4 p-md-5">
                {{-- Quick Stats Row --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-2">
                    <span class="text-muted small">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> <span id="homeModalLocation"></span>
                    </span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-warning small"><i class="bi bi-star-fill"></i></span>
                        <span id="homeModalRating" class="fw-bold text-dark small"></span>
                        <span id="homeModalReviews" class="text-muted small"></span>
                    </div>
                </div>

                {{-- Badges Row for Resorts (hidden for spots) --}}
                <div id="homeModalResortBadges" class="d-flex flex-wrap gap-2 mb-4 d-none">
                    <span class="badge bg-success text-white px-3 py-2 rounded-pill fw-bold" id="homeModalPrice"></span>
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small" id="homeModalGuests"><i class="bi bi-people me-1"></i>Max Guests</span>
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small" id="homeModalUnits"><i class="bi bi-house-door me-1"></i>Units</span>
                </div>

                {{-- Description --}}
                <h6 class="fw-bold text-dark mb-2" id="homeModalDescHeading">About this Attraction</h6>
                <p id="homeModalDesc" class="text-secondary mb-4" style="line-height: 1.7; font-size: 0.95rem;"></p>

                {{-- Amenities List (for Resorts) --}}
                <div id="homeModalAmenitiesContainer" class="d-none mb-4">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-check-circle-fill text-primary me-1"></i> Amenities &amp; Features</h6>
                    <div id="homeModalAmenities" class="d-flex flex-wrap gap-2"></div>
                </div>

                {{-- Action Footer --}}
                <div class="p-3 bg-light rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <span class="fw-bold text-dark d-block small" id="homeModalFooterHeading">Plan Your Visit</span>
                        <small class="text-muted" id="homeModalFooterSub">Explore Gubat, Sorsogon's rich nature and hospitality.</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a id="homeModalMapBtn" href="#" target="_blank" class="btn btn-outline-secondary rounded-pill fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2" style="height: 42px; padding: 0 1.4rem; font-size: 0.9rem; border-width: 1.5px;">
                            <i class="bi bi-geo-alt" style="font-size: 1rem; line-height: 1;"></i>
                            <span>Open in Maps</span>
                        </a>
                        <a id="homeModalActionBtn" href="#" class="btn btn-tourism-primary rounded-pill fw-bold shadow-sm text-white d-inline-flex align-items-center justify-content-center gap-2" style="height: 42px; padding: 0 1.4rem; font-size: 0.9rem;">
                            <i class="bi bi-arrow-right-circle" style="font-size: 1rem; line-height: 1;"></i>
                            <span>Explore More</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Hover Effects on Homepage */
.home-spot-card-clickable:hover,
.home-resort-card-clickable:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 28px rgba(0,0,0,0.12) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('homeQuickViewModal');
    if (!modalEl) return;

    const modalTitle         = document.getElementById('homeModalTitle');
    const modalCategoryBadge = document.getElementById('homeModalCategoryBadge');
    const modalImg           = document.getElementById('homeModalImg');
    const modalLocation      = document.getElementById('homeModalLocation');
    const modalRating        = document.getElementById('homeModalRating');
    const modalReviews       = document.getElementById('homeModalReviews');
    const modalDescHeading   = document.getElementById('homeModalDescHeading');
    const modalDesc          = document.getElementById('homeModalDesc');
    const resortBadges       = document.getElementById('homeModalResortBadges');
    const modalPrice         = document.getElementById('homeModalPrice');
    const modalGuests        = document.getElementById('homeModalGuests');
    const modalUnits         = document.getElementById('homeModalUnits');
    const amenitiesContainer = document.getElementById('homeModalAmenitiesContainer');
    const modalAmenities     = document.getElementById('homeModalAmenities');
    const modalMapBtn        = document.getElementById('homeModalMapBtn');
    const modalActionBtn     = document.getElementById('homeModalActionBtn');
    const footerHeading      = document.getElementById('homeModalFooterHeading');
    const footerSub          = document.getElementById('homeModalFooterSub');

    const prevBtn            = document.getElementById('homeModalPrevBtn');
    const nextBtn            = document.getElementById('homeModalNextBtn');
    const photoCounter       = document.getElementById('homeModalPhotoCounter');
    const currentIdxEl       = document.getElementById('homeModalCurrentIdx');
    const totalCountEl       = document.getElementById('homeModalTotalCount');

    const stripContainer     = document.getElementById('homeModalGalleryStripContainer');
    const thumbnailsBox      = document.getElementById('homeModalGalleryThumbnails');

    let currentPhotoList = [];
    let activePhotoIndex = 0;

    function formatAssetUrl(url) {
        if (!url) return '';
        if (url.startsWith('http://') || url.startsWith('https://')) return url;
        const clean = url.startsWith('/') ? url.slice(1) : url;
        return '{{ asset("") }}' + clean;
    }

    function showPhotoAtIndex(index) {
        if (!currentPhotoList.length) return;
        if (index < 0) index = currentPhotoList.length - 1;
        if (index >= currentPhotoList.length) index = 0;
        activePhotoIndex = index;

        modalImg.style.opacity = '0.35';
        setTimeout(() => {
            modalImg.src = currentPhotoList[activePhotoIndex];
            modalImg.style.opacity = '1';
        }, 120);

        if (currentIdxEl) currentIdxEl.textContent = activePhotoIndex + 1;

        if (thumbnailsBox) {
            const thumbs = thumbnailsBox.querySelectorAll('.home-mini-thumb');
            thumbs.forEach((th, i) => {
                if (i === activePhotoIndex) {
                    th.classList.add('border-primary', 'shadow');
                    th.classList.remove('border-transparent', 'opacity-75');
                    th.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    th.classList.remove('border-primary', 'shadow');
                    th.classList.add('border-transparent', 'opacity-75');
                }
            });
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            showPhotoAtIndex(activePhotoIndex - 1);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            showPhotoAtIndex(activePhotoIndex + 1);
        });
    }

    // Keyboard navigation when modal is open
    document.addEventListener('keydown', function(e) {
        if (!modalEl.classList.contains('show')) return;
        if (e.key === 'ArrowLeft') {
            showPhotoAtIndex(activePhotoIndex - 1);
        } else if (e.key === 'ArrowRight') {
            showPhotoAtIndex(activePhotoIndex + 1);
        }
    });

    // 1. OPEN SPOT / DESTINATION QUICK VIEW
    function openSpotQuickView(card) {
        const title    = card.getAttribute('data-title') || 'Destination';
        const category = card.getAttribute('data-category') || 'Attraction';
        const location = card.getAttribute('data-location') || 'Gubat, Sorsogon';
        const desc     = card.getAttribute('data-desc') || '';
        const rating   = card.getAttribute('data-rating') || '5.0';
        const reviews  = card.getAttribute('data-reviews') || '0';
        const cover    = card.getAttribute('data-cover') || '';
        const mapUrl   = card.getAttribute('data-map') || '#';

        let gallery = [];
        try {
            const raw = card.getAttribute('data-gallery');
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) gallery = parsed;
            }
        } catch(err) { gallery = []; }

        modalTitle.textContent    = title;
        modalLocation.textContent = location;
        modalDescHeading.textContent = 'About this Attraction';
        modalDesc.textContent     = desc;
        modalRating.textContent   = rating;
        modalReviews.textContent  = `(${reviews} reviews)`;

        modalCategoryBadge.textContent = category;
        modalCategoryBadge.className = 'badge bg-warning text-dark px-3 py-1 rounded-pill mb-2 shadow-sm small';

        // Hide resort specific blocks
        if (resortBadges) resortBadges.classList.add('d-none');
        if (amenitiesContainer) amenitiesContainer.classList.add('d-none');

        // Footer links
        modalMapBtn.href = mapUrl;
        modalActionBtn.href = '{{ route("destinations") }}';
        modalActionBtn.innerHTML = '<i class="bi bi-compass" style="font-size: 1rem; line-height: 1;"></i> <span>View All Attractions</span>';
        footerHeading.textContent = 'Explore All of Gubat';
        footerSub.textContent = 'Browse our complete catalog of beaches, caves, and historical landmarks.';

        setupGallery(cover, gallery, '{{ asset("images/destinations/rizal_beach.jpg") }}');

        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    // 2. OPEN RESORT QUICK VIEW
    function openResortQuickView(card) {
        const title     = card.getAttribute('data-title') || 'Resort';
        const category  = card.getAttribute('data-category') || 'Resort';
        const location  = card.getAttribute('data-location') || 'Gubat, Sorsogon';
        const desc      = card.getAttribute('data-desc') || '';
        const rating    = card.getAttribute('data-rating') || '5.0';
        const reviews   = card.getAttribute('data-reviews') || '0';
        const minPrice  = card.getAttribute('data-min-price') || '0';
        const maxGuests = card.getAttribute('data-max-guests') || '2';
        const units     = card.getAttribute('data-units') || '1';
        const cover     = card.getAttribute('data-cover') || '';
        const mapUrl    = card.getAttribute('data-map') || '#';
        const bookUrl   = card.getAttribute('data-book') || '#';

        let gallery = [];
        try {
            const raw = card.getAttribute('data-gallery');
            if (raw) {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) gallery = parsed;
            }
        } catch(err) { gallery = []; }

        let amenities = [];
        try {
            const rawAm = card.getAttribute('data-amenities');
            if (rawAm) {
                const parsedAm = JSON.parse(rawAm);
                if (Array.isArray(parsedAm)) amenities = parsedAm;
            }
        } catch(err) { amenities = []; }

        modalTitle.textContent    = title;
        modalLocation.textContent = location;
        modalDescHeading.textContent = 'About this Resort';
        modalDesc.textContent     = desc;
        modalRating.textContent   = rating;
        modalReviews.textContent  = `(${reviews} reviews)`;

        // Category Badge
        modalCategoryBadge.textContent = category;
        const catLower = category.toLowerCase();
        let catClass = 'bg-primary';
        if (catLower.includes('luxury')) catClass = 'bg-warning text-dark';
        else if (catLower.includes('eco')) catClass = 'bg-success';
        else if (catLower.includes('budget')) catClass = 'bg-secondary';
        else if (catLower.includes('homestay')) catClass = 'bg-info text-dark';
        modalCategoryBadge.className = `badge ${catClass} px-3 py-1 rounded-pill mb-2 shadow-sm small`;

        // Show resort badges
        if (resortBadges) {
            resortBadges.classList.remove('d-none');
            modalPrice.textContent  = `From ₱${minPrice} / night`;
            modalGuests.innerHTML   = `<i class="bi bi-people me-1"></i>Max ${maxGuests} Guests`;
            modalUnits.innerHTML    = `<i class="bi bi-house-door me-1"></i>${units} Units`;
        }

        // Amenities
        if (amenitiesContainer && modalAmenities) {
            modalAmenities.replaceChildren();
            if (amenities.length > 0) {
                amenitiesContainer.classList.remove('d-none');
                amenities.forEach(am => {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-light text-dark border px-3 py-2 rounded-pill small';
                    badge.innerHTML = `<i class="bi ${am.icon || 'bi-check-circle'} text-primary me-1"></i> ${am.name}`;
                    modalAmenities.appendChild(badge);
                });
            } else {
                amenitiesContainer.classList.add('d-none');
            }
        }

        // Footer links
        modalMapBtn.href = mapUrl;
        modalActionBtn.href = bookUrl;
        modalActionBtn.innerHTML = '<i class="bi bi-calendar-check" style="font-size: 1rem; line-height: 1;"></i> <span>Book Accommodation</span>';
        footerHeading.textContent = 'Ready to Book?';
        footerSub.textContent = 'Reserve your room or cottage directly with the resort administration.';

        setupGallery(cover, gallery, '{{ asset("images/resorts/gubat_bay_beach_resort.jpg") }}');

        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }

    function setupGallery(cover, gallery, fallback) {
        currentPhotoList = [];
        if (cover) currentPhotoList.push(cover);
        gallery.forEach(item => {
            const formatted = formatAssetUrl(item);
            if (formatted && !currentPhotoList.includes(formatted)) {
                currentPhotoList.push(formatted);
            }
        });
        if (currentPhotoList.length === 0 && fallback) {
            currentPhotoList.push(fallback);
        }

        activePhotoIndex = 0;
        modalImg.src = currentPhotoList[0];

        if (currentPhotoList.length > 1) {
            if (photoCounter) photoCounter.classList.remove('d-none');
            if (totalCountEl) totalCountEl.textContent = currentPhotoList.length;
            if (currentIdxEl) currentIdxEl.textContent = '1';
            if (prevBtn) { prevBtn.classList.remove('d-none'); prevBtn.classList.add('d-flex'); }
            if (nextBtn) { nextBtn.classList.remove('d-none'); nextBtn.classList.add('d-flex'); }

            if (stripContainer) stripContainer.classList.remove('d-none');
            if (thumbnailsBox) {
                thumbnailsBox.replaceChildren();
                currentPhotoList.forEach((photoUrl, idx) => {
                    const thumb = document.createElement('div');
                    thumb.className = 'home-mini-thumb rounded-3 border border-2 ' + (idx === 0 ? 'border-primary shadow' : 'border-transparent opacity-75');
                    thumb.style.cssText = 'flex: 0 0 76px; height: 56px; overflow: hidden; cursor: pointer; transition: all 0.2s ease;';
                    thumb.innerHTML = `<img src="${photoUrl}" alt="Photo ${idx + 1}" style="width: 100%; height: 100%; object-fit: cover;">`;
                    thumb.addEventListener('click', function(e) {
                        e.stopPropagation();
                        showPhotoAtIndex(idx);
                    });
                    thumbnailsBox.appendChild(thumb);
                });
            }
        } else {
            if (photoCounter) photoCounter.classList.add('d-none');
            if (prevBtn) { prevBtn.classList.add('d-none'); prevBtn.classList.remove('d-flex'); }
            if (nextBtn) { nextBtn.classList.add('d-none'); nextBtn.classList.remove('d-flex'); }
            if (stripContainer) stripContainer.classList.add('d-none');
        }
    }

    // Attach click listeners to Destinations cards & buttons
    document.querySelectorAll('.home-spot-card-clickable').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('a')) return;
            openSpotQuickView(this);
        });
    });

    document.querySelectorAll('.view-spot-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.home-spot-card-clickable');
            if (card) openSpotQuickView(card);
        });
    });

    // Attach click listeners to Resorts cards & buttons
    document.querySelectorAll('.home-resort-card-clickable').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('a')) return;
            openResortQuickView(this);
        });
    });

    document.querySelectorAll('.view-resort-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.home-resort-card-clickable');
            if (card) openResortQuickView(card);
        });
    });
});
</script>
