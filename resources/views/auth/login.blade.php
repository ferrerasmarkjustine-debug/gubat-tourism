@extends('layouts.guest')

@section('content')
<div class="py-5" style="background: linear-gradient(135deg, rgba(15, 76, 129, 0.03), rgba(25, 135, 84, 0.05)); min-height: 80vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow rounded-4 overflow-hidden bg-white">
                    <div class="card-header border-0 text-center py-4 px-4" style="background: linear-gradient(135deg, #0F4C81, #1A365D); color: #fff;">
                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 56px; height: 56px;">
                            <i class="bi bi-shield-lock-fill fs-3 text-warning"></i>
                        </div>
                        <h4 class="fw-bold mb-1 font-outfit text-white">Sign In to Your Account</h4>
                        <p class="text-white-50 small mb-0">Municipality of Gubat Tourism Portal</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show rounded-3 small mb-4" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show rounded-3 small mb-4" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold text-dark small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" 
                                           placeholder="e.g. admin@gubat.gov.ph"
                                           required 
                                           autofocus 
                                           autocomplete="username">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold text-dark small mb-0">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-muted small text-decoration-none">
                                            Forgot password?
                                        </a>
                                    @endif
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                           placeholder="Enter your password"
                                           required 
                                           autocomplete="current-password">
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted small" for="remember_me">
                                    Remember me on this device
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2 rounded-pill fw-bold shadow-sm" style="background: var(--primary-color);">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <small class="text-muted">
                            Authorized portal for LGU administrators and resort managers.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
