@php
    $uniqueId = $id ?? ('uploader_' . substr(md5(uniqid(mt_rand(), true)), 0, 8));
    $fieldName = $name ?? 'image';
    $urlFieldName = $urlName ?? 'image_url';
    $fieldLabel = $label ?? 'Cover Photo';
    $currentVal = $currentImage ?? null;
    $hasExisting = !empty($currentVal);
    $initialPreview = $hasExisting ? (str_starts_with($currentVal, 'http') ? $currentVal : asset($currentVal)) : '';
@endphp

<div class="card border border-2 border-dashed rounded-4 p-3 mb-3 bg-light bg-opacity-50" id="card-{{ $uniqueId }}">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <label class="form-label fw-bold text-dark mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-image text-primary fs-5"></i>
            <span>{{ $fieldLabel }}</span>
        </label>
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2 py-1 small">
            <i class="bi bi-laptop me-1"></i> From Pictures / PC
        </span>
    </div>

    {{-- Instant Live Preview Box with Crop Trigger --}}
    <div class="text-center mb-3">
        <div class="position-relative mx-auto rounded-3 overflow-hidden bg-white shadow-sm border d-flex align-items-center justify-content-center"
             style="height: 190px; max-width: 100%;">
            
            <img id="preview-img-{{ $uniqueId }}"
                 src="{{ $initialPreview }}"
                 alt="Image Preview"
                 class="w-100 h-100"
                 style="object-fit: cover; display: {{ $hasExisting ? 'block' : 'none' }};">

            <div id="placeholder-{{ $uniqueId }}"
                 class="p-4 text-center text-muted"
                 style="display: {{ $hasExisting ? 'none' : 'block' }};">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 text-primary mb-2">
                    <i class="bi bi-cloud-arrow-up fs-2"></i>
                </div>
                <div class="fw-semibold text-dark small">Select a photo from your computer</div>
                <div class="text-muted" style="font-size: 0.75rem;">Supports JPG, PNG, WEBP (Max 5MB)</div>
            </div>

            {{-- Floating Crop Button over preview --}}
            <button type="button" 
                    id="crop-trigger-{{ $uniqueId }}"
                    class="btn btn-dark btn-sm rounded-pill px-3 position-absolute bottom-0 end-0 m-2 shadow-sm"
                    style="display: {{ $hasExisting ? 'inline-flex' : 'none' }}; align-items: center; gap: 0.35rem; font-size: 0.78rem; opacity: 0.9;">
                <i class="bi bi-crop"></i>
                <span>Crop &amp; Frame</span>
            </button>
        </div>
    </div>

    {{-- File Input (Pictures / File Explorer) --}}
    <div class="mb-2">
        <label for="input-{{ $uniqueId }}" class="form-label small fw-semibold text-secondary mb-1">
            <i class="bi bi-folder2-open text-primary me-1"></i> Choose photo from your computer:
        </label>
        <input type="file"
               class="form-control rounded-3 @error($fieldName) is-invalid @enderror"
               id="input-{{ $uniqueId }}"
               name="{{ $fieldName }}"
               accept="image/jpeg,image/png,image/jpg,image/webp">
        @error($fieldName)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text small text-muted">
            <i class="bi bi-info-circle me-1"></i> Click to select from Pictures. You can crop and reposition it right after selecting.
        </div>
    </div>

    {{-- Optional Web URL Collapse --}}
    <div class="pt-2 border-top">
        <a class="small text-decoration-none text-muted d-inline-flex align-items-center"
           data-bs-toggle="collapse"
           href="#collapseUrl-{{ $uniqueId }}"
           role="button"
           aria-expanded="false"
           aria-controls="collapseUrl-{{ $uniqueId }}">
            <i class="bi bi-link-45deg me-1"></i> Or provide an external image URL instead
        </a>
        <div class="collapse mt-2" id="collapseUrl-{{ $uniqueId }}">
            <input type="url"
                   class="form-control form-control-sm rounded-3 @error($urlFieldName) is-invalid @enderror"
                   id="url-{{ $uniqueId }}"
                   name="{{ $urlFieldName }}"
                   value="{{ old($urlFieldName, (str_starts_with($currentVal ?? '', 'http') ? $currentVal : '')) }}"
                   placeholder="https://images.unsplash.com/...">
            @error($urlFieldName)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text small text-muted">If both a file and URL are provided, the uploaded file will be prioritized.</div>
        </div>
    </div>
</div>

