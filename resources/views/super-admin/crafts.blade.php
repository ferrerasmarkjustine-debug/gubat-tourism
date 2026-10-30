@extends('layouts.admin')

@section('content')
<div class="pb-5">
    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crafts &amp; Livelihood</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Crafts &amp; Livelihood Management</h2>
                <p class="text-muted mb-0">Manage community cooperatives, master weavers, pottery artisans, native food producers, and local makers.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createCraftModal">
                    <i class="bi bi-plus-circle-fill me-1"></i> Add New Craft
                </button>
                <a href="{{ route('crafts') }}" target="_blank" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Public Page
                </a>
            </div>
        </div>

        {{-- Flash Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Flash Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                    <strong>Please resolve the following errors:</strong>
                </div>
                <ul class="mb-0 ps-3 small">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Stat Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 46px; height: 46px; background-color: #8D6E63;">
                            <i class="bi bi-tools fs-5"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-semibold text-uppercase">Abaca Weaving</div>
                            <div class="fs-4 fw-bold text-dark">{{ $crafts->where('category_slug', 'abaca')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 46px; height: 46px; background-color: #d97706;">
                            <i class="bi bi-flower1 fs-5"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-semibold text-uppercase">Clay Pottery</div>
                            <div class="fs-4 fw-bold text-dark">{{ $crafts->where('category_slug', 'pottery')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 46px; height: 46px; background-color: #198754;">
                            <i class="bi bi-egg-fried fs-5"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-semibold text-uppercase">Delicacies</div>
                            <div class="fs-4 fw-bold text-dark">{{ $crafts->where('category_slug', 'culinary')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 46px; height: 46px; background-color: #0284c7;">
                            <i class="bi bi-gift-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="small text-muted fw-semibold text-uppercase">Souvenirs</div>
                            <div class="fs-4 fw-bold text-dark">{{ $crafts->where('category_slug', 'souvenirs')->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Crafts Table Card --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
            <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-list-task text-primary me-2"></i> All Craft Guilds &amp; Producers ({{ $crafts->count() }})
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="min-width: 280px;">Guild / Maker</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Contact</th>
                            <th class="text-center">Homepage</th>
                            <th class="text-end pe-4" style="min-width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($crafts as $craft)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 60px; height: 60px; border-radius: 12px; overflow: hidden; background-color: #f1f3f5; flex-shrink: 0;" class="border shadow-sm">
                                            @if($craft->image_url)
                                                <img src="{{ asset($craft->image_url) }}" alt="{{ $craft->name }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="bi bi-image fs-4"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $craft->name }}</div>
                                            @if($craft->highlight)
                                                <span class="badge bg-light text-dark border small py-1 px-2 rounded-pill">
                                                    <i class="bi bi-star-fill text-warning me-1"></i>{{ $craft->highlight }}
                                                </span>
                                            @endif
                                            @if(!empty($craft->products) && is_array($craft->products))
                                                <div class="text-muted small mt-1">
                                                    <i class="bi bi-bag-check me-1"></i>{{ implode(', ', array_slice($craft->products, 0, 3)) }}@if(count($craft->products) > 3)...@endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-white px-3 py-2 rounded-pill fw-semibold shadow-sm" style="background-color: {{ $craft->badge_color ?? '#8D6E63' }}; font-size: 0.8rem;">
                                        {{ $craft->category_name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small fw-semibold text-dark">Brgy. {{ $craft->barangay ?? 'Gubat' }}</div>
                                    <div class="small text-muted">{{ $craft->address }}</div>
                                    @if($craft->google_map_url)
                                        <a href="{{ $craft->google_map_url }}" target="_blank" class="small text-primary text-decoration-none">
                                            <i class="bi bi-geo-alt me-1"></i>Map Pin
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <span class="small text-muted">
                                        <i class="bi bi-telephone me-1"></i>{{ $craft->contact ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('admin.crafts.toggle-featured', $craft) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $craft->is_featured ? 'btn-success text-white' : 'btn-outline-secondary' }} rounded-pill px-3 shadow-none" title="Click to toggle homepage visibility">
                                            @if($craft->is_featured)
                                                <i class="bi bi-check-circle-fill me-1"></i> Featured
                                            @else
                                                <i class="bi bi-eye-slash me-1"></i> Hidden
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#editCraftModal{{ $craft->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#deleteCraftModal{{ $craft->id }}">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Edit Modal for each craft --}}
                            <div class="modal fade" id="editCraftModal{{ $craft->id }}" tabindex="-1" aria-labelledby="editCraftLabel{{ $craft->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form method="POST" action="{{ route('admin.crafts.update', $craft) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                                                <h5 class="modal-title fw-bold text-dark" id="editCraftLabel{{ $craft->id }}">
                                                    <i class="bi bi-pencil-square text-primary me-2"></i> Edit Craft Entry
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-8">
                                                        <label class="form-label fw-semibold small text-muted">Guild / Maker / Association Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $craft->name) }}" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold small text-muted">Category <span class="text-danger">*</span></label>
                                                        <select name="category_slug" class="form-select rounded-3" required>
                                                            @foreach($categories as $slug => $meta)
                                                                <option value="{{ $slug }}" {{ old('category_slug', $craft->category_slug) === $slug ? 'selected' : '' }}>
                                                                    {{ $meta['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-muted">Highlight Badge Text</label>
                                                        <input type="text" name="highlight" class="form-control rounded-3" placeholder="e.g. 100% Sustainable & Handcrafted" value="{{ old('highlight', $craft->highlight) }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-muted">Barangay Name</label>
                                                        <input type="text" name="barangay" class="form-control rounded-3" placeholder="e.g. Bulacao" value="{{ old('barangay', $craft->barangay) }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold small text-muted">Detailed Description <span class="text-danger">*</span></label>
                                                        <textarea name="description" rows="3" class="form-control rounded-3" required>{{ old('description', $craft->description) }}</textarea>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold small text-muted">Products Offered (comma-separated)</label>
                                                        @php
                                                            $productsStr = is_array($craft->products) ? implode(', ', $craft->products) : $craft->products;
                                                        @endphp
                                                        <input type="text" name="products" class="form-control rounded-3" placeholder="e.g. Abaca Bags, Table Runners, Slippers" value="{{ old('products', $productsStr) }}">
                                                        <small class="text-muted">Separate multiple items with a comma.</small>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-muted">Address / Physical Landmark</label>
                                                        <input type="text" name="address" class="form-control rounded-3" placeholder="e.g. Brgy. Bulacao, Gubat, Sorsogon" value="{{ old('address', $craft->address) }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold small text-muted">Contact Info</label>
                                                        <input type="text" name="contact" class="form-control rounded-3" placeholder="e.g. +63 917 555 4231" value="{{ old('contact', $craft->contact) }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold small text-muted">Google Maps URL</label>
                                                        <input type="url" name="google_map_url" class="form-control rounded-3" placeholder="https://maps.google.com/..." value="{{ old('google_map_url', $craft->google_map_url) }}">
                                                    </div>

                                                    <div class="col-12">
                                                        @include('partials.image-uploader', [
                                                            'id' => 'craft_edit_' . $craft->id,
                                                            'label' => 'Craft Product Photo',
                                                            'currentImage' => old('image_url', $craft->image_url),
                                                            'helperText' => 'Select a photo from your computer to replace the current craft picture (JPG, PNG, WebP up to 5MB).'
                                                        ])
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="form-check form-switch mt-2">
                                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured_{{ $craft->id }}" value="1" {{ old('is_featured', $craft->is_featured) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-semibold text-dark" for="is_featured_{{ $craft->id }}">Feature on Homepage Crafts Section</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Delete Modal for each craft --}}
                            <div class="modal fade" id="deleteCraftModal{{ $craft->id }}" tabindex="-1" aria-labelledby="deleteCraftLabel{{ $craft->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <form method="POST" action="{{ route('admin.crafts.destroy', $craft) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header border-0 pb-0 px-4 pt-4">
                                                <h5 class="modal-title fw-bold text-danger d-flex align-items-center" id="deleteCraftLabel{{ $craft->id }}">
                                                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i> Confirm Deletion
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4 text-dark">
                                                Are you sure you want to delete <strong class="text-danger">{{ $craft->name }}</strong>?
                                                <p class="text-muted small mt-2 mb-0">This entry will be permanently removed from both the public Crafts page and the homepage. This action cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">Delete Entry</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-tools display-6 d-block mb-3 text-secondary opacity-50"></i>
                                    <h5>No craft entries found.</h5>
                                    <p class="small text-muted mb-3">Click below to add your first community artisan or craft guild.</p>
                                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createCraftModal">
                                        <i class="bi bi-plus-circle-fill me-1"></i> Add First Craft
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createCraftModal" tabindex="-1" aria-labelledby="createCraftModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form method="POST" action="{{ route('admin.crafts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark" id="createCraftModalLabel">
                        <i class="bi bi-plus-circle-fill text-primary me-2"></i> Add New Craft &amp; Livelihood Entry
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold small text-muted">Guild / Maker / Association Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Bulacao Abaca Weaving Association" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-muted">Category <span class="text-danger">*</span></label>
                            <select name="category_slug" class="form-select rounded-3" required>
                                @foreach($categories as $slug => $meta)
                                    <option value="{{ $slug }}" {{ old('category_slug') === $slug ? 'selected' : '' }}>
                                        {{ $meta['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Highlight Badge Text</label>
                            <input type="text" name="highlight" class="form-control rounded-3" placeholder="e.g. 100% Sustainable & Handcrafted" value="{{ old('highlight') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Barangay Name</label>
                            <input type="text" name="barangay" class="form-control rounded-3" placeholder="e.g. Bulacao" value="{{ old('barangay') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="3" class="form-control rounded-3" placeholder="Describe the master artisan history, sustainable materials, and cultural value..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Products Offered (comma-separated)</label>
                            <input type="text" name="products" class="form-control rounded-3" placeholder="e.g. Abaca Bags, Table Runners, Slippers" value="{{ old('products') }}">
                            <small class="text-muted">Separate multiple items with a comma.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Address / Physical Landmark</label>
                            <input type="text" name="address" class="form-control rounded-3" placeholder="e.g. Brgy. Bulacao, Gubat, Sorsogon" value="{{ old('address') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-muted">Contact Info</label>
                            <input type="text" name="contact" class="form-control rounded-3" placeholder="e.g. +63 917 555 4231" value="{{ old('contact') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small text-muted">Google Maps URL</label>
                            <input type="url" name="google_map_url" class="form-control rounded-3" placeholder="https://maps.google.com/..." value="{{ old('google_map_url') }}">
                        </div>

                        <div class="col-12">
                            @include('partials.image-uploader', [
                                'id' => 'craft_create',
                                'label' => 'Craft Product Photo',
                                'currentImage' => old('image_url'),
                                'helperText' => 'Select a photo of the craft product from your computer (JPG, PNG, WebP up to 5MB).'
                            ])
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured_new" value="1" checked>
                                <label class="form-check-label fw-semibold text-dark" for="is_featured_new">Feature on Homepage Crafts Section</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">Save Craft</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
