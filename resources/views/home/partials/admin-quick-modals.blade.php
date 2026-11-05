@if(Auth::check() && Auth::user()->isLguAdmin())
    <!-- ========================================================
         LGU Admin Quick Edit Destination / Attraction Modal
         ======================================================== -->
    <div class="modal fade" id="adminQuickEditDestinationModal" tabindex="-1" aria-labelledby="adminQuickEditDestLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                    <h5 class="modal-title fw-bold d-flex align-items-center" id="adminQuickEditDestLabel">
                        <i class="bi bi-pencil-square text-warning me-2"></i> Quick Edit Attraction
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data" id="adminQuickEditDestForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-dark">Attraction / Destination Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="quickEditNameInput" class="form-control rounded-3" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" id="quickEditCategoryInput" list="adminQuickCategoryList" class="form-control rounded-3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-dark">Description</label>
                                <textarea name="description" id="quickEditDescInput" class="form-control rounded-3" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Replace Cover Photo (Optional)</label>
                                <input type="file" name="image" class="form-control rounded-3" accept="image/jpeg,image/png,image/webp">
                                <small class="text-muted" style="font-size: 0.78rem;">Leave blank to keep existing photo.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-dark">Google Maps Pin URL</label>
                                <input type="url" name="google_map_url" id="quickEditMapInput" class="form-control rounded-3" placeholder="https://maps.google.com/...">
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch p-3 bg-light rounded-3 mt-2">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="featured" id="quickEditFeaturedInput" value="1">
                                    <label class="form-check-label fw-bold text-dark" for="quickEditFeaturedInput">
                                        <i class="bi bi-star-fill text-warning me-1"></i> Featured on Homepage
                                    </label>
                                    <div class="text-muted small ps-4">Unchecking this removes the item from the homepage while keeping it in the public directory.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer px-4 py-3 bg-light border-0 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold">
                            <i class="bi bi-save2-fill me-1"></i> Update Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================================
         JavaScript Helpers for Quick Edit & Toggle
         ======================================================== -->
    <script>
        // Open Quick Edit Modal for any destination card
        function openAdminEditDestination(id, name, category, desc, mapUrl, isFeatured) {
            const form = document.getElementById('adminQuickEditDestForm');
            if (form) {
                form.action = `/super-admin/destinations/${id}`;
            }

            const nameInput = document.getElementById('quickEditNameInput');
            if (nameInput) nameInput.value = name || '';

            const catInput = document.getElementById('quickEditCategoryInput');
            if (catInput) catInput.value = category || '';

            const descInput = document.getElementById('quickEditDescInput');
            if (descInput) descInput.value = desc || '';

            const mapInput = document.getElementById('quickEditMapInput');
            if (mapInput) mapInput.value = mapUrl || '';

            const featInput = document.getElementById('quickEditFeaturedInput');
            if (featInput) {
                featInput.checked = (isFeatured === true || isFeatured === '1' || isFeatured === 1);
            }

            const modalEl = document.getElementById('adminQuickEditDestinationModal');
            if (modalEl && window.bootstrap) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        }

        // Quick Unfeature / Remove from Homepage via AJAX
        function unfeatureHomepageCard(toggleUrl, cardElement, title) {
            if (!confirm(`Remove "${title}" from the homepage?\n\n(Note: This will NOT delete the attraction. It simply removes it from this homepage section and preserves it in the directory.)`)) {
                return;
            }

            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            fetch(toggleUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Smoothly animate and remove card from DOM
                    cardElement.style.transition = 'all 0.4s ease';
                    cardElement.style.transform = 'scale(0.85)';
                    cardElement.style.opacity = '0';
                    setTimeout(() => {
                        cardElement.remove();
                    }, 400);
                } else {
                    alert(data.message || 'Could not update featured status.');
                }
            })
            .catch(err => {
                // If JSON fails, submit a standard form as fallback
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = toggleUrl;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = token;
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PATCH';
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            });
        }

        // Quick Delete with confirmation
        function deleteCardPermanently(deleteUrl, title) {
            if (!confirm(`Are you sure you want to PERMANENTLY DELETE "${title}"?\n\nWARNING: This action cannot be undone.`)) {
                return;
            }

            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const token = tokenMeta ? tokenMeta.getAttribute('content') : '';

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = token;
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endif

