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

        {{-- Global Search Trigger (Desktop) --}}
        <div class="d-none d-md-flex align-items-center ms-3">
            <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 py-1.5 d-inline-flex align-items-center gap-2 text-muted fw-normal shadow-sm"
                    id="globalQuickSearchTrigger" onclick="openGlobalSearchModal()" title="Search anything across LGU portal (Ctrl + K)">
                <i class="bi bi-search text-primary"></i>
                <span style="font-size: 0.85rem;">Quick Search...</span>
                <kbd class="bg-white border text-secondary px-1.5 py-0.5 rounded shadow-xs" style="font-size: 0.68rem; font-family: monospace;">Ctrl K</kbd>
            </button>
        </div>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler border-0 shadow-none" type="button"
                onclick="this.closest('nav').querySelector('#lguAdminNavLinks').classList.toggle('show')"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Nav links --}}
        <div class="collapse navbar-collapse" id="lguAdminNavLinks">
            {{-- Mobile Search Trigger --}}
            <div class="d-md-none mt-2 mb-2">
                <button type="button" class="btn btn-sm btn-light border rounded-pill w-100 py-2 d-flex align-items-center justify-content-center gap-2 text-muted"
                        onclick="openGlobalSearchModal()">
                    <i class="bi bi-search text-primary"></i>
                    <span>Quick Search records... (Ctrl+K)</span>
                </button>
            </div>

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

{{-- =========================================================================
     LEVEL B: GLOBAL UNIVERSAL SEARCH MODAL (Ctrl + K)
     ========================================================================= --}}
<div id="globalSearchModalBackdrop" class="global-search-backdrop" style="display: none;" onclick="handleGlobalSearchBackdrop(event)">
    <div class="global-search-dialog shadow-lg">
        {{-- Search Input Header --}}
        <div class="p-3 border-bottom d-flex align-items-center gap-2 bg-white rounded-top-4 position-relative">
            <i class="bi bi-search text-primary fs-5 ms-2"></i>
            <input type="text" id="globalSearchModalInput"
                   class="form-control form-control-lg border-0 shadow-none px-2 fs-6"
                   placeholder="Type to search resorts, destinations, crafts, events, admins, reservations..."
                   autocomplete="off"
                   oninput="handleGlobalSearchInput(this.value)">
            <div id="globalSearchSpinner" class="spinner-border spinner-border-sm text-primary me-2" role="status" style="display: none;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <button type="button" class="btn btn-sm btn-light rounded-circle p-1 lh-1 me-1" id="globalSearchClearBtn" style="display: none;" onclick="clearGlobalSearchInput()" title="Clear">
                <i class="bi bi-x fs-5 text-muted"></i>
            </button>
            {{-- Clickable Close Button (with '×' and ESC indicator) --}}
            <button type="button" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1.5 text-muted shadow-2xs gs-close-btn me-1"
                    id="globalSearchCloseModalBtn"
                    onclick="closeGlobalSearchModal()"
                    title="Close search (Esc)">
                <i class="bi bi-x-lg text-danger fw-bold" style="font-size: 0.8rem;"></i>
                <span class="small fw-semibold d-none d-sm-inline" style="font-size: 0.72rem;">Close</span>
                <kbd class="bg-white border text-secondary px-1 py-0.2 rounded" style="font-size: 0.65rem; font-family: monospace;">ESC</kbd>
            </button>
        </div>

        {{-- Group Filter Pills inside Global Search --}}
        <div class="px-3 py-2 bg-light border-bottom d-flex align-items-center gap-1 overflow-x-auto text-nowrap" id="globalSearchGroupPills">
            <button type="button" class="btn btn-xs btn-primary rounded-pill px-2.5 py-1 fw-semibold gs-pill active" data-type="all" onclick="filterGlobalSearchResults('all', this)">All</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="resorts" onclick="filterGlobalSearchResults('resorts', this)">🏨 Resorts</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="destinations" onclick="filterGlobalSearchResults('destinations', this)">📍 Destinations</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="crafts" onclick="filterGlobalSearchResults('crafts', this)">🎨 Crafts</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="events" onclick="filterGlobalSearchResults('events', this)">📅 Events</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="accommodations" onclick="filterGlobalSearchResults('accommodations', this)">🛏️ Approvals</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="admins" onclick="filterGlobalSearchResults('admins', this)">👤 Admins</button>
            <button type="button" class="btn btn-xs btn-white border rounded-pill px-2.5 py-1 text-muted gs-pill" data-type="reservations" onclick="filterGlobalSearchResults('reservations', this)">📑 Bookings</button>
        </div>

        {{-- Results Container --}}
        <div id="globalSearchResultsContainer" class="p-3 bg-white" style="max-height: 440px; overflow-y: auto;">
            {{-- Default Quick Shortcuts --}}
            <div id="globalSearchEmptyPrompt" class="text-center py-4 text-muted">
                <i class="bi bi-command display-6 text-primary mb-2 d-block opacity-75"></i>
                <div class="fw-semibold text-dark">Quick Navigation &amp; Universal Search</div>
                <p class="small text-muted mb-3">Instantly find any record across the entire LGU portal without switching pages.</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <span class="badge bg-light text-dark border px-2.5 py-1.5"><i class="bi bi-arrow-return-left me-1"></i> Press <strong>Enter</strong> to open</span>
                    <span class="badge bg-light text-dark border px-2.5 py-1.5"><i class="bi bi-arrow-down-up me-1"></i> <strong>&uarr; &darr;</strong> to navigate</span>
                    <button type="button" class="badge bg-light text-dark border px-2.5 py-1.5 text-decoration-none btn-link border-0 cursor-pointer" onclick="closeGlobalSearchModal()" style="cursor: pointer;"><i class="bi bi-x-circle-fill me-1 text-danger"></i> <strong>Esc</strong> to close</button>
                </div>
            </div>

            {{-- Live Results List --}}
            <div id="globalSearchResultsList" style="display: none;"></div>

            {{-- No Results Notice --}}
            <div id="globalSearchNotFound" class="text-center py-4" style="display: none;">
                <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                <h6 class="fw-bold text-dark">No matching records found</h6>
                <p class="text-muted small mb-0">Try searching with a different keyword, category, or booking reference.</p>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="px-3 py-2 bg-light border-top d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
            <div>
                <span class="text-dark fw-semibold">LGU Admin Portal</span> &bull; Universal Command Bar
            </div>
            <div class="d-none d-sm-block">
                Tip: Press <kbd class="bg-white border text-secondary px-1 py-0.5 rounded shadow-2xs">Ctrl + K</kbd> anywhere to open
            </div>
        </div>
    </div>
