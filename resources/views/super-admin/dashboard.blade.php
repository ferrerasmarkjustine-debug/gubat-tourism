@extends('layouts.admin')

@section('content')
<div class="pb-5">

    <div class="container">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: var(--primary-color);">Overview & Statistics</h2>
                <p class="text-muted mb-0">Monitor tourism resorts and resort administrative accounts across Gubat.</p>
                <small class="text-muted">Signed in as <strong>{{ auth()->user()->name }}</strong></small>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2 align-items-center">
                <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-tourism-primary px-4 py-2 rounded-pill shadow-sm text-white fw-semibold" style="background: var(--primary-color);">
                    <i class="bi bi-person-plus-fill me-2"></i> Add Resort Admin
                </a>
                {{-- Always-visible logout — plain POST form, no JS required --}}
                <form method="POST" action="{{ route('logout') }}" id="dashboard-logout-form">
                    @csrf
                    <button type="submit"
                            class="btn btn-danger rounded-pill px-4 py-2 fw-semibold"
                            onclick="return confirm('Log out of LGU Admin Portal?')">
                        <i class="bi bi-box-arrow-right me-1"></i> Log Out
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Quick Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3" style="background: linear-gradient(135deg, #0F4C81, #1A365D); color: #fff;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-white-50 small fw-bold text-uppercase">Total Resorts</span>
                            <h2 class="fw-bold my-1 text-white">{{ $totalResorts }}</h2>
                            <small class="text-white-50">Registered in Gubat</small>
                        </div>
                        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-building fs-4 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Resort Admins</span>
                            <h2 class="fw-bold my-1 text-dark">{{ $totalResortAdmins }}</h2>
                            <small class="text-muted">Total accounts</small>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-people-fill fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Active Admins</span>
                            <h2 class="fw-bold my-1 text-success">{{ $activeResortAdmins }}</h2>
                            <small class="text-muted">Permitted to log in</small>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small fw-bold text-uppercase">Deactivated</span>
                            <h2 class="fw-bold my-1 text-danger">{{ $inactiveResortAdmins }}</h2>
                            <small class="text-muted">Access suspended</small>
                        </div>
                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-x-fill fs-4 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Resort Admins Table -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center justify-content-between">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i> Recent Resort Admins
                </h5>
                <a href="{{ route('admin.resort-admins.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    View All Admins <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Admin Name</th>
                            <th>Email</th>
                            <th>Assigned Resort</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentAdmins as $admin)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 36px; height: 36px; font-size: 0.9rem;">
                                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold text-dark">{{ $admin->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if($admin->resort)
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3 py-1 rounded-pill">
                                            <i class="bi bi-building me-1"></i> {{ $admin->resort->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary text-white rounded-pill">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if($admin->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-1 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Deactivated
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $admin->created_at->format('M d, Y') }}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.resort-admins.edit', $admin) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                                    No resort administrators have been created yet.
                                    <div class="mt-2">
                                        <a href="{{ route('admin.resort-admins.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="bi bi-plus-lg me-1"></i> Create First Resort Admin
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
