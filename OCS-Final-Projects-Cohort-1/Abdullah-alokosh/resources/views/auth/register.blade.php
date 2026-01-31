<!-- resources/views/pages/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Wedding Hall Booking</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">

    <style>
        .auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container {
            width: 100%;
            max-width: 1200px;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .auth-left {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-left h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .auth-left p {
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0 0;
        }

        .feature-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .feature-list i {
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .auth-right {
            padding: 4rem;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: #6366f1;
        }

        .auth-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1e293b;
        }

        .auth-subtitle {
            color: #64748b;
            margin-bottom: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating label {
            color: #64748b;
        }

        .form-control {
            padding: 1rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            background: #ef4444;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .strength-text {
            font-size: 0.875rem;
            color: #64748b;
        }

        .terms-check {
            margin-bottom: 1.5rem;
        }

        .terms-check .form-check-input {
            margin-top: 0.25rem;
        }

        .terms-check label {
            font-size: 0.9rem;
        }

        .terms-check a {
            color: #6366f1;
            text-decoration: none;
        }

        .terms-check a:hover {
            text-decoration: underline;
        }

        .auth-btn {
            width: 100%;
            padding: 1rem;
            background: #6366f1;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .auth-btn:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .auth-btn:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            color: #64748b;
        }

        .auth-footer a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
        }

        .back-home a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 992px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 3rem;
            }
        }

        @media (max-width: 576px) {
            .auth-right {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <a href="{{ route('home') }}" class="back-home">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>

        <div class="auth-container">
            <div class="auth-card">
                <div class="row g-0">
                    <!-- Left Side - Promo Content -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="auth-left">
                            <div>
                                <h2>Start Your Wedding Journey</h2>
                                <p>Create an account to access hundreds of beautiful venues and start planning your special day.</p>

                                <ul class="feature-list">
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Save favorite venues
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Book venues instantly
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Manage all bookings in one place
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Get exclusive member discounts
                                    </li>
                                </ul>

                                <div class="mt-5">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-1.2.1&auto=format&fit=crop&w-100&q=80"
                                             alt="Venue" class="rounded me-3" style="width: 60px; height: 60px;">
                                        <div>
                                            <p class="mb-0 fw-medium">"Booked our dream venue within minutes!"</p>
                                            <small class="opacity-75">— Michael & Lisa, Married 2023</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Register Form -->
                    <div class="col-lg-6">
                        <div class="auth-right">
                            <a href="{{ route('home') }}" class="auth-logo">
                                <i class="fas fa-heart text-primary"></i>
                                <span>WeddingHalls</span>
                            </a>

                            <h1 class="auth-title">Create Account</h1>
                            <p class="auth-subtitle">Join thousands of couples planning their special day</p>

                            <!-- Register Form -->
                           <form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="John" required>
                <label for="firstName"><i class="fas fa-user me-2"></i> First Name</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Doe" required>
                <label for="lastName"><i class="fas fa-user me-2"></i> Last Name</label>
            </div>
        </div>
    </div>

    <div class="form-floating">
        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
        <label for="email"><i class="fas fa-envelope me-2"></i> Email Address</label>
    </div>

    <div class="form-floating">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
        <label for="password"><i class="fas fa-lock me-2"></i> Password</label>
    </div>
<div class="form-floating">
        <input type="password" name="password_confirmation" class="form-control" id="password" placeholder="confirm Password" required>
        <label for="password"><i class="fas fa-lock me-2"></i>confirm Password</label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
        <label class="form-check-label" for="terms">
            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
        </label>
    </div>

    <button type="submit" class="auth-btn w-100">
        <i class="fas fa-user-plus me-2"></i> Create Account
    </button>
</form>

                            <div class="auth-footer">
                                <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        let passwordStrength = 'weak';

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            let strength = 0;
            let color = '#ef4444';
            let text = 'Weak';

            // Check password length
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;

            // Check for mixed case
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;

            // Check for numbers
            if (/\d/.test(password)) strength++;

            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Determine strength level
            if (strength >= 4) {
                color = '#10b981';
                text = 'Strong';
                passwordStrength = 'strong';
            } else if (strength >= 2) {
                color = '#f59e0b';
                text = 'Medium';
                passwordStrength = 'medium';
            } else {
                color = '#ef4444';
                text = 'Weak';
                passwordStrength = 'weak';
            }

            // Update UI
            const width = (strength / 5) * 100;
            strengthFill.style.width = width + '%';
            strengthFill.style.backgroundColor = color;
            strengthText.textContent = 'Password strength: ' + text;
            strengthText.style.color = color;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorElement = document.getElementById('passwordMatchError');
            const registerBtn = document.getElementById('registerBtn');

            if (confirmPassword && password !== confirmPassword) {
                errorElement.style.display = 'block';
                registerBtn.disabled = true;
            } else {
                errorElement.style.display = 'none';
                registerBtn.disabled = false;
            }
        }

        // function handleRegister(event) {
        //     event.preventDefault();

        //     const firstName = document.getElementById('firstName').value;
        //     const lastName = document.getElementById('lastName').value;
        //     const email = document.getElementById('email').value;
        //     const password = document.getElementById('password').value;
        //     const confirmPassword = document.getElementById('confirmPassword').value;
        //     const phone = document.getElementById('phone').value;
        //     const weddingDate = document.getElementById('weddingDate').value;
        //     const terms = document.getElementById('terms').checked;

        //     // Validate form
        //     if (!firstName || !lastName || !email || !password || !confirmPassword) {
        //         showToast('Please fill in all required fields', 'error');
        //         return;
        //     }

        //     if (!terms) {
        //         showToast('Please accept the terms and conditions', 'error');
        //         return;
        //     }

        //     if (password !== confirmPassword) {
        //         showToast('Passwords do not match', 'error');
        //         return;
        //     }

        //     if (passwordStrength === 'weak') {
        //         showToast('Please choose a stronger password', 'warning');
        //         return;
        //     }

        //     // In a real app, you would make an API call here
        //     // For demo, simulate successful registration
        //     showToast('Account created successfully! Redirecting...', 'success');

        //     setTimeout(() => {
        //         window.location.href = "{{ route('home') }}";
        //     }, 1500);
        // }

        function showTerms() {
            // In a real app, this would show terms modal
            alert('Terms of Service would open here');
        }

        function showPrivacy() {
            // In a real app, this would show privacy policy modal
            alert('Privacy Policy would open here');
        }

        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : type === 'warning' ? '#f59e0b' : '#ef4444'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;

            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum wedding date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('weddingDate').min = today;
        });
    </script>
</body>
</html>
