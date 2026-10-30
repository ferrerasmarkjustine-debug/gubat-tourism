<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LGU Admin Portal — {{ config('app.name', 'Gubat Tourism') }}</title>
    <meta name="description" content="LGU Admin Portal — Municipality of Gubat Tourism Office">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Cropper.js for image framing & cropping -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

    <!-- Vite compiled Bootstrap & Custom CSS/JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    {{-- Admin-only navigation (no public navbar here) --}}
    @include('super-admin.partials.nav')

    <!-- Page Content -->
    <main class="flex-grow-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    {{-- Bootstrap JS CDN fallback – ensures dropdowns work even without Vite dev server --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc4s9bIOgUxi8T/jzmRh3B6wI4kj6/S6/d3bEz0RpQT"
            crossorigin="anonymous"></script>

    <!-- Cropper.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

    {{-- Universal Live Table & Card Search Filter with Pills & Substring Highlighting --}}
    <script>
    window.initLiveTableFilter = function(cfg) {
        const input = document.getElementById(cfg.inputId);
        const clearBtn = document.getElementById(cfg.clearBtnId);
        const counterEl = document.getElementById(cfg.counterId);
        const emptyState = document.getElementById(cfg.emptyStateId);
        const container = document.getElementById(cfg.containerId);
        const rowSelector = cfg.rowSelector || 'tbody tr';
        const pillSelector = cfg.pillSelector || null;
        const highlightSelector = cfg.highlightSelector || null;

        if (!input || !container) return;

        let activeFilter = 'all';

        function getItems() {
            return Array.from(container.querySelectorAll(rowSelector)).filter(el => !el.classList.contains('empty-state-row'));
        }

        const items = getItems();

        // Cache original HTML for text highlighting without destroying event listeners or attributes
        items.forEach(item => {
            const targets = highlightSelector ? item.querySelectorAll(highlightSelector) : [item];
            targets.forEach(t => {
                if (!t.hasAttribute('data-orig-html')) {
                    t.setAttribute('data-orig-html', t.innerHTML);
                }
            });
        });

        function escapeReg(str) {
            return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function applyHighlight(element, query) {
            const orig = element.getAttribute('data-orig-html');
            if (!orig) return;
            if (!query) {
                element.innerHTML = orig;
                return;
            }

            const parser = new DOMParser();
            const doc = parser.parseFromString(`<div>${orig}</div>`, 'text/html');
            const root = doc.body.firstChild;

            function walk(node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    const text = node.nodeValue;
                    const reg = new RegExp(`(${escapeReg(query)})`, 'gi');
                    if (reg.test(text)) {
                        const span = document.createElement('span');
                        span.innerHTML = text.replace(reg, '<mark class="bg-warning text-dark px-1 rounded fw-semibold">$1</mark>');
                        node.parentNode.replaceChild(span, node);
                    }
                } else if (node.nodeType === Node.ELEMENT_NODE && !['MARK', 'BUTTON', 'INPUT', 'SELECT', 'FORM'].includes(node.tagName)) {
                    Array.from(node.childNodes).forEach(walk);
                }
            }
            Array.from(root.childNodes).forEach(walk);
            element.innerHTML = root.innerHTML;
        }

        function runFilter() {
            const query = (input.value || '').trim().toLowerCase();
            let visibleCount = 0;

            if (clearBtn) {
                clearBtn.style.display = query.length > 0 ? 'inline-flex' : 'none';
            }

            items.forEach(item => {
                const itemText = (item.getAttribute('data-search') || item.innerText || '').toLowerCase();
                const itemCategory = (item.getAttribute('data-category') || '').toLowerCase();
                const itemStatus = (item.getAttribute('data-status') || '').toLowerCase();

                let matchesPill = true;
                if (activeFilter && activeFilter !== 'all') {
                    const f = activeFilter.toLowerCase();
                    matchesPill = itemCategory.includes(f) || itemStatus === f || itemText.includes(f);
                }

                const matchesQuery = query === '' || itemText.includes(query);
                const isVisible = matchesPill && matchesQuery;

                if (isVisible) {
                    item.style.display = '';
                    visibleCount++;
                    const targets = highlightSelector ? item.querySelectorAll(highlightSelector) : [item];
                    targets.forEach(t => applyHighlight(t, query));
                } else {
                    item.style.display = 'none';
                    const targets = highlightSelector ? item.querySelectorAll(highlightSelector) : [item];
                    targets.forEach(t => {
                        const orig = t.getAttribute('data-orig-html');
                        if (orig) t.innerHTML = orig;
                    });
                }
            });

            if (counterEl) {
                counterEl.innerHTML = `Showing <strong class="text-dark">${visibleCount}</strong> of <strong class="text-dark">${items.length}</strong> records`;
            }

            if (emptyState) {
                if (visibleCount === 0 && items.length > 0) {
                    emptyState.style.display = '';
                    const termSpan = emptyState.querySelector('.empty-state-term');
                    if (termSpan) termSpan.textContent = input.value.trim() ? `"${input.value.trim()}"` : `filter "${activeFilter}"`;
                } else {
                    emptyState.style.display = 'none';
                }
            }
        }

        input.addEventListener('input', runFilter);

        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                input.value = '';
                runFilter();
                input.focus();
            });
        }

        if (pillSelector) {
            const pills = document.querySelectorAll(pillSelector);
            pills.forEach(pill => {
                pill.addEventListener('click', function(e) {
                    e.preventDefault();
                    pills.forEach(p => {
                        p.classList.remove('active', 'btn-primary', 'text-white');
                        p.classList.add('btn-light', 'text-muted');
                    });
                    this.classList.remove('btn-light', 'text-muted');
                    this.classList.add('active', 'btn-primary', 'text-white');

                    activeFilter = this.getAttribute('data-filter') || 'all';
                    runFilter();
                });
            });
        }

        window[`resetSearch_${cfg.inputId}`] = function() {
            input.value = '';
            activeFilter = 'all';
            if (pillSelector) {
                const pills = document.querySelectorAll(pillSelector);
                pills.forEach(p => {
                    if (p.getAttribute('data-filter') === 'all') {
                        p.classList.remove('btn-light', 'text-muted');
                        p.classList.add('active', 'btn-primary', 'text-white');
                    } else {
                        p.classList.remove('active', 'btn-primary', 'text-white');
                        p.classList.add('btn-light', 'text-muted');
                    }
                });
            }
            runFilter();
            input.focus();
        };

        runFilter();
    };
    </script>

</body>
</html>
