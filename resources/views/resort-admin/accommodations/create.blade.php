@extends('layouts.resort-admin')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Header -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('resort.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('resort.accommodations.index') }}" class="text-decoration-none">Accommodations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New</li>
        </ol>
    </nav>

    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Register New Accommodation</h2>
            <p class="text-muted mb-0">Submit a new room or cottage request for <strong>{{ $resort->name }}</strong>. Submissions are reviewed by the LGU Tourism Office before going live.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('resort.accommodations.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back to My Accommodations
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Column -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                        <i class="bi bi-door-open-fill text-primary me-2"></i> Accommodation Details
                    </h5>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center mb-1">
                                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                                <strong>Please correct the following errors:</strong>
                            </div>
                            <ul class="mb-0 ps-4 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-info border-0 rounded-3 mb-4 small d-flex align-items-center gap-2">
                        <i class="bi bi-shield-check fs-5 text-primary"></i>
                        <span><strong>LGU Approval Workflow:</strong> Your submission will be set to <em>Pending Review</em> and will automatically be published to the public portal upon LGU Tourism verification.</span>
                    </div>

                    <form method="POST" action="{{ route('resort.accommodations.store') }}" enctype="multipart/form-data" id="accommodationForm">
                        @csrf

                        <!-- Accommodation Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-dark">
                                Accommodation / Unit Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="e.g. Deluxe Beachfront Suite"
                                   required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Type -->
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-semibold text-dark">
                                    Accommodation Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>-- Select Type --</option>
                                    <option value="room" {{ old('type') == 'room' ? 'selected' : '' }}>Standard Room / Suite</option>
                                    <option value="cottage" {{ old('type') == 'cottage' ? 'selected' : '' }}>Native Cottage / Hut</option>
                                    <option value="villa" {{ old('type') == 'villa' ? 'selected' : '' }}>Private Villa</option>
                                    <option value="dorm" {{ old('type') == 'dorm' ? 'selected' : '' }}>Backpacker Dormitory</option>
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Price per night -->
                            <div class="col-md-6">
                                <label for="price_per_night" class="form-label fw-semibold text-dark">
                                    Price per Night (₱) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">₱</span>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           class="form-control @error('price_per_night') is-invalid @enderror"
                                           id="price_per_night"
                                           name="price_per_night"
                                           value="{{ old('price_per_night') }}"
                                           placeholder="e.g. 2500.00"
                                           required>
                                </div>
                                @error('price_per_night')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <!-- Max Guests -->
                            <div class="col-md-6">
                                <label for="max_guests" class="form-label fw-semibold text-dark">
                                    Maximum Guests per Unit <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       min="1"
                                       max="50"
                                       class="form-control @error('max_guests') is-invalid @enderror"
                                       id="max_guests"
                                       name="max_guests"
                                       value="{{ old('max_guests', 2) }}"
                                       required>
                                @error('max_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Total Units -->
                            <div class="col-md-6">
                                <label for="total_units" class="form-label fw-semibold text-dark">
                                    Total Available Units <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       min="1"
                                       max="100"
                                       class="form-control @error('total_units') is-invalid @enderror"
                                       id="total_units"
                                       name="total_units"
                                       value="{{ old('total_units', 1) }}"
                                       required>
                                @error('total_units')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-dark">Room Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Describe the room, view, bed size, or inclusions...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Image Uploader (Local File or URL) -->
                        @include('partials.image-uploader', [
                            'id' => 'acc_create',
                            'label' => 'Accommodation Cover Photo',
                            'currentImage' => old('image_url'),
                            'helperText' => 'Select a photo of this room/cottage from your computer (JPG, PNG, WebP up to 5MB).'
                        ])

                        <!-- Additional Gallery Photos (Up to 10) -->
                        <div class="mb-4 pt-3 border-top">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-semibold text-dark mb-0">
                                    <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                </label>
                                <span class="badge bg-light text-muted border small">Max 10 photos</span>
                            </div>
                            <div class="form-text text-muted small mb-2">
                                Select up to 10 photos of the interior, bathroom, balcony, or views for the enlarged gallery view.
                            </div>
                            <input type="file" name="gallery_images[]" id="acc_gallery_create" class="form-control rounded-3 gallery-input" multiple accept="image/jpeg,image/png,image/webp">
                            <div id="acc_gallery_create_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                        </div>

                        <!-- Amenities Multi-Select -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">Amenities Included</label>
                            <div class="p-3 bg-light rounded-3">
                                <div class="row g-2">
                                    @foreach($amenities as $amenity)
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input amenity-checkbox"
                                                       type="checkbox"
                                                       name="amenities[]"
                                                       value="{{ $amenity->id }}"
                                                       data-name="{{ $amenity->name }}"
                                                       data-icon="{{ $amenity->icon_class }}"
                                                       id="amenity_{{ $amenity->id }}"
                                                       {{ is_array(old('amenities')) && in_array($amenity->id, old('amenities')) ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="amenity_{{ $amenity->id }}">
                                                    <i class="bi {{ $amenity->icon_class }} me-1 text-primary"></i> {{ $amenity->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('resort.accommodations.index') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="bi bi-send-check-fill me-1"></i> Submit for LGU Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Live Preview Column -->
        <div class="col-lg-5 align-self-start">
            <div class="sticky-top" style="top: 85px; z-index: 10;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                    </span>
                    <small class="text-muted">What visitors will see</small>
                </div>

                <div class="card border-0 shadow rounded-4 overflow-hidden bg-white">
                    <div class="position-relative">
                        <img id="previewCardImage"
                             src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80"
                             alt="Live Preview"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-warning text-dark shadow-sm px-3 py-2 rounded-pill" style="font-size: 0.75rem;">
                                <i class="bi bi-clock-history me-1"></i> Pending LGU Review
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0" id="previewCardName">Unit / Cottage Name</h5>
                            <span class="badge bg-light text-dark text-capitalize border" id="previewCardType">room</span>
                        </div>

                        <p class="text-muted small mb-3" id="previewCardDesc">
                            Describe the room, view, bed size, or inclusions...
                        </p>

                        <!-- Live Unit Inventory -->
                        <div class="border rounded-3 p-3 bg-light mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small fw-semibold text-dark">
                                    <i class="bi bi-box-seam text-primary me-1"></i> Unit Inventory
                                </span>
                                <span class="badge bg-success rounded-pill px-2 py-1" id="previewStockBadge">
                                    <i class="bi bi-check-circle-fill me-1"></i> <span id="previewAvailableCount">1</span> Available
                                </span>
                            </div>

                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                            </div>

                            <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.78rem;">
                                <span><strong id="previewTotalCount">1</strong> Total Units</span>
                                <span class="text-danger fw-semibold"><strong>0</strong> Booked</span>
                                <span class="text-success fw-bold"><strong id="previewAvailCountSub">1</strong> Available</span>
                            </div>
                        </div>

                        <div class="row g-2 py-1 small text-muted mb-3">
                            <div class="col-12">
                                <i class="bi bi-people me-1"></i> Accommodates up to <strong id="previewCardGuests">2</strong> guests per unit
                            </div>
                        </div>

                        <!-- Amenities Preview -->
                        <div class="mb-3 pt-2 border-top">
                            <small class="text-muted fw-semibold d-block mb-2" style="font-size:0.75rem;">Included Amenities:</small>
                            <div class="d-flex flex-wrap gap-1" id="previewAmenitiesList">
                                <span class="text-muted small fst-italic">No amenities selected</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top gap-2">
                            <div>
                                <small class="text-muted d-block" style="font-size:0.75rem;">Price per night</small>
                                <strong class="text-primary fs-5" id="previewCardPrice">₱0.00</strong>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" disabled>
                                <i class="bi bi-eye me-1"></i> Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const typeInput = document.getElementById('type');
    const priceInput = document.getElementById('price_per_night');
    const guestsInput = document.getElementById('max_guests');
    const unitsInput = document.getElementById('total_units');
    const descInput = document.getElementById('description');
    const amenityCheckboxes = document.querySelectorAll('.amenity-checkbox');

    const previewName = document.getElementById('previewCardName');
    const previewType = document.getElementById('previewCardType');
    const previewPrice = document.getElementById('previewCardPrice');
    const previewGuests = document.getElementById('previewCardGuests');
    const previewDesc = document.getElementById('previewCardDesc');
    const previewImage = document.getElementById('previewCardImage');
    const previewTotalCount = document.getElementById('previewTotalCount');
    const previewAvailableCount = document.getElementById('previewAvailableCount');
    const previewAvailCountSub = document.getElementById('previewAvailCountSub');
    const previewAmenitiesList = document.getElementById('previewAmenitiesList');

    function updatePreview() {
        if (previewName) {
            previewName.textContent = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'Unit / Cottage Name';
        }
        if (previewType) {
            previewType.textContent = typeInput && typeInput.value ? typeInput.value : 'Room';
        }
        if (previewPrice) {
            const val = priceInput && priceInput.value ? parseFloat(priceInput.value) : 0;
            previewPrice.textContent = '₱' + (isNaN(val) ? '0.00' : val.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        }
        if (previewGuests) {
            previewGuests.textContent = guestsInput && guestsInput.value ? guestsInput.value : '2';
        }
        if (previewDesc) {
            previewDesc.textContent = descInput && descInput.value.trim() 
                ? (descInput.value.trim().length > 95 ? descInput.value.trim().substring(0, 95) + '...' : descInput.value.trim())
                : 'Describe the room, view, bed size, or inclusions...';
        }
        if (previewTotalCount && unitsInput) {
            const units = unitsInput.value ? parseInt(unitsInput.value, 10) : 1;
            previewTotalCount.textContent = units;
            previewAvailableCount.textContent = units;
            previewAvailCountSub.textContent = units;
        }

        // Update Amenities
        if (previewAmenitiesList) {
            const selected = [];
            amenityCheckboxes.forEach(cb => {
                if (cb.checked) {
                    selected.push({ name: cb.getAttribute('data-name'), icon: cb.getAttribute('data-icon') });
                }
            });
            if (selected.length === 0) {
                previewAmenitiesList.innerHTML = '<span class="text-muted small fst-italic">No amenities selected</span>';
            } else {
                previewAmenitiesList.innerHTML = selected.map(item => `
                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small">
                        <i class="bi ${item.icon} text-primary me-1"></i>${item.name}
                    </span>
                `).join('');
            }
        }
    }

    [nameInput, typeInput, priceInput, guestsInput, unitsInput, descInput].forEach(elem => {
        if (elem) {
            elem.addEventListener('input', updatePreview);
            elem.addEventListener('change', updatePreview);
        }
    });

    amenityCheckboxes.forEach(cb => cb.addEventListener('change', updatePreview));

    // Listen to custom tourist-image-updated event from image-uploader
    window.addEventListener('tourist-image-updated', function (e) {
        if (previewImage && e.detail && e.detail.src) {
            previewImage.src = e.detail.src;
        }
    });

    // Instant client-side thumbnail preview for multiple gallery photos
    const galleryInput = document.getElementById('acc_gallery_create');
    const galleryPreview = document.getElementById('acc_gallery_create_preview');
    if (galleryInput && galleryPreview) {
        galleryInput.addEventListener('change', function(e) {
            galleryPreview.replaceChildren();
            const files = Array.from(e.target.files).slice(0, 10);
            files.forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        const wrap = document.createElement('div');
                        wrap.className = 'border rounded-3 p-1 bg-white shadow-sm position-relative';
                        wrap.style.cssText = 'width: 75px; height: 75px; overflow: hidden;';
                        const img = document.createElement('img');
                        img.src = evt.target.result;
                        img.className = 'w-100 h-100 rounded-2';
                        img.style.objectFit = 'cover';
                        wrap.appendChild(img);
                        galleryPreview.appendChild(wrap);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }

    updatePreview();
});
</script>
@endsection

