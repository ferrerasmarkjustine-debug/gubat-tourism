@extends('layouts.admin')

@section('content')
<div class="pb-5">
    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Accommodation Approvals</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Accommodation Approvals</h2>
                <p class="text-muted mb-0">Review, verify, and approve room registration requests submitted by Resort Administrators.</p>
            </div>
            <div>
                <a href="{{ route('admin.resorts') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-building me-1"></i> Manage Resorts
                </a>
            </div>
        </div>

        <!-- Filter Status Tabs -->
        <ul class="nav nav-pills mb-4 gap-2">
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 {{ $status === 'pending' ? 'active bg-warning text-dark fw-bold' : 'bg-white border text-dark' }}"
                   href="{{ route('admin.accommodations.index', ['status' => 'pending']) }}">
                    <i class="bi bi-clock-history me-1"></i> Pending Review
                    @if($counts['pending'] > 0)
                        <span class="badge bg-danger rounded-pill ms-1">{{ $counts['pending'] }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 {{ $status === 'approved' ? 'active bg-success text-white fw-bold' : 'bg-white border text-dark' }}"
                   href="{{ route('admin.accommodations.index', ['status' => 'approved']) }}">
                    <i class="bi bi-check-circle-fill me-1"></i> Approved & Live
                    <span class="badge bg-secondary rounded-pill ms-1">{{ $counts['approved'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 {{ $status === 'rejected' ? 'active bg-danger text-white fw-bold' : 'bg-white border text-dark' }}"
                   href="{{ route('admin.accommodations.index', ['status' => 'rejected']) }}">
                    <i class="bi bi-x-circle-fill me-1"></i> Rejected
                    <span class="badge bg-secondary rounded-pill ms-1">{{ $counts['rejected'] }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link rounded-pill px-4 {{ $status === 'all' ? 'active bg-primary text-white fw-bold' : 'bg-white border text-dark' }}"
                   href="{{ route('admin.accommodations.index', ['status' => 'all']) }}">
                    All Records ({{ $counts['all'] }})
                </a>
            </li>
        </ul>

        <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                <div class="position-relative flex-grow-1" style="max-width: 520px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="approvalSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                           placeholder="Search by unit name, resort, room type, or price..." autocomplete="off">
                    <button type="button" id="approvalSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                </div>
                <div class="small text-muted" id="approvalSearchCounter">
                    Showing <strong class="text-dark">{{ count($accommodations) }}</strong> of <strong class="text-dark">{{ count($accommodations) }}</strong> records
                </div>
            </div>

            <!-- Quick Filter Pills -->
            <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold approval-filter-pill active btn-primary text-white" data-filter="all">All</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted approval-filter-pill" data-filter="pending">Pending Review</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted approval-filter-pill" data-filter="approved">Approved</button>
                <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted approval-filter-pill" data-filter="rejected">Rejected</button>
            </div>
        </div>

        @if($accommodations->isEmpty())
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white">
                <div class="mb-3">
                    <i class="bi bi-check2-all display-3 text-success"></i>
                </div>
                <h4 class="fw-bold text-dark">No {{ ucfirst($status) }} Accommodations</h4>
                <p class="text-muted mb-0">
                    @if($status === 'pending')
                        Great job! There are currently no pending accommodation approval requests from resort admins.
                    @else
                        No accommodation records found in this view.
                    @endif
                </p>
            </div>
        @else
            <div class="row g-4" id="accommodationsCardGrid">
                @foreach($accommodations as $acc)
                    <div class="col-lg-6 approval-card-item"
                         data-search="{{ strtolower($acc->name . ' ' . ($acc->resort ? $acc->resort->name : '') . ' ' . $acc->type . ' ' . $acc->description . ' ' . $acc->status . ' ' . $acc->price_per_night) }}"
                         data-category="{{ strtolower($acc->type) }}"
                         data-status="{{ strtolower($acc->status) }}">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 bg-white">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 position-relative">
                                    <img src="{{ $acc->image_url ? (str_starts_with($acc->image_url, 'http') ? $acc->image_url : asset($acc->image_url)) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80' }}"
                                         alt="{{ $acc->name }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; min-height: 220px;">
                                    <div class="position-absolute top-0 start-0 m-2">
                                        <span class="badge bg-dark bg-opacity-75 text-capitalize rounded-pill px-3">
                                            {{ $acc->type }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-7 d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0 approval-highlight-target">{{ $acc->name }}</h5>
                                            <small class="text-muted approval-highlight-target">
                                                <i class="bi bi-building me-1"></i>{{ $acc->resort ? $acc->resort->name : 'Unassigned Resort' }}
                                            </small>
                                        </div>
                                        <div>
                                            @if($acc->status === 'approved')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                                    Approved
                                                </span>
                                            @elseif($acc->status === 'pending')
                                                <span class="badge bg-warning bg-opacity-25 text-dark border border-warning px-3 py-1 rounded-pill">
                                                    Pending LGU Review
                                                </span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1 rounded-pill">
                                                    Rejected
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="text-muted small mb-2 flex-grow-1">
                                        {{ Str::limit($acc->description ?: 'No description provided.', 80) }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                                        <span><i class="bi bi-people me-1"></i> Max {{ $acc->max_guests }} guests</span>
                                        <span><i class="bi bi-door-open me-1"></i> {{ $acc->total_units }} {{ Str::plural('unit', $acc->total_units) }}</span>
                                    </div>

                                    <div class="fw-bold text-primary fs-5 mb-3">
                                        ₱{{ number_format($acc->price_per_night, 2) }} <span class="small text-muted fw-normal">/ night</span>
                                    </div>

                                    @if($acc->status === 'rejected' && $acc->rejection_reason)
                                        <div class="alert alert-danger p-2 rounded-3 small mb-3">
                                            <strong>Feedback:</strong> {{ $acc->rejection_reason }}
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="mt-auto pt-2 border-top d-flex gap-2">
                                        @if($acc->status !== 'approved')
                                            <form method="POST" action="{{ route('admin.accommodations.approve', $acc->id) }}" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100 rounded-pill fw-semibold shadow-sm"
                                                        onclick="return confirm('Approve this accommodation and make it live on the public site?')">
                                                    <i class="bi bi-check-circle me-1"></i> Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if($acc->status !== 'rejected')
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-danger {{ $acc->status === 'approved' ? 'w-100' : 'flex-grow-1' }} rounded-pill fw-semibold"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $acc->id }}">
                                                <i class="bi bi-x-circle me-1"></i> Reject
                                            </button>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $acc->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content rounded-4 border-0">
                                                        <form method="POST" action="{{ route('admin.accommodations.reject', $acc->id) }}">
                                                            @csrf
                                                            <div class="modal-header border-bottom">
                                                                <h5 class="modal-title fw-bold text-dark">Reject Accommodation Request</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-4">
                                                                <p class="text-muted small">You are rejecting <strong>{{ $acc->name }}</strong> at {{ $acc->resort->name }}. Please provide a reason to help the resort admin address the issue.</p>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-semibold text-dark small">Reason for Rejection</label>
                                                                    <textarea name="rejection_reason" class="form-control" rows="3" required
                                                                              placeholder="e.g. Missing safety permit, pricing discrepancy, or incomplete room description..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-top">
                                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Confirm Rejection</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Empty State Notice when 0 matches --}}
            <div id="approvalSearchEmptyState" class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-3" style="display: none;">
                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                <h5 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h5>
                <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_approvalSearchInput()">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                    </button>
                </div>
            </div>

            <div class="mt-4">
                {{ $accommodations->links() }}
            </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initLiveTableFilter({
        inputId: 'approvalSearchInput',
        clearBtnId: 'approvalSearchClear',
        counterId: 'approvalSearchCounter',
        emptyStateId: 'approvalSearchEmptyState',
        containerId: 'accommodationsCardGrid',
        rowSelector: '.approval-card-item',
        pillSelector: '.approval-filter-pill',
        highlightSelector: '.approval-highlight-target'
    });
});
</script>
@endsection
