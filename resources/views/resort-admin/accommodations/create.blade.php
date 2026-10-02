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

    <div class="row justify-content-center">
        <div class="col-lg-8">
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

                    <form method="POST" action="{{ route('resort.accommodations.store') }}">
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
                                    <option value="" disabled selected>-- Select Type --</option>
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

                        <!-- Image URL -->
                        <div class="mb-3">
                            <label for="image_url" class="form-label fw-semibold text-dark">Cover Photo URL</label>
                            <input type="url"
                                   class="form-control @error('image_url') is-invalid @enderror"
                                   id="image_url"
                                   name="image_url"
                                   value="{{ old('image_url') }}"
                                   placeholder="https://images.unsplash.com/...">
                            <div class="form-text">Leave blank to use a default curated room photo.</div>
                            @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!-- Amenities Multi-Select -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark mb-2">Amenities Included</label>
                            <div class="p-3 bg-light rounded-3">
                                <div class="row g-2">
                                    @foreach($amenities as $amenity)
                                        <div class="col-sm-6 col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="amenities[]"
                                                       value="{{ $amenity->id }}"
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
    </div>
</div>
@endsection
