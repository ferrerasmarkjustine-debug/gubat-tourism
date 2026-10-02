@extends('layouts.resort-admin')

@section('content')
<div class="container py-5 mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">

            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                     style="width: 100px; height: 100px; background: linear-gradient(135deg, #fff3cd, #ffe69c);">
                    <i class="bi bi-tools" style="font-size: 3rem; color: #f59e0b;"></i>
                </div>
                <h1 class="fw-bold text-dark mb-2">Still in Development</h1>
                <p class="text-muted fs-5 mb-0">
                    Sorry, this feature isn't available yet.
                </p>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #f8f9fa, #fff);">
                <div class="d-flex align-items-start gap-3 text-start">
                    <i class="bi bi-info-circle-fill text-primary mt-1 fs-5 flex-shrink-0"></i>
                    <div>
                        <p class="fw-semibold text-dark mb-1">Add Accommodation Feature</p>
                        <p class="text-muted small mb-0">
                            The ability for Resort Admins to add, edit, and manage accommodation cards directly
                            is currently being built. Please contact the <strong>LGU Admin</strong> to add
                            accommodations for your resort in the meantime.
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('resort.dashboard') }}" class="btn btn-success rounded-pill px-4 fw-semibold">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>

        </div>
    </div>
</div>
@endsection
