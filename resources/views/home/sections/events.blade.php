<section class="section-padding bg-light" id="events-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Upcoming Tourism Festivals &amp; Events</h2>
                <p class="text-muted">Plan your trip alongside Gubat's colorful celebrations, local sports tourneys, and province-wide cultural festivals.</p>
                @if(Auth::check() && Auth::user()->isLguAdmin())
                    <div class="admin-section-controls d-flex align-items-center justify-content-center gap-2 mt-3">
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm fw-semibold">
                            <i class="bi bi-plus-circle me-1"></i> Add Event
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                            <i class="bi bi-gear-fill me-1"></i> Manage Events
                        </a>
                        <span class="badge bg-secondary rounded-pill px-3 py-2 fw-semibold" style="font-size:0.75rem;">
                            {{ $events->count() }} Events
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4">
            @foreach($events as $event)
                @php
                    $eParsed = $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date : \Carbon\Carbon::parse($event->event_date);
                    $eCover = $event->image_url 
                        ? (str_starts_with($event->image_url, 'http') ? $event->image_url : asset($event->image_url)) 
                        : asset('images/destinations/rizal_beach.jpg');
                    $eGallery = is_array($event->gallery_images) ? $event->gallery_images : [];
                    $eDateFormatted = $eParsed->format('F d, Y');
                @endphp
                <div class="col-lg-4">
                    <div class="card card-tourism h-100 bg-white home-event-card-clickable overflow-hidden position-relative"
                         style="cursor: pointer; transition: transform 0.25s ease, box-shadow 0.25s ease;"
                         data-id="{{ $event->id }}"
                         data-title="{{ $event->title }}"
                         data-date="{{ $eDateFormatted }}"
                         data-location="{{ $event->location }}"
                         data-desc="{{ $event->description }}"
                         data-cover="{{ $eCover }}"
                         data-gallery="{{ json_encode($eGallery) }}"
                         data-map="https://maps.google.com/?q={{ urlencode($event->location . ' Gubat Sorsogon') }}">
                        @if(Auth::check() && Auth::user()->isLguAdmin() && isset($event->id))
                            <div class="admin-card-overlay">
                                <a href="{{ route('admin.events.index') }}" class="admin-card-btn admin-card-btn-warning text-decoration-none" onclick="event.stopPropagation();" title="Manage this event">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                            </div>
                        @endif
                        @if($event->image_url)
                            <div class="position-relative" style="height: 180px; overflow: hidden;">
                                <img src="{{ $eCover }}" alt="{{ $event->title }}" class="w-100 h-100" style="object-fit: cover;">
                                @if(!empty($eGallery) && count($eGallery) > 0)
                                    <div class="position-absolute top-0 end-0 m-2" style="z-index: 3;">
                                        <span class="badge bg-dark bg-opacity-75 text-white px-2 py-1 rounded-pill small shadow-sm">
                                            <i class="bi bi-images me-1"></i> {{ count($eGallery) + 1 }} Photos
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                <span class="badge bg-warning text-dark fw-bold">
                                    <i class="bi bi-fire me-1"></i> Tourism Event
                                </span>
                                <div class="text-end">
                                    <h3 class="mb-0 fw-bold text-primary font-outfit">
                                        {{ $eParsed->format('d') }}
                                    </h3>
                                    <small class="text-muted text-uppercase fw-bold">
                                        {{ $eParsed->format('M Y') }}
                                    </small>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $event->title }}</h5>
                            <p class="text-muted small flex-grow-1 mb-3">{{ Str::limit($event->description, 110) }}</p>
                            <div class="mt-auto pt-3 border-top d-flex align-items-center text-muted small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> <span>{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
