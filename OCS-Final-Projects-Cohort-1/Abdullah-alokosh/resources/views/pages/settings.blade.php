<!-- resources/views/pages/profile.blade.php -->
<livewire:styles />
<livewire:scripts />




@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
    <div class="container-custom py-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- Profile Summary Card -->
                <div class="card shadow-soft mb-4">
                    <div class="card-body text-center p-4">
                        <!-- Avatar Upload Component -->
                        <livewire:avatar-upload />

                        <h4 class="mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                        <p class="text-muted mb-3">Premium Member</p>

                        <!-- Personal Info Form -->
                        <input type="text" class="form-control" name="first_name" value="{{ auth()->user()->first_name }}"
                            required>
                        <input type="text" class="form-control" name="last_name" value="{{ auth()->user()->last_name }}"
                            required>
                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}"
                            required>


                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <div class="text-center">
                                <div class="fw-bold text-primary">8</div>
                                <small class="text-muted">Bookings</small>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold text-primary">6</div>
                                <small class="text-muted">Favorites</small>
                            </div>
                            <div class="text-center">
                                <div class="fw-bold text-primary">2</div>
                                <small class="text-muted">Reviews</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" onclick="showVerificationModal()">
                                <i class="fas fa-shield-alt me-2"></i> Verify Account
                            </button>
                            <button class="btn btn-outline-secondary" onclick="showUpgradeModal()">
                                <i class="fas fa-crown me-2"></i> Upgrade to Premium
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Stats -->
                <div class="card shadow-soft">
                    <div class="card-body p-4">
                        <h6 class="mb-3">Account Information</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Member Since</span>
                                <span class="fw-medium">Jan 2023</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Account Status</span>
                                <span class="badge bg-success">Active</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Email Verified</span>
                                <span class="badge bg-success">Verified</span>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span class="text-muted">Phone Verified</span>
                                <span class="badge bg-warning">Pending</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Profile Edit Form -->
                <div class="card shadow-soft mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Personal Information</h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="editProfile()">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                        </div>

                        <form id="profileForm" action="{{ route('profile.update', auth()->user()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ auth()->user()->first_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ auth()->user()->last_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone"
                                        value="{{ auth()->user()->phone }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address"
                                        value="{{ auth()->user()->address }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control" name="city"
                                        value="{{ auth()->user()->city }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State</label>
                                    <input type="text" class="form-control" name="state"
                                        value="{{ auth()->user()->state }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" name="zip"
                                        value="{{ auth()->user()->zip }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Bio</label>
                                    <textarea class="form-control" name="bio" rows="3">{{ auth()->user()->bio }}</textarea>
                                </div>


                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Save Changes
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary ms-2" onclick="resetForm()">
                                        Cancel
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="card shadow-soft mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Change Password</h5>

                        <form id="passwordForm" onsubmit="changePassword(event)">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="currentPassword" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('currentPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="newPassword" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('newPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirmPassword" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('confirmPassword')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key me-2"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Notification Preferences -->
                <div class="card shadow-soft">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Notification Preferences</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Email Notifications
                                    </label>
                                    <small class="text-muted d-block">Receive booking updates via email</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="promotionalEmails">
                                    <label class="form-check-label" for="promotionalEmails">
                                        Promotional Emails
                                    </label>
                                    <small class="text-muted d-block">Receive special offers and discounts</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="smsNotifications" checked>
                                    <label class="form-check-label" for="smsNotifications">
                                        SMS Notifications
                                    </label>
                                    <small class="text-muted d-block">Receive important alerts via SMS</small>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="priceAlerts">
                                    <label class="form-check-label" for="priceAlerts">
                                        Price Drop Alerts
                                    </label>
                                    <small class="text-muted d-block">Get notified when favorite halls have price
                                        drops</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary" onclick="savePreferences()">
                                <i class="fas fa-bell me-2"></i> Save Preferences
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="card shadow-soft border-danger mt-4">
                    <div class="card-body p-4">
                        <h5 class="text-danger mb-4">Danger Zone</h5>

                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            These actions are irreversible. Please proceed with caution.
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <button class="btn btn-outline-danger" onclick="deactivateAccount()">
                                <i class="fas fa-user-slash me-2"></i> Deactivate Account
                            </button>
                            <button class="btn btn-danger" onclick="deleteAccount()">
                                <i class="fas fa-trash-alt me-2"></i> Delete Account
                            </button>
                            <button class="btn btn-outline-secondary" onclick="exportData()">
                                <i class="fas fa-download me-2"></i> Export My Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function editProfile() {
                const form = document.getElementById('profileForm');
                const inputs = form.querySelectorAll('input, textarea, select');
                const editBtn = form.querySelector('button[onclick="editProfile()"]');

                inputs.forEach(input => {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                });

                editBtn.innerHTML = '<i class="fas fa-times me-1"></i> Cancel';
                editBtn.setAttribute('onclick', 'cancelEdit()');
                editBtn.classList.remove('btn-outline-primary');
                editBtn.classList.add('btn-outline-danger');
            }

            function cancelEdit() {
                const form = document.getElementById('profileForm');
                const editBtn = form.querySelector('button[onclick="cancelEdit()"]');

                editBtn.innerHTML = '<i class="fas fa-edit me-1"></i> Edit';
                editBtn.setAttribute('onclick', 'editProfile()');
                editBtn.classList.remove('btn-outline-danger');
                editBtn.classList.add('btn-outline-primary');

                resetForm();
            }

            function updateProfile(event) {
                event.preventDefault();
                showToast('Profile updated successfully!', 'success');
                cancelEdit();
            }

            function resetForm() {
                // In a real app, this would reset to original values
                // For demo, we'll just show a message
                showToast('Form reset to original values', 'info');
            }

            function changePassword(event) {
                event.preventDefault();

                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (newPassword !== confirmPassword) {
                    showToast('Passwords do not match!', 'error');
                    return;
                }

                if (newPassword.length < 8) {
                    showToast('Password must be at least 8 characters long', 'error');
                    return;
                }

                showConfirmation(
                    'Change Password',
                    'Are you sure you want to change your password?',
                    function() {
                        event.target.reset();
                        showToast('Password changed successfully!', 'success');
                    }
                );
            }

            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const button = input.nextElementSibling;
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }

            function savePreferences() {
                showToast('Notification preferences saved!', 'success');
            }

            function showVerificationModal() {
                // In a real app, this would open a verification modal
                showToast('Verification process started. Check your email for instructions.', 'info');
            }

            function showUpgradeModal() {
                // In a real app, this would open an upgrade modal
                showToast('Premium upgrade modal would open here', 'info');
            }

            function deactivateAccount() {
                showConfirmation(
                    'Deactivate Account',
                    'Your account will be deactivated immediately. You can reactivate it anytime by logging in.',
                    function() {
                        showToast('Account deactivated successfully', 'success');
                    }
                );
            }

            // function uploadAvatar(input) {
            //     // event.preventDefault();
            //     if (input.files && input.files[0]) {
            //         // عرض الصورة مباشرة
            //         const reader = new FileReader();
            //         reader.onload = function(e) {
            //             document.getElementById('profileAvatar').src = e.target.result;
            //         }
            //         reader.readAsDataURL(input.files[0]);

            //         // إرسال الصورة للسيرفر
            //         const formData = new FormData();
            //         formData.append('avatar', input.files[0]);

            //         fetch("{{ route('profile.avatar') }}", {
            //                 method: 'POST',
            //                 headers: {
            //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            //                 },
            //                 body: formData
            //             })
            //             .then(res => res.ok ? res.json() : Promise.reject(res))
            //             .then(data => {
            //                 document.getElementById('profileAvatar').src = data.avatar_url;
            //                 showToast('Profile picture updated!', 'success');
            //             })

            //             .catch(err => {
            //                 console.error(err);
            //                 showToast('Failed to upload image!', 'error');
            //             });
            //     }

            // }


            function deleteAccount() {
                showConfirmation(
                    'Delete Account',
                    'This action cannot be undone. All your data, bookings, and preferences will be permanently deleted.',
                    function() {
                        showToast('Account deletion request submitted', 'success');
                    }
                );
            }

            function exportData() {
                showToast('Your data export has started. You will receive an email when it\'s ready.', 'info');
            }
        </script>
    @endsection
