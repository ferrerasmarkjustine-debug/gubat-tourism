@extends('layouts.resort-admin')

@section('content')
<div class="bg-light min-vh-100 pb-5">

    {{-- Page Header --}}
    <div class="bg-white border-bottom shadow-sm mb-4">
        <div class="container py-3">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1 small">
                            <li class="breadcrumb-item">
                                <a href="{{ route('resort.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Bookings</li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar-check-fill text-success me-2"></i>
                        Guest Bookings
                    </h4>
                    @if($resort)
                        <small class="text-muted">{{ $resort->name }}</small>
                    @endif
                </div>
                <div>
                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                        {{ $bookings->total() }} {{ Str::plural('Booking', $bookings->total()) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        @if(!$resort)
            <div class="alert alert-warning rounded-4 shadow-sm p-4 text-center">
                <i class="bi bi-exclamation-triangle fs-1 text-warning d-block mb-2"></i>
                <h5 class="fw-bold">No Resort Assigned</h5>
                <p class="text-muted mb-0">You must be assigned to a resort before viewing bookings. Contact the LGU Admin.</p>
            </div>

        @elseif($bookings->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 text-center p-5">
                <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
                <h5 class="fw-bold text-dark">No Bookings Yet</h5>
                <p class="text-muted">No reservations have been made for {{ $resort->name }} yet.</p>
            </div>

        @else
            {{-- Desktop Table --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead style="background: linear-gradient(135deg, #0F4C81, #1a6fc4);">
                            <tr class="text-white">
                                <th class="fw-semibold py-3 ps-4">Ref #</th>
                                <th class="fw-semibold py-3">Guest</th>
                                <th class="fw-semibold py-3">Contact</th>
                                <th class="fw-semibold py-3">Accommodation</th>
                                <th class="fw-semibold py-3">Check-in</th>
                                <th class="fw-semibold py-3">Check-out</th>
                                <th class="fw-semibold py-3">Rooms / Guests</th>
                                <th class="fw-semibold py-3">Booked On</th>
                                <th class="fw-semibold py-3 pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $booking->guest_name ?? '—' }}</div>
                                    <small class="text-muted">{{ $booking->guest_email ?? '—' }}</small>
                                </td>
                                <td>
                                    @if($booking->guest_phone)
                                        <a href="tel:{{ $booking->guest_phone }}" class="text-dark text-decoration-none d-flex align-items-center gap-1">
                                            <i class="bi bi-telephone-fill text-success small"></i>
                                            {{ $booking->guest_phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                    @if($booking->special_requests)
                                        <div class="mt-1">
                                            <span class="badge bg-warning text-dark rounded-pill small" title="{{ $booking->special_requests }}">
                                                <i class="bi bi-chat-left-text me-1"></i>Has requests
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-semibold text-dark small">{{ $booking->accommodation->name }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $booking->check_in->format('M j, Y') }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $booking->check_out->format('M j, Y') }}</span>
                                    <div>
                                        <small class="text-muted">
                                            {{ $booking->check_in->diffInDays($booking->check_out) }} {{ Str::plural('night', $booking->check_in->diffInDays($booking->check_out)) }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <span>{{ $booking->rooms_booked }} {{ Str::plural('room', $booking->rooms_booked) }}</span>
                                    <small class="text-muted d-block">{{ $booking->guests_count }} {{ Str::plural('guest', $booking->guests_count) }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $booking->created_at->format('M j, Y') }}</small>
                                    <div><small class="text-muted">{{ $booking->created_at->format('g:i A') }}</small></div>
                                </td>
                                <td class="pe-4">
                                    @if($booking->status === 'confirmed')
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i>Confirmed
                                        </span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            <i class="bi bi-x-circle me-1"></i>Cancelled
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- Special Requests inline row --}}
                            @if($booking->special_requests)
                            <tr style="background: #fffbf0;">
                                <td colspan="9" class="ps-4 py-2 border-0">
                                    <small>
                                        <i class="bi bi-chat-left-quote-fill text-warning me-1"></i>
                                        <strong>Special Request ({{ $booking->guest_name }}):</strong>
                                        {{ $booking->special_requests }}
                                    </small>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Cards --}}
            <div class="d-lg-none">
                @foreach($bookings as $booking)
                <div class="card border-0 shadow-sm rounded-4 mb-3 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="fw-bold text-primary">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <div class="fw-bold text-dark">{{ $booking->guest_name ?? '—' }}</div>
                            </div>
                            @if($booking->status === 'confirmed')
                                <span class="badge bg-success rounded-pill px-3">Confirmed</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </div>
                        <div class="row g-2 small mb-3">
                            <div class="col-12">
                                <div class="text-muted">Email</div>
                                <div class="fw-semibold text-dark" style="word-break:break-all;">{{ $booking->guest_email ?? '—' }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Phone</div>
                                <div class="fw-semibold">
                                    @if($booking->guest_phone)
                                        <a href="tel:{{ $booking->guest_phone }}" class="text-dark text-decoration-none">
                                            <i class="bi bi-telephone-fill text-success me-1"></i>{{ $booking->guest_phone }}
                                        </a>
                                    @else —
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Accommodation</div>
                                <div class="fw-semibold">{{ $booking->accommodation->name }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Check-in</div>
                                <div class="fw-semibold">{{ $booking->check_in->format('M j, Y') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Check-out</div>
                                <div class="fw-semibold">{{ $booking->check_out->format('M j, Y') }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Rooms</div>
                                <div class="fw-semibold">{{ $booking->rooms_booked }}</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted">Guests</div>
                                <div class="fw-semibold">{{ $booking->guests_count }}</div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted">Booked On</div>
                                <div class="fw-semibold">{{ $booking->created_at->format('M j, Y g:i A') }}</div>
                            </div>
                        </div>
                        @if($booking->special_requests)
                            <div class="alert alert-warning border-0 rounded-3 py-2 px-3 mb-0 small">
                                <i class="bi bi-chat-left-text me-1"></i>
                                <strong>Special Request:</strong> {{ $booking->special_requests }}
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($bookings->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection
