@extends('layouts.user')

@if (isset($venue) && isset($venue['name']))
    @section('title', $venue['name'] . ' - Wedding Venue Details')
@else
    @section('title', 'Venue Details')
@endif

@section('content')
    <style>
        /* متغيرات التصميم */
        :root {
            --primary-gold: #D4AF37;
            --secondary-gold: #F4E4B5;
            --dark-elegant: #1A1A1A;
            --light-elegant: #F8F5F0;
            --text-dark: #2C2C2C;
            --text-light: #666666;
            --success-color: #28a745;
            --warning-color: #ffc107;
        }

        /* تحسينات عامة */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
        }

        /* Breadcrumb */
        .breadcrumb-luxury {
            background: transparent;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-luxury .breadcrumb-item a {
            color: var(--text-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-luxury .breadcrumb-item a:hover {
            color: var(--primary-gold);
        }

        .breadcrumb-luxury .breadcrumb-item.active {
            color: var(--primary-gold);
            font-weight: 600;
        }

        /* معرض الصور */
        .gallery-container {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .main-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .main-image:hover {
            transform: scale(1.01);
        }

        .thumbnails-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .thumbnail {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--primary-gold);
            transform: scale(1.05);
        }

        /* معلومات القاعة */
        .venue-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .venue-title {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .venue-location {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .rating-badge-large {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, var(--primary-gold), #E6B325);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .rating-badge-large i {
            margin-right: 8px;
        }

        /* بطاقة الحجز */
        .booking-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 100px;
            margin-bottom: 2rem;
        }

        .price-display {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .price-amount {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-gold);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .price-period {
            color: var(--text-light);
            font-size: 1rem;
        }

        .booking-form .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control-luxury {
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control-luxury:focus {
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .btn-book-now {
            background: linear-gradient(45deg, var(--primary-gold), #E6B325);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-book-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(212, 175, 55, 0.4);
        }

        /* علامات التبويب */
        .nav-tabs-luxury {
            border-bottom: 2px solid #eee;
            margin-bottom: 2rem;
        }

        .nav-tabs-luxury .nav-link {
            color: var(--text-light);
            font-weight: 600;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px 12px 0 0;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .nav-tabs-luxury .nav-link:hover {
            color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.1);
        }

        .nav-tabs-luxury .nav-link.active {
            color: var(--primary-gold);
            background: white;
            border-bottom: 3px solid var(--primary-gold);
        }

        .tab-content {
            background: white;
            border-radius: 0 20px 20px 20px;
            padding: 2.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        /* قسم التفاصيل */
        .section-title {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--light-elegant);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-gold), transparent);
        }

        /* المميزات */
        .highlights-list {
            list-style: none;
            padding: 0;
        }

        .highlights-list li {
            padding: 0.5rem 0;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }

        .highlights-list li::before {
            content: '✓';
            color: var(--success-color);
            font-weight: bold;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* المرافق */
        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .amenity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem;
            background: var(--light-elegant);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .amenity-item:hover {
            background: rgba(212, 175, 55, 0.1);
            transform: translateY(-2px);
        }

        .amenity-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-gold), var(--secondary-gold));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        /* التقييمات */
        .review-card {
            background: var(--light-elegant);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
            border: 2px solid var(--primary-gold);
        }

        .review-stars {
            color: var(--warning-color);
            margin-bottom: 0.5rem;
        }

        /* مالك القاعة */
        .owner-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .owner-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .owner-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            border: 3px solid var(--primary-gold);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        /* التقويم */
        .calendar-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            text-align: center;
        }

        .calendar-day {
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .calendar-day:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .calendar-day.available {
            background: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            font-weight: 600;
        }

        .calendar-day.booked {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            text-decoration: line-through;
            cursor: not-allowed;
        }

        /* الخريطة */
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            height: 300px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-image {
                height: 300px;
            }

            .venue-title {
                font-size: 1.8rem;
            }

            .booking-card {
                position: static;
            }

            .tab-content {
                padding: 1.5rem;
            }

            .nav-tabs-luxury .nav-link {
                padding: 0.8rem 1rem;
                font-size: 0.9rem;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-luxury">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('explore') }}">Venues</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $venue['name'] }}</li>
            </ol>
        </div>
    </nav>

    <div class="container">
        <!-- معرض الصور (نفسه) -->
        <div class="row mb-5 fade-in">
            <div class="col-lg-8">
                <div class="gallery-container">
                    <img src="{{ $venue['main_image'] }}" alt="{{ $venue['name'] }}" class="main-image" id="mainImage">
                    <div class="thumbnails-container">
                        @foreach ($venue['images'] as $index => $image)
                            <img src="{{ $image }}" class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                onclick="changeMainImage('{{ $image }}', this)">
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- معلومات القاعة + زر الحجز -->
            <div class="col-lg-4">
                <div class="venue-header">
                    <h1 class="venue-title">{{ $venue['name'] }}</h1>
                    <p class="venue-location">
                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                        {{ $venue['location'] }}
                    </p>

                    <div class="rating-badge-large">
                        <i class="fas fa-star"></i>
                        <span>{{ $venue['rating'] }} ({{ $venue['reviews'] }} reviews)</span>
                    </div>

                    <!-- إحصائيات سريعة -->
                    <div class="quick-stats mb-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="stat-box">
                                    <i class="fas fa-users text-primary"></i>
                                    <span>{{ $venue['capacity'] }}</span>
                                    <small>Capacity</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-box">
                                    <i class="fas fa-tag text-warning"></i>
                                    <span>${{ number_format($venue['price']) }}</span>
                                    <small>Starting price</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر الحجز الرئيسي -->
                    <div class="booking-cta">
                        <a href="{{ route('bookings.create', $venue['id']) }}" class="btn btn-book-now w-100 mb-3">
                            <i class="fas fa-calendar-check me-2"></i> Check Availability & Book Now
                        </a>

                        <div class="text-center">
                            <small class="text-muted d-block">
                                <i class="fas fa-shield-alt me-1"></i> Secure booking
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> Instant confirmation
                            </small>
                        </div>
                    </div>
                </div>

                <!-- معلومات الاتصال -->
                <div class="contact-card mt-3">
                    <div class="d-flex align-items-center mb-3">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="ms-3">
                            <small class="text-muted">Need help?</small>
                            <div class="fw-bold">+962 79 000 0000</div>
                        </div>
                    </div>
                    <button class="btn btn-outline-secondary w-100">
                        <i class="fas fa-envelope me-2"></i> Contact Venue
                    </button>
                </div>
            </div>
        </div>

        <!-- علامات التبويب (نفسها بدون قسم الحجز) -->
        <ul class="nav nav-tabs nav-tabs-luxury" id="venueTabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview">
                    <i class="fas fa-info-circle me-2"></i> Overview
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#amenities">
                    <i class="fas fa-concierge-bell me-2"></i> Amenities
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">
                    <i class="fas fa-star me-2"></i> Reviews
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#location">
                    <i class="fas fa-map-marker-alt me-2"></i> Location
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Overview Tab -->
            <div class="tab-pane fade show active" id="overview">
                <h3 class="section-title">About This Venue</h3>
                <p class="lead">{{ $venue['description'] }}</p>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Highlights</h5>
                        <ul class="highlights-list">
                            @foreach ($venue['highlights'] as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-3">Quick Facts</h5>
                        <div class="facts-grid">
                            <div class="fact-item">
                                <i class="fas fa-building"></i>
                                <span>Venue Type:</span>
                                <strong>{{ $venue['category'] }}</strong>
                            </div>
                            <div class="fact-item">
                                <i class="fas fa-expand-arrows-alt"></i>
                                <span>Space Size:</span>
                                <strong>Large Ballroom</strong>
                            </div>
                            <div class="fact-item">
                                <i class="fas fa-car"></i>
                                <span>Parking:</span>
                                <strong>Available (200+ cars)</strong>
                            </div>
                            <div class="fact-item">
                                <i class="fas fa-wifi"></i>
                                <span>WiFi:</span>
                                <strong>High-speed Free</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities Tab -->
            <div class="tab-pane fade" id="amenities">
                <h3 class="section-title">Amenities & Services</h3>
                <div class="amenities-grid">
                    @foreach ($venue['amenities'] as $amenity)
                        <div class="amenity-item">
                            <div class="amenity-icon">
                                <i class="fas fa-{{ $amenity['icon'] }}"></i>
                            </div>
                            <span>{{ $amenity['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="section-title mb-0">Customer Reviews</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        <i class="fas fa-pen me-2"></i> Write Review
                    </button>
                </div>

                <!-- Reviews content هنا -->
                @foreach ($venue['reviews_list'] as $review)
                    <div class="review-card">
                        <!-- Review content -->
                    </div>
                @endforeach
            </div>

            <!-- Location Tab -->
            <div class="tab-pane fade" id="location">
                <h3 class="section-title">Location & Directions</h3>
                <div class="map-container mb-4">
                    <!-- Map -->
                </div>
                <div class="directions">
                    <h5>Getting There</h5>
                    <ul>
                        <li><strong>From Airport:</strong> 45 minutes drive</li>
                        <li><strong>Public Transport:</strong> Bus stop 500m away</li>
                        <li><strong>Parking:</strong> Free on-site parking available</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- القاعات المشابهة -->
        <div class="similar-venues mt-5">
            <h3 class="section-title">Similar Venues You Might Like</h3>
            <div class="row">
                @foreach ($featuredHalls as $similar)
                    @if ($similar['id'] !== $venue['id'])
                        <div class="col-md-4">
                            <div class="venue-card-sm">
                                <img src="{{ $similar['image'] }}" alt="{{ $similar['name'] }}">
                                <div class="venue-content">
                                    <h6>{{ $similar['name'] }}</h6>
                                    <div class="d-flex justify-content-between">
                                        <span class="price">${{ number_format($similar['price_per_day']) }}</span>
                                        <a href="{{ route('venue.details', $similar['id']) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal">
        <!-- Modal content -->
    </div>

@endsection

@section('scripts')
    <script>
        // Gallery functions
        function changeMainImage(src, element) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Tab animations
        document.addEventListener('DOMContentLoaded', function() {
            const tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => {
                pane.classList.add('fade-in');
            });
        });
    </script>
@endsection
