<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - WeddingHalls</title>

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
                        url('https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 700px;
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
            max-height: 90vh;
            overflow-y: auto;
        }

        .auth-form-side::-webkit-scrollbar {
            width: 6px;
        }

        .auth-form-side::-webkit-scrollbar-thumb {
            background: var(--royal-gold);
            border-radius: 10px;
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
            margin-bottom: 2rem;
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
            margin-bottom: 2rem;
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
            margin-bottom: 1.25rem;
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
            padding: 12px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 0.95rem;
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
            align-items: flex-start;
            gap: 8px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid #e8e8e8;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .form-check-input:checked {
            background-color: var(--royal-gold);
            border-color: var(--royal-gold);
        }

        .form-check-label {
            font-size: 0.85rem;
            color: var(--slate-gray);
            cursor: pointer;
            line-height: 1.5;
        }

        .form-check-label a {
            color: var(--royal-gold);
            text-decoration: none;
            font-weight: 600;
        }

        .form-check-label a:hover {
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
            margin-top: 1.5rem;
            padding-top: 1.5rem;
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
                                <h2>Begin Your Journey</h2>
                                <p>Join thousands of couples and venue owners who trust us for their special moments.</p>

                                <ul class="auth-features">
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Exclusive Venue Access</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Instant Booking Confirmation</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Dedicated Support Team</span>
                                    </li>
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Member-Only Benefits</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="col-lg-7">
                    <div class="auth-form-side">
                        <a href="{{ route('home') }}" class="back-link">
                            <i class="bi bi-arrow-left"></i>
                            Back to Home
                        </a>

                        <div class="auth-header">
                            <h1 class="auth-title">Create Account</h1>
                            <p class="auth-subtitle">Start your journey with us today</p>
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

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <input type="hidden" name="role" id="roleInput" value="{{ request('role') === 'owner' ? 'owner' : 'user' }}">

                            <!-- Name Fields -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input 
                                            type="text" 
                                            name="first_name" 
                                            class="form-control @error('first_name') is-invalid @enderror" 
                                            id="first_name" 
                                            placeholder="John" 
                                            value="{{ old('first_name') }}"
                                            required
                                        >
                                        @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input 
                                            type="text" 
                                            name="last_name" 
                                            class="form-control @error('last_name') is-invalid @enderror" 
                                            id="last_name" 
                                            placeholder="Doe" 
                                            value="{{ old('last_name') }}"
                                            required
                                        >
                                        @error('last_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    placeholder="name@example.com" 
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    placeholder="Create a strong password" 
                                    required
                                >
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    placeholder="Re-enter your password" 
                                    required
                                >
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input @error('terms') is-invalid @enderror" 
                                        type="checkbox" 
                                        name="terms" 
                                        id="terms" 
                                        required
                                    >
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                                    </label>
                                    @error('terms')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-primary-gold">
                                <i class="bi bi-person-plus"></i>
                                <span>Create Account</span>
                            </button>
                        </form>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <p>Already have an account? <a href="{{ route('login', ['role' => request('role')]) }}">Sign In</a></p>
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
