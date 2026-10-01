<style>
/* Pure-CSS auth dropdown — no Bootstrap JS needed */
.auth-css-dropdown { position: relative; }
.auth-css-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    z-index: 9999;
    min-width: 210px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0,0,0,.18);
    padding: 6px 0;
    color: #212529;
}
.auth-css-dropdown:hover .auth-css-dropdown-menu,
.auth-css-dropdown:focus-within .auth-css-dropdown-menu { display: block; }
.auth-css-dropdown-menu .dd-link {
    display: flex;
    align-items: center;
    padding: 9px 16px;
    font-size: .9rem;
    font-weight: 600;
    color: #212529;
    text-decoration: none;
    white-space: nowrap;
}
.auth-css-dropdown-menu .dd-link:hover { background: #f0f4ff; }
.auth-css-dropdown-menu .dd-link.text-danger { color: #dc3545 !important; }
.auth-css-dropdown-menu .dd-header {
    padding: 8px 16px 6px;
    border-bottom: 1px solid #eee;
    margin-bottom: 4px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top glass-panel py-3" style="background: rgba(15, 76, 129, 0.9); border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center fs-4" href="{{ route('home') }}">
            <i class="bi bi-compass-fill text-warning me-2 animate-float"></i>
            <span class="font-outfit text-white tracking-wide">GUBAT <span class="text-warning">TOURISM</span></span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item px-2">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active text-warning fw-bold' : 'text-white-50' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ request()->routeIs('resorts') ? 'active text-warning fw-bold' : 'text-white-50' }}" href="{{ route('resorts') }}">
                        <i class="bi bi-building me-1"></i> Resorts
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ request()->routeIs('destinations') ? 'active text-warning fw-bold' : 'text-white-50' }}" href="{{ route('destinations') }}">
                        <i class="bi bi-geo-alt me-1"></i> Destinations
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ request()->routeIs('events') ? 'active text-warning fw-bold' : 'text-white-50' }}" href="{{ route('events') }}">
                        <i class="bi bi-calendar-event me-1"></i> Events
                    </a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active text-warning fw-bold' : 'text-white-50' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle me-1"></i> About
                    </a>
                </li>

                <!-- Authentication Section -->
                @auth
                    {{-- Direct portal link for quick access --}}
                    @if(Auth::user()->isLguAdmin())
                        <li class="nav-item px-1">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-semibold text-dark">
                                <i class="bi bi-shield-lock-fill me-1"></i> Admin Portal
                            </a>
                        </li>
                    @elseif(Auth::user()->role === 'resort_admin')
                        <li class="nav-item px-1">
                            <a href="{{ route('resort.dashboard') }}" class="btn btn-warning btn-sm rounded-pill px-3 fw-semibold text-dark">
                                <i class="bi bi-building-check me-1"></i> Resort Portal
                            </a>
                        </li>
                    @endif

                    {{-- User dropdown (CSS hover — no Bootstrap JS needed) --}}
                    <li class="nav-item auth-css-dropdown ms-lg-2">
                        <span class="btn btn-outline-light d-flex align-items-center px-3 rounded-pill" style="cursor:pointer;">
                            <i class="bi bi-person-circle me-2 text-warning"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down ms-2" style="font-size:.65rem;"></i>
                        </span>
                        <div class="auth-css-dropdown-menu">
                            <div class="dd-header">
                                <small class="text-muted d-block">Signed in as</small>
                                <strong style="font-size:.85rem;">{{ Auth::user()->email }}</strong>
                            </div>

                            @if(Auth::user()->isLguAdmin())
                                <a class="dd-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 text-primary me-2"></i> Admin Dashboard
                                </a>
                                <a class="dd-link" href="{{ route('admin.resort-admins.index') }}">
                                    <i class="bi bi-people-fill text-success me-2"></i> Resort Admins
                                </a>
                                <a class="dd-link" href="{{ route('admin.resorts') }}">
                                    <i class="bi bi-building text-info me-2"></i> Manage Resorts
                                </a>
                            @elseif(Auth::user()->role === 'resort_admin')
                                <a class="dd-link" href="{{ route('resort.dashboard') }}">
                                    <i class="bi bi-building-check text-success me-2"></i> Resort Portal
                                </a>
                            @else
                                <a class="dd-link" href="/dashboard">
                                    <i class="bi bi-person-badge text-info me-2"></i> My Dashboard
                                </a>
                            @endif

                            <hr style="margin:4px 0; border-color:#eee;">
                            <form method="POST" action="{{ route('logout') }}" id="navbar-logout-form">
                                @csrf
                                <button type="submit" class="dd-link text-danger border-0 bg-transparent w-100 text-start"
                                        onclick="return confirm('Log out?')">
                                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Navbar Offset for Sticky Headers -->
<div style="height: 80px;"></div>

<!-- Navbar Scroll Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.querySelector('.navbar');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                nav.classList.add('navbar-scrolled');
                nav.style.padding = '10px 0';
            } else {
                nav.classList.remove('navbar-scrolled');
                nav.style.padding = '15px 0';
            }
        });
    });
</script>
