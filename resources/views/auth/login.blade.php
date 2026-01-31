<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - WeddingHalls</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --royal-gold: #D4AF37;
            --royal-gold-dark: #B5952F;
            --royal-gold-light: rgba(212, 175, 55, 0.1);
            --midnight: #1A1A1A;
            --slate-gray: #4A4A4A;
            --ivory-white: #FDFCF0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDFCF0 0%, #FAF9F6 50%, #F5F3E8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 1100px;
        }

        .auth-card {
            background: white;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Left Side - Image */
        .auth-image-side {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.7) 0%, rgba(26, 26, 26, 0.5) 100%), 
                        url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 600px;
            position: relative;
        }

        .auth-image-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
        }

        .auth-image-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin-bottom: 3rem;
        }

        .auth-brand i {
            color: var(--royal-gold);
            font-size: 2rem;
        }

        .auth-promo h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .auth-promo p {
            font-size: 1.1rem;
            opacity: 0.95;
            line-height: 1.6;
        }

        .auth-features {
            list-style: none;
            padding: 0;
            margin-top: 2rem;
        }

        .auth-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .auth-features i {
            color: var(--royal-gold);
            font-size: 1.2rem;
        }

        /* Right Side - Form */
        .auth-form-side {
            padding: 4rem 3.5rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--slate-gray);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--royal-gold);
            transform: translateX(-5px);
        }

        .auth-header {
            margin-bottom: 2.5rem;
        }

        .auth-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--midnight);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--slate-gray);
            font-size: 1rem;
        }

        /* Role Tabs */
        .role-tabs {
            display: flex;
            gap: 12px;
            margin-bottom: 2.5rem;
            background: #f8f9fa;
            padding: 6px;
            border-radius: 16px;
        }

        .role-tab {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            color: var(--slate-gray);
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .role-tab.active {
            background: white;
            color: var(--royal-gold);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .role-tab i {
            font-size: 1.1rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--midnight);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--royal-gold);
            box-shadow: 0 0 0 4px var(--royal-gold-light);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #e8e8e8;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--royal-gold);
            border-color: var(--royal-gold);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: var(--slate-gray);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--royal-gold);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--royal-gold-dark);
            text-decoration: underline;
        }

        .btn-primary-gold {
            width: 100%;
            padding: 16px;
            background: var(--royal-gold);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .btn-primary-gold:hover {
            background: var(--royal-gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }

        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e8e8e8;
        }

        .auth-footer p {
            color: var(--slate-gray);
            font-size: 0.95rem;
        }

        .auth-footer a {
            color: var(--royal-gold);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .auth-image-side {
                display: none;
            }

            .auth-form-side {
                padding: 3rem 2rem;
            }
        }

        @media (max-width: 576px) {
            .auth-form-side {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }

            .role-tabs {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="row g-0">
                <!-- Left Side - Image & Promo -->
                <div class="col-lg-5">
                    <div class="auth-image-side">
                        <div class="auth-image-content">
                            <div class="auth-brand">
                                <i class="bi bi-gem"></i>
                                <span>WeddingHalls</span>
                            </div>

                            <div class="auth-promo">
                                <h2>Welcome Back to Luxury</h2>
                                <p>Continue your journey to finding the perfect venue for your special day.</p>

                                <ul class="auth-features">
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Access 500+ Premium Venues</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Real-time Availability</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Secure Booking System</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>24/7 Concierge Support</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-lg-7">
                    <div class="auth-form-side">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="bi bi-arrow-left"></i>
                            Back to Home
                        </a>

                        <div class="auth-header">
                            <h1 class="auth-title">Sign In</h1>
                            <p class="auth-subtitle">Welcome back! Please enter your details</p>
                        </div>

                        <!-- Role Selection Tabs -->
                        <div class="role-tabs">
                            <button type="button" class="role-tab {{ request('role') !== 'owner' ? 'active' : '' }}" data-role="user">
                                <i class="bi bi-person"></i>
                                <span>Guest</span>
                            </button>
                            <button type="button" class="role-tab {{ request('role') === 'owner' ? 'active' : '' }}" data-role="owner">
                                <i class="bi bi-building"></i>
                                <span>Venue Owner</span>
                            </button>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <input type="hidden" name="role" id="roleInput" value="{{ request('role') === 'owner' ? 'owner' : 'user' }}">

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus
                                    class="form-control @error('email') is-invalid @enderror" 
                                    placeholder="Enter your email"
                                >
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="password" class="form-label mb-0">Password</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                                    @endif
                                </div>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required
                                    class="form-control @error('password') is-invalid @enderror" 
                                    placeholder="Enter your password"
                                >
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me for 30 days
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-primary-gold">
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Sign In</span>
                            </button>
                        </form>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <p>Don't have an account? <a href="{{ route('register', ['role' => request('role')]) }}">Create Account</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Role Tab Switching
        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Update hidden role input
                const role = this.getAttribute('data-role');
                document.getElementById('roleInput').value = role;
            });
        });
    </script>
</body>
</html>
