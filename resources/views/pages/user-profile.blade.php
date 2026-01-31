@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<div class="user-profile-page py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="profile-card text-center p-4">
                    <div class="position-relative d-inline-block mb-3" style="width: 120px; height: 120px;">
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=D4AF37&color=fff' }}" 
                             class="profile-avatar w-100 h-100" id="avatarPreview" alt="Avatar">
                        <label for="avatarInput" class="avatar-edit-btn" style="position: absolute; bottom: 0; right: 0; z-index: 10;">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="avatarInput" class="d-none" accept="image/*" onchange="uploadAvatar(this)">
                    </div>
                    <h3 class="luxury-text mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h3>
                    <p class="text-muted small mb-4">Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                    
                    <div class="d-flex justify-content-around border-top pt-4 mb-4">
                        <div class="stat-item">
                            <div class="stat-value">{{ \App\Models\Booking::where('user_id', auth()->id())->count() }}</div>
                            <div class="stat-label">Bookings</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">0</div>
                            <div class="stat-label">Reviews</div>
                        </div>
                    </div>

                    <div class="nav flex-column nav-pills custom-pills">
                        <a class="nav-link active" href="#personal" data-bs-toggle="pill">
                            <i class="fas fa-user-edit me-2"></i> Personal Details
                        </a>
                        <a class="nav-link" href="#security" data-bs-toggle="pill">
                            <i class="fas fa-shield-alt me-2"></i> Security
                        </a>
                        <a class="nav-link" href="#notifications" data-bs-toggle="pill">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="tab-content">
                    <!-- Personal Info -->
                    <div class="tab-pane fade show active" id="personal">
                        <div class="content-card p-4">
                            <h4 class="luxury-text mb-4">Personal Information</h4>
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Email Address</label>
                                        <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label small fw-bold">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Bio</label>
                                        <textarea name="bio" rows="3" class="form-control">{{ auth()->user()->bio }}</textarea>
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-luxury px-5">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Security -->
                    <div class="tab-pane fade" id="security">
                        <div class="content-card p-4">
                            <h4 class="luxury-text mb-4">Security Settings</h4>
                            <form action="#" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold">Current Password</label>
                                        <input type="password" name="current_password" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">New Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-4 text-end">
                                    <button type="submit" class="btn btn-luxury px-5">Update Password</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="tab-pane fade" id="notifications">
                        <div class="content-card p-4">
                            <h4 class="luxury-text mb-4">Notifications Preference</h4>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item bg-transparent px-0 border-light py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">Email Notifications</div>
                                            <small class="text-muted">Receive updates about your bookings via email.</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item bg-transparent px-0 border-light py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">Promotional Updates</div>
                                            <small class="text-muted">Stay updated with new halls and exclusive offers.</small>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" checked>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card bg-soft-danger p-4 mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-danger fw-bold mb-1">Delete Account</h5>
                            <p class="small text-muted mb-0">Once deleted, your account and all data cannot be recovered.</p>
                        </div>
                        <button class="btn btn-outline-danger btn-sm px-4 rounded-pill">Deactivate</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --royal-gold: #D4AF37;
        --midnight: #1A1A1A;
        --bg-profile: #F8FAFC;
    }

    .user-profile-page { background: var(--bg-profile); min-height: 100vh; }
    .luxury-text { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--midnight); }

    .profile-card, .content-card { 
        background: white; border-radius: 20px; border: 1px solid #E2E8F0; 
        box-shadow: 0 4px 20px rgba(0,0,0,0.02); 
    }

    .profile-avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    
    .avatar-edit-btn {
        position: absolute; bottom: 5px; right: 5px; width: 32px; height: 32px; 
        background: var(--royal-gold); color: white; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        border: 3px solid white; transition: 0.3s;
    }
    .avatar-edit-btn:hover { background: var(--midnight); transform: scale(1.1); }

    .stat-value { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; color: var(--royal-gold); }
    .stat-label { font-size: 0.75rem; text-transform: uppercase; color: #94A3B8; font-weight: 700; }

    .custom-pills .nav-link { 
        color: #64748B; font-weight: 600; text-align: left; padding: 12px 20px; 
        border-radius: 12px; margin-bottom: 5px; transition: 0.3s;
    }
    .custom-pills .nav-link:hover { background: #F1F5F9; color: var(--midnight); }
    .custom-pills .nav-link.active { background: var(--midnight); color: white; }

    .form-control { border-radius: 10px; padding: 12px; border: 1px solid #E2E8F0; font-size: 0.9rem; }
    .form-control:focus { border-color: var(--royal-gold); box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1); }

    .btn-luxury { 
        background: var(--midnight); color: white; border-radius: 10px; padding: 12px 30px; 
        font-weight: 600; border: none; transition: 0.3s;
    }
    .btn-luxury:hover { background: var(--royal-gold); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); }

    .bg-soft-danger { background-color: #FFF5F5 !important; border: 1px solid #FED7D7 !important; }
</style>

<script>
function uploadAvatar(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('avatar', input.files[0]);

        // Simple feedback
        const reader = new FileReader();
        reader.onload = (e) => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);

        fetch("{{ route('profile.avatar') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if(res.ok && data.success) {
                showToast('Profile picture updated successfully!');
                // Update navbars too if they exist on page
                document.querySelectorAll('.user-avatar-luxury').forEach(img => {
                    img.src = data.avatar_url;
                });
            } else {
                showToast(data.message || 'Error updating picture', 'error');
            }
        })
        .catch(err => {
            console.error('Upload error:', err);
            showToast('Connection error during upload', 'error');
        });
    }
}
</script>
@endsection
