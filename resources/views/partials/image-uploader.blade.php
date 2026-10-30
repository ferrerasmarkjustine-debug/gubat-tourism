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

    {{-- Instant Live Preview Box --}}
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
            <i class="bi bi-info-circle me-1"></i> Click to open File Explorer and choose from your Pictures folder.
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

<script>
(function() {
    const fileInput = document.getElementById('input-{{ $uniqueId }}');
    const urlInput = document.getElementById('url-{{ $uniqueId }}');
    const previewImg = document.getElementById('preview-img-{{ $uniqueId }}');
    const placeholder = document.getElementById('placeholder-{{ $uniqueId }}');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                    if (placeholder) placeholder.style.display = 'none';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    if (urlInput) {
        urlInput.addEventListener('input', function() {
            const val = this.value.trim();
            if (val.startsWith('http://') || val.startsWith('https://')) {
                previewImg.src = val;
                previewImg.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }
        });
    }
})();
</script>
