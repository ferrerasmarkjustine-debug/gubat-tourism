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
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center px-3 rounded-pill" href="#" role="button" id="authDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2 text-warning"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 animate-fade-in" style="border-radius: 12px; min-width: 200px;">
                            <li class="dropdown-header text-dark border-bottom pb-2 mb-2">
                                <small class="text-muted d-block">Signed in as</small>
                                <strong>{{ Auth::user()->email }}</strong>
                            </li>
                            
                            {{-- Check role or fallback to default dashboards --}}
                            @if(Auth::user()->email === 'admin@gubat.gov.ph')
                                <li>
                                    <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-check text-primary me-2"></i> LGU Admin Portal
                                    </a>
                                </li>
                            @elseif(Auth::user()->role === 'resort_admin')
                                <li>
                                    <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('resort.dashboard') }}">
                                        <i class="bi bi-building-check text-success me-2"></i> Resort Portal
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item py-2 d-flex align-items-center" href="/dashboard">
                                        <i class="bi bi-person-badge text-info me-2"></i> Guest Dashboard
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center">
                                        <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0 d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-warning rounded-pill px-4 shadow-sm text-dark fw-bold">
                            <i class="bi bi-person-plus me-1"></i> Register
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