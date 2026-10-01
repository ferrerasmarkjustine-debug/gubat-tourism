<section class="section-padding bg-light" id="announcements-section">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8 text-start">
                <h2 class="section-title text-start mb-0">LGU Tourism Announcements</h2>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="#" class="btn btn-tourism-outline rounded-pill">
                    View All News <i class="bi bi-arrow-right-short ms-1"></i>
                </a>
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
                                    {{ $announcement->published_at instanceof \Illuminate\Support\Carbon ? $announcement->published_at->format('F d, Y') : \Carbon\Carbon::parse($announcement->published_at)->format('F d, Y') }}
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