</div>

<style>
.global-search-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 8vh;
    animation: gsFadeIn 0.15s ease-out;
}
@keyframes gsFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.global-search-dialog {
    width: 95%;
    max-width: 660px;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    animation: gsSlideDown 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes gsSlideDown {
    from { transform: translateY(-16px) scale(0.98); opacity: 0; }
    to { transform: translateY(0) scale(1); opacity: 1; }
}
.gs-result-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: #212529;
    transition: all 0.15s ease;
    margin-bottom: 3px;
}
.gs-result-item:hover, .gs-result-item.gs-focused {
    background-color: #f0f4ff;
    transform: translateX(3px);
}
.gs-close-btn {
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.gs-close-btn:hover {
    background-color: #fee2e2 !important;
    border-color: #fca5a5 !important;
    color: #dc2626 !important;
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15) !important;
}
.gs-close-btn:hover i {
    transform: rotate(90deg);
    transition: transform 0.2s ease;
}
.gs-result-group-title {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    padding: 8px 12px 4px;
    margin-top: 6px;
    border-bottom: 1px solid #f1f3f5;
}
</style>

<script>
let globalSearchDebounceTimer = null;
let globalSearchData = null;
let currentGlobalSearchFilter = 'all';

function openGlobalSearchModal() {
    const backdrop = document.getElementById('globalSearchModalBackdrop');
    const input = document.getElementById('globalSearchModalInput');
    if (backdrop && input) {
        backdrop.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            input.focus();
            input.select();
        }, 50);
    }
}

function closeGlobalSearchModal() {
    const backdrop = document.getElementById('globalSearchModalBackdrop');
    if (backdrop) {
        backdrop.style.display = 'none';
        document.body.style.overflow = '';
    }
}

function handleGlobalSearchBackdrop(e) {
    if (e.target && e.target.id === 'globalSearchModalBackdrop') {
        closeGlobalSearchModal();
    }
}

function clearGlobalSearchInput() {
    const input = document.getElementById('globalSearchModalInput');
    if (input) {
        input.value = '';
        handleGlobalSearchInput('');
        input.focus();
    }
}

// Global Keyboard Shortcut: Ctrl + K / Cmd + K and Escape
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
        e.preventDefault();
        const backdrop = document.getElementById('globalSearchModalBackdrop');
        if (backdrop && backdrop.style.display === 'flex') {
            closeGlobalSearchModal();
        } else {
            openGlobalSearchModal();
        }
    } else if (e.key === 'Escape') {
        const backdrop = document.getElementById('globalSearchModalBackdrop');
        if (backdrop && backdrop.style.display === 'flex') {
            closeGlobalSearchModal();
        }
    }
});

