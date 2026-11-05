@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resorts</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Resorts Management</h2>
                <p class="text-muted mb-0">View registered resorts across Gubat and their assigned Resort Administrators.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.resorts.create') }}" class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Add New Resort
                </a>
                <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Resort Admin
                </a>
            </div>
        </div>

        <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div class="position-relative flex-grow-1" style="max-width: 520px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="resortSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                           placeholder="Search resorts by name, barangay, category, address, or admin..." autocomplete="off">
                    <button type="button" id="resortSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </div>
                <div class="small text-muted" id="resortSearchCounter">
                    Showing <strong class="text-dark">{{ count($resorts) }}</strong> of <strong class="text-dark">{{ count($resorts) }}</strong> records
                </div>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold resort-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted resort-filter-pill" data-filter="luxury">Luxury</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted resort-filter-pill" data-filter="eco">Eco-Lodge</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted resort-filter-pill" data-filter="budget">Budget</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted resort-filter-pill" data-filter="accredited">Accredited</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted resort-filter-pill" data-filter="pending">Pending</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Resort Name</th>
                            <th>Category</th>
                            <th>Barangay</th>
                            <th>LGU Status</th>
                            <th>Accommodations</th>
                            <th>Assigned Resort Admin</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="resortsTableBody">
                        @forelse($resorts as $resort)
                            <tr class="resort-row"
                                data-search="{{ strtolower($resort->name . ' ' . ($resort->barangay ? $resort->barangay->name : 'gubat') . ' ' . $resort->category . ' ' . $resort->address . ' ' . $resort->admins->pluck('name')->implode(' ') . ' ' . ($resort->is_lgu_approved ? 'accredited' : 'pending')) }}"
                                data-category="{{ strtolower($resort->category) }}"
                                data-status="{{ $resort->is_lgu_approved ? 'accredited' : 'pending' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ \Illuminate\Support\Str::startsWith($resort->image_url ?? '', ['http://', 'https://']) ? $resort->image_url : asset($resort->image_url ?? 'images/resorts/gubat_bay_beach_resort.jpg') }}"
                                             alt="{{ $resort->name }}"
                                             class="rounded-3 shadow-sm"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark resort-highlight-target">{{ $resort->name }}</div>
                                            <small class="text-muted resort-highlight-target">{{ $resort->address ?? 'Gubat, Sorsogon' }}</small>
                                            @if(!empty($resort->gallery_images) && count($resort->gallery_images) > 0)
                                                <span class="badge bg-secondary-subtle text-secondary small ms-1">
                                                    <i class="bi bi-images me-1"></i>{{ count($resort->gallery_images) }} gallery photos
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-1 rounded-pill resort-highlight-target">
                                        {{ ucfirst($resort->category) }}
                                    </span>
                                </td>
                                <td class="resort-highlight-target">{{ $resort->barangay ? $resort->barangay->name : 'Gubat Proper' }}</td>
                                <td>
                                    @if($resort->is_lgu_approved)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Accredited
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-3 py-1 rounded-pill">
                                            Pending
                                        </span>
                                    @endif
                                    @if($resort->featured)
                                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill small ms-1">
                                            <i class="bi bi-star-fill me-1"></i>Featured
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $resort->accommodations->count() }} registered</td>
                                <td>
                                    @if($resort->admins->isNotEmpty())
                                        @foreach($resort->admins as $admin)
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2 py-1 rounded-pill me-1 resort-highlight-target">
                                                    <i class="bi bi-person-check me-1"></i> {{ $admin->name }}
                                                </span>
                                                <small class="text-muted resort-highlight-target">({{ $admin->email }})</small>
                                            </div>
                                        @endforeach
                                    @else
                                        <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1">
                                            <i class="bi bi-plus me-1"></i> Assign Admin
                                        </a>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editResortModal-{{ $resort->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#viewRoomsModal-{{ $resort->id }}" title="View registered accommodations and room inventory">
                                            <i class="bi bi-door-open me-1"></i> Rooms ({{ $resort->accommodations->count() }})
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit Resort Modal with Live Card Preview -->
                            <div class="modal fade" id="editResortModal-{{ $resort->id }}" tabindex="-1" aria-labelledby="editResortModalLabel-{{ $resort->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">
                                        <form method="POST" action="{{ route('admin.resorts.update', $resort->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="modal-header border-bottom py-3 px-4">
                                                <h5 class="modal-title fw-bold text-dark" id="editResortModalLabel-{{ $resort->id }}">
                                                    <i class="bi bi-pencil-square text-primary me-2"></i> Edit Resort: {{ $resort->name }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <!-- Left Column: Form Inputs -->
                                                    <div class="col-lg-7">
                                                        <div class="row g-3">
                                                            <!-- Name -->
                                                            <div class="col-md-8">
                                                                <label class="form-label small fw-bold text-dark">Establishment Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $resort->name) }}" required>
                                                            </div>

                                                            <!-- Category -->
                                                            <div class="col-md-4">
                                                                <label class="form-label small fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                                                <select name="category" class="form-select rounded-3" required>
                                                                    <option value="luxury" {{ old('category', $resort->category) == 'luxury' ? 'selected' : '' }}>Luxury Resort</option>
                                                                    <option value="eco" {{ old('category', $resort->category) == 'eco' ? 'selected' : '' }}>Eco Lodge</option>
                                                                    <option value="homestay" {{ old('category', $resort->category) == 'homestay' ? 'selected' : '' }}>Homestay / Villa</option>
                                                                    <option value="budget" {{ old('category', $resort->category) == 'budget' ? 'selected' : '' }}>Budget Lodging</option>
                                                                </select>
                                                            </div>

                                                            <!-- Barangay -->
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold text-dark">Barangay <span class="text-danger">*</span></label>
                                                                <select name="barangay_id" class="form-select rounded-3" required>
                                                                    @foreach($barangays as $b)
                                                                        <option value="{{ $b->id }}" data-bname="{{ $b->name }}" {{ old('barangay_id', $resort->barangay_id) == $b->id ? 'selected' : '' }}>
                                                                            {{ $b->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Address -->
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold text-dark">Specific Address / Landmark</label>
                                                                <input type="text" name="address" class="form-control rounded-3" value="{{ old('address', $resort->address) }}">
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold text-dark">Description</label>
                                                                <textarea name="description" rows="3" class="form-control rounded-3">{{ old('description', $resort->description) }}</textarea>
                                                            </div>

                                                            <!-- Cover Photo -->
                                                            <div class="col-12">
                                                                @include('partials.image-uploader', [
                                                                    'id' => 'resort_edit_' . $resort->id,
                                                                    'label' => 'Resort Cover Photo',
                                                                    'currentImage' => old('image_url', $resort->image_url),
                                                                    'helperText' => 'Upload a photo to replace the cover image.'
                                                                ])
                                                            </div>

                                                            <!-- Additional Gallery Photos (Up to 10) -->
                                                            <div class="col-12 pt-3 border-top">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <label class="form-label small fw-bold text-dark mb-0">
                                                                        <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                                                    </label>
                                                                    <span class="badge bg-light text-muted border small">Max 10 photos</span>
                                                                </div>
                                                                <div class="form-text text-muted small mb-2">
                                                                    Photos appear in the scrollable gallery when visitors click to enlarge the resort card.
                                                                </div>

                                                                @if(!empty($resort->gallery_images) && is_array($resort->gallery_images) && count($resort->gallery_images) > 0)
                                                                    <div class="mb-2">
                                                                        <span class="small fw-semibold text-muted d-block mb-1">
                                                                            Current Gallery ({{ count($resort->gallery_images) }}/10 photos):
                                                                        </span>
                                                                        <div class="d-flex flex-wrap gap-2">
                                                                            @foreach($resort->gallery_images as $gIdx => $gPath)
                                                                                <div class="position-relative border rounded-3 p-1 bg-white shadow-sm existing-gallery-item" style="width: 75px; height: 75px;">
                                                                                    <img src="{{ \Illuminate\Support\Str::startsWith($gPath, ['http://', 'https://']) ? $gPath : asset($gPath) }}"
                                                                                         class="w-100 h-100 rounded-2"
                                                                                         style="object-fit: cover;"
                                                                                         alt="Gallery Photo">
                                                                                    <input type="hidden" name="retained_gallery_images[]" value="{{ $gPath }}">
                                                                                    <button type="button" class="btn btn-danger btn-sm p-0 position-absolute top-0 end-0 rounded-circle remove-gallery-btn"
                                                                                            style="width: 20px; height: 20px; line-height: 1; transform: translate(30%, -30%);"
                                                                                            onclick="this.closest('.existing-gallery-item').remove();"
                                                                                            title="Remove this photo">
                                                                                        &times;
                                                                                    </button>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                                <label class="form-label small fw-semibold text-muted mt-2">Upload New / Additional Photos:</label>
                                                                <input type="file" name="gallery_images[]" id="resort_gallery_edit_{{ $resort->id }}" class="form-control rounded-3 resort-gallery-input" multiple accept="image/jpeg,image/png,image/webp">
                                                                <div id="resort_gallery_edit_{{ $resort->id }}_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                                            </div>

                                                            <!-- Maps URL -->
                                                            <div class="col-12">
                                                                <label class="form-label small fw-bold text-dark">Google Maps Pin URL</label>
                                                                <input type="url" name="google_map_url" class="form-control rounded-3" value="{{ old('google_map_url', $resort->google_map_url) }}">
                                                            </div>

                                                            <!-- Switches: LGU Approved & Featured -->
                                                            <div class="col-md-6">
                                                                <div class="form-check form-switch mt-2">
                                                                    <input class="form-check-input" type="checkbox" name="is_lgu_approved" id="approvedCheck-{{ $resort->id }}" value="1" {{ old('is_lgu_approved', $resort->is_lgu_approved) ? 'checked' : '' }}>
                                                                    <label class="form-check-label fw-semibold text-dark" for="approvedCheck-{{ $resort->id }}">
                                                                        LGU Accredited
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-check form-switch mt-2">
                                                                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck-{{ $resort->id }}" value="1" {{ old('featured', $resort->featured) ? 'checked' : '' }}>
                                                                    <label class="form-check-label fw-semibold text-dark" for="featuredCheck-{{ $resort->id }}">
                                                                        Featured on Homepage
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right Column: Live Card Preview -->
                                                    <div class="col-lg-5 align-self-start">
                                                        <div class="sticky-top" style="top: 15px;">
                                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                                                    <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                                                </span>
                                                                <small class="text-muted">Public card layout</small>
                                                            </div>

                                                            @php
                                                                $coverImg = $resort->image_url 
                                                                    ? (\Illuminate\Support\Str::startsWith($resort->image_url, ['http://', 'https://']) ? $resort->image_url : asset($resort->image_url))
                                                                    : asset('images/resorts/gubat_bay_beach_resort.jpg');
                                                                $minPrice = $resort->accommodations->min('price_per_night') ?? 1500;
                                                            @endphp

                                                            <div class="card card-tourism border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                                                <div class="card-tourism-img-wrapper position-relative overflow-hidden" style="height: 200px;">
                                                                    <span class="badge bg-success text-white card-badge shadow-sm px-3 py-1.5" style="font-size: 0.75rem;">
                                                                        From ₱{{ number_format($minPrice) }} / night
                                                                    </span>
                                                                    {{-- Accredited Badge in preview --}}
                                                                    <span class="badge bg-success text-white position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm live-resort-accredited" style="z-index: 2; {{ $resort->is_lgu_approved ? '' : 'display: none;' }}">
                                                                        <i class="bi bi-patch-check-fill me-1"></i> Accredited
                                                                    </span>
                                                                    {{-- Featured Badge in preview --}}
                                                                    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm live-resort-featured" style="z-index: 2; transform: translateY(28px); {{ $resort->featured ? '' : 'display: none;' }}">
                                                                        <i class="bi bi-star-fill text-dark me-1"></i> Featured
                                                                    </span>
                                                                    <img src="{{ $coverImg }}" 
                                                                         alt="{{ $resort->name }}" 
                                                                         class="w-100 h-100 live-resort-img" 
                                                                         style="object-fit: cover;">
                                                                </div>
                                                                <div class="card-body p-4 d-flex flex-column">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                                        <span class="small text-muted fw-semibold live-resort-address">
                                                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>Brgy. {{ $resort->barangay ? $resort->barangay->name : 'Gubat' }}, Sorsogon
                                                                        </span>
                                                                        <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill px-2.5 py-1 small live-resort-cat text-capitalize">
                                                                            {{ ucfirst($resort->category) }}
                                                                        </span>
                                                                    </div>
                                                                    <h5 class="fw-bold text-dark mb-1 live-resort-name">{{ $resort->name }}</h5>
                                                                    <p class="small text-muted mb-3 live-resort-desc">
                                                                        {{ Str::limit($resort->description ?? 'Beachfront resort offering comfortable accommodations and local hospitality in Gubat.', 95) }}
                                                                    </p>
                                                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                                                        <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-house-door me-1"></i>{{ $resort->accommodations->count() }} Registered Units</span>
                                                                        <span class="badge bg-secondary-subtle text-secondary small"><i class="bi bi-images me-1"></i>{{ !empty($resort->gallery_images) ? count($resort->gallery_images) : 0 }} Gallery Photos</span>
                                                                    </div>
                                                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                                                                        <div class="text-warning small">
                                                                            <i class="bi bi-star-fill"></i>
                                                                            <i class="bi bi-star-fill"></i>
                                                                            <i class="bi bi-star-fill"></i>
                                                                            <i class="bi bi-star-fill"></i>
                                                                            <i class="bi bi-star-half"></i>
                                                                            <span class="text-dark fw-bold ms-1">{{ number_format($resort->rating ?? 4.8, 1) }}</span>
                                                                        </div>
                                                                        <span class="btn btn-sm btn-outline-primary rounded-pill px-3">Explore &rarr;</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer border-top py-3 px-4">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                                    <i class="bi bi-save me-1"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- View Rooms Modal -->
                            <div class="modal fade" id="viewRoomsModal-{{ $resort->id }}" tabindex="-1" aria-labelledby="viewRoomsModalLabel-{{ $resort->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">
                                        <div class="modal-header border-bottom py-3 px-4 bg-light">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; flex-shrink: 0;">
                                                    <i class="bi bi-door-open-fill fs-6"></i>
                                                </div>
                                                <div>
                                                    <h5 class="modal-title fw-bold text-dark mb-0" id="viewRoomsModalLabel-{{ $resort->id }}">
                                                        {{ $resort->name }}
                                                    </h5>
                                                    <small class="text-muted">Registered Accommodations &amp; Room Inventory ({{ $resort->accommodations->count() }} units)</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4 bg-light bg-opacity-50">
                                            @if($resort->accommodations->isEmpty())
                                                <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                                                    <i class="bi bi-door-closed display-5 text-muted mb-3 d-block opacity-50"></i>
                                                    <h5 class="fw-bold text-dark">No Accommodations Registered</h5>
                                                    <p class="text-muted small mb-0">
                                                        The resort administrator has not added any room units or suites yet.
                                                    </p>
                                                </div>
                                            @else
                                                <div class="row g-3">
                                                    @foreach($resort->accommodations as $acc)
                                                        @php
                                                            $accImg = $acc->image_url 
                                                                ? (str_starts_with($acc->image_url, 'http') ? $acc->image_url : asset($acc->image_url)) 
                                                                : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80';
                                                        @endphp
                                                        <div class="col-12">
                                                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                                                <div class="row g-0 align-items-center">
                                                                    <div class="col-sm-4 col-md-3">
                                                                        <img src="{{ $accImg }}" alt="{{ $acc->name }}" class="w-100" style="height: 140px; object-fit: cover;">
                                                                    </div>
                                                                    <div class="col-sm-8 col-md-9 p-3">
                                                                        <div class="d-flex justify-content-between align-items-start mb-1 flex-wrap gap-2">
                                                                            <div>
                                                                                <h6 class="fw-bold text-dark mb-0">{{ $acc->name }}</h6>
                                                                                <span class="badge bg-light text-secondary border small text-capitalize mt-1">
                                                                                    <i class="bi bi-tag me-1"></i>{{ $acc->type }}
                                                                                </span>
                                                                            </div>
                                                                            <div class="text-end">
                                                                                <div class="fw-bold text-primary fs-6">₱{{ number_format($acc->price_per_night, 2) }}</div>
                                                                                <small class="text-muted" style="font-size: 0.72rem;">per night</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="d-flex flex-wrap gap-2 my-2 small text-muted">
                                                                            <span><i class="bi bi-people me-1 text-primary"></i>Max {{ $acc->max_guests }} Guests</span>
                                                                            <span>&bull;</span>
                                                                            <span><i class="bi bi-door-closed me-1 text-primary"></i>{{ $acc->total_units }} Total Units</span>
                                                                            @if($acc->amenities && $acc->amenities->count() > 0)
                                                                                <span>&bull;</span>
                                                                                <span><i class="bi bi-stars me-1 text-warning"></i>{{ $acc->amenities->pluck('name')->implode(', ') }}</span>
                                                                            @endif
                                                                        </div>

                                                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-2">
                                                                            <div>
                                                                                @if($acc->status === 'approved')
                                                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2.5 py-1 small">
                                                                                        <i class="bi bi-check-circle me-1"></i> Approved &amp; Live
                                                                                    </span>
                                                                                @elseif($acc->status === 'rejected')
                                                                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-2.5 py-1 small">
                                                                                        <i class="bi bi-x-circle me-1"></i> Rejected
                                                                                    </span>
                                                                                @else
                                                                                    <span class="badge bg-warning bg-opacity-10 text-dark border border-warning rounded-pill px-2.5 py-1 small">
                                                                                        <i class="bi bi-clock me-1"></i> Pending Approval
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            @if($acc->status === 'pending')
                                                                                <a href="{{ route('admin.accommodations.index', ['status' => 'pending']) }}" class="btn btn-xs btn-outline-warning rounded-pill px-2 py-1 small fw-semibold">
                                                                                    Review in Approvals &rarr;
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-footer border-top py-3 px-4 bg-white d-flex justify-content-between">
                                            <a href="{{ route('admin.accommodations.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                <i class="bi bi-patch-check me-1"></i> Go to Approvals Page
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No resorts found.</td>
                            </tr>
                        @endforelse

                        {{-- Friendly Live Search Empty State --}}
                        <tr id="resortSearchEmptyRow" class="empty-state-row" style="display: none;">
                            <td colspan="7" class="text-center py-5 bg-white">
                                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h6>
                                <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_resortSearchInput()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            {{ $resorts->links() }}
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Instant client-side thumbnail preview for multiple resort gallery photos
    document.addEventListener('change', function(e) {
        if (e.target.matches('.resort-gallery-input')) {
            const previewId = e.target.id + '_preview';
            const previewContainer = document.getElementById(previewId);
            if (!previewContainer) return;
            previewContainer.replaceChildren();

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
                        previewContainer.appendChild(wrap);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    // Live Public Card Preview Sync for Edit Resort Modals
    function initResortSync(modalSelector, uploaderId) {
        const modal = document.querySelector(modalSelector);
        if (!modal) return;
        const nameInput = modal.querySelector('input[name="name"]');
        const catSelect = modal.querySelector('select[name="category"]');
        const bgySelect = modal.querySelector('select[name="barangay_id"]');
        const addrInput = modal.querySelector('input[name="address"]');
        const descInput = modal.querySelector('textarea[name="description"]');
        const appCheck  = modal.querySelector('input[name="is_lgu_approved"]');
        const featCheck = modal.querySelector('input[name="featured"]');

        const prevName       = modal.querySelector('.live-resort-name');
        const prevCat        = modal.querySelector('.live-resort-cat');
        const prevAddr       = modal.querySelector('.live-resort-address');
        const prevDesc       = modal.querySelector('.live-resort-desc');
        const prevAccredited = modal.querySelector('.live-resort-accredited');
        const prevFeatured   = modal.querySelector('.live-resort-featured');
        const prevImg        = modal.querySelector('.live-resort-img');

        function update() {
            if (prevName && nameInput) prevName.textContent = nameInput.value.trim() || 'Resort Name';
            if (prevCat && catSelect) {
                const optText = catSelect.options[catSelect.selectedIndex] ? catSelect.options[catSelect.selectedIndex].text : catSelect.value;
                prevCat.textContent = optText;
            }
            if (prevAddr) {
                const bName = bgySelect && bgySelect.options[bgySelect.selectedIndex] 
                    ? (bgySelect.options[bgySelect.selectedIndex].getAttribute('data-bname') || bgySelect.options[bgySelect.selectedIndex].text) 
                    : 'Gubat';
                const addr = addrInput && addrInput.value.trim() ? addrInput.value.trim() : `Brgy. ${bName.trim()}, Gubat`;
                prevAddr.innerHTML = `<i class="bi bi-geo-alt-fill text-danger me-1"></i>${addr}`;
            }
            if (prevDesc && descInput) {
                const t = descInput.value.trim();
                prevDesc.textContent = t ? (t.length > 95 ? t.substring(0, 95) + '...' : t) : 'Beachfront resort offering comfortable accommodations and local hospitality in Gubat.';
            }
            if (prevAccredited && appCheck) {
                prevAccredited.style.display = appCheck.checked ? 'inline-block' : 'none';
            }
            if (prevFeatured && featCheck) {
                prevFeatured.style.display = featCheck.checked ? 'inline-block' : 'none';
            }
        }

        [nameInput, catSelect, bgySelect, addrInput, descInput, appCheck, featCheck].forEach(el => {
            if (el) {
                el.addEventListener('input', update);
                el.addEventListener('change', update);
            }
        });

        window.addEventListener('tourist-image-updated', function(e) {
            if (prevImg && e.detail && e.detail.src && e.detail.uploaderId === uploaderId) {
                prevImg.src = e.detail.src;
            }
        });

        update();
    }

    @foreach($resorts as $resort)
        initResortSync('#editResortModal-{{ $resort->id }}', 'resort_edit_{{ $resort->id }}');
    @endforeach

    // Initialize Level A live table search for Resorts
    initLiveTableFilter({
        inputId: 'resortSearchInput',
        clearBtnId: 'resortSearchClear',
        counterId: 'resortSearchCounter',
        emptyStateId: 'resortSearchEmptyRow',
        containerId: 'resortsTableBody',
        rowSelector: 'tr.resort-row',
        pillSelector: '.resort-filter-pill',
        highlightSelector: '.resort-highlight-target'
    });
});
</script>
@endsection
