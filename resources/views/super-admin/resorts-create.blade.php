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

        <div class="row justify-content-center">
            <div class="col-lg-8">
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

                        <form method="POST" action="{{ route('admin.resorts.store') }}">
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
                                        <option value="" disabled selected>-- Select Category --</option>
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

                            <!-- Image URL -->
                            <div class="mb-3">
                                <label for="image_url" class="form-label fw-semibold text-dark">Cover Image URL</label>
                                <input type="url"
                                       class="form-control @error('image_url') is-invalid @enderror"
                                       id="image_url"
                                       name="image_url"
                                       value="{{ old('image_url') }}"
                                       placeholder="https://images.unsplash.com/...">
                                <div class="form-text">Leave blank to use a default curated Gubat beach cover photo.</div>
                                @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
        </div>
    </div>
</div>
@endsection
