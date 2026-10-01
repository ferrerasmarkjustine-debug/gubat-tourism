@extends('layouts.guest')

@section('content')
<div class="bg-light pb-5">
    @include('super-admin.partials.nav')

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.resort-admins.index') }}">Resort Admins</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Resort Admin</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Create Resort Admin Account</h2>
                <p class="text-muted mb-0">Provision an administrative account for an existing resort in Gubat.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            <i class="bi bi-person-fill-gear text-primary me-2"></i> Account Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                                    <strong>Please correct the following errors:</strong>
                                </div>
                                <ul class="mb-0 ps-4 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.resort-admins.store') }}">
                            @csrf

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="e.g. Maria Santos" 
                                           value="{{ old('name') }}" 
                                           required 
                                           autofocus>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="e.g. maria.santos@resort.com" 
                                           value="{{ old('email') }}" 
                                           required>
                                </div>
                                <div class="form-text small">This will be used as their login username. Must be unique.</div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Assigned Resort -->
                            <div class="mb-4">
                                <label for="resort_id" class="form-label fw-semibold text-dark">
                                    Assigned Resort <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">
                                        <i class="bi bi-building"></i>
                                    </span>
                                    <select id="resort_id" 
                                            name="resort_id" 
                                            class="form-select @error('resort_id') is-invalid @enderror" 
                                            required>
                                        <option value="" disabled {{ old('resort_id') ? '' : 'selected' }}>-- Select a Resort --</option>
                                        @foreach($resorts as $resort)
                                            <option value="{{ $resort->id }}" {{ old('resort_id') == $resort->id ? 'selected' : '' }}>
                                                {{ $resort->name }} ({{ ucfirst($resort->category) }} &bull; {{ $resort->barangay ? $resort->barangay->name : 'Gubat' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-text small">Select an existing registered resort from the tourism database.</div>
                                @error('resort_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4 text-muted">

                            <!-- Password Fields -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-semibold text-dark">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Minimum 8 characters" 
                                               required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted">
                                            <i class="bi bi-shield-check"></i>
                                        </span>
                                        <input type="password" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               class="form-control" 
                                               placeholder="Re-enter password" 
                                               required>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-light rounded-pill px-4">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold">
                                    <i class="bi bi-check-lg me-1"></i> Create Resort Admin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
