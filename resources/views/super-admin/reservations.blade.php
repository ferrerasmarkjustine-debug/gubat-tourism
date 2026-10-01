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
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $booking->accommodation && $booking->accommodation->resort ? $booking->accommodation->resort->name : 'N/A' }}</td>
                                <td>{{ $booking->accommodation ? $booking->accommodation->name : 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                                <td>{{ $booking->rooms_booked }} room(s) &bull; {{ $booking->guests_count }} guest(s)</td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1">
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
@endsection
