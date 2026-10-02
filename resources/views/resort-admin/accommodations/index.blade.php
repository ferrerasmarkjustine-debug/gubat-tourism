@extends('layouts.resort-admin')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Header -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('resort.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Accommodations</li>
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
            <h2 class="fw-bold mb-1 text-dark">My Accommodations</h2>
            <p class="text-muted mb-0">Manage rooms, cottages, and villas for <strong>{{ $resort ? $resort->name : 'Your Resort' }}</strong>.</p>
        </div>
        <div>
            <a href="{{ route('resort.accommodations.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                <i class="bi bi-plus-circle me-1"></i> Add Accommodation
            </a>
        </div>
    </div>

    @if($accommodations->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <div class="mb-3">
                <i class="bi bi-door-closed display-3 text-muted"></i>
            </div>
            <h4 class="fw-bold text-dark">No Accommodations Listed Yet</h4>
            <p class="text-muted mb-4">Start by adding your first room, cottage, or villa to receive guest reservations.</p>
            <div>
                <a href="{{ route('resort.accommodations.create') }}" class="btn btn-primary rounded-pill px-4 fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Register Your First Accommodation
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($accommodations as $acc)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 d-flex flex-column">
                        <div class="position-relative">
                            <img src="{{ $acc->image_url ?: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80' }}"
                                 alt="{{ $acc->name }}"
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                            
                            {{-- Status Badge --}}
                            <div class="position-absolute top-0 end-0 m-3">
                                @if($acc->status === 'approved')
                                    <span class="badge bg-success shadow-sm px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Approved & Live
                                    </span>
                                @elseif($acc->status === 'pending')
                                    <span class="badge bg-warning text-dark shadow-sm px-3 py-2 rounded-pill">
                                        <i class="bi bi-clock-history me-1"></i> Pending LGU Review
                                    </span>
                                @else
                                    <span class="badge bg-danger shadow-sm px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle-fill me-1"></i> Rejected
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-dark mb-0">{{ $acc->name }}</h5>
                                <span class="badge bg-light text-dark text-capitalize border">{{ $acc->type }}</span>
                            </div>

                            <p class="text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($acc->description ?: 'No description provided.', 90) }}
                            </p>

                            @if($acc->status === 'rejected' && $acc->rejection_reason)
                                <div class="alert alert-danger p-2 rounded-3 small mb-3">
                                    <i class="bi bi-info-circle me-1"></i> <strong>LGU Feedback:</strong> {{ $acc->rejection_reason }}
                                </div>
                            @endif

                            <!-- Live Unit Inventory & Reservation Tracker -->
                            <div class="border rounded-3 p-3 bg-light mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-semibold text-dark">
                                        <i class="bi bi-box-seam text-primary me-1"></i> Unit Inventory
                                    </span>
                                    @php
                                        $available = $acc->available_units;
                                        $booked = $acc->booked_units;
                                        $total = $acc->total_units;
                                        $percent = $total > 0 ? round(($booked / $total) * 100) : 0;
                                    @endphp

                                    @if($available == 0)
                                        <span class="badge bg-danger rounded-pill px-2 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i> Fully Booked (0 left)
                                        </span>
                                    @elseif($available == 1)
                                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock (1 left)
                                        </span>
                                    @else
                                        <span class="badge bg-success rounded-pill px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> {{ $available }} Available
                                        </span>
                                    @endif
                                </div>

                                <div class="progress" style="height: 6px;" title="{{ $booked }} of {{ $total }} units booked today ({{ $percent }}% occupied)">
                                    <div class="progress-bar {{ $percent >= 100 ? 'bg-danger' : ($percent >= 70 ? 'bg-warning' : 'bg-primary') }}"
                                         role="progressbar"
                                         style="width: {{ min(100, $percent) }}%"></div>
                                </div>

                                <div class="d-flex justify-content-between text-muted mt-2" style="font-size: 0.78rem;">
                                    <span><strong>{{ $total }}</strong> Total {{ Str::plural('Unit', $total) }}</span>
                                    <span class="text-danger fw-semibold"><strong>{{ $booked }}</strong> Booked</span>
                                    <span class="text-success fw-bold"><strong>{{ $available }}</strong> Available</span>
                                </div>
                            </div>

                            <div class="row g-2 py-1 small text-muted mb-3">
                                <div class="col-12">
                                    <i class="bi bi-people me-1"></i> Accommodates up to <strong>{{ $acc->max_guests }}</strong> guests per unit
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top gap-2">
                                <div>
                                    <small class="text-muted d-block" style="font-size:0.75rem;">Price per night</small>
                                    <strong class="text-primary fs-5">₱{{ number_format($acc->price_per_night, 2) }}</strong>
                                </div>
                                <div class="d-flex gap-1">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#accDetailModal{{ $acc->id }}">
                                        <i class="bi bi-eye me-1"></i> Details
                                    </button>
                                    <a href="{{ route('resort.accommodations.edit', $acc->id) }}"
                                       class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Full Accommodation Card Details Modal -->
                <div class="modal fade" id="accDetailModal{{ $acc->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $acc->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow overflow-hidden">
                            <div class="position-relative">
                                <img src="{{ $acc->image_url ?: 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80' }}"
                                     alt="{{ $acc->name }}"
                                     class="w-100"
                                     style="height: 250px; object-fit: cover;">
                                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="position-absolute bottom-0 start-0 m-3 d-flex gap-2 align-items-center">
                                    <span class="badge bg-dark bg-opacity-75 text-white text-capitalize rounded-pill px-3 py-2">
                                        <i class="bi bi-house me-1"></i> {{ $acc->type }}
                                    </span>
                                    @if($acc->status === 'approved')
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i> Approved & Live
                                        </span>
                                    @elseif($acc->status === 'pending')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-clock-history me-1"></i> Pending LGU Review
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            <i class="bi bi-x-circle-fill me-1"></i> Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h4 class="fw-bold text-dark mb-1">{{ $acc->name }}</h4>
                                        <span class="text-muted"><i class="bi bi-building me-1"></i>{{ $resort->name }}</span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">Nightly Rate</small>
                                        <h3 class="fw-bold text-primary mb-0">₱{{ number_format($acc->price_per_night, 2) }}</h3>
                                    </div>
                                </div>

                                @if($acc->status === 'rejected' && $acc->rejection_reason)
                                    <div class="alert alert-danger rounded-3 mb-3 p-3">
                                        <strong class="d-block mb-1"><i class="bi bi-exclamation-octagon-fill me-1"></i> LGU Tourism Feedback:</strong>
                                        <span>{{ $acc->rejection_reason }}</span>
                                    </div>
                                @endif

                                <!-- Inventory & Capacity Overview -->
                                <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                                    <div class="row text-center g-2">
                                        <div class="col-4 border-end">
                                            <small class="text-muted d-block">Total Units</small>
                                            <h5 class="fw-bold text-dark mb-0">{{ $acc->total_units }}</h5>
                                        </div>
                                        <div class="col-4 border-end">
                                            <small class="text-muted d-block">Booked Today</small>
                                            <h5 class="fw-bold text-danger mb-0">{{ $acc->booked_units }}</h5>
                                        </div>
                                        <div class="col-4">
                                            <small class="text-muted d-block">Available Now</small>
                                            <h5 class="fw-bold text-success mb-0">{{ $acc->available_units }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark mb-1">Room Description</h6>
                                    <p class="text-muted mb-0">{{ $acc->description ?: 'No detailed description provided.' }}</p>
                                </div>

                                <!-- Guest Capacity -->
                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark mb-1">Guest Capacity</h6>
                                    <p class="text-muted mb-0"><i class="bi bi-people me-1 text-primary"></i> Accommodates up to <strong>{{ $acc->max_guests }} guests</strong> per unit</p>
                                </div>

                                <!-- Amenities -->
                                <div class="mb-2">
                                    <h6 class="fw-bold text-dark mb-2">Amenities Included</h6>
                                    @if($acc->amenities->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($acc->amenities as $amenity)
                                                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-normal">
                                                    <i class="bi {{ $amenity->icon_class }} text-primary me-1"></i> {{ $amenity->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted small">No specific amenities selected.</span>
                                    @endif
                                </div>
                            </div>

                            <div class="modal-footer border-top bg-light d-flex justify-content-between">
                                <a href="{{ route('resort.accommodations.edit', $acc->id) }}"
                                   class="btn btn-sm btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Edit This Accommodation
                                </a>
                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $accommodations->links() }}
        </div>
    @endif
</div>
@endsection
