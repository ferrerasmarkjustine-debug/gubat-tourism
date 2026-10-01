@php
    $prefix = $prefix ?? 'guest_selector_' . Str::random(6);
    $initialAdults = (int) request('adults', 2);
    $initialChildren = (int) request('children', 0);
    $initialRooms = (int) request('rooms', 1);

    // Support legacy/backward-compatible 'guests' parameter
    if (request()->has('guests') && !request()->has('adults')) {
        $initialAdults = max(1, (int) request('guests', 2));
    }

    $initialChildAges = request('child_ages', []);
    if (!is_array($initialChildAges)) {
        $initialChildAges = [];
    }
@endphp

<!-- Guests & Rooms Selector Component -->
<div class="guest-room-selector-wrapper position-relative"
     id="{{ $prefix }}_wrapper"
     data-init-adults="{{ $initialAdults }}"
     data-init-children="{{ $initialChildren }}"
     data-init-rooms="{{ $initialRooms }}"
     data-init-child-ages="{{ json_encode(array_values($initialChildAges)) }}">

    <label class="form-label small fw-bold text-muted" for="{{ $prefix }}_trigger">
        <i class="bi bi-people-fill text-primary me-1"></i> Guests &amp; Rooms
    </label>

    <!-- Compact Trigger Field in Search Bar -->
    <div class="guest-selector-trigger form-control border-2 d-flex align-items-center justify-content-between px-3"
         id="{{ $prefix }}_trigger"
         role="button"
         tabindex="0"
         aria-haspopup="true"
         aria-expanded="false"
         style="border-radius: 10px; cursor: pointer; height: 48px; background-color: #ffffff; user-select: none;">
        
        <div class="d-flex flex-column justify-content-center text-truncate pe-2">
            <span class="guest-summary-line1 fw-semibold text-dark text-truncate" style="font-size: 0.85rem; line-height: 1.25;">
                {{ $initialAdults }} {{ $initialAdults === 1 ? 'adult' : 'adults' }}{{ $initialChildren > 0 ? ', ' . $initialChildren . ' ' . ($initialChildren === 1 ? 'child' : 'children') : '' }}
            </span>
            <span class="guest-summary-line2 text-muted text-truncate" style="font-size: 0.75rem; line-height: 1.25;">
                {{ $initialRooms }} {{ $initialRooms === 1 ? 'room' : 'rooms' }}
            </span>
        </div>
        <i class="bi bi-chevron-down text-muted small guest-chevron"></i>
    </div>

    <!-- Dropdown / Popover -->
    <div class="guest-selector-popover card border-0 shadow-lg p-3 position-absolute"
         id="{{ $prefix }}_popover"
         style="display: none; top: calc(100% + 8px); left: 0; min-width: 320px; max-width: 360px; width: 100%; z-index: 1050; border-radius: 16px; border: 1px solid rgba(15, 76, 129, 0.12); background-color: #ffffff; box-shadow: 0 12px 35px rgba(0,0,0,0.15);">

        <!-- Popover Header -->
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <span class="fw-bold text-dark font-outfit" style="font-size: 0.95rem;">
                <i class="bi bi-sliders me-1 text-primary"></i> Guests &amp; Rooms
            </span>
            <button type="button" class="btn-close guest-close-btn" style="font-size: 0.75rem;" aria-label="Close"></button>
        </div>

        <!-- 1. Rooms Stepper -->
        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.9rem;">Rooms</div>
                <div class="text-muted extra-small" style="font-size: 0.75rem;">Number of rooms</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="guest-counter-btn btn-minus" data-type="rooms" aria-label="Decrease rooms">
                    <i class="bi bi-dash"></i>
                </button>
                <span class="guest-count-val fw-bold text-dark text-center" data-type="rooms" style="min-width: 24px; font-size: 0.95rem;">{{ $initialRooms }}</span>
                <button type="button" class="guest-counter-btn btn-plus" data-type="rooms" aria-label="Increase rooms">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>

        <!-- 2. Adults Stepper (18+ years old) -->
        <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.9rem;">Adults</div>
                <div class="text-muted extra-small" style="font-size: 0.75rem;">18 years old and above</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="guest-counter-btn btn-minus" data-type="adults" aria-label="Decrease adults">
                    <i class="bi bi-dash"></i>
                </button>
                <span class="guest-count-val fw-bold text-dark text-center" data-type="adults" style="min-width: 24px; font-size: 0.95rem;">{{ $initialAdults }}</span>
                <button type="button" class="guest-counter-btn btn-plus" data-type="adults" aria-label="Increase adults">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>

        <!-- 3. Children Stepper (0–12 years old) -->
        <div class="d-flex align-items-center justify-content-between py-2">
            <div>
                <div class="fw-bold text-dark" style="font-size: 0.9rem;">Children</div>
                <div class="text-muted extra-small" style="font-size: 0.75rem;">0–12 years old</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="guest-counter-btn btn-minus" data-type="children" aria-label="Decrease children">
                    <i class="bi bi-dash"></i>
                </button>
                <span class="guest-count-val fw-bold text-dark text-center" data-type="children" style="min-width: 24px; font-size: 0.95rem;">{{ $initialChildren }}</span>
                <button type="button" class="guest-counter-btn btn-plus" data-type="children" aria-label="Increase children">
                    <i class="bi bi-plus"></i>
                </button>
            </div>
        </div>

        <!-- 4. Dynamic Child Ages Section -->
        <div class="child-ages-section mt-2 pt-2 border-top" style="display: {{ $initialChildren > 0 ? 'block' : 'none' }};">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-muted">
                    <i class="bi bi-info-circle text-primary me-1"></i> Child Ages
                </span>
                <span class="text-muted" style="font-size: 0.7rem;">Age at check-in</span>
            </div>
            <div class="child-ages-grid row g-2"></div>
        </div>

        <!-- Popover Action Footer -->
        <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-link text-decoration-none btn-sm p-0 text-muted guest-reset-btn" style="font-size: 0.8rem;">
                Reset
            </button>
            <button type="button" class="btn btn-sm btn-tourism-primary rounded-pill px-4 fw-bold guest-done-btn" style="font-size: 0.85rem; padding-top: 6px; padding-bottom: 6px;">
                Done
            </button>
        </div>
    </div>

    <!-- Hidden form inputs for submission -->
    <input type="hidden" name="rooms" class="hidden-rooms" value="{{ $initialRooms }}">
    <input type="hidden" name="adults" class="hidden-adults" value="{{ $initialAdults }}">
    <input type="hidden" name="children" class="hidden-children" value="{{ $initialChildren }}">
    <input type="hidden" name="guests" class="hidden-guests" value="{{ $initialAdults + $initialChildren }}">
