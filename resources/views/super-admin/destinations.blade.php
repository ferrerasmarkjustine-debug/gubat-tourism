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
                            <th class="text-end pe-4" style="min-width: 220px;">Actions</th>
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
                                    <div class="d-inline-flex align-items-center gap-1">
                                        {{-- Quick Toggle Featured --}}
                                        <form method="POST" action="{{ route('admin.destinations.toggle-featured', $dest) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $dest->featured ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-2 py-1"
                                                    title="{{ $dest->featured ? 'Click to unmark as Featured' : 'Click to mark as Featured' }}">
                                                <i class="bi {{ $dest->featured ? 'bi-star-fill' : 'bi-star' }} me-1"></i>
                                                <span class="small">{{ $dest->featured ? 'Featured' : 'Standard' }}</span>
                                            </button>
                                        </form>

                                        {{-- Edit Button (triggers modal) --}}
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal-{{ $dest->id }}"
                                                title="Edit destination details">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        {{-- Google Maps Link --}}
                                        @if($dest->google_map_url)
                                            <a href="{{ $dest->google_map_url }}" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               class="btn btn-sm btn-outline-secondary rounded-pill px-2 py-1"
                                               title="View on Google Maps">
                                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                            </a>
                                        @endif
                                    </div>
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

            @if($destinations->hasPages())
                <div class="card-footer bg-white border-top py-3 px-4">
                    {{ $destinations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Modals rendered outside table for proper stacking --}}
@foreach($destinations as $dest)
    <div class="modal fade" id="editModal-{{ $dest->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $dest->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom px-4 pt-4 pb-3">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="editModalLabel-{{ $dest->id }}">
                        <i class="bi bi-pencil-square text-primary me-2"></i> Edit Destination: {{ $dest->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.destinations.update', $dest) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body px-4 py-3">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Destination Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $dest->name) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" list="categoryOptions" class="form-control rounded-3" value="{{ old('category', $dest->category) }}" required>
                                <datalist id="categoryOptions">
                                    <option value="Surf Haven">
                                    <option value="Public Beach">
                                    <option value="Heritage Landmark">
                                    <option value="Century-Old Church">
                                    <option value="Traditional Pottery">
                                    <option value="Livelihood Center">
                                    <option value="Historical Heritage">
                                </datalist>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Description</label>
                                <textarea name="description" class="form-control rounded-3" rows="3">{{ old('description', $dest->description) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Image URL (Cover Photo)</label>
                                <input type="text" name="image_url" class="form-control rounded-3" value="{{ old('image_url', $dest->image_url) }}" placeholder="e.g. images/destinations/beach.jpg">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Google Maps URL</label>
                                <input type="url" name="google_map_url" class="form-control rounded-3" value="{{ old('google_map_url', $dest->google_map_url) }}" placeholder="https://maps.google.com/...">
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="featured" id="featuredCheck-{{ $dest->id }}" value="1" {{ $dest->featured ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-dark" for="featuredCheck-{{ $dest->id }}">
                                        Feature this destination
                                    </label>
                                    <div class="form-text text-muted small">Featured destinations appear prominently on the public homepage and featured spots section.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top px-4 py-3 bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
