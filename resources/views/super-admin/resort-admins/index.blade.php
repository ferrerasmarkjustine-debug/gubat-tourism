@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resort Admins</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Resort Administrators</h2>
                <p class="text-muted mb-0">Manage accounts responsible for administrative oversight of resorts in Gubat.</p>
            </div>
            <div>
                <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm fw-semibold">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Resort Admin
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter & Search Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('admin.resort-admins.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, email, or resort..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Deactivated Only</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary rounded-pill px-3">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Admins Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Full Name</th>
                            <th>Email Address</th>
                            <th>Assigned Resort</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($resortAdmins as $admin)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 38px; height: 38px; font-size: 0.95rem;">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $admin->name }}</div>
                                            <small class="text-muted">Resort Admin</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $admin->email }}</span>
                                </td>
                                <td>
                                    @if($admin->resort)
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1 rounded-pill">
                                                <i class="bi bi-building me-1"></i> {{ $admin->resort->name }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary text-white rounded-pill">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Deactivated
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ $admin->created_at->format('M d, Y') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('admin.resort-admins.edit', $admin) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Edit Admin">
                                            <i class="bi bi-pencil me-1"></i> Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.resort-admins.toggle-status', $admin) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to {{ $admin->is_active ? 'deactivate' : 'activate' }} this Resort Admin account?');">
                                            @csrf
                                            @method('PATCH')
                                            @if($admin->is_active)
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Deactivate Account">
                                                    <i class="bi bi-person-x me-1"></i> Deactivate
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Activate Account">
                                                    <i class="bi bi-person-check me-1"></i> Activate
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2 text-muted"></i>
                                    <h5>No resort administrators found</h5>
                                    <p class="text-muted small mb-3">Get started by creating your first Resort Administrator account.</p>
                                    <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-primary rounded-pill px-4">
                                        <i class="bi bi-person-plus-fill me-2"></i> Add Resort Admin
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($resortAdmins->hasPages())
                <div class="card-footer bg-white border-0 py-3 px-4">
                    {{ $resortAdmins->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
