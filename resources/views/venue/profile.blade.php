@extends('layouts.venue')

@section('title', 'My Profile')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Header -->
    <div class="mb-5">
        <h2 class="fw-bold text-dark mb-1">Account settings</h2>
        <p class="text-muted mb-0">Manage your venue owner profile and security preferences.</p>
    </div>

    <div class="row g-4">
        <!-- Profile Sidebar -->
        <div class="col-lg-4">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 text-center mb-4">
                <livewire:venue-avatar-upload />
                <h4 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h4>
                <div class="badge bg-soft-primary text-primary rounded-pill px-3 mb-4">Venue Owner Account</div>
                
                <div class="hstack justify-content-center gap-4 border-top pt-4">
                    <div class="text-center">
                        <div class="fw-bold text-dark">{{ auth()->user()->halls->count() }}</div>
                        <div class="small text-muted">Venues</div>
                    </div>
                    <div class="vr text-light"></div>
                    <div class="text-center">
                        <div class="fw-bold text-dark">{{ \App\Models\Booking::whereIn('hall_id', auth()->user()->halls->pluck('id'))->count() }}</div>
                        <div class="small text-muted">Bookings</div>
                    </div>
                    <div class="vr text-light"></div>
                    <div class="text-center">
                        <div class="fw-bold text-dark">4.9/5</div>
                        <div class="small text-muted">Rating</div>
                    </div>
                </div>
            </div>

            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h6 class="fw-bold text-dark mb-4 text-uppercase small">Trust & Security</h6>
                <div class="vstack gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success-light text-success rounded-circle p-2">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="small fw-bold">Email Verified</div>
                            <div class="small text-muted">{{ auth()->user()->email_verified_at ? auth()->user()->email_verified_at->format('M Y') : 'January 2026' }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info-light text-info rounded-circle p-2">
                            <i class="bi bi-fingerprint"></i>
                        </div>
                        <div>
                            <div class="small fw-bold">Identity Confirmed</div>
                            <div class="small text-muted">Corporate Partner</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="col-lg-8">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">Personal Information</h5>
                <form action="{{ route('venue.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">First Name</label>
                            <input type="text" name="first_name" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ auth()->user()->first_name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Last Name</label>
                            <input type="text" name="last_name" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ auth()->user()->last_name }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Phone Number</label>
                            <input type="tel" name="phone" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ auth()->user()->phone ?? '+962 ' }}" placeholder="+962 7XXX XXX XX">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill fw-bold shadow-gold">Save Changes</button>
                    </div>
                </form>
            </div>

            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4">Security Settings</h5>
                <form action="#" method="POST">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Current Password</label>
                            <input type="password" name="current_password" class="form-control rounded-3 py-3 px-4 border-light bg-light">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">New Password</label>
                            <input type="password" name="password" class="form-control rounded-3 py-3 px-4 border-light bg-light">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-3 py-3 px-4 border-light bg-light">
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark px-5 py-3 rounded-pill fw-bold">Update security</button>
                    </div>
                </form>
            </div>
            
            <div class="mt-4 p-4 bg-soft-danger rounded-4 border border-danger-subtle d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="fw-bold text-danger mb-1">Deactivate Account</h6>
                    <p class="small text-muted mb-0">Permanently remove your account and all venue data.</p>
                </div>
                <button class="btn btn-danger px-4 rounded-pill py-2">Delete Profile</button>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .bg-soft-primary { background-color: rgba(212, 175, 55, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.05); }
    
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    .btn-icon { width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; }
    
    .cursor-pointer { cursor: pointer; }
    .form-control:focus { background-color: white; box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15); border-color: #D4AF37; }
</style>
@endsection
