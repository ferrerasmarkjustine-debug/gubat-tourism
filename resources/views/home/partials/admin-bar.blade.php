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

            <!-- Full Admin Portal Link -->
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold d-inline-flex align-items-center" title="Open complete Admin Portal">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Collapsed Floating Admin Pill (Animated in bottom-left when edit mode is OFF) -->
    <div id="lguAdminRestorePill" class="lgu-admin-restore-pill is-hidden" onclick="setLguEditMode(true)" title="Click to restore LGU Admin Edit Mode">
        <i class="bi bi-shield-lock-fill text-warning fs-5"></i>
        <span class="small fw-bold">Restore Admin Edit Mode</span>
    </div>

    <style>
        .lgu-admin-toolbar {
            position: fixed;
            top: 86px;
            left: 50%;
            transform: translateX(-50%) translateY(0) scale(1);
            width: 94%;
            max-width: 1080px;
            z-index: 1040;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 193, 7, 0.45);
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.38);
            border-radius: 50px;
            opacity: 1;
            pointer-events: auto;
            transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), 
                        opacity 0.35s ease, 
                        box-shadow 0.35s ease;
        }

        .lgu-admin-toolbar.is-collapsed {
            transform: translateX(-50%) translateY(-65px) scale(0.92);
            opacity: 0;
            pointer-events: none;
        }

        .active-edit-btn {
            background-color: #ffc107 !important;
            color: #0f172a !important;
        }

        /* Bottom-Left Restore Pill with Spring Bounce & Pulse Glow */
        .lgu-admin-restore-pill {
            position: fixed;
            bottom: 25px;
            left: 25px;
            z-index: 1050;
            cursor: pointer;
            background: #0f172a;
            color: #ffffff;
            border: 2px solid #ffc107;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.45), 0 0 18px rgba(255, 193, 7, 0.35);
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 18px;
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: auto;
            transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1), 
                        opacity 0.3s ease, 
                        box-shadow 0.25s ease,
                        border-color 0.25s ease;
            animation: lguPillPulse 3s infinite alternate ease-in-out;
        }

        @keyframes lguPillPulse {
            0% { box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4), 0 0 10px rgba(255, 193, 7, 0.25); }
            100% { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(255, 193, 7, 0.5); }
        }

        .lgu-admin-restore-pill:hover {
            transform: translateY(-3px) scale(1.05);
            border-color: #fbbf24;
            animation: none;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.55), 0 0 25px rgba(255, 193, 7, 0.6);
        }

        .lgu-admin-restore-pill.is-hidden {
            transform: translateY(35px) scale(0.8);
            opacity: 0;
            pointer-events: none;
        }

        /* Show/Hide Admin Badges on Cards based on Edit Mode */
        body:not(.lgu-edit-active) .admin-card-overlay,
        body:not(.lgu-edit-active) .admin-section-controls {
            display: none !important;
        }

        /* Admin Action Overlay on Cards */
        .admin-card-overlay {
            position: absolute;
            bottom: 10px;
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
                setLguEditMode(false, true);
            } else {
                setLguEditMode(true, true);
            }
        });

        function setLguEditMode(isActive, isInitial) {
            const body = document.body;
            const toolbar = document.getElementById('lguAdminToolbar');
            const restorePill = document.getElementById('lguAdminRestorePill');
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

                if (restorePill) {
                    restorePill.classList.add('is-hidden');
                }
                if (toolbar) {
                    toolbar.classList.remove('is-collapsed');
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

                if (toolbar) {
                    toolbar.classList.add('is-collapsed');
                }
                if (restorePill) {
                    if (isInitial) {
                        restorePill.classList.remove('is-hidden');
                    } else {
                        setTimeout(() => {
                            restorePill.classList.remove('is-hidden');
                        }, 120);
                    }
                }
                localStorage.setItem('lgu_edit_mode', '0');
            }
        }
    </script>
@endif

