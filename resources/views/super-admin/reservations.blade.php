@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reservations</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Reservations Overview</h2>
                <p class="text-muted mb-0">Monitor reservation records across all accredited resorts in Gubat.</p>
            </div>
            <div>
                <a href="{{ route('admin.resorts') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-building me-1"></i> View Resorts
                </a>
            </div>
        </div>

        <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div class="position-relative flex-grow-1" style="max-width: 520px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="reservationSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                           placeholder="Search by booking ref (#00012), resort, unit, or guest name..." autocomplete="off">
                    <button type="button" id="reservationSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </div>
                <div class="small text-muted" id="reservationSearchCounter">
                    Showing <strong class="text-dark">{{ count($bookings) }}</strong> of <strong class="text-dark">{{ count($bookings) }}</strong> records
                </div>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold res-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted res-filter-pill" data-filter="confirmed">Confirmed</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted res-filter-pill" data-filter="pending">Pending</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted res-filter-pill" data-filter="cancelled">Cancelled</button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Booking Ref</th>
                            <th>Resort</th>
                            <th>Accommodation</th>
                            <th>Dates</th>
                            <th>Rooms / Guests</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="reservationsTableBody">
                        @forelse($bookings as $booking)
                            @php
                                $ref = '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                                $resortName = $booking->accommodation && $booking->accommodation->resort ? $booking->accommodation->resort->name : 'N/A';
                                $accName = $booking->accommodation ? $booking->accommodation->name : 'N/A';
                            @endphp
                            <tr class="res-row"
                                data-search="{{ strtolower($ref . ' ' . $booking->id . ' ' . $resortName . ' ' . $accName . ' ' . $booking->guest_name . ' ' . $booking->guest_email . ' ' . $booking->status) }}"
                                data-category="{{ strtolower($booking->status) }}"
                                data-status="{{ strtolower($booking->status) }}">
                                <td class="ps-4 fw-bold res-highlight-target">{{ $ref }}</td>
                                <td class="res-highlight-target">{{ $resortName }}</td>
                                <td class="res-highlight-target">{{ $accName }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                                <td>{{ $booking->rooms_booked }} room(s) &bull; {{ $booking->guests_count }} guest(s)</td>
                                <td>
                                    @php
                                        $badgeColor = match($booking->status) {
                                            'confirmed' => 'bg-success bg-opacity-10 text-success border border-success',
                                            'cancelled' => 'bg-danger bg-opacity-10 text-danger border border-danger',
                                            default     => 'bg-warning bg-opacity-10 text-dark border border-warning'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeColor }} rounded-pill px-3 py-1 res-highlight-target">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2 text-muted"></i>
                                    <h5>No reservations recorded yet</h5>
                                    <p class="text-muted small">Bookings made through resort accommodation portals will appear here.</p>
                                </td>
                            </tr>
                        @endforelse

                        {{-- Friendly Live Search Empty State --}}
                        <tr id="resSearchEmptyRow" class="empty-state-row" style="display: none;">
                            <td colspan="6" class="text-center py-5 bg-white">
                                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h6>
                                <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_reservationSearchInput()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initLiveTableFilter({
        inputId: 'reservationSearchInput',
        clearBtnId: 'reservationSearchClear',
        counterId: 'reservationSearchCounter',
        emptyStateId: 'resSearchEmptyRow',
        containerId: 'reservationsTableBody',
        rowSelector: 'tr.res-row',
        pillSelector: '.res-filter-pill',
        highlightSelector: '.res-highlight-target'
    });
});
</script>
@endsection
