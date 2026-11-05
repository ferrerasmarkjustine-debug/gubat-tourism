@if(Auth::check() && Auth::user()->isLguAdmin())
    <!-- Floating LGU Admin Toolbar -->
    <div id="lguAdminToolbar" class="lgu-admin-toolbar shadow-lg py-2 px-3 px-md-4 rounded-pill d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase d-flex align-items-center shadow-sm" style="font-size: 0.78rem; letter-spacing: 0.5px;">
                <i class="bi bi-shield-lock-fill me-1"></i> LGU ADMIN ACTIVE
            </span>
            <span class="text-white small d-none d-lg-inline opacity-75">| Homepage In-Place Controls</span>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Edit Mode Toggle Switch -->
            <div class="btn-group btn-group-sm rounded-pill p-1 bg-dark bg-opacity-50 border border-white border-opacity-25" role="group">
                <button type="button" class="btn btn-sm rounded-pill fw-bold px-3 active-edit-btn" id="btnEditModeOn" onclick="setLguEditMode(true)">
                    <i class="bi bi-pencil-square me-1"></i> Edit Mode: ON
                </button>
                <button type="button" class="btn btn-sm rounded-pill fw-semibold px-3 text-white-50" id="btnEditModeOff" onclick="setLguEditMode(false)">
                    OFF
                </button>
            </div>

            <!-- View as Public Visitor -->
            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-semibold d-none d-sm-inline-flex align-items-center" id="btnVisitorPreview" onclick="toggleVisitorPreview(true)" title="Preview homepage exactly as ordinary visitors see it">
                <i class="bi bi-eye me-1"></i> Visitor View
            </button>

            <!-- Full Admin Portal Link -->
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold d-none d-md-inline-flex align-items-center" title="Open complete Admin Portal">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>

            <!-- Minimize / Hide Toolbar Button -->
            <button type="button" class="btn btn-sm text-white-50 p-1 border-0" onclick="toggleAdminBarCollapse()" title="Minimize toolbar">
                <i class="bi bi-dash-circle fs-6"></i>
            </button>
        </div>
    </div>

    <!-- Collapsed Admin Pill (Shown when visitor preview is active or toolbar minimized) -->
    <div id="lguAdminRestorePill" class="position-fixed shadow-lg d-none align-items-center gap-2 py-2 px-3 rounded-pill bg-dark text-white" style="bottom: 25px; left: 25px; z-index: 1050; cursor: pointer; border: 2px solid #ffc107;" onclick="toggleVisitorPreview(false)" title="Click to restore LGU Admin Edit Mode">
        <i class="bi bi-shield-lock-fill text-warning fs-5"></i>
        <span class="small fw-bold">Restore Admin Edit Mode</span>
    </div>

    <style>
        .lgu-admin-toolbar {
            position: fixed;
            top: 86px;
            left: 50%;
            transform: translateX(-50%);
            width: 94%;
            max-width: 1100px;
            z-index: 1040;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1.5px solid rgba(255, 193, 7, 0.4);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.35);
            transition: all 0.3s ease;
        }

        .active-edit-btn {
            background-color: #ffc107 !important;
            color: #0f172a !important;
        }

        /* Show/Hide Admin Badges on Cards based on Edit Mode */
        body:not(.lgu-edit-active) .admin-card-overlay,
        body:not(.lgu-edit-active) .admin-section-controls {
            display: none !important;
        }

        /* Admin Action Overlay on Cards */
        .admin-card-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 25;
            display: inline-flex;
            width: fit-content;
            gap: 6px;
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(8px);
            padding: 4px 8px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
            transition: opacity 0.2s ease;
        }

        .admin-card-btn {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .admin-card-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .admin-card-btn-danger:hover {
            background: #dc3545;
            color: #ffffff;
        }

        .admin-card-btn-warning:hover {
            background: #ffc107;
            color: #0f172a;
        }

        /* Section Admin Controls */
        .admin-section-controls {
            transition: opacity 0.2s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restore Edit Mode state from localStorage
            const savedMode = localStorage.getItem('lgu_edit_mode');
            if (savedMode === '0') {
                setLguEditMode(false);
            } else {
                setLguEditMode(true);
            }
        });

        function setLguEditMode(isActive) {
            const body = document.body;
            const btnOn = document.getElementById('btnEditModeOn');
            const btnOff = document.getElementById('btnEditModeOff');

            if (isActive) {
                body.classList.add('lgu-edit-active');
                if (btnOn) {
                    btnOn.classList.add('active-edit-btn');
                    btnOn.classList.remove('text-white-50');
                }
                if (btnOff) {
                    btnOff.classList.remove('active-edit-btn');
                    btnOff.classList.add('text-white-50');
                }
                localStorage.setItem('lgu_edit_mode', '1');
            } else {
                body.classList.remove('lgu-edit-active');
                if (btnOn) {
                    btnOn.classList.remove('active-edit-btn');
                    btnOn.classList.add('text-white-50');
                }
                if (btnOff) {
                    btnOff.classList.add('active-edit-btn');
                    btnOff.classList.remove('text-white-50');
                }
                localStorage.setItem('lgu_edit_mode', '0');
            }
        }

        function toggleVisitorPreview(isVisitor) {
            const toolbar = document.getElementById('lguAdminToolbar');
            const restorePill = document.getElementById('lguAdminRestorePill');

            if (isVisitor) {
                setLguEditMode(false);
                if (toolbar) toolbar.classList.add('d-none');
                if (restorePill) {
                    restorePill.classList.remove('d-none');
                    restorePill.classList.add('d-flex');
                }
            } else {
                setLguEditMode(true);
                if (toolbar) toolbar.classList.remove('d-none');
                if (restorePill) {
                    restorePill.classList.add('d-none');
                    restorePill.classList.remove('d-flex');
                }
            }
        }

        function toggleAdminBarCollapse() {
            toggleVisitorPreview(true);
        }
    </script>
@endif

