@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 330px; background: linear-gradient(135deg, #4E342E 0%, #6D4C41 50%, #8D6E63 80%, #B45309 100%);">

    {{-- Decorative wave --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 50px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:relative;display:block;width:calc(100% + 1.3px);height:50px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z"
                  style="fill:#F4F7FA;"></path>
        </svg>
    </div>

    {{-- Floating decorative circles --}}
    <div class="position-absolute" style="width:280px;height:280px;background:rgba(255,255,255,0.04);border-radius:50%;top:-60px;right:-40px;"></div>
    <div class="position-absolute" style="width:180px;height:180px;background:rgba(255,255,255,0.06);border-radius:50%;bottom:-30px;left:8%;"></div>

    <div class="container position-relative py-5" style="z-index:3;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                {{-- Breadcrumb --}}
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none small">
                                <i class="bi bi-house-door me-1"></i>Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Crafts &amp; Livelihood</li>
                    </ol>
                </nav>

                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm" style="font-size:0.8rem;">
                    <i class="bi bi-tools me-1"></i> Indigenous Livelihood &amp; Heritage
                </span>
                <h1 class="display-5 fw-bold font-outfit text-white mb-3" style="line-height:1.2;text-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    Traditional <span class="text-warning">Crafts &amp; Livelihood</span>
                </h1>
                <p class="lead text-white-50 mb-0" style="max-width:620px;">
                    Experience the timeless artistry of Gubat. From resilient handwoven abaca products and ancestral terracotta clay pottery to artisanal delicacies and seaside woodwork.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div class="text-center" style="opacity:0.18;">
                    <i class="bi bi-tools" style="font-size:8.5rem; color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CATEGORY FILTER BAR
================================================================ --}}
<section class="py-4 bg-white border-bottom shadow-sm">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-muted"></i>
                <span class="fw-bold small text-uppercase text-muted">Filter by Craft:</span>
            </div>
            <div class="d-flex flex-wrap gap-2">
                @foreach($categories as $slug => $label)
                    <a href="{{ route('crafts', ['category' => $slug]) }}"
                       class="btn btn-sm rounded-pill px-3 py-2 fw-semibold transition-all {{ $selectedCategory === $slug ? 'btn-dark text-white shadow-sm' : 'btn-outline-secondary' }}">
                        @if($slug === 'all')
                            <i class="bi bi-grid-fill me-1"></i>
                        @elseif($slug === 'abaca')
                            <i class="bi bi-bag-check-fill me-1" style="color: #8D6E63;"></i>
                        @elseif($slug === 'pottery')
                            <i class="bi bi-cup-hot-fill me-1 text-warning"></i>
                        @elseif($slug === 'culinary')
                            <i class="bi bi-heart-fill me-1 text-success"></i>
                        @else
                            <i class="bi bi-hammer me-1 text-info"></i>
                        @endif
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CRAFTS SHOWCASE GRID
================================================================ --}}
<section class="section-padding bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($crafts as $craft)
                @php
                    $cImgUrl = \Illuminate\Support\Str::startsWith($craft->image_url ?? '', ['http://', 'https://']) 
                        ? $craft->image_url 
                        : asset($craft->image_url ?? 'images/crafts/craft_1793363252_ybYdopUBMG.jpg');
                @endphp
                <div class="col-lg-6">
                    <div class="card card-tourism h-100 p-3 shadow-sm border-0 craft-card-clickable" 
                         style="border-radius: 18px; cursor: pointer;"
                         data-bs-toggle="modal"
                         data-bs-target="#craftQuickViewModal"
                         data-title="{{ $craft->name }}"
                         data-category="{{ $craft->category_name }}"
                         data-badge-color="{{ $craft->badge_color }}"
                         data-highlight="{{ $craft->highlight }}"
                         data-desc="{{ $craft->description }}"
                         data-img="{{ $cImgUrl }}"
                         data-gallery="{{ json_encode($craft->gallery_images ?? []) }}"
                         data-products="{{ json_encode($craft->products ?? []) }}"
                         data-address="{{ $craft->address }}"
                         data-contact="{{ $craft->contact }}"
                         data-map="{{ $craft->google_map_url ?? 'https://maps.google.com/?q=' . urlencode($craft->name . ' Gubat Sorsogon') }}">
                        <div class="row g-0 h-100">
                            <div class="col-md-5 position-relative" style="min-height: 240px; border-radius: 14px; overflow: hidden;">
                                <img src="{{ $cImgUrl }}" alt="{{ $craft->name }}" class="w-100 h-100" style="object-fit: cover;">
                                <span class="badge position-absolute top-0 start-0 m-3 shadow-sm fw-bold px-3 py-2 rounded-pill" style="background-color: {{ $craft->badge_color }}; color: #ffffff; z-index: 2;">
                                    {{ $craft->category_name }}
                                </span>

                                @if(!empty($craft->gallery_images) && count($craft->gallery_images) > 0)
                                    <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 end-0 m-3 px-2 py-1 rounded-pill small shadow-sm" style="z-index: 2;">
                                        <i class="bi bi-images me-1"></i> {{ count($craft->gallery_images) + 1 }} Photos
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-7">
                                <div class="card-body p-3 p-md-4 d-flex flex-column h-100">
                                    <div class="mb-1">
                                        <span class="badge bg-light text-dark border small fw-semibold">
                                            <i class="bi bi-patch-check-fill text-warning me-1"></i> {{ $craft->highlight }}
                                        </span>
                                    </div>
                                    <h4 class="fw-bold font-outfit text-dark mb-2">{{ $craft->name }}</h4>
                                    <p class="text-muted small mb-3 flex-grow-1" style="line-height: 1.6;">
                                        {{ \Illuminate\Support\Str::limit($craft->description, 140) }}
                                    </p>

                                    {{-- Product highlights --}}
                                    @if(!empty($craft->products) && is_array($craft->products))
                                        <div class="mb-3">
                                            <small class="fw-bold text-uppercase text-muted d-block mb-1" style="font-size: 0.72rem;">Signature Products:</small>
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach(array_slice($craft->products, 0, 3) as $prod)
                                                    <span class="badge bg-white text-secondary border small px-2 py-1">
                                                        • {{ $prod }}
                                                    </span>
                                                @endforeach
                                                @if(count($craft->products) > 3)
                                                    <span class="badge bg-light text-muted border small px-2 py-1">+{{ count($craft->products) - 3 }} more</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div class="border-top pt-3 mt-auto d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <div>
                                            <small class="text-muted d-block">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $craft->address }}
                                            </small>
                                            @if(!empty($craft->contact))
                                                <small class="text-muted d-block">
                                                    <i class="bi bi-telephone-fill text-primary me-1"></i> {{ $craft->contact }}
                                                </small>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold btn-craft-quick-view shadow-sm" style="background: var(--primary-color, #0F4C81); border:none;">
                                                Explore <i class="bi bi-arrow-right-short ms-1"></i>
                                            </button>
                                            <a href="{{ $craft->google_map_url }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 fw-bold" onclick="event.stopPropagation();">
                                                Map <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 shadow-sm d-inline-block">
                        <i class="bi bi-search display-3 text-muted mb-3 d-block"></i>
                        <h4 class="fw-bold text-dark">No crafts found in this category</h4>
                        <p class="text-muted small mb-3">Try choosing a different filter above.</p>
                        <a href="{{ route('crafts') }}" class="btn btn-primary rounded-pill px-4">View All Crafts</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- LGU Community Artisan Support Callout --}}
        <div class="card mt-5 border-0 shadow-sm text-white overflow-hidden" style="background: linear-gradient(135deg, #0b2545 0%, #154c79 100%); border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill mb-3">Community Partnership</span>
                        <h3 class="fw-bold font-outfit text-white mb-2">Support Gubat's Local Producers &amp; Weavers</h3>
                        <p class="text-white-50 mb-0" style="max-width: 650px;">
                            By purchasing directly from Gubat's artisan associations, you empower local families, sustain traditional craft techniques passed through generations, and take home authentic handmade heritage pieces.
                        </p>
                    </div>
                    <div class="col-lg-4 text-center text-lg-end mt-4 mt-lg-0">
                        <a href="https://maps.google.com/?q=Gubat+Sorsogon" target="_blank" class="btn btn-warning btn-lg rounded-pill px-4 py-3 fw-bold text-dark shadow">
                            <i class="bi bi-compass-fill me-2"></i> Visit Artisan Studios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CRAFTS QUICK VIEW MODAL WITH HORIZONTAL MINI-TILE GALLERY
