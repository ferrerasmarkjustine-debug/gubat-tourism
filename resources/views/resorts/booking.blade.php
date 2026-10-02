@extends('layouts.guest')

@section('content')

<div class="py-5 text-white" style="background: linear-gradient(135deg, #0F4C81, #1A365D) !important; background-color: #0F4C81; border-bottom: 4px solid #f59e0b;">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('search') }}" class="text-white-50 text-decoration-none">Search</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Book Stay</li>
            </ol>
        </nav>
        <h1 class="fw-bold text-white mb-1 font-outfit" style="color: #ffffff !important;">Confirm Your Reservation</h1>
        <p class="text-white-50 mb-0">Fill in your details to complete the booking at {{ $accommodation->resort->name }}</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4 justify-content-center">

        {{-- Booking Form --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 18px;">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold text-dark mb-4"><i class="bi bi-person-fill text-primary me-2"></i>Guest Information</h4>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store') }}" id="booking-form">
                        @csrf
                        <input type="hidden" name="accommodation_id" value="{{ $accommodation->id }}">
                        <input type="hidden" name="check_in"     value="{{ $checkIn }}">
                        <input type="hidden" name="check_out"    value="{{ $checkOut }}">
                        <input type="hidden" name="rooms_booked" value="{{ $rooms }}">
                        <input type="hidden" name="guests_count" value="{{ $adults + $children }}">

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control border-2 py-2 @error('guest_name') is-invalid @enderror"
                                       name="guest_name" value="{{ old('guest_name') }}"
                                       placeholder="e.g. Juan dela Cruz" required>
                                @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control border-2 py-2 @error('guest_email') is-invalid @enderror"
                                       name="guest_email" value="{{ old('guest_email') }}"
                                       placeholder="you@email.com" required>
                                @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control border-2 py-2 @error('guest_phone') is-invalid @enderror"
                                       name="guest_phone" value="{{ old('guest_phone') }}"
                                       placeholder="+63 9XX XXX XXXX" required>
                                @error('guest_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-check text-primary me-2"></i>Stay Details</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Check-in</small>
                                    <strong class="text-dark">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('M j, Y') : 'Flexible' }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Check-out</small>
                                    <strong class="text-dark">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('M j, Y') : 'Flexible' }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Rooms</small>
                                    <strong class="text-dark">{{ $rooms }} {{ Str::plural('Room', $rooms) }}</strong>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Guests</small>
                                    <strong class="text-dark">{{ $adults }} {{ Str::plural('Adult', $adults) }}{{ $children > 0 ? ', ' . $children . ' ' . Str::plural('Child', $children) : '' }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Special Requests <span class="text-muted">(optional)</span></label>
                            <textarea class="form-control border-2" name="special_requests" rows="3"
                                      placeholder="Allergies, late check-in, extra bedding, etc.">{{ old('special_requests') }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-tourism-primary btn-lg rounded-pill fw-bold py-3" id="btn-confirm-booking"
                                    style="background: linear-gradient(135deg, #0F4C81, #1a6fc4);">
                                <i class="bi bi-check-circle-fill me-2"></i> Confirm Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Summary Sidebar --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="border-radius: 18px; top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-building text-primary me-2"></i>Booking Summary</h5>

                    <div class="mb-3">
                        <div class="fw-bold text-dark">{{ $accommodation->name }}</div>
                        <small class="text-muted">{{ $accommodation->resort->name }}</small>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">₱{{ number_format($accommodation->price_per_night) }} × {{ $nights }} {{ Str::plural('night', $nights) }} × {{ $rooms }} {{ Str::plural('room', $rooms) }}</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold text-dark border-top pt-3 mt-2" style="font-size: 1.1rem;">
                        <span>Total</span>
                        <span class="text-success">₱{{ number_format($totalPrice) }}</span>
                    </div>

                    <div class="mt-3 p-3 bg-light rounded-3">
                        <small class="text-muted d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-5"></i>
                            <span>This is a <strong>reservation request</strong>. Payment is handled directly with the resort upon arrival.</span>
                        </small>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100 rounded-pill mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i> Back to Results
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