function handleGlobalSearchInput(query) {
    const clearBtn = document.getElementById('globalSearchClearBtn');
    const spinner = document.getElementById('globalSearchSpinner');
    const emptyPrompt = document.getElementById('globalSearchEmptyPrompt');
    const resultsList = document.getElementById('globalSearchResultsList');
    const notFound = document.getElementById('globalSearchNotFound');

    const cleanQuery = (query || '').trim();

    if (clearBtn) clearBtn.style.display = cleanQuery.length > 0 ? 'inline-block' : 'none';

    if (cleanQuery.length === 0) {
        if (spinner) spinner.style.display = 'none';
        if (emptyPrompt) emptyPrompt.style.display = 'block';
        if (resultsList) {
            resultsList.style.display = 'none';
            resultsList.innerHTML = '';
        }
        if (notFound) notFound.style.display = 'none';
        globalSearchData = null;
        return;
    }

    if (spinner) spinner.style.display = 'inline-block';
    clearTimeout(globalSearchDebounceTimer);

    globalSearchDebounceTimer = setTimeout(() => {
        fetch(`{{ route('admin.global-search') }}?q=${encodeURIComponent(cleanQuery)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (spinner) spinner.style.display = 'none';
            globalSearchData = data;
            renderGlobalSearchResults(cleanQuery);
        })
        .catch(err => {
            if (spinner) spinner.style.display = 'none';
            console.error('Global search error:', err);
        });
    }, 200);
}

function filterGlobalSearchResults(type, btnEl) {
    currentGlobalSearchFilter = type;
    const pills = document.querySelectorAll('#globalSearchGroupPills .gs-pill');
    pills.forEach(p => {
        p.classList.remove('btn-primary', 'active');
        p.classList.add('btn-white', 'text-muted');
    });
    if (btnEl) {
        btnEl.classList.remove('btn-white', 'text-muted');
        btnEl.classList.add('btn-primary', 'active');
    }
    const input = document.getElementById('globalSearchModalInput');
    renderGlobalSearchResults(input ? input.value : '');
}

function escapeHtml(text) {
    if (!text) return '';
    return text.toString().replace(/[&<>"']/g, function(m) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m];
    });
}

function highlightMatch(text, query) {
    if (!text) return '';
    const safeText = escapeHtml(text);
    if (!query) return safeText;
    const safeQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const regex = new RegExp(`(${safeQuery})`, 'gi');
    return safeText.replace(regex, '<mark class="bg-warning text-dark px-1 rounded">$1</mark>');
}

function renderGlobalSearchResults(query) {
    const emptyPrompt = document.getElementById('globalSearchEmptyPrompt');
    const resultsList = document.getElementById('globalSearchResultsList');
    const notFound = document.getElementById('globalSearchNotFound');

    if (!globalSearchData || !resultsList) return;

    if (emptyPrompt) emptyPrompt.style.display = 'none';

    const categories = [
        { key: 'resorts', label: 'Resorts & Hotels', icon: 'bi-building text-primary' },
        { key: 'destinations', label: 'Destinations & Spots', icon: 'bi-geo-alt-fill text-success' },
        { key: 'crafts', label: 'Crafts & Livelihood', icon: 'bi-tools text-warning' },
        { key: 'events', label: 'Events & News', icon: 'bi-calendar-event text-danger' },
        { key: 'accommodations', label: 'Accommodation Approvals', icon: 'bi-patch-check-fill text-info' },
        { key: 'admins', label: 'Resort Admins', icon: 'bi-person-check-fill text-primary' },
        { key: 'reservations', label: 'Reservations & Bookings', icon: 'bi-calendar-check text-purple' }
    ];

    let html = '';
    let totalShown = 0;

    categories.forEach(cat => {
        if (currentGlobalSearchFilter !== 'all' && currentGlobalSearchFilter !== cat.key) {
            return;
        }

        const items = globalSearchData[cat.key] || [];
        if (items.length > 0) {
            html += `<div class="gs-result-group-title"><i class="bi ${cat.icon} me-1"></i> ${cat.label} (${items.length})</div>`;
            items.forEach(item => {
                totalShown++;
                const imgHtml = item.image 
                    ? `<img src="${item.image.startsWith('http') ? item.image : '/'+item.image.replace(/^\//,'')}" class="rounded-2 shadow-xs" style="width: 36px; height: 36px; object-fit: cover; flex-shrink: 0;" onerror="this.style.display='none';">`
                    : `<div class="rounded-2 bg-light d-flex align-items-center justify-content-center text-muted" style="width: 36px; height: 36px; flex-shrink: 0;"><i class="bi ${cat.icon}"></i></div>`;

                const badgeHtml = item.badge 
                    ? `<span class="badge ${item.badge_class || 'bg-light text-dark'} rounded-pill ms-auto small" style="font-size: 0.7rem;">${item.badge}</span>` 
                    : '';

                html += `
                    <a href="${item.url}" class="gs-result-item">
                        ${imgHtml}
                        <div class="flex-grow-1 overflow-hidden">
                            <div class="fw-semibold text-dark text-truncate" style="font-size: 0.9rem;">${highlightMatch(item.title, query)}</div>
                            <div class="text-muted small text-truncate" style="font-size: 0.78rem;">${highlightMatch(item.subtitle, query)}</div>
                        </div>
                        ${badgeHtml}
                        <i class="bi bi-chevron-right text-muted small ms-1"></i>
                    </a>
                `;
            });
        }
    });

    if (totalShown > 0) {
        resultsList.innerHTML = html;
        resultsList.style.display = 'block';
        if (notFound) notFound.style.display = 'none';
    } else {
        resultsList.innerHTML = '';
        resultsList.style.display = 'none';
        if (notFound) notFound.style.display = 'block';
    }
}
</script>
