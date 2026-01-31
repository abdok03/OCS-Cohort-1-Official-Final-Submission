<!-- resources/views/pages/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wedding Hall Booking</title>

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

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: white;
            color: #475569;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            border-color: #6366f1;
            color: #6366f1;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #94a3b8;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider span {
            padding: 0 1rem;
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .forgot-link {
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
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

            .social-login {
                flex-direction: column;
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
                                <h2>Find Your Dream Wedding Venue</h2>
                                <p>Join thousands of happy couples who found their perfect wedding hall through our platform.</p>

                                <ul class="feature-list">
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Browse 500+ premium venues
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Real-time availability checking
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        Secure online booking
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle"></i>
                                        24/7 customer support
                                    </li>
                                </ul>

                                <div class="mt-5">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80"
                                             alt="User" class="rounded-circle me-3" style="width: 60px; height: 60px;">
                                        <div>
                                            <p class="mb-0 fw-medium">"Found our perfect venue in just 3 days!"</p>
                                            <small class="opacity-75">— Sarah & James, Married 2023</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="col-lg-6">
                        <div class="auth-right">
                            <a href="{{ route('home') }}" class="auth-logo">
                                <i class="fas fa-heart text-primary"></i>
                                <span>WeddingHalls</span>
                            </a>

                            <h1 class="auth-title">Welcome Back</h1>
                            <p class="auth-subtitle">Sign in to your account to continue</p>

                            <!-- Social Login -->
                            <div class="social-login">
                                <button class="social-btn">
                                    <i class="fab fa-google text-danger"></i>
                                    Google
                                </button>
                                <button class="social-btn">
                                    <i class="fab fa-facebook text-primary"></i>
                                    Facebook
                                </button>
                            </div>

                            <div class="divider">
                                <span>Or continue with email</span>
                            </div>

                            <!-- Login Form -->
                          <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email -->
    <div class="form-floating mb-3">
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="form-control @error('email') is-invalid @enderror" placeholder="Email">
        <label for="email"><i class="fas fa-envelope me-2"></i> Email Address</label>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-floating mb-3">
        <input id="password" type="password" name="password" required
               class="form-control @error('password') is-invalid @enderror" placeholder="Password">
        <label for="password"><i class="fas fa-lock me-2"></i> Password</label>
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">
            Remember me
        </label>
    </div>

    <button type="submit" class="auth-btn w-100 mb-3">
        <i class="fas fa-sign-in-alt me-2"></i> Sign In
    </button>

    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="d-block text-center text-primary">
            Forgot your password?
        </a>
    @endif
</form>


                            <div class="auth-footer">
                                <p>Don't have an account? <a href="{{ route('register') }}">Create account</a></p>
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
        function handleLogin(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Simple validation
            if (!email || !password) {
                showToast('Please fill in all fields', 'error');
                return;
            }

            // In a real app, you would make an API call here
            // For demo, simulate successful login
            showToast('Login successful! Redirecting...', 'success');

            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 1500);
        }

        function showForgotPassword() {
            // In a real app, this would show a forgot password modal
            alert('Forgot password feature would open here');
        }

        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
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
    </script>
</body>
</html>