</div>

<style>
/* Scoped Guest & Rooms Component Styles */
.guest-counter-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid var(--primary-color, #0F4C81);
    background: #ffffff;
    color: var(--primary-color, #0F4C81);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
    line-height: 1;
}
.guest-counter-btn:hover:not(:disabled) {
    background: var(--primary-color, #0F4C81);
    color: #ffffff;
    transform: scale(1.05);
}
.guest-counter-btn:disabled {
    border-color: #dee2e6;
    color: #adb5bd;
    background: #f8f9fa;
    cursor: not-allowed;
    opacity: 0.55;
    pointer-events: none;
}
.guest-selector-trigger {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.guest-selector-trigger:hover {
    border-color: var(--primary-color, #0F4C81) !important;
}
.guest-selector-trigger.is-active {
    border-color: var(--primary-color, #0F4C81) !important;
    box-shadow: 0 0 0 0.2rem rgba(15, 76, 129, 0.15) !important;
}
.guest-selector-trigger.is-active .guest-chevron {
    transform: rotate(180deg);
}
.guest-chevron {
    transition: transform 0.25s ease;
}
.child-age-item select:focus {
    border-color: var(--primary-color, #0F4C81);
    box-shadow: 0 0 0 0.15rem rgba(15, 76, 129, 0.12);
}
</style>

<script>
(function() {
    function setupGuestSelector() {
        const wrappers = document.querySelectorAll('.guest-room-selector-wrapper');
        wrappers.forEach(function(wrapper) {
            if (wrapper.dataset.guestSelectorInitialized === 'true') {
                return;
            }
            wrapper.dataset.guestSelectorInitialized = 'true';

            // Initial State from Data Attributes
            let adults = Math.max(1, parseInt(wrapper.dataset.initAdults, 10) || 2);
            let children = Math.max(0, parseInt(wrapper.dataset.initChildren, 10) || 0);
            let rooms = Math.max(1, parseInt(wrapper.dataset.initRooms, 10) || 1);
            let childAges = [];

            try {
                const parsedAges = JSON.parse(wrapper.dataset.initChildAges || '[]');
                if (Array.isArray(parsedAges)) {
                    childAges = parsedAges.slice(0, children);
                }
            } catch (e) {
                childAges = [];
            }

            // Fill childAges to match children count if needed
            while (childAges.length < children) {
                childAges.push('');
            }

            // Elements
            const trigger = wrapper.querySelector('.guest-selector-trigger');
            const popover = wrapper.querySelector('.guest-selector-popover');
            const line1 = wrapper.querySelector('.guest-summary-line1');
            const line2 = wrapper.querySelector('.guest-summary-line2');

            const hiddenAdults = wrapper.querySelector('.hidden-adults');
            const hiddenChildren = wrapper.querySelector('.hidden-children');
            const hiddenRooms = wrapper.querySelector('.hidden-rooms');
            const hiddenGuests = wrapper.querySelector('.hidden-guests');

            const childSection = wrapper.querySelector('.child-ages-section');
            const childGrid = wrapper.querySelector('.child-ages-grid');

            const closeBtn = wrapper.querySelector('.guest-close-btn');
            const doneBtn = wrapper.querySelector('.guest-done-btn');
            const resetBtn = wrapper.querySelector('.guest-reset-btn');

            // Render Child Age Selectors using safe DOM manipulation
            function renderChildAges() {
                if (children <= 0) {
                    childSection.style.display = 'none';
                    childGrid.replaceChildren();
                    return;
                }

                childSection.style.display = 'block';
                childGrid.replaceChildren();

                for (let i = 0; i < children; i++) {
                    const col = document.createElement('div');
                    col.className = (children === 1) ? 'col-12' : 'col-6';

                    const label = document.createElement('label');
                    label.className = 'form-label extra-small text-muted mb-1 fw-semibold d-block';
                    label.style.fontSize = '0.75rem';
                    label.textContent = 'Child ' + (i + 1) + ' Age';
                    col.appendChild(label);

                    const select = document.createElement('select');
                    select.className = 'form-select form-select-sm border-2 child-age-select';
                    select.name = 'child_ages[]';
                    select.style.borderRadius = '8px';
                    select.style.fontSize = '0.8rem';
                    select.setAttribute('aria-label', 'Child ' + (i + 1) + ' Age');

                    // Default placeholder option
                    const optPlaceholder = document.createElement('option');
                    optPlaceholder.value = '';
                    optPlaceholder.textContent = 'Select age';
                    select.appendChild(optPlaceholder);

                    // Option: Under 1 year
                    const optUnder1 = document.createElement('option');
                    optUnder1.value = '0';
                    optUnder1.textContent = 'Under 1 year';
                    select.appendChild(optUnder1);

                    // Options: 1 to 12 years old
                    for (let age = 1; age <= 12; age++) {
                        const opt = document.createElement('option');
                        opt.value = String(age);
                        opt.textContent = age === 1 ? '1 year' : age + ' years';
                        select.appendChild(opt);
                    }

                    // Pre-select age if previously chosen
                    if (childAges[i] !== undefined && childAges[i] !== null && childAges[i] !== '') {
                        select.value = String(childAges[i]);
                    }

                    const childIndex = i;
                    select.addEventListener('change', function() {
                        childAges[childIndex] = select.value;
                    });

                    col.appendChild(select);
                    childGrid.appendChild(col);
                }
            }

            // Update Summary Line text
            function updateSummary() {
                const adultLabel = adults === 1 ? 'adult' : 'adults';
                let line1Text = adults + ' ' + adultLabel;

                if (children > 0) {
                    const childLabel = children === 1 ? 'child' : 'children';
                    line1Text += ', ' + children + ' ' + childLabel;
                }

                const roomLabel = rooms === 1 ? 'room' : 'rooms';
                const line2Text = rooms + ' ' + roomLabel;

                line1.textContent = line1Text;
                line2.textContent = line2Text;
            }

            // Synchronize hidden inputs for form submission
            function updateHiddenInputs() {
                if (hiddenAdults) hiddenAdults.value = adults;
                if (hiddenChildren) hiddenChildren.value = children;
                if (hiddenRooms) hiddenRooms.value = rooms;
                if (hiddenGuests) hiddenGuests.value = adults + children;
            }

            // Update displayed numbers and button disabled states
            function updateButtonStates() {
                wrapper.querySelectorAll('.guest-count-val').forEach(function(span) {
                    const type = span.dataset.type;
                    if (type === 'rooms') span.textContent = rooms;
                    if (type === 'adults') span.textContent = adults;
                    if (type === 'children') span.textContent = children;
                });

                wrapper.querySelectorAll('.btn-minus').forEach(function(btn) {
                    const type = btn.dataset.type;
                    if (type === 'rooms') btn.disabled = (rooms <= 1);
                    if (type === 'adults') btn.disabled = (adults <= 1);
                    if (type === 'children') btn.disabled = (children <= 0);
                });

                wrapper.querySelectorAll('.btn-plus').forEach(function(btn) {
                    const type = btn.dataset.type;
                    if (type === 'rooms') btn.disabled = (rooms >= 10);
                    if (type === 'adults') btn.disabled = (adults >= 20);
                    if (type === 'children') btn.disabled = (children >= 10);
                });
            }

            // Stepper Minus button click handler
            wrapper.querySelectorAll('.btn-minus').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const type = this.dataset.type;
                    if (type === 'rooms' && rooms > 1) {
                        rooms--;
                    } else if (type === 'adults' && adults > 1) {
                        adults--;
                    } else if (type === 'children' && children > 0) {
                        children--;
                        childAges.pop();
                        renderChildAges();
                    }
                    updateButtonStates();
                    updateSummary();
                    updateHiddenInputs();
                });
            });

            // Stepper Plus button click handler
            wrapper.querySelectorAll('.btn-plus').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const type = this.dataset.type;
                    if (type === 'rooms' && rooms < 10) {
                        rooms++;
                    } else if (type === 'adults' && adults < 20) {
                        adults++;
                    } else if (type === 'children' && children < 10) {
                        children++;
                        childAges.push('');
                        renderChildAges();
                    }
                    updateButtonStates();
                    updateSummary();
                    updateHiddenInputs();
                });
            });

            // Popover Open / Close
            function openPopover() {
                // Close other open guest popovers first
                document.querySelectorAll('.guest-selector-popover').forEach(function(p) {
                    p.style.display = 'none';
                });
                document.querySelectorAll('.guest-selector-trigger').forEach(function(t) {
                    t.classList.remove('is-active');
                    t.setAttribute('aria-expanded', 'false');
                });

                popover.style.display = 'block';
                trigger.classList.add('is-active');
                trigger.setAttribute('aria-expanded', 'true');
            }

            function closePopover() {
                popover.style.display = 'none';
                trigger.classList.remove('is-active');
                trigger.setAttribute('aria-expanded', 'false');
            }

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                if (popover.style.display === 'block') {
                    closePopover();
                } else {
                    openPopover();
                }
            });

            // Keyboard accessibility for trigger
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    trigger.click();
                }
            });

            // Prevent clicks inside popover from closing it
            popover.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closePopover();
                });
            }

            if (doneBtn) {
                doneBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    closePopover();
                });
            }

            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    rooms = 1;
                    adults = 2;
                    children = 0;
                    childAges = [];
                    renderChildAges();
                    updateButtonStates();
                    updateSummary();
                    updateHiddenInputs();
                });
            }

            // Close when clicking outside this wrapper
            document.addEventListener('click', function(e) {
                if (!wrapper.contains(e.target)) {
                    closePopover();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && popover.style.display === 'block') {
                    closePopover();
                    trigger.focus();
                }
            });

            // Initial render
            renderChildAges();
            updateButtonStates();
            updateSummary();
            updateHiddenInputs();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupGuestSelector);
    } else {
        setupGuestSelector();
    }
})();
</script>
