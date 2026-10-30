@extends('layouts.admin')

@section('content')
<div class="pb-5">
    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.resorts') }}">Resorts</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Resort</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Register New Resort</h2>
                <p class="text-muted mb-0">Add a new tourism establishment or eco-lodge to Gubat's directory.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.resorts') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back to Resorts
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Form Column -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            <i class="bi bi-building-add text-primary me-2"></i> Establishment Details
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

                        <form method="POST" action="{{ route('admin.resorts.store') }}" enctype="multipart/form-data" id="resortCreateForm">
                            @csrf

                            <!-- Resort Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Resort / Establishment Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="e.g. Pacific Sunrise Beach Resort"
                                       required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <!-- Barangay -->
                                <div class="col-md-6">
                                    <label for="barangay_id" class="form-label fw-semibold text-dark">
                                        Barangay Location <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('barangay_id') is-invalid @enderror"
                                            id="barangay_id"
                                            name="barangay_id"
                                            required>
                                        <option value="" disabled selected>-- Select Barangay --</option>
                                        @foreach($barangays as $barangay)
                                            <option value="{{ $barangay->id }}" {{ old('barangay_id') == $barangay->id ? 'selected' : '' }}>
                                                {{ $barangay->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('barangay_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label for="category" class="form-label fw-semibold text-dark">
                                        Establishment Category <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('category') is-invalid @enderror"
                                            id="category"
                                            name="category"
                                            required>
                                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Select Category --</option>
                                        <option value="luxury" {{ old('category') == 'luxury' ? 'selected' : '' }}>Luxury Resort</option>
                                        <option value="eco" {{ old('category') == 'eco' ? 'selected' : '' }}>Eco Lodge / Nature Camp</option>
                                        <option value="homestay" {{ old('category') == 'homestay' ? 'selected' : '' }}>Homestay / Villa</option>
                                        <option value="budget" {{ old('category') == 'budget' ? 'selected' : '' }}>Budget / Surfer Cabin</option>
                                    </select>
                                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Specific Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold text-dark">Specific Address / Landmark</label>
                                <input type="text"
                                       class="form-control @error('address') is-invalid @enderror"
                                       id="address"
                                       name="address"
                                       value="{{ old('address') }}"
                                       placeholder="e.g. Near Rizal Surf Camp, Rizal, Gubat, Sorsogon">
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold text-dark">Description & Highlights</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Describe amenities, beach view, surfing access, or dining options...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Cover Image Uploader (Local File or URL) -->
                            @include('partials.image-uploader', [
                                'id' => 'resort_create',
                                'label' => 'Resort Cover Photo',
                                'currentImage' => old('image_url'),
                                'helperText' => 'Select a photo of the resort from your computer (JPG, PNG, WebP up to 5MB).'
                            ])

                            <!-- Additional Gallery Photos (Up to 10) -->
                            <div class="mb-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fw-semibold text-dark mb-0">
                                        <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                    </label>
                                    <span class="badge bg-light text-muted border small">Max 10 photos</span>
                                </div>
                                <div class="form-text text-muted small mb-2">
                                    Select up to 10 additional photos. When visitors click the card or explore, they can scroll horizontally through these photos in the enlarged modal.
                                </div>
                                <input type="file" name="gallery_images[]" id="resort_gallery_create" class="form-control rounded-3 gallery-input" multiple accept="image/jpeg,image/png,image/webp">
                                <div id="resort_gallery_create_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                            </div>

                            <!-- Google Map URL -->
                            <div class="mb-3">
                                <label for="google_map_url" class="form-label fw-semibold text-dark">Google Maps Pin URL</label>
                                <input type="url"
                                       class="form-control @error('google_map_url') is-invalid @enderror"
                                       id="google_map_url"
                                       name="google_map_url"
                                       value="{{ old('google_map_url') }}"
                                       placeholder="https://maps.google.com/?q=...">
                                @error('google_map_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <hr class="my-4">

                            <!-- Optional: Assign Resort Admin -->
                            <div class="mb-4">
                                <label for="admin_user_id" class="form-label fw-semibold text-dark d-flex justify-content-between">
                                    <span>Assign Resort Administrator <span class="text-muted fw-normal">(optional)</span></span>
                                    <a href="{{ route('admin.resort-admins.create') }}" class="small text-decoration-none">
                                        <i class="bi bi-plus"></i> Create new admin account first
                                    </a>
                                </label>
                                <select class="form-select @error('admin_user_id') is-invalid @enderror"
                                        id="admin_user_id"
                                        name="admin_user_id">
                                    <option value="">-- No Admin Assigned Yet (Can be assigned later) --</option>
                                    @foreach($unassignedAdmins as $unassignedAdmin)
                                        <option value="{{ $unassignedAdmin->id }}" {{ old('admin_user_id') == $unassignedAdmin->id ? 'selected' : '' }}>
                                            {{ $unassignedAdmin->name }} ({{ $unassignedAdmin->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Only shows active resort admin accounts not yet linked to any resort.</div>
                                @error('admin_user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- LGU Accreditation Status -->
                            <div class="form-check form-switch mb-4 p-3 bg-light rounded-3">
                                <input class="form-check-input ms-0 me-3"
                                       type="checkbox"
                                       role="switch"
                                       id="is_lgu_approved"
                                       name="is_lgu_approved"
                                       value="1"
                                       {{ old('is_lgu_approved', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold text-dark" for="is_lgu_approved">
                                    LGU Tourism Accredited
                                </label>
                                <small class="text-muted d-block ms-5">When enabled, the establishment carries the official LGU Accredited seal on the public tourism portal.</small>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('admin.resorts') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                    <i class="bi bi-check-circle me-1"></i> Register Resort
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Live Card Preview Column -->
            <div class="col-lg-5 align-self-start">
                <div class="sticky-top" style="top: 85px; z-index: 10;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                            <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                        </span>
                        <small class="text-muted">Public directory card</small>
                    </div>

                    <div class="card card-tourism border-0 shadow rounded-4 overflow-hidden bg-white">
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            <img id="previewResortImage"
                                 src="{{ asset('images/resorts/gubat_bay_beach_resort.jpg') }}"
                                 alt="Resort Preview"
                                 class="w-100 h-100"
                                 style="object-fit: cover;">
                            
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-success text-white shadow-sm px-3 py-2 rounded-pill" id="previewResortRateBadge">
                                    From ₱1,500 / night
                                </span>
                            </div>

                            <div class="position-absolute top-0 end-0 m-3" id="previewLguAccreditedBadge">
                                <span class="badge bg-primary shadow-sm px-3 py-2 rounded-pill">
                                    <i class="bi bi-patch-check-fill me-1"></i> LGU Accredited
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="small text-muted" id="previewResortLocation">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. Rizal, Gubat
                                </span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1" id="previewResortName">Resort / Establishment Name</h5>
                            <p class="small text-muted mb-3" id="previewResortDesc">
                                Describe amenities, beach view, surfing access, or dining options...
                            </p>

                            {{-- Badges --}}
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-people me-1"></i>Max 4 Guests</span>
                                <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-house-door me-1"></i>Units Available</span>
                                <span class="badge bg-info-subtle text-info small text-capitalize" id="previewResortCategoryBadge">
                                    Resort
                                </span>
                            </div>

                            {{-- Amenity Icons --}}
                            <div class="d-flex gap-3 mb-3 text-primary fs-5 border-top border-bottom py-2">
                                <span title="WiFi"><i class="bi bi-wifi"></i></span>
                                <span title="Parking"><i class="bi bi-p-circle"></i></span>
                                <span title="Air Conditioning"><i class="bi bi-snow"></i></span>
                                <span title="Restaurant / Cafe"><i class="bi bi-cup-hot"></i></span>
                            </div>

                            {{-- Rating --}}
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="small fw-bold text-dark">4.8</span>
                                <span class="small text-muted">(New listing)</span>
                            </div>
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
    const barangaySelect = document.getElementById('barangay_id');
    const categorySelect = document.getElementById('category');
    const descInput = document.getElementById('description');
    const lguSwitch = document.getElementById('is_lgu_approved');

    const previewName = document.getElementById('previewResortName');
    const previewLocation = document.getElementById('previewResortLocation');
    const previewCategory = document.getElementById('previewResortCategoryBadge');
    const previewDesc = document.getElementById('previewResortDesc');
    const previewImage = document.getElementById('previewResortImage');
    const previewLguBadge = document.getElementById('previewLguAccreditedBadge');

    function updatePreview() {
        if (previewName) {
            previewName.textContent = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'Resort / Establishment Name';
        }
        if (previewLocation) {
            let brgyText = 'Gubat Proper';
            if (barangaySelect && barangaySelect.selectedIndex > 0) {
                brgyText = barangaySelect.options[barangaySelect.selectedIndex].text.trim();
            }
            previewLocation.innerHTML = `<i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. ${brgyText}, Gubat`;
        }
        if (previewCategory) {
            const cat = categorySelect && categorySelect.value ? categorySelect.value : 'Resort';
            previewCategory.textContent = cat.charAt(0).toUpperCase() + cat.slice(1);
        }
        if (previewDesc) {
            previewDesc.textContent = descInput && descInput.value.trim() 
                ? (descInput.value.trim().length > 110 ? descInput.value.trim().substring(0, 110) + '...' : descInput.value.trim())
                : 'Describe amenities, beach view, surfing access, or dining options...';
        }
        if (previewLguBadge) {
            previewLguBadge.style.display = lguSwitch && lguSwitch.checked ? 'block' : 'none';
        }
    }

    [nameInput, barangaySelect, categorySelect, descInput, lguSwitch].forEach(elem => {
        if (elem) {
            elem.addEventListener('input', updatePreview);
            elem.addEventListener('change', updatePreview);
        }
    });

    window.addEventListener('tourist-image-updated', function (e) {
        if (previewImage && e.detail && e.detail.src) {
            previewImage.src = e.detail.src;
        }
    });

    // Instant client-side thumbnail preview for multiple gallery photos
    const galleryInput = document.getElementById('resort_gallery_create');
    const galleryPreview = document.getElementById('resort_gallery_create_preview');
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
    </div>
</div>
@endsection
