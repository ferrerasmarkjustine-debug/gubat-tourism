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

        <!-- Signature Highlights (Spotlights) Showcase Panel -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="card-body p-4 text-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 pb-3 border-bottom border-light border-opacity-10 gap-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold text-uppercase" style="font-size:0.75rem;">
                                <i class="bi bi-stars me-1"></i> Public Directory Hero Spotlights
                            </span>
                            <span class="badge bg-white text-dark rounded-pill px-2.5 py-1 small fw-bold" style="color: #000000 !important;">
                                {{ isset($spotlightDestinations) ? $spotlightDestinations->count() : 0 }}/2 Pinned
                            </span>
                        </div>
                        <h4 class="fw-bold text-white mb-0 font-outfit">Signature Highlights of Gubat</h4>
                        <p class="text-white-50 small mb-0 mt-1">
                            These 2 premier attractions are pinned to the widescreen panoramic hero section at the top of the public <a href="{{ route('destinations') }}" target="_blank" class="text-warning text-decoration-none fw-semibold">Attractions Directory <i class="bi bi-box-arrow-up-right small"></i></a>.
                        </p>
                    </div>
                    <div>
                        <span class="text-white-50 small d-block text-md-end">
                            Use the <strong class="text-warning"><i class="bi bi-stars"></i> Pin</strong> button in the table below to feature any attraction.
                        </span>
                    </div>
                </div>

                <div class="row g-3">
                    @for($slot = 0; $slot < 2; $slot++)
                        @php
                            $spotItem = isset($spotlightDestinations) ? $spotlightDestinations->get($slot) : null;
                        @endphp
                        <div class="col-md-6">
                            @if($spotItem)
                                <div class="card border-0 rounded-4 overflow-hidden position-relative h-100 shadow-sm text-white" style="background: {{ $slot === 0 ? '#1e1b4b' : '#064e3b' }}; min-height: 120px;">
                                    @php
                                        $sImg = $spotItem->image_url 
                                            ? (\Illuminate\Support\Str::startsWith($spotItem->image_url, ['http://', 'https://']) ? $spotItem->image_url : asset($spotItem->image_url))
                                            : asset('images/destinations/buenavista_tourism_hub.jpg');
                                    @endphp
                                    <img src="{{ $sImg }}" alt="{{ $spotItem->name }}" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; opacity: 0.35;">
                                    <div class="card-body p-3 p-lg-4 position-relative d-flex flex-column justify-content-between h-100" style="z-index: 2;">
                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                            <div>
                                                <span class="badge {{ $slot === 0 ? 'bg-warning text-dark' : 'bg-success text-white' }} rounded-pill px-2.5 py-1 small fw-bold">
                                                    <i class="bi bi-stars me-1"></i> Spotlight #{{ $slot + 1 }}
                                                </span>
                                                <span class="badge bg-white bg-opacity-25 text-white rounded-pill px-2 py-1 small ms-1">
                                                    {{ $spotItem->category }}
                                                </span>
                                            </div>
                                            <form method="POST" action="{{ route('admin.destinations.toggle-spotlight', $spotItem) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-light rounded-pill px-2.5 py-1 small" title="Unpin from Signature Spotlight">
                                                    <i class="bi bi-x-circle me-1"></i> Unpin
                                                </button>
                                            </form>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold text-white mb-1 font-outfit">{{ $spotItem->name }}</h5>
                                            <p class="text-white-50 small mb-0">{{ Str::limit($spotItem->description, 80) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border border-2 border-dashed border-light border-opacity-25 rounded-4 p-4 h-100 d-flex flex-column align-items-center justify-content-center text-center text-white-50" style="min-height: 120px; background: rgba(255,255,255,0.03);">
                                    <i class="bi bi-plus-circle-dotted fs-3 text-warning mb-2"></i>
                                    <div class="fw-semibold text-white">Spotlight Slot #{{ $slot + 1 }} Empty</div>
                                    <div class="small text-white-50 mt-1">Click the <strong class="text-warning">Pin</strong> button on any destination row below to feature it.</div>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>

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

            <!-- Quick Filter Pills (Mapped to Homepage Sections) -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Homepage Sections:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold dest-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="beach">
                    <i class="bi bi-water me-1 text-primary"></i>Beach & Surfing
                </button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="church">
                    <i class="bi bi-bank me-1 text-warning"></i>Churches
                </button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="heritage">
                    <i class="bi bi-hourglass-split me-1" style="color:#92400e;"></i>History & Heritage
                </button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="nature">
                    <i class="bi bi-tree-fill me-1 text-success"></i>Nature & Eco
                </button>
                <span class="border-start mx-1" style="height:18px;"></span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="featured">
                    <i class="bi bi-star-fill me-1 text-success"></i>Featured
                </button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted dest-filter-pill" data-filter="spotlight">
                    <i class="bi bi-stars me-1 text-warning"></i>Spotlight
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="min-width: 300px;">Destination</th>
                            <th>Category</th>
                            <th>Homepage Section</th>
                            <th>Featured</th>
                            <th>Spotlight</th>
                            <th class="text-end pe-4" style="min-width: 280px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="destinationsTableBody">
                        @forelse($destinations as $dest)
                            @php
                                $catFilterLower = strtolower($dest->category ?? '');
                                $sectionFilter = 'beach';
                                if (str_contains($catFilterLower, 'church') || str_contains($catFilterLower, 'chapel') || str_contains($catFilterLower, 'parish') || str_contains($catFilterLower, 'grotto') || str_contains($catFilterLower, 'shrine') || str_contains($catFilterLower, 'religious')) {
                                    $sectionFilter = 'church';
                                } elseif (str_contains($catFilterLower, 'heritage') || str_contains($catFilterLower, 'history') || str_contains($catFilterLower, 'landmark') || str_contains($catFilterLower, 'ancestral') || str_contains($catFilterLower, 'civic')) {
                                    $sectionFilter = 'heritage';
                                } elseif (str_contains($catFilterLower, 'nature') || str_contains($catFilterLower, 'forest') || str_contains($catFilterLower, 'cave') || str_contains($catFilterLower, 'eco') || str_contains($catFilterLower, 'boardwalk') || str_contains($catFilterLower, 'spring') || str_contains($catFilterLower, 'farm') || str_contains($catFilterLower, 'marine') || str_contains($catFilterLower, 'mangrove')) {
                                    $sectionFilter = 'nature';
                                }
                            @endphp
                            <tr class="dest-row"
                                data-search="{{ strtolower($dest->name . ' ' . $dest->category . ' ' . ($dest->municipality ? $dest->municipality->name : 'gubat') . ' ' . $dest->barangay_name . ' ' . $dest->description . ' ' . ($dest->featured ? 'featured' : 'standard') . ' ' . ($dest->is_spotlight ? 'spotlight signature highlight' : '') . ' ' . $sectionFilter) }}"
                                data-category="{{ $sectionFilter }}"
                                data-status="{{ $dest->featured ? 'featured' : 'standard' }}"
                                data-spotlight="{{ $dest->is_spotlight ? 'spotlight' : '' }}">
                                @php
                                    $rowImg = $dest->image_url
                                        ? (str_starts_with($dest->image_url, 'http') ? $dest->image_url : asset($dest->image_url))
                                        : asset('images/destinations/rizal_beach.jpg');
                                    $catLower = strtolower($dest->category ?? '');
                                    if (str_contains($catLower, 'church') || str_contains($catLower, 'chapel') || str_contains($catLower, 'parish') || str_contains($catLower, 'grotto') || str_contains($catLower, 'shrine') || str_contains($catLower, 'religious')) {
                                        $hpSection = 'Historic Churches'; $hpIcon = 'bi-bank'; $hpColor = '#d97706'; $hpAnchor = '#dest-card-' . $dest->id;
                                    } elseif (str_contains($catLower, 'heritage') || str_contains($catLower, 'history') || str_contains($catLower, 'landmark') || str_contains($catLower, 'ancestral') || str_contains($catLower, 'civic')) {
                                        $hpSection = 'History & Heritage'; $hpIcon = 'bi-hourglass-split'; $hpColor = '#92400e'; $hpAnchor = '#dest-card-' . $dest->id;
                                    } elseif (str_contains($catLower, 'nature') || str_contains($catLower, 'forest') || str_contains($catLower, 'cave') || str_contains($catLower, 'eco') || str_contains($catLower, 'boardwalk') || str_contains($catLower, 'spring') || str_contains($catLower, 'farm') || str_contains($catLower, 'marine') || str_contains($catLower, 'mangrove')) {
                                        $hpSection = 'Nature & Ecotourism'; $hpIcon = 'bi-tree-fill'; $hpColor = '#198754'; $hpAnchor = '#dest-card-' . $dest->id;
                                    } else {
                                        $hpSection = 'Featured Destinations'; $hpIcon = 'bi-geo-alt-fill'; $hpColor = '#0284c7'; $hpAnchor = '#dest-card-' . $dest->id;
                                    }
                                @endphp
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $rowImg }}" class="rounded-3 shadow-sm flex-shrink-0" style="width: 56px; height: 56px; object-fit: cover;" alt="{{ $dest->name }}">
                                        <div>
                                            <div class="fw-bold text-dark dest-highlight-target">{{ $dest->name }}</div>
                                            <small class="text-muted dest-highlight-target">{{ Str::limit($dest->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border px-3 py-1 rounded-pill dest-highlight-target">
                                        {{ $dest->category }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge rounded-pill px-2 py-1 fw-semibold" style="background-color: {{ $hpColor }}15; color: {{ $hpColor }}; font-size: 0.72rem;">
                                            <i class="bi {{ $hpIcon }} me-1"></i> {{ $hpSection }}
                                        </span>
                                        @if($dest->featured)
                                            <a href="{{ route('home') }}{{ $hpAnchor }}" target="_blank" class="text-decoration-none small fw-semibold" style="color: {{ $hpColor }}; font-size: 0.7rem;">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>View on Homepage
                                            </a>
                                        @else
                                            <span class="text-muted small" style="font-size: 0.7rem;">Not on homepage</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($dest->featured)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2 py-1">Featured</span>
                                    @else
                                        <span class="text-muted small">Standard</span>
                                    @endif
                                </td>
                                <td>
                                    @if($dest->is_spotlight)
                                        <span class="badge bg-warning bg-opacity-20 text-warning-emphasis border border-warning rounded-pill px-2.5 py-1 fw-bold">
                                            <i class="bi bi-stars text-warning me-1"></i> Spotlight
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex align-items-center gap-1">
                                        {{-- Quick Toggle Spotlight --}}
                                        <form method="POST" action="{{ route('admin.destinations.toggle-spotlight', $dest) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $dest->is_spotlight ? 'btn-warning text-dark fw-bold' : 'btn-outline-warning text-dark' }} rounded-pill px-2.5 py-1"
                                                    title="{{ $dest->is_spotlight ? 'Click to unpin from Signature Spotlights' : 'Click to pin as Signature Spotlight (max 2)' }}">
                                                <i class="bi {{ $dest->is_spotlight ? 'bi-stars' : 'bi-sparkles' }} me-1"></i>
                                                <span class="small">{{ $dest->is_spotlight ? 'Spotlight' : 'Pin' }}</span>
                                            </button>
                                        </form>

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
                                    <select name="category" class="form-select rounded-3" required>
                                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Choose category...</option>
                                        <optgroup label="🏖️ Beach & Surfing — Homepage: Featured Destinations">
                                            <option value="Surf Haven" {{ old('category') == 'Surf Haven' ? 'selected' : '' }}>Surf Haven</option>
                                            <option value="Public Beach" {{ old('category') == 'Public Beach' ? 'selected' : '' }}>Public Beach</option>
                                            <option value="Surf Haven & Resort" {{ old('category') == 'Surf Haven & Resort' ? 'selected' : '' }}>Surf Haven & Resort</option>
                                        </optgroup>
                                        <optgroup label="⛪ Churches — Homepage: Historic Churches">
                                            <option value="Century-Old Church" {{ old('category') == 'Century-Old Church' ? 'selected' : '' }}>Century-Old Church</option>
                                            <option value="Parish Church" {{ old('category') == 'Parish Church' ? 'selected' : '' }}>Parish Church</option>
                                            <option value="Chapel" {{ old('category') == 'Chapel' ? 'selected' : '' }}>Chapel</option>
                                            <option value="Shrine" {{ old('category') == 'Shrine' ? 'selected' : '' }}>Shrine</option>
                                        </optgroup>
                                        <optgroup label="🏛️ Heritage — Homepage: History & Heritage">
                                            <option value="Historical Heritage" {{ old('category') == 'Historical Heritage' ? 'selected' : '' }}>Historical Heritage</option>
                                            <option value="Heritage Landmark" {{ old('category') == 'Heritage Landmark' ? 'selected' : '' }}>Heritage Landmark</option>
                                            <option value="Civic Landmark" {{ old('category') == 'Civic Landmark' ? 'selected' : '' }}>Civic Landmark</option>
                                        </optgroup>
                                        <optgroup label="🌿 Nature — Homepage: Nature & Ecotourism">
                                            <option value="Eco-Tourism Site" {{ old('category') == 'Eco-Tourism Site' ? 'selected' : '' }}>Eco-Tourism Site</option>
                                            <option value="Nature Reserve" {{ old('category') == 'Nature Reserve' ? 'selected' : '' }}>Nature Reserve</option>
                                            <option value="Mangrove Forest" {{ old('category') == 'Mangrove Forest' ? 'selected' : '' }}>Mangrove Forest</option>
                                            <option value="Marine Reserve" {{ old('category') == 'Marine Reserve' ? 'selected' : '' }}>Marine Reserve</option>
                                        </optgroup>
                                        <optgroup label="🛠️ Other">
                                            <option value="Traditional Pottery" {{ old('category') == 'Traditional Pottery' ? 'selected' : '' }}>Traditional Pottery</option>
                                            <option value="Livelihood Center" {{ old('category') == 'Livelihood Center' ? 'selected' : '' }}>Livelihood Center</option>
                                        </optgroup>
                                    </select>
                                    <small class="text-muted" style="font-size: 0.72rem;">Category determines which homepage section this item appears in.</small>
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
                                <div class="col-12">
                                    <div class="form-check form-switch mt-1">
                                        <input class="form-check-input" type="checkbox" name="is_spotlight" id="spotlightCheckNew" value="1" {{ old('is_spotlight') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark" for="spotlightCheckNew">
                                            <i class="bi bi-stars text-warning me-1"></i> Pin to Signature Spotlights (Top of Public Attractions Page)
                                        </label>
                                        <div class="form-text text-muted small">Max 2 destinations can be pinned across the municipality.</div>
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
                                        @php $editCat = old('category', $dest->category); @endphp
                                        <select name="category" class="form-select rounded-3" required>
                                            <option value="" disabled>Choose category...</option>
                                            <optgroup label="🏖️ Beach & Surfing — Homepage: Featured Destinations">
                                                <option value="Surf Haven" {{ $editCat == 'Surf Haven' ? 'selected' : '' }}>Surf Haven</option>
                                                <option value="Public Beach" {{ $editCat == 'Public Beach' ? 'selected' : '' }}>Public Beach</option>
                                                <option value="Surf Haven & Resort" {{ $editCat == 'Surf Haven & Resort' ? 'selected' : '' }}>Surf Haven & Resort</option>
                                            </optgroup>
                                            <optgroup label="⛪ Churches — Homepage: Historic Churches">
                                                <option value="Century-Old Church" {{ $editCat == 'Century-Old Church' ? 'selected' : '' }}>Century-Old Church</option>
                                                <option value="Parish Church" {{ $editCat == 'Parish Church' ? 'selected' : '' }}>Parish Church</option>
                                                <option value="Chapel" {{ $editCat == 'Chapel' ? 'selected' : '' }}>Chapel</option>
                                                <option value="Shrine" {{ $editCat == 'Shrine' ? 'selected' : '' }}>Shrine</option>
                                            </optgroup>
                                            <optgroup label="🏛️ Heritage — Homepage: History & Heritage">
                                                <option value="Historical Heritage" {{ $editCat == 'Historical Heritage' ? 'selected' : '' }}>Historical Heritage</option>
                                                <option value="Heritage Landmark" {{ $editCat == 'Heritage Landmark' ? 'selected' : '' }}>Heritage Landmark</option>
                                                <option value="Civic Landmark" {{ $editCat == 'Civic Landmark' ? 'selected' : '' }}>Civic Landmark</option>
                                            </optgroup>
                                            <optgroup label="🌿 Nature — Homepage: Nature & Ecotourism">
                                                <option value="Eco-Tourism Site" {{ $editCat == 'Eco-Tourism Site' ? 'selected' : '' }}>Eco-Tourism Site</option>
                                                <option value="Nature Reserve" {{ $editCat == 'Nature Reserve' ? 'selected' : '' }}>Nature Reserve</option>
                                                <option value="Mangrove Forest" {{ $editCat == 'Mangrove Forest' ? 'selected' : '' }}>Mangrove Forest</option>
                                                <option value="Marine Reserve" {{ $editCat == 'Marine Reserve' ? 'selected' : '' }}>Marine Reserve</option>
                                            </optgroup>
                                            <optgroup label="🛠️ Other">
                                                <option value="Traditional Pottery" {{ $editCat == 'Traditional Pottery' ? 'selected' : '' }}>Traditional Pottery</option>
                                                <option value="Livelihood Center" {{ $editCat == 'Livelihood Center' ? 'selected' : '' }}>Livelihood Center</option>
                                            </optgroup>
                                            @if(!in_array($editCat, ['Surf Haven','Public Beach','Surf Haven & Resort','Century-Old Church','Parish Church','Chapel','Shrine','Historical Heritage','Heritage Landmark','Civic Landmark','Eco-Tourism Site','Nature Reserve','Mangrove Forest','Marine Reserve','Traditional Pottery','Livelihood Center']))
                                                <optgroup label="📌 Current (Custom)">
                                                    <option value="{{ $editCat }}" selected>{{ $editCat }}</option>
                                                </optgroup>
                                            @endif
                                        </select>
                                        <small class="text-muted" style="font-size: 0.72rem;">Category determines which homepage section this item appears in.</small>
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
                                    <div class="col-12">
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_spotlight" id="spotlightCheck-{{ $dest->id }}" value="1" {{ $dest->is_spotlight ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold text-dark" for="spotlightCheck-{{ $dest->id }}">
                                                <i class="bi bi-stars text-warning me-1"></i> Pin to Signature Spotlights (Top of Public Attractions Page)
                                            </label>
                                            <div class="form-text text-muted small">Max 2 destinations can be pinned across the municipality.</div>
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
        const catInput = modal.querySelector('select[name="category"]') || modal.querySelector('input[name="category"]');
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
