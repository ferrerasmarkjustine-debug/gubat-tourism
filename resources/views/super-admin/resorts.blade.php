@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resorts</li>
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
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Resorts Management</h2>
                <p class="text-muted mb-0">View registered resorts across Gubat and their assigned Resort Administrators.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.resorts.create') }}" class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-semibold">
                    <i class="bi bi-plus-circle me-1"></i> Add New Resort
                </a>
                <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Resort Admin
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Resort Name</th>
                            <th>Category</th>
                            <th>Barangay</th>
                            <th>LGU Status</th>
                            <th>Accommodations</th>
                            <th>Assigned Resort Admin</th>
                            <th class="text-end pe-4">Public View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resorts as $resort)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $resort->name }}</div>
                                    <small class="text-muted">{{ $resort->address ?? 'Gubat, Sorsogon' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-1 rounded-pill">
                                        {{ ucfirst($resort->category) }}
                                    </span>
                                </td>
                                <td>{{ $resort->barangay ? $resort->barangay->name : 'Gubat Proper' }}</td>
                                <td>
                                    @if($resort->is_lgu_approved)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Accredited
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-3 py-1 rounded-pill">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $resort->accommodations->count() }} registered</td>
                                <td>
                                    @if($resort->admins->isNotEmpty())
                                        @foreach($resort->admins as $admin)
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2 py-1 rounded-pill me-1">
                                                    <i class="bi bi-person-check me-1"></i> {{ $admin->name }}
                                                </span>
                                                <small class="text-muted">({{ $admin->email }})</small>
                                            </div>
                                        @endforeach
                                    @else
                                        <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-1">
                                            <i class="bi bi-plus me-1"></i> Assign Admin
                                        </a>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('resorts') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No resorts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
