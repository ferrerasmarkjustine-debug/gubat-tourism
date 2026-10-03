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

@php
    $defaultCheckIn = $checkIn ? \Carbon\Carbon::parse($checkIn)->format('Y-m-d') : now()->format('Y-m-d');
    $defaultCheckOut = $checkOut ? \Carbon\Carbon::parse($checkOut)->format('Y-m-d') : now()->addDay()->format('Y-m-d');
@endphp

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
                        <input type="hidden" name="rooms_booked" id="input_rooms_booked" value="{{ old('rooms_booked', $rooms) }}">
                        <input type="hidden" name="rooms" id="input_rooms" value="{{ old('rooms_booked', $rooms) }}">
                        <input type="hidden" name="guests_count" id="input_guests_count" value="{{ old('guests_count', $adults + $children) }}">
                        <input type="hidden" name="adults" id="input_adults" value="{{ old('adults', $adults) }}">
                        <input type="hidden" name="children" id="input_children" value="{{ old('children', $children) }}">

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
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-calendar-check text-primary me-2"></i>Stay Details</h5>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold" id="nights-badge">
                                <i class="bi bi-moon-stars me-1"></i><span id="badge-nights-count">{{ $nights }}</span> {{ Str::plural('Night', $nights) }}
                            </span>
                        </div>
                        <div class="row g-3 mb-4 position-relative">
                            {{-- Check-in Date --}}
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                                    <label for="check_in" class="form-label text-muted small fw-semibold mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-box-arrow-in-right text-primary me-1"></i>Check-in Date <span class="text-danger">*</span></span>
                                        <span class="text-primary small" role="button" style="cursor: pointer;" onclick="const ci = document.getElementById('check_in'); ci.showPicker ? ci.showPicker() : ci.focus();">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </span>
                                    </label>
                                    <input type="date" 
                                           class="form-control border-2 bg-white fw-bold py-2 @error('check_in') is-invalid @enderror" 
                                           id="check_in" 
                                           name="check_in" 
                                           value="{{ old('check_in', $defaultCheckIn) }}" 
                                           min="{{ now()->format('Y-m-d') }}" 
                                           required>
                                    @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Check-out Date --}}
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                                    <label for="check_out" class="form-label text-muted small fw-semibold mb-1 d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-box-arrow-right text-primary me-1"></i>Check-out Date <span class="text-danger">*</span></span>
                                        <span class="text-primary small" role="button" style="cursor: pointer;" onclick="const co = document.getElementById('check_out'); co.showPicker ? co.showPicker() : co.focus();">
                                            <i class="bi bi-pencil-square me-1"></i>Edit
                                        </span>
                                    </label>
                                    <input type="date" 
                                           class="form-control border-2 bg-white fw-bold py-2 @error('check_out') is-invalid @enderror" 
                                           id="check_out" 
                                           name="check_out" 
                                           value="{{ old('check_out', $defaultCheckOut) }}" 
                                           min="{{ old('check_in', $defaultCheckIn) }}" 
                                           required>
                                    @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Rooms Card (Clickable Trigger) --}}
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100 guest-room-card-trigger" 
                                     id="trigger-rooms" role="button" tabindex="0" title="Click to edit rooms and guests">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted fw-semibold"><i class="bi bi-door-closed text-primary me-1"></i>Rooms</small>
                                        <span class="text-primary small fw-semibold"><i class="bi bi-pencil-square me-1"></i>Edit</span>
                                    </div>
                                    <strong class="text-dark fs-6 d-block" id="display-rooms">{{ $rooms }} {{ Str::plural('Room', $rooms) }}</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Click to change</small>
                                </div>
                            </div>

                            {{-- Guests Card (Clickable Trigger) --}}
                            <div class="col-sm-6">
                                <div class="p-3 bg-light rounded-3 border border-light-subtle h-100 guest-room-card-trigger" 
                                     id="trigger-guests" role="button" tabindex="0" title="Click to edit rooms and guests">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted fw-semibold"><i class="bi bi-people text-primary me-1"></i>Guests</small>
                                        <span class="text-primary small fw-semibold"><i class="bi bi-pencil-square me-1"></i>Edit</span>
                                    </div>
                                    <strong class="text-dark fs-6 d-block" id="display-guests">{{ $adults }} {{ Str::plural('Adult', $adults) }}{{ $children > 0 ? ', ' . $children . ' ' . Str::plural('Child', $children) : '' }}</strong>
                                    <small class="text-muted" style="font-size: 0.72rem;">Click to change</small>
                                </div>
                            </div>

                            {{-- Guests & Rooms Popover (Interactive Dropdown Stepper) --}}
                            <div class="card border-0 shadow-lg p-3 position-absolute" id="guest-room-popover"
                                 style="display: none; top: calc(100% + 8px); right: 12px; z-index: 1050; border-radius: 16px; border: 1px solid rgba(15, 76, 129, 0.15); background-color: #ffffff; box-shadow: 0 12px 35px rgba(0,0,0,0.18); min-width: 320px; max-width: 360px; width: calc(100% - 24px);">

                                <!-- Popover Header -->
                                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                    <span class="fw-bold text-dark font-outfit" style="font-size: 0.95rem;">
                                        <i class="bi bi-sliders me-1 text-primary"></i> Guests &amp; Rooms
                                    </span>
                                    <button type="button" class="btn-close" id="popover-close-btn" style="font-size: 0.75rem;" aria-label="Close"></button>
                                </div>

                                <!-- 1. Rooms Stepper -->
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">Rooms</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Number of rooms</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="guest-counter-btn" id="btn-rooms-minus" aria-label="Decrease rooms">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="fw-bold text-dark text-center" id="counter-rooms-val" style="min-width: 24px; font-size: 0.95rem;">{{ $rooms }}</span>
                                        <button type="button" class="guest-counter-btn" id="btn-rooms-plus" aria-label="Increase rooms">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- 2. Adults Stepper (18+ years old) -->
                                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">Adults</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">18 years old and above</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="guest-counter-btn" id="btn-adults-minus" aria-label="Decrease adults">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="fw-bold text-dark text-center" id="counter-adults-val" style="min-width: 24px; font-size: 0.95rem;">{{ $adults }}</span>
                                        <button type="button" class="guest-counter-btn" id="btn-adults-plus" aria-label="Increase adults">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- 3. Children Stepper (0–12 years old) -->
                                <div class="d-flex align-items-center justify-content-between py-2">
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 0.9rem;">Children</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">0–12 years old</div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="guest-counter-btn" id="btn-children-minus" aria-label="Decrease children">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <span class="fw-bold text-dark text-center" id="counter-children-val" style="min-width: 24px; font-size: 0.95rem;">{{ $children }}</span>
                                        <button type="button" class="guest-counter-btn" id="btn-children-plus" aria-label="Increase children">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Popover Action Footer -->
                                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-link text-decoration-none btn-sm p-0 text-muted" id="popover-reset-btn" style="font-size: 0.8rem;">
                                        Reset
                                    </button>
                                    <button type="button" class="btn btn-sm btn-tourism-primary rounded-pill px-4 fw-bold" id="popover-done-btn" style="font-size: 0.85rem; padding-top: 6px; padding-bottom: 6px;">
                                        Done
                                    </button>
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
                        <span class="text-muted" id="price-breakdown-text">₱{{ number_format($accommodation->price_per_night) }} × <span id="summary-nights">{{ $nights }}</span> {{ Str::plural('night', $nights) }} × <span id="summary-rooms">{{ $rooms }}</span> {{ Str::plural('room', $rooms) }}</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold text-dark border-top pt-3 mt-2" style="font-size: 1.1rem;">
                        <span>Total</span>
                        <span class="text-success" id="summary-total">₱{{ number_format($totalPrice) }}</span>
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

