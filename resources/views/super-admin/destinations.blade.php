@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Destinations</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Destinations Management</h2>
                <p class="text-muted mb-0">Manage municipal destinations, surf camps, and historical spots across Gubat.</p>
            </div>
            <div>
                <a href="{{ route('destinations') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-eye me-1"></i> Public Destinations
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Destination Name</th>
                            <th>Category</th>
                            <th>Municipality</th>
                            <th>Rating</th>
                            <th>Featured</th>
                            <th class="text-end pe-4">Public View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($destinations as $dest)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-dark">{{ $dest->name }}</div>
                                    <small class="text-muted">{{ Str::limit($dest->description, 60) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-dark border px-3 py-1 rounded-pill">
                                        {{ $dest->category }}
                                    </span>
                                </td>
                                <td>{{ $dest->municipality ? $dest->municipality->name : 'Gubat' }}</td>
                                <td>
                                    <span class="text-warning fw-semibold">
                                        <i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($dest->rating, 1) }}
                                    </span>
                                </td>
                                <td>
                                    @if($dest->featured)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-2 py-1">Featured</span>
                                    @else
                                        <span class="text-muted small">Standard</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('destinations') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No destinations recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
