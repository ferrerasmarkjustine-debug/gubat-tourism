@extends('layouts.guest')

@section('content')

{{-- ================================================================
     PAGE HERO
================================================================ --}}
<section class="position-relative text-white overflow-hidden d-flex align-items-center"
         style="min-height: 320px; background: linear-gradient(135deg, #7c2d12 0%, #c0392b 60%, #9b59b6 100%);">

    {{-- Decorative wave --}}
    <div class="position-absolute bottom-0 start-0 w-100 overflow-hidden" style="height: 50px; z-index: 2; transform: translateY(1px);">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="position:relative;display:block;width:calc(100% + 1.3px);height:50px;">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,86.64,25.8,168,46.7,250.75,67.8,321.39,56.44Z"
                  style="fill:#F4F7FA;"></path>
        </svg>
    </div>

    {{-- Decorative circles --}}
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
                        <li class="breadcrumb-item active text-warning small" aria-current="page">Events</li>
                    </ol>
                </nav>

                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm" style="font-size:0.8rem;">
                    <i class="bi bi-calendar-event me-1"></i> Upcoming in Gubat
                </span>
                <h1 class="display-5 fw-bold font-outfit text-white mb-3" style="line-height:1.2;text-shadow:0 4px 15px rgba(0,0,0,0.3);">
                    Events &amp; <span class="text-warning">Festivals</span>
                </h1>
                <p class="lead text-white-50 mb-0" style="max-width:600px;">
                    Plan your visit around Gubat's vibrant cultural celebrations, surfing competitions, and province-wide festivals that showcase the true spirit of Sorsogon.
                </p>
            </div>
            <div class="col-lg-4 d-none d-lg-flex justify-content-end">
                <div class="text-center" style="opacity:0.15;">
                    <i class="bi bi-calendar-heart" style="font-size:9rem; color:white;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     UPCOMING EVENTS — Full Listing
================================================================ --}}
<section class="section-padding bg-light" id="events-full-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="section-title">Upcoming Tourism Festivals &amp; Events</h2>
                <p class="text-muted">All scheduled events in and around Gubat, Sorsogon — from surfing competitions to cultural heritage fiestas.</p>
            </div>
        </div>

        @if($events->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h5 class="fw-bold text-muted mt-3">No upcoming events at the moment.</h5>
                <p class="text-muted">Check back soon for new events and festivals!</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-tourism h-100 bg-white">
                            <div class="card-body p-4 d-flex flex-column">
                                {{-- Date badge + label --}}
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                    <span class="badge bg-warning text-dark fw-bold">
                                        <i class="bi bi-fire me-1"></i> Event
                                    </span>
                                    <div class="text-end">
                                        <h3 class="mb-0 fw-bold text-primary font-outfit">
                                            {{ $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date->format('d') : \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                        </h3>
                                        <small class="text-muted text-uppercase fw-bold">
                                            {{ $event->event_date instanceof \Illuminate\Support\Carbon ? $event->event_date->format('M Y') : \Carbon\Carbon::parse($event->event_date)->format('M Y') }}
                                        </small>
                                    </div>
                                </div>

                                <h5 class="fw-bold text-dark mb-2">{{ $event->title }}</h5>
                                <p class="text-muted small flex-grow-1">{{ $event->description }}</p>

                                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $event->location }}</span>
                                    @php
                                        $eventDate = $event->event_date instanceof \Illuminate\Support\Carbon
                                            ? $event->event_date
                                            : \Carbon\Carbon::parse($event->event_date);
                                        $isPast = $eventDate->isPast();
                                    @endphp
                                    <span class="fw-bold {{ $isPast ? 'text-secondary' : 'text-success' }}">
                                        <i class="bi bi-{{ $isPast ? 'check-circle' : 'clock-history' }}"></i>
                                        {{ $isPast ? 'Completed' : 'Upcoming' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ================================================================
     LGU ANNOUNCEMENTS — Full Listing
================================================================ --}}
<section class="section-padding bg-white" id="announcements-full-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <h2 class="section-title text-start mb-0">LGU Tourism Announcements</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-megaphone-fill me-1"></i> {{ count($announcements) }} Announcements
                </span>
            </div>
        </div>

        <div class="row g-4">
            @foreach($announcements as $announcement)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-tourism h-100 bg-white">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge bg-primary text-white">
                                    <i class="bi bi-megaphone-fill me-1"></i> {{ $announcement->category }}
                                </span>
                                <span class="small text-muted">
                                    {{ $announcement->published_at instanceof \Illuminate\Support\Carbon
                                        ? $announcement->published_at->format('F d, Y')
                                        : \Carbon\Carbon::parse($announcement->published_at)->format('F d, Y') }}
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $announcement->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ $announcement->content }}</p>
                            <a href="#" class="btn btn-link text-primary p-0 btn-sm fw-bold mt-3 align-self-start">
                                Read Full Details <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection