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
                            <tbody>
                                @forelse($events as $event)
                                    @php
                                        $eDate = $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date : \Carbon\Carbon::parse($event->event_date);
                                        $isPast = $eDate->isPast();
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $event->title }}</div>
                                            <small class="text-muted">{{ Str::limit($event->description, 70) }}</small>
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
                                            <span class="small"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $event->location }}</span>
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
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                'label' => 'Event Banner / Poster Photo',
                                'helperText' => 'Select an event poster or photo from your computer (JPG, PNG, WebP up to 5MB).'
                            ])
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                    'label' => 'Event Banner / Poster Photo',
                                    'currentImage' => old('image_url', $event->image_url),
                                    'helperText' => 'Upload a new event photo to replace the current banner (JPG, PNG, WebP up to 5MB).'
                                ])
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
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                'label' => 'Announcement Photo / Infographic',
                                'helperText' => 'Select an advisory infographic or picture from your computer (JPG, PNG, WebP up to 5MB).'
                            ])
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                    'label' => 'Announcement Photo / Infographic',
                                    'currentImage' => old('image_url', $announcement->image_url),
                                    'helperText' => 'Upload a new infographic or photo to replace the current one (JPG, PNG, WebP up to 5MB).'
                                ])
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
@endsection