{{-- Crop & Re-frame Modal --}}
<div class="modal fade" id="cropModal-{{ $uniqueId }}" tabindex="-1" aria-labelledby="cropModalLabel-{{ $uniqueId }}" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 pt-3 pb-3">
                <h6 class="modal-title fw-bold text-dark d-flex align-items-center" id="cropModalLabel-{{ $uniqueId }}">
                    <i class="bi bi-crop text-primary me-2 fs-5"></i> Adjust Photo Framing for Card Cover
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 bg-dark d-flex align-items-center justify-content-center" style="min-height: 380px; max-height: 60vh;">
                <div style="max-width: 100%; max-height: 55vh; overflow: hidden;">
                    <img id="cropper-target-{{ $uniqueId }}" src="" alt="To Crop" style="max-width: 100%; display: block;">
                </div>
            </div>
            <div class="modal-footer border-top px-4 py-2 bg-light d-flex justify-content-between align-items-center">
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary" id="zoom-in-{{ $uniqueId }}" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                    <button type="button" class="btn btn-outline-secondary" id="zoom-out-{{ $uniqueId }}" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                    <button type="button" class="btn btn-outline-secondary" id="rotate-{{ $uniqueId }}" title="Rotate 90deg"><i class="bi bi-arrow-clockwise"></i></button>
                    <button type="button" class="btn btn-outline-secondary" id="reset-{{ $uniqueId }}" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></button>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-3 btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 btn-sm fw-semibold shadow-sm" id="crop-save-{{ $uniqueId }}">
                        <i class="bi bi-check2 me-1"></i> Apply Framing
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const uniqueId = '{{ $uniqueId }}';
    const fileInput = document.getElementById('input-' + uniqueId);
    const urlInput = document.getElementById('url-' + uniqueId);
    const previewImg = document.getElementById('preview-img-' + uniqueId);
    const placeholder = document.getElementById('placeholder-' + uniqueId);
    const cropTriggerBtn = document.getElementById('crop-trigger-' + uniqueId);
    const cropModalEl = document.getElementById('cropModal-' + uniqueId);
    const cropperTargetImg = document.getElementById('cropper-target-' + uniqueId);
    const cropSaveBtn = document.getElementById('crop-save-' + uniqueId);
    const zoomInBtn = document.getElementById('zoom-in-' + uniqueId);
    const zoomOutBtn = document.getElementById('zoom-out-' + uniqueId);
    const rotateBtn = document.getElementById('rotate-' + uniqueId);
    const resetBtn = document.getElementById('reset-' + uniqueId);

    let cropper = null;
    let cropModal = null;
    let currentRawImageSrc = previewImg.src || '';

    function notifyImageChanged(src) {
        window.dispatchEvent(new CustomEvent('tourist-image-updated', {
            detail: { uploaderId: uniqueId, src: src }
        }));
    }

    function initCropperModal() {
        if (!cropModal && window.bootstrap) {
            cropModal = new bootstrap.Modal(cropModalEl);
        }
    }

    function openCropper(imageSrc) {
        initCropperModal();
        cropperTargetImg.src = imageSrc;
        if (cropModal) {
            cropModal.show();
        }
    }

    if (cropModalEl) {
        cropModalEl.addEventListener('shown.bs.modal', function () {
            if (typeof Cropper !== 'undefined') {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(cropperTargetImg, {
                    aspectRatio: 16 / 9,
                    viewMode: 1,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                });
            }
        });

        cropModalEl.addEventListener('hidden.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    }

    if (cropTriggerBtn) {
        cropTriggerBtn.addEventListener('click', function() {
            if (currentRawImageSrc) {
                openCropper(currentRawImageSrc);
            }
        });
    }

    if (cropSaveBtn) {
        cropSaveBtn.addEventListener('click', function() {
            if (!cropper) return;
            const canvas = cropper.getCroppedCanvas({
                width: 1200,
                height: 675,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (canvas) {
                canvas.toBlob(function(blob) {
                    if (blob && fileInput) {
                        try {
                            const file = new File([blob], 'cropped_' + Date.now() + '.jpg', { type: 'image/jpeg' });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                        } catch (err) {
                            console.warn('DataTransfer not fully supported:', err);
                        }
                    }

                    const croppedUrl = canvas.toDataURL('image/jpeg', 0.92);
                    previewImg.src = croppedUrl;
                    previewImg.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                    if (cropTriggerBtn) cropTriggerBtn.style.display = 'inline-flex';

                    notifyImageChanged(croppedUrl);

                    if (cropModal) {
                        cropModal.hide();
                    }
                }, 'image/jpeg', 0.92);
            }
        });
    }

    if (zoomInBtn) zoomInBtn.addEventListener('click', () => cropper && cropper.zoom(0.1));
    if (zoomOutBtn) zoomOutBtn.addEventListener('click', () => cropper && cropper.zoom(-0.1));
    if (rotateBtn) rotateBtn.addEventListener('click', () => cropper && cropper.rotate(90));
    if (resetBtn) resetBtn.addEventListener('click', () => cropper && cropper.reset());

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentRawImageSrc = e.target.result;
                    previewImg.src = currentRawImageSrc;
                    previewImg.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                    if (cropTriggerBtn) cropTriggerBtn.style.display = 'inline-flex';

                    notifyImageChanged(currentRawImageSrc);

                    // Prompt to crop immediately if desired
                    setTimeout(() => {
                        openCropper(currentRawImageSrc);
                    }, 250);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    if (urlInput) {
        urlInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val.startsWith('http://') || val.startsWith('https://')) {
                currentRawImageSrc = val;
                previewImg.src = val;
                previewImg.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
                if (cropTriggerBtn) cropTriggerBtn.style.display = 'inline-flex';

                notifyImageChanged(val);
            }
        });
    }
})();
</script>
