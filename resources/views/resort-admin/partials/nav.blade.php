<style>
/* Pure-CSS Resort Admin Navbar */
.resort-admin-nav { background: #fff; border-bottom: 1px solid #e9ecef; box-shadow: 0 2px 12px rgba(0,0,0,.06); }

/* CSS-only dropdown for user menu */
.ra-dropdown { position: relative; }
.ra-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    z-index: 1050;
    min-width: 200px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    padding: 6px 0;
}
.ra-dropdown:hover .ra-dropdown-menu,
.ra-dropdown:focus-within .ra-dropdown-menu { display: block; }
.ra-dropdown-menu .ra-dd-item {
    display: flex;
    align-items: center;
    padding: 9px 16px;
    font-size: .875rem;
    font-weight: 600;
    color: #212529;
    text-decoration: none;
    white-space: nowrap;
}
.ra-dropdown-menu .ra-dd-item:hover { background: #f0f4ff; }
.ra-dropdown-menu .ra-dd-header { padding: 8px 16px 6px; border-bottom: 1px solid #eee; margin-bottom: 4px; }
</style>

<nav class="navbar navbar-expand-lg resort-admin-nav mb-4" id="resort-admin-navbar">
    <div class="container">

        {{-- Brand --}}
        <a href="{{ route('resort.dashboard') }}" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" id="resortAdminBrand">
            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                 style="width: 38px; height: 38px; flex-shrink: 0;">
                <i class="bi bi-building-check fs-6"></i>
            </div>
            <div class="lh-sm">
                <div class="fw-bold text-dark fs-6 mb-0">Resort Portal</div>
                <div class="text-muted" style="font-size: 0.72rem;">
                    {{ auth()->user()->resort?->name ?? 'Gubat Tourism' }}
                </div>
            </div>
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button"
                onclick="this.closest('nav').querySelector('#resortAdminNavLinks').classList.toggle('show')"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Nav links --}}
        <div class="collapse navbar-collapse" id="resortAdminNavLinks">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 py-2 py-lg-0">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('resort.dashboard') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('resort.dashboard') ? 'bg-success text-white' : 'text-dark' }}"
                       id="ra-nav-dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                {{-- Bookings --}}
                <li class="nav-item">
                    <a href="{{ route('resort.bookings') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('resort.bookings') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="ra-nav-bookings">
                        <i class="bi bi-calendar-check me-1"></i> Bookings
                    </a>
                </li>

                {{-- Accommodations --}}
                <li class="nav-item">
                    <a href="{{ route('resort.accommodations.index') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('resort.accommodations.index') ? 'bg-secondary text-white' : 'text-dark' }}"
                       id="ra-nav-accommodations">
                        <i class="bi bi-door-open me-1"></i> Accommodations
                    </a>
                </li>

                {{-- Add Accommodation --}}
                <li class="nav-item">
                    <a href="{{ route('resort.accommodations.create') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('resort.accommodations.create') ? 'bg-warning text-dark' : 'text-dark' }}"
                       id="ra-nav-add-accommodation">
                        <i class="bi bi-plus-circle me-1"></i> Add Accommodation
                    </a>
                </li>

                {{-- Back to Website --}}
                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold text-dark"
                       id="ra-nav-back-to-site">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Website
                    </a>
                </li>

                {{-- User dropdown + Logout --}}
                <li class="nav-item ra-dropdown ms-lg-2">
                    <span class="btn btn-outline-success d-flex align-items-center px-3 rounded-pill" style="cursor:pointer;">
                        <i class="bi bi-person-circle me-2 text-success"></i>
                        <span class="fw-semibold" style="font-size:.875rem;">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down ms-2" style="font-size:.65rem;"></i>
                    </span>
                    <div class="ra-dropdown-menu">
                        <div class="ra-dd-header">
                            <small class="text-muted d-block">Signed in as</small>
                            <strong style="font-size:.82rem;">{{ auth()->user()->email }}</strong>
                        </div>
                        <hr style="margin:4px 0; border-color:#eee;">
                        <form method="POST" action="{{ route('logout') }}" id="resort-admin-logout-form">
                            @csrf
                            <button type="submit"
                                    class="ra-dd-item text-danger border-0 bg-transparent w-100 text-start"
                                    onclick="return confirm('Log out of Resort Portal?')">
                                <i class="bi bi-box-arrow-right me-2"></i> Log Out
                            </button>
                        </form>
                    </div>
                </li>

                {{-- Quick Logout button --}}
                <li class="nav-item ms-lg-1">
                    <form method="POST" action="{{ route('logout') }}" id="ra-logout-form">
                        @csrf
                        <button type="submit" id="ra-btn-logout"
                                class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold"
                                onclick="return confirm('Log out of Resort Portal?')">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