<style>
.guest-counter-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid #0F4C81;
    background: #ffffff;
    color: #0F4C81;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    line-height: 1;
}
.guest-counter-btn:hover:not(:disabled) {
    background: #0F4C81;
    color: #ffffff;
    transform: scale(1.06);
}
.guest-counter-btn:disabled {
    border-color: #dee2e6;
    color: #adb5bd;
    background: #f8f9fa;
    cursor: not-allowed;
    opacity: 0.55;
    pointer-events: none;
}
.guest-room-card-trigger {
    transition: all 0.2s ease;
    user-select: none;
}
.guest-room-card-trigger:hover, .guest-room-card-trigger.is-active {
    border-color: #0F4C81 !important;
    background-color: #f0f7ff !important;
    box-shadow: 0 4px 12px rgba(15, 76, 129, 0.08);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const nightsBadge = document.getElementById('nights-badge');
    const priceBreakdownText = document.getElementById('price-breakdown-text');
    const summaryTotal = document.getElementById('summary-total');

    // Popover & Stepper Elements
    const triggerRooms = document.getElementById('trigger-rooms');
    const triggerGuests = document.getElementById('trigger-guests');
    const popover = document.getElementById('guest-room-popover');
    const popoverCloseBtn = document.getElementById('popover-close-btn');
    const popoverDoneBtn = document.getElementById('popover-done-btn');
    const popoverResetBtn = document.getElementById('popover-reset-btn');

    const btnRoomsMinus = document.getElementById('btn-rooms-minus');
    const btnRoomsPlus = document.getElementById('btn-rooms-plus');
    const btnAdultsMinus = document.getElementById('btn-adults-minus');
    const btnAdultsPlus = document.getElementById('btn-adults-plus');
    const btnChildrenMinus = document.getElementById('btn-children-minus');
    const btnChildrenPlus = document.getElementById('btn-children-plus');

    const counterRoomsVal = document.getElementById('counter-rooms-val');
    const counterAdultsVal = document.getElementById('counter-adults-val');
    const counterChildrenVal = document.getElementById('counter-children-val');

    const displayRooms = document.getElementById('display-rooms');
    const displayGuests = document.getElementById('display-guests');

    const inputRoomsBooked = document.getElementById('input_rooms_booked');
    const inputRooms = document.getElementById('input_rooms');
    const inputGuestsCount = document.getElementById('input_guests_count');
    const inputAdults = document.getElementById('input_adults');
    const inputChildren = document.getElementById('input_children');

    const pricePerNight = {{ (float) $accommodation->price_per_night }};
    const maxRoomsAvailable = {{ (int) min(20, $accommodation->total_units ?? 20) }};

    const initialRooms = {{ (int) $rooms }};
    const initialAdults = {{ (int) $adults }};
    const initialChildren = {{ (int) $children }};

    let rooms = parseInt(inputRoomsBooked ? inputRoomsBooked.value : initialRooms, 10) || initialRooms;
    let adults = parseInt(inputAdults ? inputAdults.value : initialAdults, 10) || initialAdults;
    let children = parseInt(inputChildren ? inputChildren.value : initialChildren, 10) || initialChildren;

    function syncState() {
        // Enforce bounds
        rooms = Math.max(1, Math.min(maxRoomsAvailable, rooms));
        adults = Math.max(1, Math.min(20, adults));
        children = Math.max(0, Math.min(10, children));

        // Update counter numbers
        if (counterRoomsVal) counterRoomsVal.textContent = rooms;
        if (counterAdultsVal) counterAdultsVal.textContent = adults;
        if (counterChildrenVal) counterChildrenVal.textContent = children;

        // Update stepper button states
        if (btnRoomsMinus) btnRoomsMinus.disabled = (rooms <= 1);
        if (btnRoomsPlus) btnRoomsPlus.disabled = (rooms >= maxRoomsAvailable);
        if (btnAdultsMinus) btnAdultsMinus.disabled = (adults <= 1);
        if (btnAdultsPlus) btnAdultsPlus.disabled = (adults >= 20);
        if (btnChildrenMinus) btnChildrenMinus.disabled = (children <= 0);
        if (btnChildrenPlus) btnChildrenPlus.disabled = (children >= 10);

        // Update card text
        if (displayRooms) {
            displayRooms.textContent = `${rooms} ${rooms === 1 ? 'Room' : 'Rooms'}`;
        }
        if (displayGuests) {
            const adultStr = `${adults} ${adults === 1 ? 'Adult' : 'Adults'}`;
            const childStr = children > 0 ? `, ${children} ${children === 1 ? 'Child' : 'Children'}` : '';
            displayGuests.textContent = adultStr + childStr;
        }

        // Update form hidden fields
        if (inputRoomsBooked) inputRoomsBooked.value = rooms;
        if (inputRooms) inputRooms.value = rooms;
        if (inputGuestsCount) inputGuestsCount.value = adults + children;
        if (inputAdults) inputAdults.value = adults;
        if (inputChildren) inputChildren.value = children;

        // Recalculate price
        recalculate();
    }

    function recalculate() {
        if (!checkInInput || !checkOutInput) return;
        const d1 = new Date(checkInInput.value + 'T00:00:00');
        const d2 = new Date(checkOutInput.value + 'T00:00:00');

        if (!isNaN(d1.getTime()) && !isNaN(d2.getTime())) {
            const diffTime = d2.getTime() - d1.getTime();
            const diffDays = Math.round(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                const total = pricePerNight * rooms * diffDays;
                const nightText = diffDays === 1 ? 'Night' : 'Nights';
                const nightTextLower = diffDays === 1 ? 'night' : 'nights';
                const roomText = rooms === 1 ? 'room' : 'rooms';

                if (nightsBadge) {
                    nightsBadge.innerHTML = `<i class="bi bi-moon-stars me-1"></i><span id="badge-nights-count">${diffDays}</span> ${nightText}`;
                }

                if (priceBreakdownText) {
                    priceBreakdownText.innerHTML = `₱${pricePerNight.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0})} × <span id="summary-nights">${diffDays}</span> ${nightTextLower} × <span id="summary-rooms">${rooms}</span> ${roomText}`;
                }

                if (summaryTotal) {
                    summaryTotal.textContent = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0})}`;
                }
            }
        }
    }

    // Toggle Popover
    function togglePopover(show) {
        if (!popover) return;
        const isVisible = popover.style.display === 'block';
        const willShow = (typeof show === 'boolean') ? show : !isVisible;
        popover.style.display = willShow ? 'block' : 'none';
        if (triggerRooms) triggerRooms.classList.toggle('is-active', willShow);
        if (triggerGuests) triggerGuests.classList.toggle('is-active', willShow);
    }

    if (triggerRooms) {
        triggerRooms.addEventListener('click', function(e) {
            e.stopPropagation();
            togglePopover();
        });
        triggerRooms.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePopover();
            }
        });
    }

    if (triggerGuests) {
        triggerGuests.addEventListener('click', function(e) {
            e.stopPropagation();
            togglePopover();
        });
        triggerGuests.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePopover();
            }
        });
    }

    if (popoverCloseBtn) {
        popoverCloseBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            togglePopover(false);
        });
    }

    if (popoverDoneBtn) {
        popoverDoneBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            togglePopover(false);
        });
    }

    if (popoverResetBtn) {
        popoverResetBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            rooms = initialRooms;
            adults = initialAdults;
            children = initialChildren;
            syncState();
        });
    }

    if (btnRoomsMinus) {
        btnRoomsMinus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (rooms > 1) {
                rooms--;
                syncState();
            }
        });
    }

    if (btnRoomsPlus) {
        btnRoomsPlus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (rooms < maxRoomsAvailable) {
                rooms++;
                syncState();
            }
        });
    }

    if (btnAdultsMinus) {
        btnAdultsMinus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (adults > 1) {
                adults--;
                syncState();
            }
        });
    }

    if (btnAdultsPlus) {
        btnAdultsPlus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (adults < 20) {
                adults++;
                syncState();
            }
        });
    }

    if (btnChildrenMinus) {
        btnChildrenMinus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (children > 0) {
                children--;
                syncState();
            }
        });
    }

    if (btnChildrenPlus) {
        btnChildrenPlus.addEventListener('click', function(e) {
            e.stopPropagation();
            if (children < 10) {
                children++;
                syncState();
            }
        });
    }

    // Close when clicking outside
    document.addEventListener('click', function (e) {
        if (popover && popover.style.display === 'block') {
            if (!popover.contains(e.target) && 
                (!triggerRooms || !triggerRooms.contains(e.target)) && 
                (!triggerGuests || !triggerGuests.contains(e.target))) {
                togglePopover(false);
            }
        }
    });

    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener('change', function () {
            if (this.value) {
                const inDate = new Date(this.value + 'T00:00:00');
                if (!isNaN(inDate.getTime())) {
                    const minOut = new Date(inDate);
                    minOut.setDate(minOut.getDate() + 1);
                    const minOutStr = minOut.toISOString().split('T')[0];
                    checkOutInput.min = minOutStr;

                    if (!checkOutInput.value || checkOutInput.value <= this.value) {
                        checkOutInput.value = minOutStr;
                    }
                }
            }
            recalculate();
        });

        checkOutInput.addEventListener('change', function () {
            if (checkInInput.value && this.value <= checkInInput.value) {
                const inDate = new Date(checkInInput.value + 'T00:00:00');
                inDate.setDate(inDate.getDate() + 1);
                this.value = inDate.toISOString().split('T')[0];
            }
            recalculate();
        });
    }

    // Initial sync
    syncState();
});
</script>
@endsection
