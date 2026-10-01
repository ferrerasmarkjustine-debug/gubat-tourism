<style>
/* Pure-CSS dropdown — no JS required */
.css-dropdown { position: relative; }
.css-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    z-index: 1050;
    min-width: 230px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
    padding: 6px 0;
}
.css-dropdown:hover .css-dropdown-menu,
.css-dropdown:focus-within .css-dropdown-menu { display: block; }
.css-dropdown-menu .dd-item {
    display: block;
    padding: 8px 16px;
    font-weight: 600;
    font-size: .9rem;
    color: #212529;
    text-decoration: none;
    white-space: nowrap;
}
.css-dropdown-menu .dd-item:hover { background: #f0f4ff; }
.css-dropdown-menu .dd-item.text-danger { color: #dc3545 !important; }
.css-dropdown-menu hr { margin: 4px 0; border-color: #e9ecef; }
.css-dropdown-menu .dd-header { padding: 6px 16px 4px; }

/* CSS dropdown for Resort Admins nav item */
.nav-css-dropdown { position: relative; }
.nav-css-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    z-index: 1050;
    min-width: 210px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
    padding: 6px 0;
}
.nav-css-dropdown:hover .nav-css-dropdown-menu,
.nav-css-dropdown:focus-within .nav-css-dropdown-menu { display: block; }
.nav-css-dropdown-menu a {
    display: block;
    padding: 8px 14px;
    font-weight: 600;
    font-size: .875rem;
    color: #212529;
    text-decoration: none;
}
.nav-css-dropdown-menu a:hover { background: #f0f4ff; }
</style>

<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm mb-4" id="lgu-admin-navbar">
    <div class="container">

        {{-- Brand with CSS-only hover dropdown --}}
        <div class="css-dropdown">
            <a href="{{ route('admin.dashboard') }}"
               class="navbar-brand d-flex align-items-center gap-2 text-decoration-none"
               id="lguAdminBrand">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 38px; height: 38px; flex-shrink: 0;">
                    <i class="bi bi-shield-lock-fill fs-6"></i>
                </div>
                <div class="lh-sm">
                    <div class="fw-bold text-dark fs-6 mb-0">LGU Admin Portal <i class="bi bi-chevron-down" style="font-size:.65rem;"></i></div>
                    <div class="text-muted" style="font-size: 0.72rem;">Municipality of Gubat Tourism Office</div>
                </div>
            </a>
            <div class="css-dropdown-menu">
                <div class="dd-header">
                    <small class="text-muted">Signed in as</small>
                    <div class="fw-semibold text-dark small">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.72rem;">{{ auth()->user()->email }}</div>
                </div>
                <hr>
                <a class="dd-item" href="{{ route('admin.dashboard') }}" id="dropdown-lgu-dashboard">
                    <i class="bi bi-speedometer2 text-primary me-2"></i> Dashboard
                </a>
                <a class="dd-item" href="{{ route('admin.resort-admins.create') }}" id="dropdown-create-resort-admin">
                    <i class="bi bi-person-plus-fill text-success me-2"></i> Add Resort Admin
                </a>
                <hr>
                <form method="POST" action="{{ route('logout') }}" id="lgu-logout-form-brand">
                    @csrf
                    <button type="submit" id="btn-logout-brand"
                            class="dd-item text-danger border-0 bg-transparent w-100 text-start"
                            onclick="return confirm('Are you sure you want to log out?')">
                        <i class="bi bi-box-arrow-right me-2"></i> Log Out
                    </button>
                </form>
            </div>
        </div>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button"
                onclick="this.closest('nav').querySelector('#lguAdminNavLinks').classList.toggle('show')"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Nav links --}}
        <div class="collapse navbar-collapse" id="lguAdminNavLinks">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-1 py-2 py-lg-0">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-dashboard">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                {{-- Resorts --}}
                <li class="nav-item">
                    <a href="{{ route('admin.resorts') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.resorts') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-resorts">
                        <i class="bi bi-building me-1"></i> Resorts
                    </a>
                </li>

                {{-- Destinations --}}
                <li class="nav-item">
                    <a href="{{ route('admin.destinations') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.destinations') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-destinations">
                        <i class="bi bi-geo-alt-fill me-1"></i> Destinations
                    </a>
                </li>

                {{-- Resort Admins — CSS-only hover dropdown --}}
                <li class="nav-item nav-css-dropdown">
                    <span class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.resort-admins.*') ? 'bg-primary text-white' : 'text-dark' }}"
                          style="cursor:pointer; user-select:none;">
                        <i class="bi bi-people-fill me-1"></i> Resort Admins <i class="bi bi-chevron-down" style="font-size:.65rem;"></i>
                    </span>
                    <div class="nav-css-dropdown-menu">
                        <a href="{{ route('admin.resort-admins.index') }}" id="nav-resort-admins-list">
                            <i class="bi bi-list-ul me-2 text-primary"></i> View Resort Admins
                        </a>
                        <a href="{{ route('admin.resort-admins.create') }}" id="nav-resort-admins-create">
                            <i class="bi bi-person-plus-fill me-2 text-success"></i> Add Resort Admin
                        </a>
                    </div>
                </li>

                {{-- Reservations --}}
                <li class="nav-item">
                    <a href="{{ route('admin.reservations') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.reservations') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-reservations">
                        <i class="bi bi-calendar-check me-1"></i> Reservations
                    </a>
                </li>

                {{-- Logout — plain form submit, zero JS --}}
                <li class="nav-item ms-lg-2">
                    <form method="POST" action="{{ route('logout') }}" id="lgu-admin-logout-form">
                        @csrf
                        <button type="submit" id="btn-logout"
                                class="btn btn-sm btn-danger rounded-pill px-3 fw-semibold text-white"
                                onclick="return confirm('Are you sure you want to log out?')">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>
