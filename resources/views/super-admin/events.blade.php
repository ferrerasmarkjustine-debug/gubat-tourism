@extends('layouts.admin')

@section('content')
<div class="pb-5">
    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Events &amp; News</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Events &amp; Announcements Management</h2>
                <p class="text-muted mb-0">Schedule municipal festivals, surf competitions, and publish official LGU tourism advisories.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createEventModal">
                    <i class="bi bi-calendar-plus me-1"></i> Add Event
                </button>
                <button type="button" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">
                    <i class="bi bi-megaphone me-1"></i> Post Announcement
                </button>
                <a href="{{ route('events') }}" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-eye me-1"></i> View Public Page
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Nav Tabs -->
        <ul class="nav nav-pills mb-4 gap-2" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-semibold" id="events-tab" data-bs-toggle="pill" data-bs-target="#events-pane" type="button" role="tab" aria-controls="events-pane" aria-selected="true">
                    <i class="bi bi-calendar-event me-2"></i> Festivals &amp; Events ({{ count($events) }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold" id="announcements-tab" data-bs-toggle="pill" data-bs-target="#announcements-pane" type="button" role="tab" aria-controls="announcements-pane" aria-selected="false">
                    <i class="bi bi-megaphone me-2"></i> LGU Announcements ({{ count($announcements) }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="eventTabsContent">
            <!-- Pane 1: Events -->
            <div class="tab-pane fade show active" id="events-pane" role="tabpanel" aria-labelledby="events-tab" tabindex="0">
                <!-- Page-Specific Live Table Search & Quick Filter Toolbar -->
                <div class="card border-0 shadow-sm rounded-4 mb-3 bg-white p-3">
                    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
                        <div class="position-relative flex-grow-1" style="max-width: 520px;">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" id="eventSearchInput" class="form-control rounded-pill ps-5 pe-5 py-2 border bg-light bg-opacity-50"
                                   placeholder="Search events by title, location, or description..." autocomplete="off">
                            <button type="button" id="eventSearchClear" class="btn btn-sm btn-link text-muted position-absolute top-50 end-0 translate-middle-y me-2 p-0 text-decoration-none" style="display: none;" title="Clear search">
                                <i class="bi bi-x-circle-fill fs-5"></i>
                            </button>
                        </div>
                        <div class="small text-muted" id="eventSearchCounter">
                            Showing <strong class="text-dark">{{ count($events) }}</strong> of <strong class="text-dark">{{ count($events) }}</strong> records
                        </div>
                    </div>

                    <!-- Quick Filter Pills -->
                    <div class="d-flex align-items-center gap-1.5 flex-wrap mt-3 pt-2 border-top">
                        <span class="text-muted small fw-semibold me-2"><i class="bi bi-funnel me-1"></i>Filters:</span>
                        <button type="button" class="btn btn-xs rounded-pill px-3 py-1 fw-semibold event-filter-pill active btn-primary text-white" data-filter="all">All</button>
                        <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted event-filter-pill" data-filter="upcoming">Upcoming Events</button>
                        <button type="button" class="btn btn-xs rounded-pill px-3 py-1 btn-light text-muted event-filter-pill" data-filter="completed">Completed / Past</button>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Event Details</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="eventsTableBody">
                                @forelse($events as $event)
                                    @php
                                        $eDate = $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date : \Carbon\Carbon::parse($event->event_date);
                                        $isPast = $eDate->isPast();
                                        $statusStr = $isPast ? 'completed' : 'upcoming';
                                    @endphp
                                    <tr class="event-row"
                                        data-search="{{ strtolower($event->title . ' ' . $event->location . ' ' . $event->description . ' ' . $eDate->format('F d Y') . ' ' . $statusStr) }}"
                                        data-category="{{ $statusStr }}"
                                        data-status="{{ $statusStr }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark event-highlight-target">{{ $event->title }}</div>
                                            <small class="text-muted event-highlight-target">{{ Str::limit($event->description, 70) }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 rounded-3 text-center" style="min-width: 50px;">
                                                    <div class="fw-bold fs-6">{{ $eDate->format('d') }}</div>
                                                    <div class="small text-uppercase" style="font-size: 0.65rem;">{{ $eDate->format('M Y') }}</div>
                                                </div>
                                                <span class="small text-muted d-none d-md-inline">{{ $eDate->format('l') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="small event-highlight-target"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $event->location }}</span>
                                        </td>
                                        <td>
                                            @if($isPast)
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border rounded-pill px-3 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Completed
                                                </span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1">
                                                    <i class="bi bi-clock-history me-1"></i> Upcoming
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editEventModal-{{ $event->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete event: {{ addslashes($event->title) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Delete Event">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">No events recorded. Click "Add Event" to create one.</td>
                                    </tr>
                                @endforelse

                                {{-- Friendly Live Search Empty State --}}
                                <tr id="eventSearchEmptyRow" class="empty-state-row" style="display: none;">
                                    <td colspan="5" class="text-center py-5 bg-white">
                                        <i class="bi bi-search text-muted display-6 d-block mb-2"></i>
                                        <h6 class="fw-bold text-dark">No records found matching <span class="empty-state-term text-primary"></span></h6>
                                        <p class="text-muted small mb-3">Try adjusting your search terms or clearing the active filters.</p>
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="resetSearch_eventSearchInput()">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Search
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pane 2: Announcements -->
            <div class="tab-pane fade" id="announcements-pane" role="tabpanel" aria-labelledby="announcements-tab" tabindex="0">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Category</th>
                                    <th>Announcement Title &amp; Details</th>
                                    <th>Published Date</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td class="ps-4" style="width: 180px;">
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill">
                                                <i class="bi bi-tag-fill me-1"></i> {{ $announcement->category }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $announcement->title }}</div>
                                            <small class="text-muted">{{ Str::limit($announcement->content, 90) }}</small>
                                        </td>
                                        <td>
                                            <span class="small text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $announcement->published_at ? $announcement->published_at->format('M j, Y') : 'Draft' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal-{{ $announcement->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete announcement: {{ addslashes($announcement->title) }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2" title="Delete Announcement">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No announcements published yet. Click "Post Announcement" to create one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==========================================
     MODALS: CREATE EVENT
========================================== -->
<!-- ==========================================
     MODALS: CREATE EVENT
========================================== -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold text-dark" id="createEventModalLabel">
                    <i class="bi bi-calendar-plus text-primary me-2"></i> Add New Festival / Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold text-muted">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. Gubat Surf Nationals" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" name="event_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold text-muted">Location / Venue <span class="text-danger">*</span></label>
                                    <input type="text" name="location" class="form-control rounded-3" placeholder="e.g. Rizal Beach Surfing Hub" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted">Municipality</label>
                                    <select name="municipality_id" class="form-select rounded-3">
                                        @foreach($municipalities as $mun)
                                            <option value="{{ $mun->id }}" {{ $mun->name === 'Gubat' ? 'selected' : '' }}>{{ $mun->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Description</label>
                                    <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Provide full details about activities, schedule, and attractions..."></textarea>
                                </div>
                                <div class="col-12">
                                    @include('partials.image-uploader', [
                                        'id' => 'event_create',
                                        'label' => 'Event Banner / Poster Photo (Optional)',
                                        'helperText' => 'Select an event poster or photo from your computer (JPG, PNG, WebP up to 5MB).'
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Live Card Preview Column -->
                        <div class="col-lg-5 align-self-start">
                            <div class="sticky-top" style="top: 15px;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                        <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                    </span>
                                    <small class="text-muted">Public event card</small>
                                </div>

                                <div class="card card-tourism bg-white border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="live-event-img-wrap" style="height: 160px; overflow: hidden; display: none;">
                                        <img src="" alt="Event Banner" class="w-100 h-100 live-event-img" style="object-fit: cover;">
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        {{-- Date badge + label --}}
                                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                            <span class="badge bg-warning text-dark fw-bold">
                                                <i class="bi bi-fire me-1"></i> Event
                                            </span>
                                            <div class="text-end">
                                                <h3 class="mb-0 fw-bold text-primary font-outfit live-event-day">{{ date('d') }}</h3>
                                                <small class="text-muted text-uppercase fw-bold live-event-month">{{ strtoupper(date('M Y')) }}</small>
                                            </div>
                                        </div>

                                        <h5 class="fw-bold text-dark mb-2 live-event-title">Festival / Event Title</h5>
                                        <p class="text-muted small live-event-desc mb-3">Details about festival activities, attractions, and schedules...</p>

                                        <div class="pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                                            <span><i class="bi bi-geo-alt-fill text-danger me-1"></i><span class="live-event-loc">Venue Location</span></span>
                                            <span class="badge bg-success text-white px-2 py-1 rounded-pill">
                                                <i class="bi bi-clock-history me-1"></i> Upcoming
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     MODALS: EDIT EVENTS
========================================== -->
@foreach($events as $event)
    <div class="modal fade" id="editEventModal-{{ $event->id }}" tabindex="-1" aria-labelledby="editEventModalLabel-{{ $event->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark" id="editEventModalLabel-{{ $event->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Edit Event: {{ $event->title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-3">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Event Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $event->title) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Event Date <span class="text-danger">*</span></label>
                                        @php
                                            $rawDate = $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date->format('Y-m-d') : substr((string)$event->event_date, 0, 10);
                                        @endphp
                                        <input type="date" name="event_date" class="form-control rounded-3" value="{{ old('event_date', $rawDate) }}" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Location / Venue <span class="text-danger">*</span></label>
                                        <input type="text" name="location" class="form-control rounded-3" value="{{ old('location', $event->location) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Municipality</label>
                                        <select name="municipality_id" class="form-select rounded-3">
                                            @foreach($municipalities as $mun)
                                                <option value="{{ $mun->id }}" {{ $event->municipality_id == $mun->id ? 'selected' : '' }}>{{ $mun->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Description</label>
                                        <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $event->description) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        @include('partials.image-uploader', [
                                            'id' => 'event_edit_' . $event->id,
                                            'label' => 'Event Banner / Poster Photo (Optional)',
                                            'currentImage' => old('image_url', $event->image_url),
                                            'helperText' => 'Upload a new event photo to replace current banner (JPG, PNG, WebP up to 5MB).'
                                        ])
                                    </div>
                                </div>
                            </div>

                            <!-- Live Card Preview Column -->
                            <div class="col-lg-5 align-self-start">
                                <div class="sticky-top" style="top: 15px;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                        </span>
                                        <small class="text-muted">Public event card</small>
                                    </div>

                                    @php
                                        $eParsed = $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date : \Carbon\Carbon::parse($event->event_date);
                                    @endphp

                                    <div class="card card-tourism bg-white border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div class="live-event-img-wrap" style="height: 160px; overflow: hidden; {{ $event->image_url ? '' : 'display: none;' }}">
                                            <img src="{{ $event->image_url ? asset($event->image_url) : '' }}" alt="Event Banner" class="w-100 h-100 live-event-img" style="object-fit: cover;">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                                <span class="badge bg-warning text-dark fw-bold">
                                                    <i class="bi bi-fire me-1"></i> Event
                                                </span>
                                                <div class="text-end">
                                                    <h3 class="mb-0 fw-bold text-primary font-outfit live-event-day">{{ $eParsed->format('d') }}</h3>
                                                    <small class="text-muted text-uppercase fw-bold live-event-month">{{ $eParsed->format('M Y') }}</small>
                                                </div>
                                            </div>

                                            <h5 class="fw-bold text-dark mb-2 live-event-title">{{ $event->title }}</h5>
                                            <p class="text-muted small live-event-desc mb-3">{{ $event->description }}</p>

                                            <div class="pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                                                <span><i class="bi bi-geo-alt-fill text-danger me-1"></i><span class="live-event-loc">{{ $event->location }}</span></span>
                                                <span class="badge bg-success text-white px-2 py-1 rounded-pill">
                                                    <i class="bi bi-clock-history me-1"></i> Upcoming
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Update Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- ==========================================
     MODALS: CREATE ANNOUNCEMENT
========================================== -->
<div class="modal fade" id="createAnnouncementModal" tabindex="-1" aria-labelledby="createAnnouncementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom px-4 pt-4 pb-3">
                <h5 class="modal-title fw-bold text-dark" id="createAnnouncementModalLabel">
                    <i class="bi bi-megaphone text-success me-2"></i> Post LGU Tourism Announcement
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold text-muted">Announcement Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. LGU Launches Eco-Tourism Green Guidelines" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                    <input type="text" name="category" list="announcementCategoryList" class="form-control rounded-3" placeholder="e.g. Eco Guidelines" required>
                                    <datalist id="announcementCategoryList">
                                        <option value="Eco Guidelines">
                                        <option value="Tourism Event">
                                        <option value="Environment">
                                        <option value="Public Advisory">
                                        <option value="Festival Notice">
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Publication Date</label>
                                    <input type="date" name="published_at" class="form-control rounded-3" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted">Announcement Content <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control rounded-3" rows="4" placeholder="Enter complete policy notice, rules, or advisory details..." required></textarea>
                                </div>
                                <div class="col-12">
                                    @include('partials.image-uploader', [
                                        'id' => 'announcement_create',
                                        'label' => 'Announcement Photo / Infographic (Optional)',
                                        'helperText' => 'Select an advisory infographic or picture from your computer (JPG, PNG, WebP up to 5MB).'
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Live Card Preview Column -->
                        <div class="col-lg-5 align-self-start">
                            <div class="sticky-top" style="top: 15px;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-semibold">
                                        <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                    </span>
                                    <small class="text-muted">Public announcement card</small>
                                </div>

                                <div class="card card-tourism bg-white border-0 shadow-sm rounded-4 overflow-hidden">
                                    <div class="live-ann-img-wrap" style="height: 160px; overflow: hidden; display: none;">
                                        <img src="" alt="Infographic" class="w-100 h-100 live-ann-img" style="object-fit: cover;">
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="badge bg-primary text-white live-ann-cat">
                                                <i class="bi bi-megaphone-fill me-1"></i> Notice
                                            </span>
                                            <span class="small text-muted live-ann-date">
                                                {{ date('F d, Y') }}
                                            </span>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-2 live-ann-title">Announcement Title</h5>
                                        <p class="text-muted small live-ann-content mb-3">Announcement details, official circular or tourism guidelines...</p>
                                        <span class="text-primary btn btn-link p-0 btn-sm fw-bold align-self-start">
                                            Read Full Details <i class="bi bi-arrow-right ms-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
                        <i class="bi bi-send me-1"></i> Publish Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==========================================
     MODALS: EDIT ANNOUNCEMENTS
========================================== -->
@foreach($announcements as $announcement)
    <div class="modal fade" id="editAnnouncementModal-{{ $announcement->id }}" tabindex="-1" aria-labelledby="editAnnouncementModalLabel-{{ $announcement->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark" id="editAnnouncementModalLabel-{{ $announcement->id }}">
                        <i class="bi bi-pencil-square text-success me-2"></i> Edit Announcement: {{ $announcement->title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-3">
                        <div class="row g-4">
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label small fw-bold text-muted">Announcement Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control rounded-3" value="{{ old('title', $announcement->title) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                        <input type="text" name="category" list="announcementCategoryList" class="form-control rounded-3" value="{{ old('category', $announcement->category) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Publication Date</label>
                                        @php
                                            $rawPubDate = $announcement->published_at ? $announcement->published_at->format('Y-m-d') : date('Y-m-d');
                                        @endphp
                                        <input type="date" name="published_at" class="form-control rounded-3" value="{{ old('published_at', $rawPubDate) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">Announcement Content <span class="text-danger">*</span></label>
                                        <textarea name="content" class="form-control rounded-3" rows="4" required>{{ old('content', $announcement->content) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        @include('partials.image-uploader', [
                                            'id' => 'announcement_edit_' . $announcement->id,
                                            'label' => 'Announcement Photo / Infographic (Optional)',
                                            'currentImage' => old('image_url', $announcement->image_url),
                                            'helperText' => 'Upload a new infographic or photo to replace the current one (JPG, PNG, WebP up to 5MB).'
                                        ])
                                    </div>
                                </div>
                            </div>

                            <!-- Live Card Preview Column -->
                            <div class="col-lg-5 align-self-start">
                                <div class="sticky-top" style="top: 15px;">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-1 rounded-pill fw-semibold">
                                            <i class="bi bi-eye-fill me-1"></i> Live Card Preview
                                        </span>
                                        <small class="text-muted">Public announcement card</small>
                                    </div>

                                    <div class="card card-tourism bg-white border-0 shadow-sm rounded-4 overflow-hidden">
                                        <div class="live-ann-img-wrap" style="height: 160px; overflow: hidden; {{ $announcement->image_url ? '' : 'display: none;' }}">
                                            <img src="{{ $announcement->image_url ? asset($announcement->image_url) : '' }}" alt="Infographic" class="w-100 h-100 live-ann-img" style="object-fit: cover;">
                                        </div>
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <span class="badge bg-primary text-white live-ann-cat">
                                                    <i class="bi bi-megaphone-fill me-1"></i> {{ $announcement->category }}
                                                </span>
                                                <span class="small text-muted live-ann-date">
                                                    {{ $announcement->published_at ? $announcement->published_at->format('F d, Y') : date('F d, Y') }}
                                                </span>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-2 live-ann-title">{{ $announcement->title }}</h5>
                                            <p class="text-muted small live-ann-content mb-3">{{ Str::limit($announcement->content, 120) }}</p>
                                            <span class="text-primary btn btn-link p-0 btn-sm fw-bold align-self-start">
                                                Read Full Details <i class="bi bi-arrow-right ms-1"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Update Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Event Sync
    function initEventSync(modalSelector, uploaderId) {
        const modal = document.querySelector(modalSelector);
        if (!modal) return;
        const titleInput = modal.querySelector('input[name="title"]');
        const dateInput = modal.querySelector('input[name="event_date"]');
        const locInput = modal.querySelector('input[name="location"]');
        const descInput = modal.querySelector('textarea[name="description"]');

        const prevTitle = modal.querySelector('.live-event-title');
        const prevDay = modal.querySelector('.live-event-day');
        const prevMonth = modal.querySelector('.live-event-month');
        const prevLoc = modal.querySelector('.live-event-loc');
        const prevDesc = modal.querySelector('.live-event-desc');
        const prevImg = modal.querySelector('.live-event-img');
        const prevImgWrap = modal.querySelector('.live-event-img-wrap');

        function update() {
            if (prevTitle && titleInput) prevTitle.textContent = titleInput.value.trim() || 'Festival / Event Title';
            if (dateInput && dateInput.value) {
                const parts = dateInput.value.split('-');
                if (parts.length === 3) {
                    const d = new Date(parts[0], parts[1] - 1, parts[2]);
                    if (!isNaN(d.getTime())) {
                        if (prevDay) prevDay.textContent = d.getDate().toString().padStart(2, '0');
                        if (prevMonth) prevMonth.textContent = d.toLocaleString('en-US', { month: 'short', year: 'numeric' }).toUpperCase();
                    }
                }
            }
            if (prevLoc && locInput) prevLoc.textContent = locInput.value.trim() || 'Venue Location';
            if (prevDesc && descInput) {
                const t = descInput.value.trim();
                prevDesc.textContent = t ? (t.length > 90 ? t.substring(0, 90) + '...' : t) : 'Details about festival activities, attractions, and schedules...';
            }
        }

        [titleInput, dateInput, locInput, descInput].forEach(el => {
            if (el) {
                el.addEventListener('input', update);
                el.addEventListener('change', update);
            }
        });

        window.addEventListener('tourist-image-updated', function(e) {
            if (e.detail && e.detail.src && e.detail.uploaderId === uploaderId) {
                if (prevImg) prevImg.src = e.detail.src;
                if (prevImgWrap) prevImgWrap.style.display = 'block';
            }
        });

        update();
    }

    initEventSync('#createEventModal', 'event_create');
    @foreach($events as $event)
        initEventSync('#editEventModal-{{ $event->id }}', 'event_edit_{{ $event->id }}');
    @endforeach

    // Announcement Sync
    function initAnnSync(modalSelector, uploaderId) {
        const modal = document.querySelector(modalSelector);
        if (!modal) return;
        const titleInput = modal.querySelector('input[name="title"]');
        const catInput = modal.querySelector('input[name="category"]');
        const dateInput = modal.querySelector('input[name="published_at"]');
        const contentInput = modal.querySelector('textarea[name="content"]');

        const prevTitle = modal.querySelector('.live-ann-title');
        const prevCat = modal.querySelector('.live-ann-cat');
        const prevDate = modal.querySelector('.live-ann-date');
        const prevContent = modal.querySelector('.live-ann-content');
        const prevImg = modal.querySelector('.live-ann-img');
        const prevImgWrap = modal.querySelector('.live-ann-img-wrap');

        function update() {
            if (prevTitle && titleInput) prevTitle.textContent = titleInput.value.trim() || 'Announcement Title';
            if (prevCat && catInput) prevCat.innerHTML = `<i class="bi bi-megaphone-fill me-1"></i> ${catInput.value.trim() || 'Notice'}`;
            if (dateInput && dateInput.value) {
                const parts = dateInput.value.split('-');
                if (parts.length === 3) {
                    const d = new Date(parts[0], parts[1] - 1, parts[2]);
                    if (!isNaN(d.getTime())) {
                        if (prevDate) prevDate.textContent = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                    }
                }
            }
            if (prevContent && contentInput) {
                const t = contentInput.value.trim();
                prevContent.textContent = t ? (t.length > 110 ? t.substring(0, 110) + '...' : t) : 'Announcement details, official circular or tourism guidelines...';
            }
        }

        [titleInput, catInput, dateInput, contentInput].forEach(el => {
            if (el) {
                el.addEventListener('input', update);
                el.addEventListener('change', update);
            }
        });

        window.addEventListener('tourist-image-updated', function(e) {
            if (e.detail && e.detail.src && e.detail.uploaderId === uploaderId) {
                if (prevImg) prevImg.src = e.detail.src;
                if (prevImgWrap) prevImgWrap.style.display = 'block';
            }
        });

        update();
    }

    initAnnSync('#createAnnouncementModal', 'announcement_create');
    @foreach($announcements as $announcement)
        initAnnSync('#editAnnouncementModal-{{ $announcement->id }}', 'announcement_edit_{{ $announcement->id }}');
    @endforeach

    // Initialize Level A live table search for Events
    initLiveTableFilter({
        inputId: 'eventSearchInput',
        clearBtnId: 'eventSearchClear',
        counterId: 'eventSearchCounter',
        emptyStateId: 'eventSearchEmptyRow',
        containerId: 'eventsTableBody',
        rowSelector: 'tr.event-row',
        pillSelector: '.event-filter-pill',
        highlightSelector: '.event-highlight-target'
    });
});
</script>
@endsection
