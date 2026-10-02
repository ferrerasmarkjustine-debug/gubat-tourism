@extends('layouts.guest')

@section('content')

<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">

            {{-- Success Icon --}}
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 mb-3"
                     style="width: 90px; height: 90px;">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                </div>
                <h1 class="fw-bold text-dark">Reservation Confirmed!</h1>
                <p class="text-muted fs-5">Your booking has been successfully submitted.</p>
            </div>

            {{-- Booking Card --}}
            <div class="card border-0 shadow-sm text-start mb-4" style="border-radius: 18px; border-left: 5px solid #198754 !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0"><i class="bi bi-receipt text-primary me-2"></i>Booking Details</h5>
                        <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                            <i class="bi bi-check-circle me-1"></i> Confirmed
                        </span>
                    </div>

                    <div class="mb-3 p-3 bg-light rounded-3">
                        <div class="fw-bold text-dark">{{ $booking->accommodation->name }}</div>
                        <small class="text-muted">
                            <i class="bi bi-building me-1"></i>{{ $booking->accommodation->resort->name }}
                        </small>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <small class="text-muted d-block">Booking Ref</small>
                            <strong class="text-dark">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Guest Name</small>
                            <strong class="text-dark">{{ $booking->guest_name }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Check-in</small>
                            <strong class="text-dark">{{ $booking->check_in->format('M j, Y') }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Check-out</small>
                            <strong class="text-dark">{{ $booking->check_out->format('M j, Y') }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Rooms</small>
                            <strong class="text-dark">{{ $booking->rooms_booked }} {{ Str::plural('Room', $booking->rooms_booked) }}</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">Guests</small>
                            <strong class="text-dark">{{ $booking->guests_count }} {{ Str::plural('Guest', $booking->guests_count) }}</strong>
                        </div>
                    </div>

                    @if($booking->special_requests)
                        <div class="border-top pt-3">
                            <small class="text-muted d-block">Special Requests</small>
                            <small class="text-dark">{{ $booking->special_requests }}</small>
                        </div>
                    @endif

                    <div class="alert alert-info border-0 rounded-3 mt-3 mb-0 d-flex align-items-start gap-2" style="font-size: 0.85rem;">
                        <i class="bi bi-info-circle-fill text-info mt-1 flex-shrink-0"></i>
                        <span>A confirmation has been noted for <strong>{{ $booking->guest_email }}</strong>. Payment is handled directly at the resort upon check-in.</span>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="{{ route('search') }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold">
                    <i class="bi bi-search me-1"></i> Search More Stays
                </a>
                <a href="{{ route('home') }}" class="btn btn-tourism-primary rounded-pill px-4 fw-bold text-white"
                   style="background: linear-gradient(135deg, #0F4C81, #1a6fc4);">
                    <i class="bi bi-house-door-fill me-1"></i> Back to Home
                </a>
            </div>

        </div>
    </div>
</div>

@endsection
