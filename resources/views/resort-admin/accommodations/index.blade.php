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

                            <div class="row g-2 py-2 border-top border-bottom small text-muted mb-3">
                                <div class="col-6">
                                    <i class="bi bi-people me-1"></i> Up to {{ $acc->max_guests }} Guests
                                </div>
                                <div class="col-6 text-end">
                                    <i class="bi bi-door-open me-1"></i> {{ $acc->total_units }} {{ Str::plural('Unit', $acc->total_units) }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <div>
                                    <small class="text-muted d-block">Price per night</small>
                                    <strong class="text-primary fs-5">₱{{ number_format($acc->price_per_night, 2) }}</strong>
                                </div>
                                @if($acc->status === 'approved')
                                    <a href="{{ route('booking.create', ['accommodation_id' => $acc->id]) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View Form
                                    </a>
                                @endif
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
