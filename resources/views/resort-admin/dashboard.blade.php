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

            @if($fullyBookedRooms->isNotEmpty())
                <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-25 p-2 text-dark">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <div>
                        <strong class="d-block text-dark">Capacity Alert: Some rooms are fully booked today!</strong>
                        <span class="small text-muted">
                            @foreach($fullyBookedRooms as $fb)
                                <strong>{{ $fb->name }}</strong> (0 of {{ $fb->total_units }} units left){{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </span>
                    </div>
                </div>
            @endif

            <!-- Stats & Quick Information -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Accommodations</span>
                                <h3 class="fw-bold my-1 text-dark">{{ $totalAccommodations }}</h3>
                                <small class="text-muted">Room types listed</small>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-door-open fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Total Units</span>
                                <h3 class="fw-bold my-1 text-dark">{{ $totalUnits }}</h3>
                                <small class="text-muted">Physical rooms/cabins</small>
                            </div>
                            <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-box-seam fs-4 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Available Today</span>
                                <h3 class="fw-bold my-1 {{ $availableUnitsToday == 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $availableUnitsToday }}
                                </h3>
                                <small class="text-muted">{{ $occupiedUnitsToday }} units booked today</small>
                            </div>
                            <div class="rounded-circle {{ $availableUnitsToday == 0 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi {{ $availableUnitsToday == 0 ? 'bi-x-circle text-danger' : 'bi-check-circle text-success' }} fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted small fw-bold text-uppercase">Total Bookings</span>
                                <h3 class="fw-bold my-1 text-primary">{{ $totalBookings }}</h3>
                                <small class="text-muted">All-time reservations</small>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-calendar-check fs-4 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Unit Inventory Breakdown -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Live Room Inventory & Capacity</h5>
                        <small class="text-muted">Real-time unit tracking based on confirmed reservations.</small>
                    </div>
                    <a href="{{ route('resort.accommodations.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <i class="bi bi-gear me-1"></i> Manage Rooms
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Accommodation Name</th>
                                <th>Type</th>
                                <th class="text-center">Total Units</th>
                                <th class="text-center">Booked Today</th>
                                <th class="text-center">Available Right Now</th>
                                <th>Inventory Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resort->accommodations as $acc)
                                @php
                                    $avail = $acc->available_units;
                                    $booked = $acc->booked_units;
                                    $tot = $acc->total_units;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $acc->name }}</div>
                                        <small class="text-muted">₱{{ number_format($acc->price_per_night, 2) }} / night</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border text-capitalize">{{ $acc->type }}</span>
                                    </td>
                                    <td class="text-center fw-semibold">{{ $tot }}</td>
                                    <td class="text-center text-danger fw-semibold">{{ $booked }}</td>
                                    <td class="text-center text-success fw-bold fs-6">{{ $avail }}</td>
                                    <td>
                                        @if($avail === 0)
                                            <span class="badge bg-danger rounded-pill px-3 py-1">
                                                <i class="bi bi-x-circle me-1"></i> Sold Out
                                            </span>
                                        @elseif($avail === 1)
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1">
                                                <i class="bi bi-exclamation-circle me-1"></i> Low Stock (1 left)
                                            </span>
                                        @else
                                            <span class="badge bg-success rounded-pill px-3 py-1">
                                                <i class="bi bi-check-circle me-1"></i> Available ({{ $avail }} left)
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No accommodations registered yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
