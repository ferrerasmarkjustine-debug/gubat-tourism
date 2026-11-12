@if(Auth::check() && Auth::user()->isLguAdmin())
    <!-- Cropper.js for image framing & cropping in Admin Quick Edit -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    <!-- ========================================================
         LGU Admin Quick Edit Destination / Attraction Modal
         Rich 2-Column Layout with Live Card Preview & Image Framing
         ======================================================== -->
    <div class="modal fade" id="adminQuickEditDestinationModal" tabindex="-1" aria-labelledby="adminQuickEditDestLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-4 pb-3 bg-white">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="adminQuickEditDestLabel">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Edit Destination: <span id="quickEditModalTitle" class="ms-1"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data" id="adminQuickEditDestForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-3">
                        <div class="row g-4">
                            <!-- Left: Form Inputs Column -->
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Destination Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="quickEditNameInput" class="form-control rounded-3" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                        <select name="category" id="quickEditCategorySelect" class="form-select rounded-3" required>
                                            <option value="" disabled>Choose category...</option>
                                            <optgroup label="🏖️ Beach & Surfing — Homepage: Featured Destinations">
                                                <option value="Surf Haven">Surf Haven</option>
                                                <option value="Public Beach">Public Beach</option>
                                                <option value="Surf Haven & Resort">Surf Haven & Resort</option>
                                                <option value="Surf Haven & Eco-Farm">Surf Haven & Eco-Farm</option>
                                                <option value="Public Beach & Promenade">Public Beach & Promenade</option>
                                                <option value="Surf Break">Surf Break</option>
                                            </optgroup>
                                            <optgroup label="⛪ Churches — Homepage: Historic Churches">
                                                <option value="Century-Old Church">Century-Old Church</option>
                                                <option value="Parish Church">Parish Church</option>
                                                <option value="Chapel">Chapel</option>
                                                <option value="Shrine">Shrine</option>
                                            </optgroup>
                                            <optgroup label="🏛️ Heritage — Homepage: History & Heritage">
                                                <option value="Historical Heritage">Historical Heritage</option>
                                                <option value="Heritage Landmark">Heritage Landmark</option>
                                                <option value="Civic Landmark">Civic Landmark</option>
                                            </optgroup>
                                            <optgroup label="🌿 Nature — Homepage: Nature & Ecotourism">
                                                <option value="Eco-Tourism Site">Eco-Tourism Site</option>
                                                <option value="Nature Reserve">Nature Reserve</option>
                                                <option value="Nature & Forest Reserve">Nature & Forest Reserve</option>
                                                <option value="Mangrove Forest">Mangrove Forest</option>
                                                <option value="Marine Reserve">Marine Reserve</option>
                                            </optgroup>
                                            <optgroup label="🛠️ Other">
                                                <option value="Traditional Pottery">Traditional Pottery</option>
                                                <option value="Livelihood Center">Livelihood Center</option>
                                            </optgroup>
                                        </select>
                                        <small class="text-muted" style="font-size: 0.72rem;">Category determines which homepage section this item appears in.</small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Description</label>
                                        <textarea name="description" id="quickEditDescInput" class="form-control rounded-3" rows="3"></textarea>
                                    </div>

                                    <!-- Cover Photo Card Uploader -->
                                    <div class="col-12">
                                        <div class="card border border-2 border-dashed rounded-4 p-3 mb-2 bg-light bg-opacity-50">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <label class="form-label fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                                    <i class="bi bi-image text-primary fs-5"></i>
                                                    <span>Cover Photo (Primary Card Banner)</span>
                                                </label>
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1 small">
                                                    <i class="bi bi-laptop me-1"></i> From Pictures / PC
                                                </span>
                                            </div>

                                            <div class="text-center mb-3">
                                                <div class="position-relative mx-auto rounded-3 overflow-hidden bg-white shadow-sm border d-flex align-items-center justify-content-center"
                                                     style="height: 190px; max-width: 100%;">
                                                    <img id="quickEditPreviewImg" src="" alt="Image Preview" class="w-100 h-100" style="object-fit: cover; display: none;">
                                                    <div id="quickEditPlaceholder" class="p-4 text-center text-muted">
                                                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 text-primary mb-2">
                                                            <i class="bi bi-cloud-arrow-up fs-2"></i>
                                                        </div>
                                                        <div class="fw-semibold text-dark small">Select a photo from your computer</div>
                                                        <div class="text-muted" style="font-size: 0.75rem;">Supports JPG, PNG, WEBP (Max 5MB)</div>
                                                    </div>
                                                    <button type="button" id="quickEditCropTrigger" class="btn btn-dark btn-sm rounded-pill px-3 position-absolute bottom-0 end-0 m-2 shadow-sm" style="display: none; align-items: center; gap: 0.35rem; font-size: 0.78rem; opacity: 0.9;">
                                                        <i class="bi bi-crop"></i>
                                                        <span>Crop &amp; Frame</span>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label small fw-semibold text-secondary mb-1">
                                                    <i class="bi bi-folder2-open text-primary me-1"></i> Choose photo from your computer:
                                                </label>
                                                <input type="file" class="form-control rounded-3" id="quickEditFileInput" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                                                <div class="form-text small text-muted">
                                                    <i class="bi bi-info-circle me-1"></i> Click to select from Pictures. You can crop and reposition it right after selecting.
                                                </div>
                                            </div>

                                            <div class="pt-2 border-top">
                                                <a class="small text-decoration-none text-muted d-inline-flex align-items-center" data-bs-toggle="collapse" href="#quickEditCollapseUrl" role="button" aria-expanded="false">
                                                    <i class="bi bi-link-45deg me-1"></i> Or provide an external image URL instead
                                                </a>
                                                <div class="collapse mt-2" id="quickEditCollapseUrl">
                                                    <input type="url" class="form-control form-control-sm rounded-3" id="quickEditUrlInput" name="image_url" placeholder="https://images.unsplash.com/...">
                                                    <div class="form-text small text-muted">If both a file and URL are provided, the uploaded file will be prioritized.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Gallery Photos (Up to 10 Photos) -->
                                    <div class="col-12 mt-2 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-bold text-dark mb-0">
                                                <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                            </label>
                                            <span class="badge bg-light text-muted border small">Max 10 photos</span>
                                        </div>
                                        <div class="form-text text-muted small mb-2">
                                            Select up to 10 extra photos. You can choose photos one-by-one or multiple at once without overwriting previous selections.
                                        </div>
                                        <div id="quickEditRetainedGalleryWrap" class="p-2 bg-light rounded-3 mb-2 border" style="display: none;">
                                            <div class="small fw-semibold text-muted mb-2">
                                                Current Gallery (<span id="quickEditRetainedCount">0</span>/10 photos):
                                            </div>
                                            <div class="d-flex flex-wrap gap-2" id="quickEditRetainedGalleryList"></div>
                                        </div>
                                        <input type="file" name="gallery_images[]" id="quickEditGalleryInput" class="form-control rounded-3" multiple accept="image/jpeg,image/png,image/webp">
                                        <div id="quickEditGalleryPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Google Maps Pin URL</label>
                                        <input type="url" name="google_map_url" id="quickEditMapInput" class="form-control rounded-3" placeholder="https://maps.google.com/...">
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="featured" id="quickEditFeaturedInput" value="1">
                                            <label class="form-check-label fw-semibold text-dark" for="quickEditFeaturedInput">
                                                Feature this destination
                                            </label>
                                            <div class="form-text text-muted small">Featured destinations appear prominently on the public homepage and featured spots section.</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_spotlight" id="quickEditSpotlightInput" value="1">
                                            <label class="form-check-label fw-semibold text-dark" for="quickEditSpotlightInput">
                                                <i class="bi bi-stars text-warning me-1"></i> Pin to Signature Spotlights (Top of Public Attractions Page)
                                            </label>
                                            <div class="form-text text-muted small">Max 2 destinations can be pinned across the municipality.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Live Card Preview Column -->
                            <div class="col-lg-5 align-self-start">
                                <div class="sticky-top" style="top: 15px;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                        </span>
                                        <small class="text-muted">Public card layout</small>
                                    </div>

                                    <div class="card card-tourism border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                        <div class="card-tourism-img-wrapper position-relative overflow-hidden" style="height: 200px;">
                                            <span class="badge text-white card-badge shadow-sm px-3 py-2 live-dest-cat" id="quickEditLiveCat" style="background-color: #0284c7; font-size: 0.75rem;">
                                                <i class="bi bi-geo-alt-fill me-1"></i> Category
                                            </span>
                                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm" id="quickEditLiveFeat" style="z-index: 2; display: none;">
                                                <i class="bi bi-star-fill text-dark me-1"></i> Featured
                                            </span>
                                            <img id="quickEditLiveImg" src="" alt="Destination Preview" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small text-muted fw-semibold">
                                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> <span id="quickEditLiveLocation">Gubat, Sorsogon</span>
                                                </span>
                                                <span class="badge bg-light text-secondary border small">
                                                    <i class="bi bi-shield-check text-success me-1"></i> LGU Verified
                                                </span>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-1" id="quickEditLiveName">Destination Name</h5>
                                            <p class="small text-muted mb-3" id="quickEditLiveDesc">Destination highlights and activities...</p>
                                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <span class="text-dark fw-bold ms-1" id="quickEditLiveRating">4.9</span>
                                                </div>
                                                <span class="btn btn-sm btn-outline-primary rounded-pill px-3">Explore</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-danger rounded-pill px-3" id="quickEditDeleteBtn" onclick="deleteDestinationFromQuickEdit()">
                            <i class="bi bi-trash3 me-1"></i> Delete Destination
                        </button>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Crop Modal for Quick Edit Image Framing -->
    <div class="modal fade" id="quickEditCropModal" tabindex="-1" aria-labelledby="quickEditCropModalLabel" aria-hidden="true" data-bs-backdrop="static" style="z-index: 1070;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-3 pb-3">
                    <h6 class="modal-title fw-bold text-dark d-flex align-items-center" id="quickEditCropModalLabel">
                        <i class="bi bi-crop text-primary me-2 fs-5"></i> Adjust Photo Framing for Card Cover
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 bg-dark d-flex align-items-center justify-content-center" style="min-height: 380px; max-height: 60vh;">
                    <div style="max-width: 100%; max-height: 55vh; overflow: hidden;">
                        <img id="quickEditCropperTarget" src="" alt="To Crop" style="max-width: 100%; display: block;">
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-2 bg-light d-flex justify-content-between align-items-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="quickEditZoomIn" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="quickEditZoomOut" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="quickEditRotate" title="Rotate 90deg"><i class="bi bi-arrow-clockwise"></i></button>
                        <button type="button" class="btn btn-outline-secondary" id="quickEditReset" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-3 btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 btn-sm fw-semibold shadow-sm" id="quickEditCropSave">
                            <i class="bi bi-check2 me-1"></i> Apply Framing
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         LGU Admin Feature Existing Item on Homepage Modal
         ======================================================== -->
    <div class="modal fade" id="adminFeaturePickerModal" tabindex="-1" aria-labelledby="adminFeaturePickerModalLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="adminFeaturePickerModalLabel">
                        <i class="bi bi-star-fill text-warning me-2"></i> <span id="featurePickerSectionTitle">Feature Attraction on Homepage</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="p-3 bg-light border-bottom">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted" id="featurePickerSectionSubtitle">Choose an existing item from your database to feature in this section:</span>
                        <span class="badge bg-primary rounded-pill small" id="featurePickerAvailableCount">0 unfeatured available</span>
                    </div>
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="featurePickerSearchInput" class="form-control rounded-pill ps-5 py-2 border bg-white" placeholder="Search available attractions by name, category, or barangay...">
                    </div>
                </div>

                <div class="modal-body p-3 p-md-4" style="max-height: 440px; overflow-y: auto;">
                    <!-- Destinations List Container -->
                    <div id="featurePickerDestinationsContainer">
                        @if(isset($allDestinations))
                            @foreach($allDestinations as $d)
                                @php
                                    $dImg = str_starts_with($d->image_url ?? '', 'http') ? $d->image_url : asset($d->image_url ?? 'images/destinations/rizal_beach.jpg');
                                    $bName = $d->barangay->name ?? $d->barangay_name ?? 'Gubat';
                                    $cLower = strtolower($d->category ?? '');
                                    $dSection = 'beach';
                                    if (str_contains($cLower, 'church') || str_contains($cLower, 'chapel') || str_contains($cLower, 'parish') || str_contains($cLower, 'grotto') || str_contains($cLower, 'shrine') || str_contains($cLower, 'religious')) {
                                        $dSection = 'church';
                                    } elseif (str_contains($cLower, 'heritage') || str_contains($cLower, 'history') || str_contains($cLower, 'landmark') || str_contains($cLower, 'ancestral') || str_contains($cLower, 'civic')) {
                                        $dSection = 'heritage';
                                    } elseif (str_contains($cLower, 'nature') || str_contains($cLower, 'forest') || str_contains($cLower, 'cave') || str_contains($cLower, 'eco') || str_contains($cLower, 'boardwalk') || str_contains($cLower, 'spring') || str_contains($cLower, 'farm') || str_contains($cLower, 'marine') || str_contains($cLower, 'mangrove')) {
                                        $dSection = 'nature';
                                    }
                                @endphp
                                <div class="feature-picker-item d-flex align-items-center justify-content-between p-3 rounded-3 mb-2 border bg-white shadow-sm"
                                     data-type="destination"
                                     data-section="{{ $dSection }}"
                                     data-featured="{{ $d->featured ? '1' : '0' }}"
                                     data-search="{{ strtolower($d->name . ' ' . $d->category . ' ' . $bName) }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $dImg }}" class="rounded-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; object-fit: cover;" alt="{{ $d->name }}">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $d->name }}</div>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <span class="badge bg-secondary-subtle text-secondary small border">{{ $d->category }}</span>
                                                <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. {{ $bName }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        @if($d->featured)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 small fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Already on Homepage
                                            </span>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold" 
                                                    onclick="toggleFeatureFromPicker('{{ route('admin.destinations.toggle-featured', $d->id) }}', this, '{{ addslashes($d->name) }}')">
                                                <i class="bi bi-plus-circle me-1"></i> Feature on Homepage
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Resorts List Container -->
                    <div id="featurePickerResortsContainer">
                        @if(isset($allResorts))
                            @foreach($allResorts as $r)
                                @php
                                    $rImg = str_starts_with($r->image_url ?? '', 'http') ? $r->image_url : asset($r->image_url ?? 'images/resorts/gubat_bay_beach_resort.jpg');
                                    $rbName = $r->barangay->name ?? 'Gubat';
                                @endphp
                                <div class="feature-picker-item d-flex align-items-center justify-content-between p-3 rounded-3 mb-2 border bg-white shadow-sm"
                                     data-type="resort"
                                     data-section="resort"
                                     data-featured="{{ $r->featured ? '1' : '0' }}"
                                     data-search="{{ strtolower($r->name . ' ' . $r->category . ' ' . $rbName) }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $rImg }}" class="rounded-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; object-fit: cover;" alt="{{ $r->name }}">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $r->name }}</div>
                                            <div class="d-flex align-items-center gap-2 mt-1">
                                                <span class="badge bg-info-subtle text-info small border">{{ ucfirst($r->category) }}</span>
                                                <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. {{ $rbName }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        @if($r->featured)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 small fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Already on Homepage
                                            </span>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold" 
                                                    onclick="toggleFeatureFromPicker('{{ route('admin.resorts.toggle-featured', $r->id) }}', this, '{{ addslashes($r->name) }}')">
                                                <i class="bi bi-plus-circle me-1"></i> Feature on Homepage
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Empty state if no items match -->
                    <div id="featurePickerEmptyState" class="text-center py-5 d-none">
                        <i class="bi bi-search text-muted display-6 d-block mb-2 opacity-50"></i>
                        <h6 class="fw-bold text-dark mb-1">No Available Attractions Found</h6>
                        <p class="text-muted small mb-0">All items in this section may already be featured, or no records match your search filter.</p>
                    </div>
                </div>

                <div class="modal-footer px-4 py-3 bg-light border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="{{ route('admin.destinations') }}" id="featurePickerCreateLink" target="_blank" class="small text-decoration-none text-muted">
                        <i class="bi bi-plus-circle me-1 text-primary"></i> Can't find it? <strong>Create a new attraction in Admin Portal &rarr;</strong>
                    </a>
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         JavaScript Helpers for Quick Edit & Toggle
         ======================================================== -->
    <script>
        // Open Feature Picker Modal for any section
        function openFeaturePicker(section) {
            const modalEl = document.getElementById('adminFeaturePickerModal');
            if (!modalEl || !window.bootstrap) return;

            const titleEl = document.getElementById('featurePickerSectionTitle');
            const subtitleEl = document.getElementById('featurePickerSectionSubtitle');
            const createLink = document.getElementById('featurePickerCreateLink');
            const searchInput = document.getElementById('featurePickerSearchInput');
            const countBadge = document.getElementById('featurePickerAvailableCount');
            const emptyState = document.getElementById('featurePickerEmptyState');

            if (searchInput) searchInput.value = '';

            let secName = 'Featured Destinations';
            let adminUrl = '{{ route('admin.destinations') }}';

            if (section === 'beach') {
                secName = 'Featured Beach & Surfing';
                adminUrl = '{{ route('admin.destinations') }}';
            } else if (section === 'church') {
                secName = 'Historic Churches';
                adminUrl = '{{ route('admin.destinations') }}';
            } else if (section === 'heritage') {
                secName = 'History & Heritage Landmarks';
                adminUrl = '{{ route('admin.destinations') }}';
            } else if (section === 'nature') {
                secName = 'Nature & Ecotourism';
                adminUrl = '{{ route('admin.destinations') }}';
            } else if (section === 'resort') {
                secName = 'Featured Beach Resorts & Hotels';
                adminUrl = '{{ route('admin.resorts.create') }}';
            }

            if (titleEl) titleEl.textContent = `Add Attraction to ${secName}`;
            if (subtitleEl) subtitleEl.textContent = `Choose an existing item from your database to feature in ${secName}:`;
            if (createLink) {
                createLink.href = adminUrl;
                createLink.innerHTML = `<i class="bi bi-plus-circle me-1 text-primary"></i> Can't find it? <strong>Create a new attraction in Admin Portal &rarr;</strong>`;
            }

            const items = modalEl.querySelectorAll('.feature-picker-item');
            let visibleCount = 0;
            let availableToFeature = 0;

            items.forEach(item => {
                const itemType = item.getAttribute('data-type');
                const itemSec = item.getAttribute('data-section');
                const isFeatured = item.getAttribute('data-featured') === '1';

                let matches = false;
                if (section === 'resort' && itemType === 'resort') {
                    matches = true;
                } else if (section !== 'resort' && itemType === 'destination') {
                    matches = (section === 'all' || itemSec === section);
                }

                if (matches) {
                    item.classList.remove('d-none');
                    item.style.display = '';
                    visibleCount++;
                    if (!isFeatured) availableToFeature++;
                } else {
                    item.classList.add('d-none');
                    item.style.display = 'none';
                }
            });

            if (countBadge) {
                countBadge.textContent = `${availableToFeature} unfeatured available`;
            }

            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('d-none');
                } else {
                    emptyState.classList.add('d-none');
                }
            }

            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }

        // Toggle Feature status from Picker via AJAX
        function toggleFeatureFromPicker(toggleUrl, btnEl, title) {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            btnEl.disabled = true;
            btnEl.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Adding...';

            fetch(toggleUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btnEl.classList.remove('btn-success');
                    btnEl.classList.add('btn-primary');
                    btnEl.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Added to Homepage!';
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    alert(data.message || 'Could not feature attraction.');
                    btnEl.disabled = false;
                    btnEl.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Feature on Homepage';
                }
            })
            .catch(err => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = toggleUrl;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = token;
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            });
        }

        // Filter items in Feature Picker modal via search input
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('featurePickerSearchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const q = this.value.trim().toLowerCase();
                    const modalEl = document.getElementById('adminFeaturePickerModal');
                    if (!modalEl) return;
                    const items = modalEl.querySelectorAll('.feature-picker-item:not(.d-none)');
                    items.forEach(item => {
                        const searchData = item.getAttribute('data-search') || '';
                        if (q === '' || searchData.includes(q)) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });

        // Open Quick Edit Modal for any destination card
        let currentQuickEditDestId = null;
        let quickEditCropper = null;
        let quickEditCropModal = null;
        let quickEditCurrentRawImageSrc = '';
        const quickEditGalleryFiles = [];

        function showQuickEditModal() {
            const modalEl = document.getElementById('adminQuickEditDestinationModal');
            if (!modalEl) return;
            const bs = window.bootstrap || (typeof bootstrap !== 'undefined' ? bootstrap : null);
            if (bs && bs.Modal) {
                const modal = bs.Modal.getOrCreateInstance(modalEl);
                modal.show();
            } else if (typeof jQuery !== 'undefined' && jQuery(modalEl).modal) {
                jQuery(modalEl).modal('show');
            } else {
                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                document.body.classList.add('modal-open');
                let backdrop = document.querySelector('.modal-backdrop');
                if (!backdrop) {
                    backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            }
        }

        function openAdminEditDestination(target, name, category, desc, mapUrl, isFeatured, imageUrl, locationName, rating, isSpotlight) {
            try {
                let id = target;
                let cardEl = null;

                // If target is an HTML element (e.g. `this` passed from button)
                if (target && (target instanceof HTMLElement || target.nodeType === 1)) {
                    cardEl = target.closest('.card') || target.closest('.home-spot-card-clickable') || target.closest('[id^="dest-card-"]');
                    if (cardEl) {
                        id = cardEl.getAttribute('data-id') || (cardEl.id ? cardEl.id.replace('dest-card-', '') : '');
                        name = cardEl.getAttribute('data-title') || '';
                        category = cardEl.getAttribute('data-category') || '';
                        desc = cardEl.getAttribute('data-desc') || '';
                        mapUrl = cardEl.getAttribute('data-map') || '';
                        isFeatured = cardEl.getAttribute('data-featured') || '1';
                        imageUrl = cardEl.getAttribute('data-cover') || '';
                        locationName = cardEl.getAttribute('data-location') || 'Gubat, Sorsogon';
                        rating = cardEl.getAttribute('data-rating') || '4.9';
                        isSpotlight = cardEl.getAttribute('data-spotlight') || '0';
                    }
                } else if (id && (!name || !desc || !imageUrl)) {
                    cardEl = document.getElementById('dest-card-' + id) || document.querySelector(`[data-id="${id}"]`);
                    if (cardEl) {
                        if (!name) name = cardEl.getAttribute('data-title') || '';
                        if (!category) category = cardEl.getAttribute('data-category') || '';
                        if (!desc) desc = cardEl.getAttribute('data-desc') || '';
                        if (!mapUrl) mapUrl = cardEl.getAttribute('data-map') || '';
                        if (isFeatured === undefined || isFeatured === null) isFeatured = cardEl.getAttribute('data-featured') || '1';
                        if (!imageUrl) imageUrl = cardEl.getAttribute('data-cover') || '';
                        if (!locationName) locationName = cardEl.getAttribute('data-location') || 'Gubat, Sorsogon';
                        if (!rating) rating = cardEl.getAttribute('data-rating') || '4.9';
                        if (isSpotlight === undefined || isSpotlight === null) isSpotlight = cardEl.getAttribute('data-spotlight') || '0';
                    }
                }

                currentQuickEditDestId = id;
                const form = document.getElementById('adminQuickEditDestForm');
                if (form) {
                    form.action = `/super-admin/destinations/${id}`;
                }

                const titleEl = document.getElementById('quickEditModalTitle');
                if (titleEl) titleEl.textContent = name || 'Destination';

                const nameInput = document.getElementById('quickEditNameInput');
                if (nameInput) nameInput.value = name || '';

                const catSelect = document.getElementById('quickEditCategorySelect');
                if (catSelect) {
                    catSelect.value = category || '';
                    if (catSelect.value !== category && category) {
                        const opt = document.createElement('option');
                        opt.value = category;
                        opt.textContent = category;
                        opt.selected = true;
                        catSelect.appendChild(opt);
                    }
                }

                const descInput = document.getElementById('quickEditDescInput');
                if (descInput) descInput.value = desc || '';

                const mapInput = document.getElementById('quickEditMapInput');
                if (mapInput) mapInput.value = mapUrl || '';

                const featInput = document.getElementById('quickEditFeaturedInput');
                if (featInput) {
                    featInput.checked = (isFeatured === true || isFeatured === '1' || isFeatured === 1);
                }

                const spotInput = document.getElementById('quickEditSpotlightInput');
                if (spotInput) {
                    spotInput.checked = (isSpotlight === true || isSpotlight === '1' || isSpotlight === 1);
                }

                // Fallback for image and location if not passed explicitly
                if (!imageUrl) {
                    if (!cardEl) {
                        cardEl = document.getElementById('dest-card-' + id) || document.querySelector(`[data-id="${id}"]`);
                    }
                    if (cardEl) {
                        imageUrl = cardEl.getAttribute('data-cover') || '';
                        locationName = cardEl.getAttribute('data-location') || 'Gubat, Sorsogon';
                        rating = cardEl.getAttribute('data-rating') || '4.9';
                    }
                }
                if (!imageUrl) {
                    imageUrl = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                }
                quickEditCurrentRawImageSrc = imageUrl;

                // Reset file input
                const fileInput = document.getElementById('quickEditFileInput');
                if (fileInput) fileInput.value = '';
                const urlInput = document.getElementById('quickEditUrlInput');
                if (urlInput) urlInput.value = (typeof imageUrl === 'string' && imageUrl.startsWith('http') && !imageUrl.includes('localhost') && !imageUrl.includes('127.0.0.1')) ? imageUrl : '';

                // Reset and load gallery images
                const retainedWrap = document.getElementById('quickEditRetainedGalleryWrap');
                const retainedList = document.getElementById('quickEditRetainedGalleryList');
                const retainedCount = document.getElementById('quickEditRetainedCount');
                const galleryInput = document.getElementById('quickEditGalleryInput');
                const galleryPreview = document.getElementById('quickEditGalleryPreview');

                if (galleryInput) galleryInput.value = '';
                if (galleryPreview) {
                    if (galleryPreview.replaceChildren) {
                        galleryPreview.replaceChildren();
                    } else {
                        galleryPreview.innerHTML = '';
                    }
                }
                quickEditGalleryFiles.length = 0;

                let galleryArray = [];
                if (!cardEl) {
                    cardEl = document.getElementById('dest-card-' + id) || document.querySelector(`[data-id="${id}"]`);
                }
                if (cardEl && cardEl.getAttribute('data-gallery')) {
                    try {
                        galleryArray = JSON.parse(cardEl.getAttribute('data-gallery')) || [];
                    } catch (e) {
                        galleryArray = [];
                    }
                }

                if (retainedList) {
                    if (retainedList.replaceChildren) {
                        retainedList.replaceChildren();
                    } else {
                        retainedList.innerHTML = '';
                    }
                }
                if (galleryArray.length > 0 && retainedWrap && retainedList) {
                    retainedWrap.style.display = 'block';
                    if (retainedCount) retainedCount.textContent = galleryArray.length;
                    galleryArray.forEach(path => {
                        const src = (path.startsWith('http')) ? path : ('/' + path.replace(/^\//, ''));
                        const wrap = document.createElement('div');
                        wrap.className = 'position-relative border rounded-3 p-1 bg-white shadow-sm';
                        wrap.style.cssText = 'width: 75px; height: 75px;';
                        wrap.innerHTML = `<img src="${src}" class="w-100 h-100 rounded-2" style="object-fit: cover;">
                            <input type="hidden" name="retained_gallery_images[]" value="${path}">
                            <button type="button" class="btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0 translate-middle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; line-height: 1;" title="Remove this photo">
                                <i class="bi bi-x"></i>
                            </button>`;
                        wrap.querySelector('button').addEventListener('click', function() {
                            wrap.remove();
                            const remaining = retainedList.querySelectorAll('input[name="retained_gallery_images[]"]').length;
                            if (retainedCount) retainedCount.textContent = remaining;
                            if (remaining === 0) retainedWrap.style.display = 'none';
                        });
                        retainedList.appendChild(wrap);
                    });
                } else if (retainedWrap) {
                    retainedWrap.style.display = 'none';
                }

                // Update image preview box
                const previewImg = document.getElementById('quickEditPreviewImg');
                const placeholder = document.getElementById('quickEditPlaceholder');
                const cropTrigger = document.getElementById('quickEditCropTrigger');
                if (previewImg) {
                    previewImg.src = imageUrl;
                    previewImg.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
                if (cropTrigger) cropTrigger.style.display = 'inline-flex';

                // Update Live Card Preview
                const liveName = document.getElementById('quickEditLiveName');
                const liveCat = document.getElementById('quickEditLiveCat');
                const liveDesc = document.getElementById('quickEditLiveDesc');
                const liveImg = document.getElementById('quickEditLiveImg');
                const liveFeat = document.getElementById('quickEditLiveFeat');
                const liveLoc = document.getElementById('quickEditLiveLocation');
                const liveRating = document.getElementById('quickEditLiveRating');

                if (liveName) liveName.textContent = name || 'Destination Name';
                if (liveCat) liveCat.innerHTML = `<i class="bi bi-geo-alt-fill me-1"></i> ${category || 'Category'}`;
                if (liveDesc) liveDesc.textContent = desc ? (desc.length > 90 ? desc.substring(0, 90) + '...' : desc) : 'Destination highlights and activities...';
                if (liveImg) liveImg.src = imageUrl;
                if (liveFeat) liveFeat.style.display = (featInput && featInput.checked) ? 'inline-block' : 'none';
                if (liveLoc) liveLoc.textContent = locationName ? (locationName.includes('Sorsogon') ? locationName : locationName + ', Sorsogon') : 'Gubat, Sorsogon';
                if (liveRating) liveRating.textContent = rating || '4.9';

                showQuickEditModal();
            } catch (err) {
                console.error('Error in openAdminEditDestination:', err);
                showQuickEditModal();
            }
        }
        window.openAdminEditDestination = openAdminEditDestination;

        // Live synchronizers for adminQuickEditDestinationModal
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('quickEditNameInput');
            const catSelect = document.getElementById('quickEditCategorySelect');
            const descInput = document.getElementById('quickEditDescInput');
            const featInput = document.getElementById('quickEditFeaturedInput');
            const fileInput = document.getElementById('quickEditFileInput');
            const urlInput = document.getElementById('quickEditUrlInput');
            const previewImg = document.getElementById('quickEditPreviewImg');
            const placeholder = document.getElementById('quickEditPlaceholder');
            const cropTrigger = document.getElementById('quickEditCropTrigger');

            const liveName = document.getElementById('quickEditLiveName');
            const liveCat = document.getElementById('quickEditLiveCat');
            const liveDesc = document.getElementById('quickEditLiveDesc');
            const liveImg = document.getElementById('quickEditLiveImg');
            const liveFeat = document.getElementById('quickEditLiveFeat');

            if (nameInput) {
                nameInput.addEventListener('input', function() {
                    const titleEl = document.getElementById('quickEditModalTitle');
                    if (titleEl) titleEl.textContent = this.value.trim() || 'Destination';
                    if (liveName) liveName.textContent = this.value.trim() || 'Destination Name';
                });
            }

            if (catSelect) {
                catSelect.addEventListener('change', function() {
                    if (liveCat) liveCat.innerHTML = `<i class="bi bi-geo-alt-fill me-1"></i> ${this.value || 'Category'}`;
                });
            }

            if (descInput) {
                descInput.addEventListener('input', function() {
                    const t = this.value.trim();
                    if (liveDesc) liveDesc.textContent = t ? (t.length > 90 ? t.substring(0, 90) + '...' : t) : 'Destination highlights and activities...';
                });
            }

            if (featInput) {
                featInput.addEventListener('change', function() {
                    if (liveFeat) liveFeat.style.display = this.checked ? 'inline-block' : 'none';
                });
            }

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            quickEditCurrentRawImageSrc = e.target.result;
                            if (previewImg) {
                                previewImg.src = e.target.result;
                                previewImg.style.display = 'block';
                            }
                            if (placeholder) placeholder.style.display = 'none';
                            if (cropTrigger) cropTrigger.style.display = 'inline-flex';
                            if (liveImg) liveImg.src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            if (urlInput) {
                urlInput.addEventListener('input', function() {
                    const url = this.value.trim();
                    if (url) {
                        quickEditCurrentRawImageSrc = url;
                        if (previewImg) {
                            previewImg.src = url;
                            previewImg.style.display = 'block';
                        }
                        if (placeholder) placeholder.style.display = 'none';
                        if (cropTrigger) cropTrigger.style.display = 'inline-flex';
                        if (liveImg) liveImg.src = url;
                    }
                });
            }

            // Cropper functionality
            const cropModalEl = document.getElementById('quickEditCropModal');
            const cropperTargetImg = document.getElementById('quickEditCropperTarget');
            const cropSaveBtn = document.getElementById('quickEditCropSave');
            const zoomInBtn = document.getElementById('quickEditZoomIn');
            const zoomOutBtn = document.getElementById('quickEditZoomOut');
            const rotateBtn = document.getElementById('quickEditRotate');
            const resetBtn = document.getElementById('quickEditReset');

            if (cropTrigger) {
                cropTrigger.addEventListener('click', function() {
                    if (quickEditCurrentRawImageSrc) {
                        if (!quickEditCropModal && window.bootstrap) {
                            quickEditCropModal = new bootstrap.Modal(cropModalEl);
                        }
                        if (cropperTargetImg) cropperTargetImg.src = quickEditCurrentRawImageSrc;
                        if (quickEditCropModal) quickEditCropModal.show();
                    }
                });
            }

            if (cropModalEl) {
                cropModalEl.addEventListener('shown.bs.modal', function() {
                    if (typeof Cropper !== 'undefined' && cropperTargetImg) {
                        if (quickEditCropper) quickEditCropper.destroy();
                        quickEditCropper = new Cropper(cropperTargetImg, {
                            aspectRatio: 16 / 9,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            background: false,
                        });
                    }
                });

                cropModalEl.addEventListener('hidden.bs.modal', function() {
                    if (quickEditCropper) {
                        quickEditCropper.destroy();
                        quickEditCropper = null;
                    }
                });
            }

            if (cropSaveBtn) {
                cropSaveBtn.addEventListener('click', function() {
                    if (!quickEditCropper) return;
                    const canvas = quickEditCropper.getCroppedCanvas({
                        width: 1200,
                        height: 675,
                        imageSmoothingEnabled: true,
                        imageSmoothingQuality: 'high',
                    });

                    if (canvas) {
                        canvas.toBlob(function(blob) {
                            if (blob && fileInput) {
                                try {
                                    const file = new File([blob], 'cropped_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                                    const dt = new DataTransfer();
                                    dt.items.add(file);
                                    fileInput.files = dt.files;
                                } catch (e) {
                                    console.warn('DataTransfer fallback:', e);
                                }
                            }
                            const croppedUrl = canvas.toDataURL('image/jpeg', 0.92);
                            quickEditCurrentRawImageSrc = croppedUrl;
                            if (previewImg) previewImg.src = croppedUrl;
                            if (liveImg) liveImg.src = croppedUrl;
                            if (quickEditCropModal) quickEditCropModal.hide();
                        }, 'image/jpeg', 0.92);
                    }
                });
            }

            if (zoomInBtn) zoomInBtn.addEventListener('click', () => quickEditCropper && quickEditCropper.zoom(0.1));
            if (zoomOutBtn) zoomOutBtn.addEventListener('click', () => quickEditCropper && quickEditCropper.zoom(-0.1));
            if (rotateBtn) rotateBtn.addEventListener('click', () => quickEditCropper && quickEditCropper.rotate(90));
            if (resetBtn) resetBtn.addEventListener('click', () => quickEditCropper && quickEditCropper.reset());

            // Gallery input accumulation for quick edit
            const qGalleryInput = document.getElementById('quickEditGalleryInput');
            const qGalleryPreview = document.getElementById('quickEditGalleryPreview');
            if (qGalleryInput && qGalleryPreview) {
                qGalleryInput.addEventListener('change', function(e) {
                    const retainedCount = document.querySelectorAll('#quickEditRetainedGalleryList input[name="retained_gallery_images[]"]').length;
                    const maxNewAllowed = Math.max(0, 10 - retainedCount);

                    const newlySelected = Array.from(e.target.files).filter(f => f.type.startsWith('image/'));

                    let addedCount = 0;
                    newlySelected.forEach(file => {
                        const isDuplicate = quickEditGalleryFiles.some(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified);
                        if (!isDuplicate) {
                            if (quickEditGalleryFiles.length < maxNewAllowed) {
                                quickEditGalleryFiles.push(file);
                                addedCount++;
                            }
                        }
                    });

                    if (retainedCount + quickEditGalleryFiles.length >= 10 && newlySelected.length > addedCount) {
                        alert(`Maximum 10 gallery photos reached (${retainedCount} saved + ${quickEditGalleryFiles.length} new). Some photos could not be added.`);
                    }

                    try {
                        const dt = new DataTransfer();
                        quickEditGalleryFiles.forEach(f => dt.items.add(f));
                        qGalleryInput.files = dt.files;
                    } catch (err) {
                        console.warn('DataTransfer error:', err);
                    }

                    // Render previews
                    qGalleryPreview.replaceChildren();
                    if (quickEditGalleryFiles.length > 0) {
                        const header = document.createElement('div');
                        header.className = 'w-100 small fw-semibold text-primary mb-1 d-flex align-items-center justify-content-between';
                        header.innerHTML = `<span><i class="bi bi-images me-1"></i> New Photos Ready to Upload (${quickEditGalleryFiles.length}):</span>
                            <button type="button" class="btn btn-link btn-sm text-danger text-decoration-none p-0 small" style="font-size: 0.78rem;">Clear all new</button>`;
                        header.querySelector('button').addEventListener('click', function(ev) {
                            ev.preventDefault();
                            quickEditGalleryFiles.length = 0;
                            const emptyDt = new DataTransfer();
                            qGalleryInput.files = emptyDt.files;
                            qGalleryPreview.replaceChildren();
                        });
                        qGalleryPreview.appendChild(header);
                    }

                    quickEditGalleryFiles.forEach((file, idx) => {
                        const wrap = document.createElement('div');
                        wrap.className = 'border rounded-3 p-1 bg-white shadow-sm position-relative';
                        wrap.style.cssText = 'width: 75px; height: 75px; overflow: hidden;';

                        const img = document.createElement('img');
                        img.className = 'w-100 h-100 rounded-2';
                        img.style.objectFit = 'cover';
                        wrap.appendChild(img);

                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0 translate-middle d-flex align-items-center justify-content-center shadow-sm';
                        removeBtn.style.cssText = 'width: 22px; height: 22px; font-size: 11px; line-height: 1; z-index: 5;';
                        removeBtn.title = 'Remove this photo';
                        removeBtn.innerHTML = '<i class="bi bi-x"></i>';
                        removeBtn.addEventListener('click', function(ev) {
                            ev.stopPropagation();
                            ev.preventDefault();
                            quickEditGalleryFiles.splice(idx, 1);
                            const newDt = new DataTransfer();
                            quickEditGalleryFiles.forEach(f => newDt.items.add(f));
                            qGalleryInput.files = newDt.files;
                            qGalleryInput.dispatchEvent(new Event('change'));
                        });
                        wrap.appendChild(removeBtn);

                        const reader = new FileReader();
                        reader.onload = function(evt) {
                            img.src = evt.target.result;
                        };
                        reader.readAsDataURL(file);

                        qGalleryPreview.appendChild(wrap);
                    });
                });
            }
        });

        // Delete destination from quick edit modal
        function deleteDestinationFromQuickEdit() {
            if (!currentQuickEditDestId) return;
            const destName = document.getElementById('quickEditNameInput') ? document.getElementById('quickEditNameInput').value : 'this destination';
            if (!confirm(`Are you sure you want to move "${destName}" to Recently Deleted?\n\n(It will disappear from the public website and be safely archived in Recently Deleted in Admin Portal.)`)) {
                return;
            }

            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/super-admin/destinations/${currentQuickEditDestId}`;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token;
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }

        // Quick Unfeature / Remove from Homepage via AJAX
        function unfeatureHomepageCard(toggleUrl, cardElement, title) {
            let targetCardEl = cardElement;
            if (cardElement && (cardElement instanceof HTMLElement || cardElement.nodeType === 1)) {
                targetCardEl = cardElement.closest('.col-lg-4') || cardElement.closest('.col-md-6') || cardElement.closest('.card') || cardElement;
                if (!title) {
                    const cardInner = targetCardEl.querySelector('.card') || targetCardEl;
                    title = cardInner.getAttribute('data-title') || 'this item';
                }
            }

            if (!confirm(`Remove "${title || 'this item'}" from the homepage?\n\n(Note: This will NOT delete the attraction. It simply removes it from this homepage section and preserves it in the directory.)`)) {
                return;
            }

            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            fetch(toggleUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Smoothly animate and remove card from DOM
                    if (targetCardEl) {
                        targetCardEl.style.transition = 'all 0.4s ease';
                        targetCardEl.style.transform = 'scale(0.85)';
                        targetCardEl.style.opacity = '0';
                        setTimeout(() => {
                            targetCardEl.remove();
                        }, 400);
                    }
                } else {
                    alert(data.message || 'Could not update featured status.');
                }
            })
            .catch(err => {
                // If JSON fails, submit a standard form as fallback
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = toggleUrl;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = token;
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            });
        }
        window.unfeatureHomepageCard = unfeatureHomepageCard;

        // Quick Delete with confirmation
        function deleteCardPermanently(deleteUrl, title) {
            if (!confirm(`Are you sure you want to PERMANENTLY DELETE "${title}"?\n\nWARNING: This action cannot be undone.`)) {
                return;
            }

            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token;
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endif

