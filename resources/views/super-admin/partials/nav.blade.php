<div class="bg-white border-bottom shadow-sm mb-4">
    <div class="container py-3">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 44px; height: 44px;">
                    <i class="bi bi-shield-lock-fill fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">LGU Super Admin Portal</h5>
                    <small class="text-muted">Municipality of Gubat Tourism Office</small>
                </div>
            </div>

            <div class="d-flex align-items-center flex-wrap gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm {{ request()->routeIs('admin.dashboard') ? 'btn-primary text-white' : 'btn-outline-secondary' }} px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                </a>
                <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-sm {{ request()->routeIs('admin.resort-admins.*') ? 'btn-primary text-white' : 'btn-outline-secondary' }} px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-people-fill me-1"></i> Resort Admins
                </a>
                <a href="{{ route('resorts') }}" class="btn btn-sm btn-outline-primary px-3 py-2 rounded-pill">
                    <i class="bi bi-box-arrow-up-right me-1"></i> View Public Site
                </a>
            </div>
        </div>
    </div>
</div>
