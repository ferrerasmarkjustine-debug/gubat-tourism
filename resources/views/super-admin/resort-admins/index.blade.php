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

        <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div class="position-relative flex-grow-1" style="max-width: 520px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="adminSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                           placeholder="Search resort admins by name, email, phone, or assigned resort..." autocomplete="off">
                    <button type="button" id="adminSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </div>
                <div class="small text-muted" id="adminSearchCounter">
                    Showing <strong class="text-dark">{{ count($resortAdmins) }}</strong> of <strong class="text-dark">{{ count($resortAdmins) }}</strong> records
                </div>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold admin-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted admin-filter-pill" data-filter="active">Active Accounts</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted admin-filter-pill" data-filter="inactive">Deactivated</button>
            </div>
        </div>

        <!-- Admins Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Full Name</th>
                            <th>Contact Details</th>
                            <th>Assigned Resort</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="resortAdminsTableBody">
                        @forelse($resortAdmins as $admin)
                            <tr class="admin-row"
                                data-search="{{ strtolower($admin->name . ' ' . $admin->email . ' ' . ($admin->phone_number ?? '') . ' ' . ($admin->resort ? $admin->resort->name : 'unassigned') . ' ' . ($admin->is_active ? 'active' : 'inactive')) }}"
                                data-category="{{ $admin->is_active ? 'active' : 'inactive' }}"
                                data-status="{{ $admin->is_active ? 'active' : 'inactive' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 38px; height: 38px; font-size: 0.95rem;">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark admin-highlight-target">{{ $admin->name }}</div>
                                            <small class="text-muted">Resort Admin</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark fw-semibold small admin-highlight-target">{{ $admin->email }}</div>
                                    @if($admin->phone_number)
                                        <div class="mt-1">
                                            <a href="tel:{{ $admin->phone_number }}" class="text-decoration-none small text-success fw-medium d-inline-flex align-items-center admin-highlight-target">
                                                <i class="bi bi-telephone-fill me-1"></i> {{ $admin->phone_number }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <span class="badge bg-warning bg-opacity-10 text-dark border border-warning" style="font-size: 0.72rem;">
                                                <i class="bi bi-phone me-1"></i> No phone set
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->resort)
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1 rounded-pill admin-highlight-target">
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

                        {{-- Friendly Live Search Empty State --}}
                        <tr id="adminSearchEmptyRow" class="empty-state-row" style="display: none;">
                            <td colspan="6" class="text-center py-5 bg-white">
                                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h6>
                                <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_adminSearchInput()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                                </button>
                            </td>
                        </tr>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    initLiveTableFilter({
        inputId: 'adminSearchInput',
        clearBtnId: 'adminSearchClear',
        counterId: 'adminSearchCounter',
        emptyStateId: 'adminSearchEmptyRow',
        containerId: 'resortAdminsTableBody',
        rowSelector: 'tr.admin-row',
        pillSelector: '.admin-filter-pill',
        highlightSelector: '.admin-highlight-target'
    });
});
</script>
@endsection
