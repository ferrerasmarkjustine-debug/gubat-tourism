<section class="section-padding bg-light" id="events-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Upcoming Tourism Festivals & Events</h2>
                <p class="text-muted">Plan your trip alongside Gubat's colorful celebrations, local sports tourneys, and province-wide cultural festivals.</p>
            </div>
        </div>

        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-lg-4">
                    <div class="card card-tourism h-100 bg-white">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                <span class="badge bg-warning text-dark fw-bold">
                                    <i class="bi bi-fire me-1"></i> Event
                                </span>
                                <div class="text-end">
                                    <h3 class="mb-0 fw-bold text-primary font-outfit">
                                        {{ $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date->format('d') : \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                    </h3>
                                    <small class="text-muted text-uppercase fw-bold">
                                        {{ $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date->format('M') : \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                    </small>
                                </div>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $event->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ $event->description }}</p>
                            <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                                <span><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}</span>
                                <span class="text-success fw-bold">
                                    <i class="bi bi-clock-history"></i> Upcoming
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
