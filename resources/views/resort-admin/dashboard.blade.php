@extends('layouts.resort-admin')

@section('content')
<div class="bg-light pb-5">

    <div class="container">
        @if(!$resort)
            <div class="alert alert-warning rounded-4 shadow-sm p-4 text-center">
                <i class="bi bi-exclamation-triangle fs-1 text-warning d-block mb-2"></i>
                <h4 class="fw-bold">No Resort Assigned</h4>
                <p class="text-muted mb-0">Your account is active, but you are not yet linked to an authorized resort in Gubat. Please contact the LGU Admin to assign your resort.</p>
            </div>
        @else
            <!-- Assigned Resort Welcome Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body p-4 p-md-5" style="background: linear-gradient(135deg, rgba(15, 76, 129, 0.05), rgba(25, 135, 84, 0.08));">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <span class="badge bg-primary text-white text-uppercase px-3 py-1 rounded-pill mb-2">
                                <i class="bi bi-geo-alt-fill me-1"></i> Gubat, Sorsogon
                            </span>
                            <h1 class="display-6 fw-bold mb-2" style="color: var(--primary-color);">
                                {{ $resort->name }}
                            </h1>
                            <p class="text-muted lead mb-3">
                                {{ $resort->description ?? 'Welcome to your resort management portal. As the designated resort administrator, you are authorized to manage this property.' }}
                            </p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="d-flex align-items-center text-dark">
                                    <i class="bi bi-geo-alt text-primary me-2"></i>
                                    {{ $resort->address ?? ($resort->barangay ? 'Brgy. ' . $resort->barangay->name . ', Gubat' : 'Gubat, Sorsogon') }}
                                </span>
                                <span class="d-flex align-items-center text-dark">
                                    <i class="bi bi-tag text-success me-2"></i>
                                    Category: <strong class="ms-1">{{ ucfirst($resort->category) }}</strong>
                                </span>
                                <span class="d-flex align-items-center">
                                    <i class="bi bi-shield-check text-success me-1"></i>
                                    <span class="text-success fw-semibold">{{ $resort->is_lgu_approved ? 'LGU Accredited' : 'Pending Review' }}</span>
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                            <a href="{{ route('resorts') }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                <i class="bi bi-eye me-1"></i> View on Public Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats & Quick Information -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Accommodations</span>
                                <h3 class="fw-bold my-1 text-dark">{{ $totalAccommodations }}</h3>
                                <small class="text-muted">Rooms & units registered</small>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-door-open fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Rating & Reviews</span>
                                <h3 class="fw-bold my-1 text-warning">
                                    <i class="bi bi-star-fill text-warning fs-5 me-1"></i>{{ number_format($resort->rating, 1) }}
                                </h3>
                                <small class="text-muted">{{ $resort->reviews_count }} verified reviews</small>
                            </div>
                            <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-chat-square-quote fs-4 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Total Bookings</span>
                                <h3 class="fw-bold my-1 text-success">{{ $totalBookings }}</h3>
                                <small class="text-muted">Recorded reservations</small>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-calendar-check fs-4 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notice card for next phase -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary">
                        <i class="bi bi-info-circle-fill fs-3"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-1">Accommodation Card Management</h5>
                        <p class="text-muted mb-0">
                            Your account is properly linked to <strong>{{ $resort->name }}</strong>. Accommodation cards, room rates, and unit availability management features will be activated in the next development phase for your resort.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
