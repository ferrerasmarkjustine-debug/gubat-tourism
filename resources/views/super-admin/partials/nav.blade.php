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

/* Keep all navbar items in one horizontal line with icon strictly to the left of text */
#lgu-admin-navbar .nav-link,
#lgu-admin-navbar .nav-css-dropdown > span,
#lgu-admin-navbar .btn {
    display: inline-flex !important;
    align-items: center !important;
    flex-direction: row !important;
    white-space: nowrap !important;
    gap: 0.45rem !important;
}

#lgu-admin-navbar .nav-link i,
#lgu-admin-navbar .nav-css-dropdown > span i,
#lgu-admin-navbar .btn i {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 1.05rem !important;
    line-height: 1 !important;
    margin: 0 !important;
    flex-shrink: 0 !important;
}

#lgu-admin-navbar .navbar-nav {
    flex-wrap: nowrap !important;
}

#lgu-admin-navbar .nav-link {
    padding: 0.45rem 0.85rem !important;
    font-size: 0.9rem !important;
}

/* ==========================================================================
   PREMIUM HOVER DESIGNS & MICRO-INTERACTIONS
   ========================================================================== */
#lgu-admin-navbar .nav-link,
#lgu-admin-navbar .nav-css-dropdown > span {
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    position: relative;
    border: 1px solid transparent;
}

#lgu-admin-navbar .nav-link i,
#lgu-admin-navbar .nav-css-dropdown > span i {
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
}

/* Inactive items hover: soft blue background, blue text, subtle lift, and gentle shadow */
#lgu-admin-navbar .nav-link:not(.bg-primary):not(.bg-warning):hover,
#lgu-admin-navbar .nav-css-dropdown:hover > span:not(.bg-primary) {
    background-color: #eef4ff !important;
    color: #0d6efd !important;
    border-color: rgba(13, 110, 253, 0.18) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(13, 110, 253, 0.12) !important;
}

/* Icon playful pop-up on hover */
#lgu-admin-navbar .nav-link:hover i,
#lgu-admin-navbar .nav-css-dropdown:hover > span i {
    transform: scale(1.18);
    color: inherit;
}

/* Active primary pill hover: enhanced depth and vibrant glow */
#lgu-admin-navbar .nav-link.bg-primary:hover,
#lgu-admin-navbar .nav-css-dropdown > span.bg-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4) !important;
    filter: brightness(1.05);
}

/* Active warning pill hover (Approvals) */
#lgu-admin-navbar .nav-link.bg-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255, 193, 7, 0.45) !important;
    filter: brightness(1.03);
}

/* Dropdown menu items hover: smooth slide and blue accent */
.nav-css-dropdown-menu a,
.css-dropdown-menu .dd-item {
    transition: all 0.2s ease !important;
}
.nav-css-dropdown-menu a:hover,
.css-dropdown-menu .dd-item:hover {
    background: #eef4ff !important;
    color: #0d6efd !important;
    padding-left: 18px !important;
}
.css-dropdown-menu .dd-item.text-danger:hover {
    background: #fff5f5 !important;
    color: #dc3545 !important;
}

/* Brand badge playful hover */
#lgu-admin-navbar .navbar-brand {
    transition: transform 0.25s ease;
}
#lgu-admin-navbar .navbar-brand:hover {
    transform: translateY(-1px);
}
#lgu-admin-navbar .navbar-brand:hover .bg-primary {
    transform: scale(1.08) rotate(-4deg);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.35);
}

/* Logout button hover */
#lgu-admin-navbar #btn-logout {
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
#lgu-admin-navbar #btn-logout:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.38) !important;
    filter: brightness(1.05);
}
#lgu-admin-navbar #btn-logout:hover i {
    transform: scale(1.18) translateX(2px);
    transition: transform 0.25s ease;
}
</style>

<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm mb-4" id="lgu-admin-navbar">
    <div class="container-fluid px-xl-4 px-3">

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
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.resorts*') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-resorts">
                        <i class="bi bi-building me-1"></i> Resorts
                    </a>
                </li>

                {{-- Accommodation Approvals --}}
                <li class="nav-item">
                    <a href="{{ route('admin.accommodations.index') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.accommodations.*') ? 'bg-warning text-dark' : 'text-dark' }}"
                       id="nav-approvals">
                        <i class="bi bi-patch-check-fill me-1"></i> Approvals
                        @php $pendingCount = \App\Models\Accommodation::where('status', 'pending')->count(); @endphp
                        @if($pendingCount > 0)
                            <span class="badge bg-danger text-white rounded-pill ms-1">{{ $pendingCount }}</span>
                        @endif
                    </a>
                </li>

                {{-- Destinations --}}
                <li class="nav-item">
                    <a href="{{ route('admin.destinations') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.destinations*') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-destinations">
                        <i class="bi bi-geo-alt-fill me-1"></i> Destinations
                    </a>
                </li>

                {{-- Events & Announcements --}}
                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.events*') || request()->routeIs('admin.announcements*') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-admin-events">
                        <i class="bi bi-calendar-event me-1"></i> Events &amp; News
                    </a>
                </li>

                {{-- Crafts & Livelihood --}}
                <li class="nav-item">
                    <a href="{{ route('admin.crafts.index') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold {{ request()->routeIs('admin.crafts*') ? 'bg-primary text-white' : 'text-dark' }}"
                       id="nav-admin-crafts">
                        <i class="bi bi-tools me-1"></i> Crafts
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

                {{-- Back to Website --}}
                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link px-3 py-2 rounded-pill fw-semibold text-dark"
                       id="nav-back-to-site"
                       title="Return to public website">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Website
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
