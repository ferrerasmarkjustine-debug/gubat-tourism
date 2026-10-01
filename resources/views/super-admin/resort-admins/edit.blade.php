@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Breadcrumb & Header -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.resort-admins.index') }}">Resort Admins</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Resort Admin</li>
            </ol>
        </nav>

        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Edit Resort Admin: {{ $user->name }}</h2>
                <p class="text-muted mb-0">Modify account details, change assigned resort, or update account access status.</p>
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
                            <i class="bi bi-pencil-square text-primary me-2"></i> Update Account Details
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

                        <form method="POST" action="{{ route('admin.resort-admins.update', $user) }}">
                            @csrf
                            @method('PUT')

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
                                           value="{{ old('name', $user->name) }}" 
                                           required>
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
                                           value="{{ old('email', $user->email) }}" 
                                           required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Assigned Resort -->
                            <div class="mb-3">
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
                                        @foreach($resorts as $resort)
                                            <option value="{{ $resort->id }}" {{ (string)old('resort_id', $user->resort_id) === (string)$resort->id ? 'selected' : '' }}>
                                                {{ $resort->name }} ({{ ucfirst($resort->category) }} &bull; {{ $resort->barangay ? $resort->barangay->name : 'Gubat' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('resort_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Account Status -->
                            <div class="mb-4">
                                <label for="is_active" class="form-label fw-semibold text-dark">
                                    Account Status <span class="text-danger">*</span>
                                </label>
                                <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>
                                        Active (User can log in and manage resort)
                                    </option>
                                    <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>
                                        Deactivated (User login is blocked)
                                    </option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Section (Optional) -->
                            <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                                <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                    <i class="bi bi-shield-lock me-2 text-primary"></i> Change Password
                                </h6>
                                <p class="text-muted small mb-3">Leave blank if you do not want to change the password.</p>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label small fw-semibold text-dark">New Password</label>
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Min. 8 characters">
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label small fw-semibold text-dark">Confirm New Password</label>
                                        <input type="password" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               class="form-control" 
                                               placeholder="Confirm password">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                                <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-light rounded-pill px-4">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm fw-semibold">
                                    <i class="bi bi-save me-1"></i> Save Changes
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
