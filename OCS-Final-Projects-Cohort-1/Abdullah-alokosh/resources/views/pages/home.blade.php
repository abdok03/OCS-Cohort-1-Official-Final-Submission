@extends('layouts.user')

@section('title', 'Home - Find Your Perfect Wedding Venue')

@section('content')
    <style>
        /* متغيرات اللون */
        :root {
            --primary-gold: #D4AF37;
            --secondary-gold: #F4E4B5;
            --dark-elegant: #1A1A1A;
            --light-elegant: #F8F5F0;
            --text-dark: #2C2C2C;
            --text-light: #666666;
        }

        /* تحسينات عامة */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-elegant);
        }

        /* تحسين الـ Hero Section */
        .hero-premium {
            background: linear-gradient(rgba(26, 26, 26, 0.85), rgba(26, 26, 26, 0.9)),
                url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
            min-height: 85vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.15) 0%, transparent 50%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .text-gradient {
            background: linear-gradient(90deg, var(--primary-gold), #FFD700, var(--secondary-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .badge-premium {
            background: linear-gradient(45deg, var(--primary-gold), var(--secondary-gold));
            color: var(--dark-elegant);
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* تحسين مربع البحث */
        .search-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            outline: none;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-premium {
            background: linear-gradient(45deg, var(--primary-gold), #E6B325);
            color: var(--dark-elegant);
            border: none;
            padding: 15px 35px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        /* تصميم بطاقات الفئات */
        .category-card {
            background: white;
            border-radius: 20px;
            padding: 40px 25px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-gold), var(--secondary-gold));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            border-color: var(--secondary-gold);
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .category-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--light-elegant), white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            border: 2px solid var(--secondary-gold);
        }

        .category-icon i {
            font-size: 2.5rem;
            background: linear-gradient(45deg, var(--primary-gold), var(--dark-elegant));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* تحسين بطاقات القاعات */
        .venue-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid #eee;
        }

        .venue-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .venue-image {
            height: 280px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .venue-card:hover .venue-image {
            transform: scale(1.05);
        }

        .price-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(45deg, var(--primary-gold), #E6B325);
            color: var(--dark-elegant);
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .rating-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.95);
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .venue-content {
            padding: 25px;
        }

        .venue-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        /* تصميم CTA */
        .cta-section {
            background: linear-gradient(135deg, var(--dark-elegant), #2A2A2A);
            border-radius: 30px;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        }

        .btn-outline-premium {
            border: 2px solid var(--primary-gold);
            color: var(--primary-gold);
            background: transparent;
            padding: 12px 35px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-premium:hover {
            background: var(--primary-gold);
            color: var(--dark-elegant);
        }

        /* تحسينات Responsive */
        @media (max-width: 768px) {
            .hero-premium {
                min-height: 70vh;
                text-align: center;
            }

            .display-3 {
                font-size: 2.5rem;
            }

            .search-container {
                padding: 20px;
            }

            .cta-section {
                padding: 40px 25px;
            }

            .category-card {
                padding: 30px 20px;
            }
        }

        /* تحسينات للخطوط */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
        }

        .lead {
            font-size: 1.25rem;
            line-height: 1.6;
            font-weight: 300;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-premium">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-10 mx-auto text-center hero-content">
                    <div class="badge-premium animate__animated animate__fadeInDown">
                        <i class="fas fa-crown me-2"></i> Premium Venue Selection
                    </div>

                    <h1 class="display-3 fw-bold mb-4 text-white animate__animated animate__fadeInUp">
                        Where Dreams Become <span class="text-gradient">Memories</span>
                    </h1>

                    <p class="lead text-white mb-5 opacity-85 animate__animated animate__fadeInUp animate__delay-1s">
                        Discover Jordan's finest wedding venues. From luxurious halls to enchanting outdoor spaces,
                        we help you find the perfect setting for your special day.
                    </p>

                    <!-- Search Box -->
                    <div class="search-container animate__animated animate__fadeInUp animate__delay-2s">
                        <form class="row g-3 align-items-center justify-content-center">
                            <div class="col-lg-4 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-0 text-white fs-5">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <input type="text" class="form-control search-input border-0 shadow-none"
                                        placeholder="City or venue location">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-0 text-white fs-5">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <input type="date" class="form-control search-input border-0 shadow-none">
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-0 text-white fs-5">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    <select class="form-control search-input border-0 shadow-none">
                                        <option>Guests</option>
                                        <option>50-100</option>
                                        <option>100-300</option>
                                        <option>300-500</option>
                                        <option>500+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <button class="btn btn-premium w-100 h-100">
                                    <i class="fas fa-search me-2"></i> Find Venues
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-uppercase ls-2 mb-3" style="color: var(--primary-gold); letter-spacing: 3px;">
                    <i class="fas fa-star me-2"></i> EXPLORE CATEGORIES
                </h6>
                <h2 class="fw-bold display-5 mb-4">Find Your Perfect Venue Type</h2>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">
                    Browse through our carefully curated categories to find the venue that matches your vision
                </p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach ($categories->where('status', 1)->take(6) as $category)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('explore', ['category_id' => $category->id]) }}" class="text-decoration-none">
                            <div class="category-card h-100">
                                <div class="category-icon"
                                    style="border-color: {{ $category->color }}20; background: {{ $category->color }}10;">
                                    <i class="fas fa-{{ $category->icon }}" style="color: {{ $category->color }};"></i>
                                </div>
                                <h4 class="fw-bold mb-3" style="color: var(--text-dark);">
                                    {{ $category->name }}
                                </h4>
                                <p class="text-muted mb-0">
                                    {{ $category->description ?? 'Premium venues for your special day' }}
                                </p>
                                @if ($category->halls()->count())
                                    <span class="badge">
                                        {{ $category->halls()->count() }} venues
                                    </span>
                                @endif
                                <div class="mt-4">
                                    <span class="fw-bold" style="color: {{ $category->color }};">
                                        Explore <i class="fas fa-arrow-right ms-1"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if ($categories->where('status', 1)->count() > 6)
                <div class="text-center mt-5">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-lg px-5 rounded-pill">
                        View All Categories <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>
    <!-- Featured Venues Section -->
    <section class="py-5 my-5" style="background: white; border-radius: 50px 50px 0 0;">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-end mb-5">
                <div>
                    <h6 class="text-uppercase ls-2 mb-2" style="color: var(--primary-gold); letter-spacing: 3px;">
                        <i class="fas fa-fire me-2"></i> TRENDING NOW
                    </h6>
                    <h2 class="fw-bold display-5 mb-3">Featured Premium Venues</h2>
                    <p class="text-muted mb-0">Most booked venues this season</p>
                </div>
                <a href="{{ route('explore') }}" class="btn btn-outline-dark btn-lg px-4 rounded-pill mt-3 mt-lg-0">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach ($featuredHalls as $hall)
                    <div class="col-md-6 col-lg-3">
                        <div class="venue-card h-100">
                            <div class="position-relative overflow-hidden">
                                <img src="{{ $hall['image'] }}" class="venue-image" alt="{{ $hall['name'] }}">
                                <div class="price-badge">
                                    ${{ number_format($hall['price_per_day']) }}/day
                                </div>
                                <div class="rating-badge">
                                    <i class="fas fa-star text-warning"></i>
                                    <span>{{ $hall['rating'] }}</span>
                                    <span class="text-muted">({{ $hall['reviews'] }})</span>
                                </div>
                            </div>

                            <div class="venue-content">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-1">
                                        {{ $hall['category'] }}
                                    </span>
                                    <small class="text-muted">
                                        <i class="fas fa-users me-1"></i> {{ $hall['capacity'] }}
                                    </small>
                                </div>

                                <h5 class="fw-bold mb-3">{{ $hall['name'] }}</h5>

                                <div class="venue-meta">
                                    <div class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        <small>{{ $hall['location'] }}</small>
                                    </div>
                                    <a href="{{ route('venue.details', ['hall' => $hall['id']]) }}"
                                        class="btn btn-sm btn-dark px-4 rounded-pill">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($featuredHalls->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-building fa-4x text-muted mb-3"></i>
                    <h4>No venues available yet</h4>
                    <p class="text-muted">Check back soon for our premium venues</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="cta-section text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold text-white mb-4">
                            Are You a Venue Owner?
                        </h2>
                        <p class="lead text-white opacity-85 mb-5">
                            Join our exclusive network of premium venues and connect with thousands of couples
                            planning their dream weddings. Increase your bookings and grow your business with us.
                        </p>
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="#" class="btn btn-premium btn-lg px-5 py-3">
                                <i class="fas fa-plus-circle me-2"></i> List Your Venue
                            </a>
                            <a href="#" class="btn btn-outline-premium btn-lg px-5 py-3">
                                <i class="fas fa-play-circle me-2"></i> Watch Tour
                            </a>
                        </div>
                        <div class="mt-4">
                            <small class="text-white opacity-75">
                                <i class="fas fa-shield-alt me-1"></i> Trusted by 500+ venue owners across Jordan
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats Section -->
    <section class="py-5 my-5">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-4">
                        <h2 class="display-4 fw-bold text-gradient mb-2">{{ $stats['total_venues'] }}+</h2>
                        <p class="text-muted mb-0">Premium Venues</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4">
                        <h2 class="display-4 fw-bold text-gradient mb-2">{{ $stats['successful_events'] }}+</h2>
                        <p class="text-muted mb-0">Successful Events</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4">
                        <h2 class="display-4 fw-bold text-gradient mb-2">{{ $stats['client_satisfaction'] }}%</h2>
                        <p class="text-muted mb-0">Client Satisfaction</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-4">
                        <h2 class="display-4 fw-bold text-gradient mb-2">{{ $stats['support_available'] }}</h2>
                        <p class="text-muted mb-0">Support Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@section('scripts')
    <script>
        // إضافة تأثيرات تفاعلية بسيطة
        document.addEventListener('DOMContentLoaded', function() {
            // تأثير التمرير السلس للروابط
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // إضافة تأثير للمدخلات عند التركيز
            const inputs = document.querySelectorAll('.search-input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // إضافة Counter Animation للإحصائيات
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target + (element.textContent.includes('+') ? '+' : '');
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current) + (element.textContent.includes('+') ?
                            '+' : '');
                    }
                }, 20);
            }

            // تشغيل العداد عند التمرير للقسم
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counters = entry.target.querySelectorAll('.display-4');
                        counters.forEach(counter => {
                            const target = parseInt(counter.textContent);
                            animateCounter(counter, target);
                        });
                    }
                });
            });

            const statsSection = document.querySelector('section:last-of-type');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });
    </script>
@endsection
