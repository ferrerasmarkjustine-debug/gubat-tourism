@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Destinations</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Destinations Management</h2>
                <p class="text-muted mb-0">Manage municipal destinations, surf camps, and historical spots across Gubat.</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success rounded-pill px-4 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#createDestinationModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Destination
                </button>
                <a href="{{ route('destinations') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-eye me-1"></i> Public Destinations
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div class="position-relative flex-grow-1" style="max-width: 520px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="destSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                           placeholder="Search destinations by name, category, municipality, or description..." autocomplete="off">
                    <button type="button" id="destSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </div>
                <div class="small text-muted" id="destSearchCounter">
                    Showing <strong class="text-dark">{{ count($destinations) }}</strong> of <strong class="text-dark">{{ count($destinations) }}</strong> records
                </div>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold dest-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="beach">Beach</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="eco">Ecotourism</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="historical">Historical</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="cultural">Cultural</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="featured">Featured</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Destination Name</th>
                            <th>Category</th>
                            <th>Municipality</th>
                            <th>Rating</th>
                            <th>Featured</th>
                            <th class="text-end pe-4" style="min-width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="destinationsTableBody">
                        @forelse($destinations as $dest)
                            <tr class="dest-row"
                                data-search="{{ strtolower($dest->name . ' ' . $dest->category . ' ' . ($dest->municipality ? $dest->municipality->name : 'gubat') . ' ' . $dest->barangay_name . ' ' . $dest->description . ' ' . ($dest->featured ? 'featured' : 'standard')) }}"
                                data-category="{{ strtolower($dest->category) }}"
                                data-status="{{ $dest->featured ? 'featured' : 'standard' }}">
                                <td class="ps-4">
                                    <div class="fw-bold text-dark dest-highlight-target">{{ $dest->name }}</div>
                                    <small class="text-muted dest-highlight-target">{{ Str::limit($dest->description, 60) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border px-3 py-1 rounded-pill dest-highlight-target">
                                        {{ $dest->category }}
                                    </span>
                                </td>
                                <td class="dest-highlight-target">{{ $dest->municipality ? $dest->municipality->name : 'Gubat' }}</td>
                                <td>
                                    <span class="text-warning fw-semibold">
                                        <i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($dest->rating, 1) }}
                                    </span>
                                </td>
                                <td>
                                    @if($dest->featured)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2 py-1">Featured</span>
                                    @else
                                        <span class="text-muted small">Standard</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        {{-- Quick Toggle Featured --}}
                                        <form method="POST" action="{{ route('admin.destinations.toggle-featured', $dest) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $dest->featured ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-2 py-1"
                                                    title="{{ $dest->featured ? 'Click to unmark as Featured' : 'Click to mark as Featured' }}">
                                                <i class="bi {{ $dest->featured ? 'bi-star-fill' : 'bi-star' }} me-1"></i>
                                                <span class="small">{{ $dest->featured ? 'Featured' : 'Standard' }}</span>
                                            </button>
                                        </form>

                                        {{-- Edit Button (triggers modal) --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal-{{ $dest->id }}"
                                                title="Edit destination details">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        {{-- Google Maps Link --}}
                                        @if($dest->google_map_url)
                                            <a href="{{ $dest->google_map_url }}" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1"
                                               title="View on Google Maps">
                                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No destinations recorded.</td>
                            </tr>
                        @endforelse

                        {{-- Friendly Live Search Empty State --}}
                        <tr id="destSearchEmptyRow" class="empty-state-row" style="display: none;">
                            <td colspan="6" class="text-center py-5 bg-white">
                                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h6>
                                <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_destSearchInput()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($destinations->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4 d-flex justify-content-center">
                    {{ $destinations->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Create Destination Modal --}}
<div class="modal fade" id="createDestinationModal" tabindex="-1" aria-labelledby="createDestinationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="createDestinationModalLabel">
                    <i class="bi bi-geo-alt-fill text-success me-2"></i> Add New Tourist Destination
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold text-muted">Destination Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Dancalan Beach Eco-Park" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                    <input type="text" name="category" list="categoryOptionsNew" class="form-control rounded-3" placeholder="Select or type..." value="{{ old('category') }}" required>
                                    <datalist id="categoryOptionsNew">
                                        <option value="Surf Haven">
                                        <option value="Public Beach">
                                        <option value="Heritage Landmark">
                                        <option value="Century-Old Church">
                                        <option value="Traditional Pottery">
                                        <option value="Livelihood Center">
                                        <option value="Historical Heritage">
                                        <option value="Eco-Tourism Site">
                                        <option value="Nature Reserve">
                                    </datalist>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Description</label>
                                    <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Describe the destination highlights, activities, views, and visitor attractions...">{{ old('description') }}</textarea>
                                </div>
                                <div class="col-12">
                                    @include('partials.image-uploader', [
                                        'id' => 'dest_create',
                                        'label' => 'Cover Photo (Primary Card Banner)',
                                        'currentImage' => old('image_url'),
                                        'helperText' => 'Select a cover photo for this destination from your computer (JPG, PNG, WebP up to 5MB).'
                                    ])
                                </div>
                                <div class="col-12 mt-2 pt-3 border-top">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-bold text-dark mb-0">
                                            <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                        </label>
                                        <span class="badge bg-light text-muted border small">Max 10 photos</span>
                                    </div>
                                    <div class="form-text text-muted small mb-2">
                                        Select up to 10 additional photos. When visitors click the card or explore, they can scroll through these photos.
                                    </div>
                                    <input type="file" name="gallery_images[]" id="gallery_create" class="form-control rounded-3 gallery-input" multiple accept="image/jpeg,image/png,image/webp">
                                    <div id="gallery_create_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Google Maps Pin URL</label>
                                    <input type="url" name="google_map_url" class="form-control rounded-3" value="{{ old('google_map_url') }}" placeholder="https://maps.google.com/...">
                                </div>
                                <div class="col-12">
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="featured" id="featuredCheckNew" value="1" {{ old('featured') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark" for="featuredCheckNew">
                                            Feature this destination
                                        </label>
                                        <div class="form-text text-muted small">Featured destinations appear prominently on the public homepage and featured spots section.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Live Card Preview Column -->
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
                                        <span class="badge text-white card-badge shadow-sm px-3 py-2 live-dest-cat" style="background-color: #0284c7; font-size: 0.75rem;">
                                            <i class="bi bi-geo-alt-fill me-1"></i> Category
                                        </span>
                                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm live-dest-feat" style="z-index: 2; display: none;">
                                            <i class="bi bi-star-fill text-dark me-1"></i> Featured
                                        </span>
                                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80" 
                                             alt="Live Preview" 
                                             class="w-100 h-100 live-dest-img" 
                                             style="object-fit: cover;">
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="small text-muted fw-semibold">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> Gubat, Sorsogon
                                            </span>
                                            <span class="badge bg-light text-secondary border small">
                                                <i class="bi bi-shield-check text-success me-1"></i> LGU Verified
                                            </span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1 live-dest-name">Destination Name</h5>
                                        <p class="small text-muted mb-3 live-dest-desc">
                                            Describe the destination highlights, activities, views, and visitor attractions...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                            <div class="text-warning small">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span class="text-dark fw-bold ms-1">5.0</span>
                                            </div>
                                            <span class="btn btn-sm btn-outline-primary rounded-pill px-3">Explore</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Save Destination
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals rendered outside table for proper stacking --}}
@foreach($destinations as $dest)
    <div class="modal fade" id="editModal-{{ $dest->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $dest->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="editModalLabel-{{ $dest->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Edit Destination: {{ $dest->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.destinations.update', $dest) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-3">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Destination Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $dest->name) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                        <input type="text" name="category" list="categoryOptions" class="form-control rounded-3" value="{{ old('category', $dest->category) }}" required>
                                        <datalist id="categoryOptions">
                                            <option value="Surf Haven">
                                            <option value="Public Beach">
                                            <option value="Heritage Landmark">
                                            <option value="Century-Old Church">
                                            <option value="Traditional Pottery">
                                            <option value="Livelihood Center">
                                            <option value="Historical Heritage">
                                        </datalist>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Description</label>
                                        <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $dest->description) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        @include('partials.image-uploader', [
                                            'id' => 'dest_' . $dest->id,
                                            'label' => 'Cover Photo (Primary Card Banner)',
                                            'currentImage' => old('image_url', $dest->image_url),
                                            'helperText' => 'Upload a cover photo of this tourist destination from your computer (JPG, PNG, WebP up to 5MB).'
                                        ])
                                    </div>
                                    <div class="col-12 mt-2 pt-3 border-top">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small fw-bold text-dark mb-0">
                                                <i class="bi bi-images text-primary me-1"></i> Additional Gallery Photos (Up to 10 Photos)
                                            </label>
                                            <span class="badge bg-light text-muted border small">Max 10 photos</span>
                                        </div>
                                        <div class="form-text text-muted small mb-2">
                                            Upload extra photos for the enlarged detail view gallery. Click the red button to remove any photo.
                                        </div>

                                        @if(!empty($dest->gallery_images) && is_array($dest->gallery_images) && count($dest->gallery_images) > 0)
                                            <div class="p-2 bg-light rounded-3 mb-2 border">
                                                <div class="small fw-semibold text-muted mb-2">
                                                    Current Gallery ({{ count($dest->gallery_images) }}/10 photos):
                                                </div>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($dest->gallery_images as $gIdx => $gPath)
                                                        @php
                                                            $gSrc = \Illuminate\Support\Str::startsWith($gPath, ['http://', 'https://']) ? $gPath : asset($gPath);
                                                        @endphp
                                                        <div class="position-relative border rounded-3 p-1 bg-white shadow-sm" style="width: 75px; height: 75px;">
                                                            <img src="{{ $gSrc }}" class="w-100 h-100 rounded-2" style="object-fit: cover;">
                                                            <input type="hidden" name="retained_gallery_images[]" value="{{ $gPath }}">
                                                            <button type="button" class="btn btn-danger btn-sm p-0 rounded-circle position-absolute top-0 end-0 translate-middle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; line-height: 1;" title="Remove this photo" onclick="this.parentElement.remove();">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <input type="file" name="gallery_images[]" id="gallery_edit_{{ $dest->id }}" class="form-control rounded-3 gallery-input" multiple accept="image/jpeg,image/png,image/webp">
                                        <div id="gallery_edit_{{ $dest->id }}_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Google Maps URL</label>
                                        <input type="url" name="google_map_url" class="form-control rounded-3" value="{{ old('google_map_url', $dest->google_map_url) }}" placeholder="https://maps.google.com/...">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck-{{ $dest->id }}" value="1" {{ $dest->featured ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold text-dark" for="featuredCheck-{{ $dest->id }}">
                                                Feature this destination
                                            </label>
                                            <div class="form-text text-muted small">Featured destinations appear prominently on the public homepage and featured spots section.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Live Card Preview Column -->
                            <div class="col-lg-5 align-self-start">
                                <div class="sticky-top" style="top: 15px;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                        </span>
                                        <small class="text-muted">Public card layout</small>
                                    </div>

                                    @php
                                        $destImgSrc = $dest->image_url 
                                            ? (str_starts_with($dest->image_url, 'http') ? $dest->image_url : asset($dest->image_url)) 
                                            : 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80';
                                    @endphp

                                    <div class="card card-tourism border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                                        <div class="card-tourism-img-wrapper position-relative overflow-hidden" style="height: 200px;">
                                            <span class="badge text-white card-badge shadow-sm px-3 py-2 live-dest-cat" style="background-color: #0284c7; font-size: 0.75rem;">
                                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $dest->category }}
                                            </span>
                                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-2 py-1 rounded-pill small fw-bold shadow-sm live-dest-feat" style="z-index: 2; {{ $dest->featured ? '' : 'display: none;' }}">
                                                <i class="bi bi-star-fill text-dark me-1"></i> Featured
                                            </span>
                                            <img src="{{ $destImgSrc }}" 
                                                 alt="{{ $dest->name }}" 
                                                 class="w-100 h-100 live-dest-img" 
                                                 style="object-fit: cover;">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small text-muted fw-semibold">
                                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $dest->municipality ? $dest->municipality->name : 'Gubat' }}, Sorsogon
                                                </span>
                                                <span class="badge bg-light text-secondary border small">
                                                    <i class="bi bi-shield-check text-success me-1"></i> LGU Verified
                                                </span>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-1 live-dest-name">{{ $dest->name }}</h5>
                                            <p class="small text-muted mb-3 live-dest-desc">
                                                {{ Str::limit($dest->description, 90) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                <div class="text-warning small">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <span class="text-dark fw-bold ms-1">{{ number_format($dest->rating, 1) }}</span>
                                                </div>
                                                <span class="btn btn-sm btn-outline-primary rounded-pill px-3">Explore</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    function initDestSync(modalSelector, uploaderId) {
        const modal = document.querySelector(modalSelector);
        if (!modal) return;
        const nameInput = modal.querySelector('input[name="name"]');
        const catInput = modal.querySelector('input[name="category"]');
        const descInput = modal.querySelector('textarea[name="description"]');
        const featInput = modal.querySelector('input[name="featured"]');

        const prevName = modal.querySelector('.live-dest-name');
        const prevCat = modal.querySelector('.live-dest-cat');
        const prevDesc = modal.querySelector('.live-dest-desc');
        const prevFeat = modal.querySelector('.live-dest-feat');
        const prevImg = modal.querySelector('.live-dest-img');

        function update() {
            if (prevName && nameInput) prevName.textContent = nameInput.value.trim() || 'Destination Name';
            if (prevCat && catInput) prevCat.innerHTML = `<i class="bi bi-geo-alt-fill me-1"></i> ${catInput.value.trim() || 'Category'}`;
            if (prevDesc && descInput) {
                const t = descInput.value.trim();
                prevDesc.textContent = t ? (t.length > 90 ? t.substring(0, 90) + '...' : t) : 'Destination highlights and activities...';
            }
            if (prevFeat && featInput) {
                prevFeat.style.display = featInput.checked ? 'inline-block' : 'none';
            }
        }

        [nameInput, catInput, descInput, featInput].forEach(el => {
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

    initDestSync('#createDestinationModal', 'dest_create');
    @foreach($destinations as $dest)
        initDestSync('#editModal-{{ $dest->id }}', 'dest_{{ $dest->id }}');
    @endforeach

    // Instant client-side thumbnail preview for multiple gallery photos
    document.addEventListener('change', function(e) {
        if (e.target.matches('.gallery-input')) {
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

    // Initialize Level A live table search for Destinations
    initLiveTableFilter({
        inputId: 'destSearchInput',
        clearBtnId: 'destSearchClear',
        counterId: 'destSearchCounter',
        emptyStateId: 'destSearchEmptyRow',
        containerId: 'destinationsTableBody',
        rowSelector: 'tr.dest-row',
        pillSelector: '.dest-filter-pill',
        highlightSelector: '.dest-highlight-target'
    });
});
</script>
@endsection