================================================================ --}}
<div class="modal fade" id="craftQuickViewModal" tabindex="-1" aria-labelledby="craftModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 overflow-hidden shadow-lg">
            {{-- Main Enlarged Photo Hero Area --}}
            <div class="position-relative bg-dark" style="height: 380px; overflow: hidden;">
                <img id="craftModalImg" src="" alt="Craft Photo" class="w-100 h-100" style="object-fit: cover; transition: opacity 0.25s ease;">
                
                {{-- Close Button --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 p-2 bg-dark bg-opacity-50 rounded-circle shadow" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10;"></button>
                
                {{-- Prev / Next Photo Overlay Controls --}}
                <button type="button" id="craftModalPrevBtn" class="btn btn-dark bg-opacity-50 text-white rounded-circle position-absolute top-50 start-0 translate-middle-y ms-3 p-0 d-none align-items-center justify-content-center shadow" style="width: 44px; height: 44px; z-index: 10;" title="Previous Photo">
                    <i class="bi bi-chevron-left fs-5"></i>
                </button>
                <button type="button" id="craftModalNextBtn" class="btn btn-dark bg-opacity-50 text-white rounded-circle position-absolute top-50 end-0 translate-middle-y me-3 p-0 d-none align-items-center justify-content-center shadow" style="width: 44px; height: 44px; z-index: 10;" title="Next Photo">
                    <i class="bi bi-chevron-right fs-5"></i>
                </button>

                {{-- Photo Counter Badge --}}
                <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                    <span id="craftModalPhotoCounter" class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill small fw-semibold shadow-sm d-none">
                        <i class="bi bi-camera-fill me-1"></i> <span id="craftModalCurrentIdx">1</span> / <span id="craftModalTotalCount">1</span>
                    </span>
                </div>

                {{-- Title & Category Gradient Overlay --}}
                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.5) 60%, transparent 100%); z-index: 5;">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span id="craftModalCategoryBadge" class="badge text-white px-3 py-1 rounded-pill shadow-sm small"></span>
                        <span id="craftModalHighlightBadge" class="badge bg-white bg-opacity-25 text-white px-3 py-1 rounded-pill small"></span>
                    </div>
                    <h2 id="craftModalTitle" class="text-white fw-bold mb-0 font-outfit fs-3"></h2>
                </div>
            </div>

            {{-- Horizontal Mini-Tile Thumbnail Strip (Scrollable Left to Right) --}}
            <div id="craftModalGalleryStrip" class="p-3 bg-light border-bottom d-none">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="small fw-bold text-dark">
                        <i class="bi bi-images text-primary me-1"></i> Craft Gallery <small class="text-muted fw-normal">(Click thumbnail to view)</small>
                    </span>
                    <small class="text-muted"><i class="bi bi-arrow-left-right me-1"></i>Scroll left / right</small>
                </div>
                <div id="craftModalThumbnails" class="d-flex gap-2" style="overflow-x: auto; scroll-behavior: smooth; padding-bottom: 6px;">
                    {{-- Mini tiles populated dynamically --}}
                </div>
            </div>

            <div class="modal-body p-4 p-md-5">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-2">
                    <span class="text-muted small">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> <span id="craftModalAddress"></span>
                    </span>
                    <span id="craftModalContactWrap" class="text-muted small d-none">
                        <i class="bi bi-telephone-fill text-primary me-1"></i> <span id="craftModalContact"></span>
                    </span>
                </div>

                <h6 class="fw-bold text-dark mb-2">Artisan Heritage & Craft Story</h6>
                <p id="craftModalDesc" class="text-secondary mb-4" style="line-height: 1.7; font-size: 0.95rem;"></p>

                {{-- Products Section --}}
                <div id="craftModalProductsSection" class="mb-4 d-none">
                    <h6 class="fw-bold text-dark mb-2">Signature Products & Goods</h6>
                    <div id="craftModalProductsList" class="d-flex flex-wrap gap-2"></div>
                </div>

                <div class="p-3 bg-light rounded-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div>
                        <span class="fw-bold text-dark d-block small">Support Local Makers</span>
                        <small class="text-muted">Direct community purchases help sustain Gubat's traditional artisan cooperatives.</small>
                    </div>
                    <a id="craftModalMapBtn" href="#" target="_blank" class="btn btn-primary rounded-pill px-4 fw-bold btn-sm shadow-sm" style="background: var(--primary-color, #0F4C81); border:none;">
                        <i class="bi bi-compass me-1"></i> View Workshop on Maps
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let craftPhotos = [];
    let craftActiveIdx = 0;

    const cImg = document.getElementById('craftModalImg');
    const cPrevBtn = document.getElementById('craftModalPrevBtn');
    const cNextBtn = document.getElementById('craftModalNextBtn');
    const cCounter = document.getElementById('craftModalPhotoCounter');
    const cCurrentSpan = document.getElementById('craftModalCurrentIdx');
    const cTotalSpan = document.getElementById('craftModalTotalCount');
    const cStrip = document.getElementById('craftModalGalleryStrip');
    const cThumbs = document.getElementById('craftModalThumbnails');

    function displayCraftPhoto(idx) {
        if (!craftPhotos.length) return;
        craftActiveIdx = (idx + craftPhotos.length) % craftPhotos.length;
        cImg.style.opacity = '0.4';
        setTimeout(() => {
            cImg.src = craftPhotos[craftActiveIdx];
            cImg.style.opacity = '1';
        }, 120);

        if (cCurrentSpan) cCurrentSpan.textContent = craftActiveIdx + 1;

        if (cThumbs) {
            Array.from(cThumbs.children).forEach((thumb, i) => {
                if (i === craftActiveIdx) {
                    thumb.style.borderColor = '#0F4C81';
                    thumb.style.boxShadow = '0 0 0 2px rgba(15, 76, 129, 0.4)';
                    thumb.style.transform = 'scale(1.05)';
                    thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                } else {
                    thumb.style.borderColor = 'transparent';
                    thumb.style.boxShadow = 'none';
                    thumb.style.transform = 'scale(1)';
                }
            });
        }
    }

    if (cPrevBtn) {
        cPrevBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            displayCraftPhoto(craftActiveIdx - 1);
        });
    }

    if (cNextBtn) {
        cNextBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            displayCraftPhoto(craftActiveIdx + 1);
        });
    }

    document.addEventListener('keydown', function (e) {
        const modalEl = document.getElementById('craftQuickViewModal');
        if (modalEl && modalEl.classList.contains('show') && craftPhotos.length > 1) {
            if (e.key === 'ArrowLeft') displayCraftPhoto(craftActiveIdx - 1);
            else if (e.key === 'ArrowRight') displayCraftPhoto(craftActiveIdx + 1);
        }
    });

    function openCraftModal(target) {
        const title = target.getAttribute('data-title');
        const cat = target.getAttribute('data-category');
        const badgeColor = target.getAttribute('data-badge-color');
        const highlight = target.getAttribute('data-highlight');
        const desc = target.getAttribute('data-desc');
        const coverImg = target.getAttribute('data-img');
        const address = target.getAttribute('data-address');
        const contact = target.getAttribute('data-contact');
        const mapUrl = target.getAttribute('data-map');

        let rawGallery = target.getAttribute('data-gallery');
        let galleryImgs = [];
        try {
            if (rawGallery) galleryImgs = JSON.parse(rawGallery);
        } catch (err) {
            galleryImgs = [];
        }

        let rawProducts = target.getAttribute('data-products');
        let products = [];
        try {
            if (rawProducts) products = JSON.parse(rawProducts);
        } catch (err) {
            products = [];
        }

        craftPhotos = [];
        if (coverImg) craftPhotos.push(coverImg);
        if (Array.isArray(galleryImgs)) {
            galleryImgs.forEach(g => {
                if (g && !craftPhotos.includes(g)) {
                    craftPhotos.push(g.startsWith('http') ? g : ('/' + g.replace(/^\//, '')));
                }
            });
        }

        document.getElementById('craftModalTitle').textContent = title || '';
        document.getElementById('craftModalDesc').textContent = desc || '';
        document.getElementById('craftModalAddress').textContent = address || 'Gubat, Sorsogon';
        document.getElementById('craftModalMapBtn').href = mapUrl || '#';

        const catBadge = document.getElementById('craftModalCategoryBadge');
        if (catBadge) {
            catBadge.textContent = cat || 'Craft';
            catBadge.style.backgroundColor = badgeColor || '#8D6E63';
        }

        const highBadge = document.getElementById('craftModalHighlightBadge');
        if (highBadge) {
            if (highlight) {
                highBadge.textContent = highlight;
                highBadge.classList.remove('d-none');
            } else {
                highBadge.classList.add('d-none');
            }
        }

        const contactWrap = document.getElementById('craftModalContactWrap');
        const contactSpan = document.getElementById('craftModalContact');
        if (contact && contact.trim()) {
            contactSpan.textContent = contact;
            contactWrap.classList.remove('d-none');
        } else {
            contactWrap.classList.add('d-none');
        }

        // Products
        const prodSec = document.getElementById('craftModalProductsSection');
        const prodList = document.getElementById('craftModalProductsList');
        if (prodList) {
            prodList.replaceChildren();
            if (Array.isArray(products) && products.length > 0) {
                prodSec.classList.remove('d-none');
                products.forEach(p => {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-white text-dark border px-3 py-2 rounded-pill small shadow-sm';
                    badge.textContent = '• ' + p;
                    prodList.appendChild(badge);
                });
            } else {
                prodSec.classList.add('d-none');
            }
        }

        // Thumbnails
        if (cThumbs) cThumbs.replaceChildren();

        if (craftPhotos.length > 1) {
            if (cStrip) cStrip.classList.remove('d-none');
            if (cPrevBtn) cPrevBtn.classList.replace('d-none', 'd-flex');
            if (cNextBtn) cNextBtn.classList.replace('d-none', 'd-flex');
            if (cCounter) cCounter.classList.remove('d-none');
            if (cTotalSpan) cTotalSpan.textContent = craftPhotos.length;

            craftPhotos.forEach((pUrl, pIdx) => {
                const thumbWrap = document.createElement('div');
                thumbWrap.className = 'border rounded-3 p-1 bg-white shadow-sm flex-shrink-0';
                thumbWrap.style.cssText = 'width: 85px; height: 60px; overflow: hidden; cursor: pointer; transition: all 0.2s ease; border-width: 2px;';
                
                const thumbImg = document.createElement('img');
                thumbImg.src = pUrl;
                thumbImg.className = 'w-100 h-100 rounded-2';
                thumbImg.style.objectFit = 'cover';
                thumbWrap.appendChild(thumbImg);

                thumbWrap.addEventListener('click', function(e) {
                    e.stopPropagation();
                    displayCraftPhoto(pIdx);
                });

                cThumbs.appendChild(thumbWrap);
            });
        } else {
            if (cStrip) cStrip.classList.add('d-none');
            if (cPrevBtn) cPrevBtn.classList.replace('d-flex', 'd-none');
            if (cNextBtn) cNextBtn.classList.replace('d-flex', 'd-none');
            if (cCounter) cCounter.classList.add('d-none');
        }

        displayCraftPhoto(0);
    }

    document.querySelectorAll('.craft-card-clickable, .btn-craft-quick-view').forEach(function (el) {
        el.addEventListener('click', function () {
            const target = this.hasAttribute('data-title') ? this : this.closest('.craft-card-clickable');
            if (target) openCraftModal(target);
        });
    });
});
</script>

@endsection
