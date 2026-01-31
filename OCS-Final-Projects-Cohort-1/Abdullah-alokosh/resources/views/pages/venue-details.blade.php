{{-- @php
    // بيانات القاعة المفترضة - في الحقيقة ستأتي من Controller
    $venue = [
        'id' => 1,
        'name' => 'Grand Royal Hall',
        'price' => 1200,
        'main_image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1200&q=80',
        'images' => [
            'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1519735777090-ec97162dc266?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80',
        ],
        'category' => 'Wedding Hall',
        'location' => 'Amman, Jordan',
        'rating' => 4.8,
        'reviews' => 124,
        'capacity' => '500 Guests',
        'description' => 'The Grand Royal Hall is one of the most prestigious wedding venues in Jordan, offering an unparalleled experience for your special day. With its magnificent architecture, luxurious interiors, and world-class amenities, this venue promises to make your wedding unforgettable.',
        'highlights' => [
            'Luxury interior design with crystal chandeliers',
            'Spacious ballroom with capacity up to 500 guests',
            'Professional sound and lighting systems',
            'Dedicated wedding planning team',
            'Multiple changing rooms and VIP lounge',
            'Valet parking service',
            'Outdoor garden for ceremonies',
            'Catering services available',
        ],
        'amenities' => [
            ['icon' => 'wifi', 'text' => 'High-speed WiF'],
            ['icon' => 'parking', 'text' => 'Free Parking'],
            ['icon' => 'snowflake', 'text' => 'Air Conditioning'],
            ['icon' => 'wheelchair', 'text' => 'Wheelchair Accessible'],
            ['icon' => 'utensils', 'text' => 'Catering Service'],
            ['icon' => 'music', 'text' => 'Sound System'],
            ['icon' => 'video', 'text' => 'Projector & Screen'],
            ['icon' => 'gem', 'text' => 'Luxury Decor'],
        ],
        'reviews_list' => [
            [
                'user' => 'Sarah Mohammed',
                'avatar' => 'https://randomuser.me/api/portraits/women/32.jpg',
                'rating' => 5,
                'date' => '2024-03-15',
                'comment' => 'Absolutely stunning venue! The staff was incredibly professional and made our wedding day perfect.',
            ],
            [
                'user' => 'Ahmed Al-Saadi',
                'avatar' => 'https://randomuser.me/api/portraits/men/54.jpg',
                'rating' => 4,
                'date' => '2024-02-28',
                'comment' => 'Beautiful hall with excellent service. The lighting and decor were exactly what we wanted.',
            ],
            [
                'user' => 'Layla Hassan',
                'avatar' => 'https://randomuser.me/api/portraits/women/67.jpg',
                'rating' => 5,
                'date' => '2024-01-10',
                'comment' => 'Best wedding venue in Amman! The team went above and beyond to accommodate our needs.',
            ],
        ],
        'owner' => [
            'name' => 'Royal Venues Group',
            'avatar' => 'https://randomuser.me/api/portraits/men/75.jpg',
            'joined' => '2020',
            'venues' => 8,
            'rating' => 4.9,
        ],
        'pricing' => [
            'peak_season' => 1500,
            'off_season' => 1000,
            'weekend_surcharge' => 200,
            'minimum_hours' => 5,
        ],
        'availability' => [
            '2024' => [
                '04' => ['15', '16', '20', '25'],
                '05' => ['01', '02', '10', '15', '20'],
                '06' => ['05', '12', '18', '25'],
            ],
        ],
    ];
@endphp

@extends('layouts.user')

@section('title', $venue['name'] . ' - Wedding Venue Details')

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

    /* تأثيرات إضافية */
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
            <li class="breadcrumb-item"><a href="#">{{ $venue['category'] }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $venue['name'] }}</li>
        </ol>
    </div>
</nav>

<div class="container">
    <!-- معرض الصور -->
    <div class="row mb-5 fade-in">
        <div class="col-lg-8">
            <div class="gallery-container">
                <img src="{{ $venue['main_image'] }}" alt="{{ $venue['name'] }}" class="main-image" id="mainImage">

                <div class="thumbnails-container">
                    @foreach($venue['images'] as $index => $image)
                        <img src="{{ $image }}"
                             alt="{{ $venue['name'] }} - Image {{ $index + 1 }}"
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             onclick="changeMainImage('{{ $image }}', this)">
                    @endforeach
                </div>
            </div>
        </div>

        <!-- معلومات القاعة -->
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

                <div class="d-flex flex-wrap gap-3 mb-4">
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-users me-1"></i> {{ $venue['capacity'] }}
                    </span>
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-building me-1"></i> {{ $venue['category'] }}
                    </span>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary flex-fill">
                        <i class="fas fa-heart me-2"></i> Save
                    </button>
                    <button class="btn btn-outline-secondary flex-fill">
                        <i class="fas fa-share-alt me-2"></i> Share
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- المحتوى الرئيسي -->
        <div class="col-lg-8">
            <!-- علامات التبويب -->
            <ul class="nav nav-tabs nav-tabs-luxury" id="venueTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                        <i class="fas fa-info-circle me-2"></i> Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="amenities-tab" data-bs-toggle="tab" data-bs-target="#amenities" type="button" role="tab">
                        <i class="fas fa-concierge-bell me-2"></i> Amenities
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                        <i class="fas fa-star me-2"></i> Reviews
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" type="button" role="tab">
                        <i class="fas fa-calendar-alt me-2"></i> Availability
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="venueTabsContent">
                <!-- نظرة عامة -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel">
                    <h3 class="section-title">Description</h3>
                    <p class="lead">{{ $venue['description'] }}</p>

                    <h3 class="section-title mt-5">Highlights</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="highlights-list">
                                @foreach(array_slice($venue['highlights'], 0, ceil(count($venue['highlights']) / 2)) as $highlight)
                                    <li>{{ $highlight }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="highlights-list">
                                @foreach(array_slice($venue['highlights'], ceil(count($venue['highlights']) / 2)) as $highlight)
                                    <li>{{ $highlight }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- مالك القاعة -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="section-title">Venue Owner</h3>
                            <div class="owner-card">
                                <img src="{{ $venue['owner']['avatar'] }}" alt="{{ $venue['owner']['name'] }}" class="owner-avatar">
                                <h4 class="fw-bold mb-2">{{ $venue['owner']['name'] }}</h4>
                                <p class="text-muted mb-3">Venue Manager</p>
                                <div class="d-flex justify-content-center gap-4 mb-3">
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $venue['owner']['venues'] }}</div>
                                        <small class="text-muted">Venues</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $venue['owner']['rating'] }}</div>
                                        <small class="text-muted">Rating</small>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $venue['owner']['joined'] }}</div>
                                        <small class="text-muted">Since</small>
                                    </div>
                                </div>
                                <button class="btn btn-outline-primary btn-sm">Contact Owner</button>
                            </div>
                        </div>
                    </div>

                    <!-- الخريطة -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <h3 class="section-title">Location</h3>
                            <div class="map-container">
                                <!-- هنا سيتم وضع خريطة Google Maps -->
                                <div style="width:100%;height:100%;background:#eee;display:flex;align-items:center;justify-content:center;">
                                    <div class="text-center">
                                        <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Map Location</p>
                                        <p class="small">{{ $venue['location'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- المرافق -->
                <div class="tab-pane fade" id="amenities" role="tabpanel">
                    <h3 class="section-title">Amenities & Services</h3>
                    <div class="amenities-grid">
                        @foreach($venue['amenities'] as $amenity)
                            <div class="amenity-item">
                                <div class="amenity-icon">
                                    <i class="fas fa-{{ $amenity['icon'] }}"></i>
                                </div>
                                <span class="fw-medium">{{ $amenity['text'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- التسعير -->
                    <h3 class="section-title mt-5">Pricing Details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-calendar-day text-warning me-2"></i> Peak Season</h5>
                                    <h2 class="text-primary">${{ number_format($venue['pricing']['peak_season']) }}</h2>
                                    <small class="text-muted">April - September</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-calendar-alt text-success me-2"></i> Off Season</h5>
                                    <h2 class="text-success">${{ number_format($venue['pricing']['off_season']) }}</h2>
                                    <small class="text-muted">October - March</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Minimum booking duration: {{ $venue['pricing']['minimum_hours'] }} hours.
                                Weekend surcharge: ${{ number_format($venue['pricing']['weekend_surcharge']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- التقييمات -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="section-title mb-0">Customer Reviews</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                            <i class="fas fa-pen me-2"></i> Write Review
                        </button>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="display-4 fw-bold text-primary mb-2">{{ $venue['rating'] }}</div>
                            <div class="review-stars mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i > $venue['rating'] ? '-half-alt' : '' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted">{{ $venue['reviews'] }} reviews</small>
                        </div>
                        <div class="col-md-8">
                            <!-- Rating breakdown هنا -->
                        </div>
                    </div>

                    @foreach($venue['reviews_list'] as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <img src="{{ $review['avatar'] }}" alt="{{ $review['user'] }}" class="review-avatar">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $review['user'] }}</h6>
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i > $review['rating'] ? '' : ' text-warning' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ date('F j, Y', strtotime($review['date'])) }}</small>
                                </div>
                            </div>
                            <p class="mb-0">{{ $review['comment'] }}</p>
                        </div>
                    @endforeach

                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-outline-primary">Load More Reviews</a>
                    </div>
                </div>

                <!-- التقويم -->
                <div class="tab-pane fade" id="calendar" role="tabpanel">
                    <h3 class="section-title">Availability Calendar</h3>

                    <div class="calendar-container">
                        <div class="calendar-header">
                            <h5 class="fw-bold mb-0">April 2024</h5>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-left"></i></button>
                                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>

                        <div class="calendar-grid mb-3">
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="fw-bold text-muted">{{ $day }}</div>
                            @endforeach

                            @for($i = 1; $i <= 30; $i++)
                                @php
                                    $isBooked = in_array($i, $venue['availability']['2024']['04'] ?? []);
                                @endphp
                                <div class="calendar-day {{ $isBooked ? 'booked' : 'available' }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>

                        <div class="legend d-flex justify-content-center gap-4">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:15px;height:15px;background:rgba(40,167,69,0.1);border:1px solid #28a745;border-radius:3px;"></div>
                                <small>Available</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:15px;height:15px;background:rgba(220,53,69,0.1);border:1px solid #dc3545;border-radius:3px;"></div>
                                <small>Booked</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success mt-4">
                        <i class="fas fa-calendar-check me-2"></i>
                        This venue is available for {{ count(array_diff(range(1, 30), $venue['availability']['2024']['04'] ?? [])) }} days in April
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقة الحجز -->
        <div class="col-lg-4">
            <div class="booking-card">
                <div class="price-display">
                    <div class="price-amount">${{ number_format($venue['price']) }}</div>
                    <div class="price-period">per night</div>
                    <small class="text-muted">+ taxes & fees</small>
                </div>

                <form class="booking-form">
                    @csrf
                    <input type="hidden" name="venue_id" value="{{ $venue['id'] }}">

                    <div class="mb-3">
                        <label class="form-label">Check-in Date</label>
                        <input type="date" class="form-control form-control-luxury" name="check_in" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Check-out Date</label>
                        <input type="date" class="form-control form-control-luxury" name="check_out" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guests</label>
                        <select class="form-control form-control-luxury" name="guests" required>
                            <option value="">Select number of guests</option>
                            <option value="1-50">1-50 Guests</option>
                            <option value="51-100">51-100 Guests</option>
                            <option value="101-200">101-200 Guests</option>
                            <option value="201-300">201-300 Guests</option>
                            <option value="301-400">301-400 Guests</option>
                            <option value="401-500">401-500 Guests</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Event Type</label>
                        <select class="form-control form-control-luxury" name="event_type" required>
                            <option value="">Select event type</option>
                            <option value="wedding">Wedding</option>
                            <option value="engagement">Engagement</option>
                            <option value="birthday">Birthday</option>
                            <option value="corporate">Corporate Event</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-book-now mb-3">
                        <i class="fas fa-calendar-check me-2"></i> Book Now
                    </button>

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-lock me-1"></i> Secure booking • Free cancellation within 48 hours
                        </small>
                    </div>
                </form>

                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Base price</span>
                        <span>${{ number_format($venue['price']) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Service fee</span>
                        <span>${{ number_format($venue['price'] * 0.1) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Taxes</span>
                        <span>${{ number_format($venue['price'] * 0.08) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span>${{ number_format($venue['price'] * 1.18) }}</span>
                    </div>
                </div>
            </div>

            <!-- القاعات المشابهة -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Similar Venues</h5>
                    @foreach($featuredHalls as $similar)
                        @if($similar['name'] !== $venue['name'])
                            <div class="d-flex gap-3 mb-3">
                                <img src="{{ $similar['image'] }}" alt="{{ $similar['name'] }}"
                                     style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $similar['name'] }}</h6>
                                    <div class="d-flex align-items-center mb-1">
                                        <small class="text-warning me-2">
                                            <i class="fas fa-star"></i> {{ $similar['rating'] }}
                                        </small>
                                        <small class="text-muted">${{ number_format($similar['price']) }}/night</small>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal للتقيم -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Write a Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reviewForm">
                    <div class="mb-3 text-center">
                        <h6>How would you rate this venue?</h6>
                        <div class="rating-stars-large">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star fa-2x text-muted" data-rating="{{ $i }}" onclick="setRating({{ $i }})"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingValue">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Summarize your experience">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Your Review</label>
                        <textarea class="form-control" name="comment" rows="5" placeholder="Share details of your experience..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitReview()">Submit Review</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // تغيير الصورة الرئيسية
    function changeMainImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.thumbnail').forEach(thumb => {
            thumb.classList.remove('active');
        });
        element.classList.add('active');
    }

    // تعيين التقييم
    function setRating(rating) {
        const stars = document.querySelectorAll('.rating-stars-large i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('text-warning');
                star.classList.remove('text-muted');
            } else {
                star.classList.remove('text-warning');
                star.classList.add('text-muted');
            }
        });
        document.getElementById('ratingValue').value = rating;
    }

    // إرسال التقييم
    function submitReview() {
        const rating = document.getElementById('ratingValue').value;
        const form = document.getElementById('reviewForm');

        if (!rating) {
            alert('Please select a rating');
            return;
        }

        // هنا سيتم إرسال البيانات إلى السيرفر
        alert('Thank you for your review!');
        $('#reviewModal').modal('hide');
        form.reset();

        // إعادة تعيين النجوم
        document.querySelectorAll('.rating-stars-large i').forEach(star => {
            star.classList.remove('text-warning');
            star.classList.add('text-muted');
        });
    }

    // حاسبة السعر
    function calculateTotal() {
        const basePrice = {{ $venue['price'] }};
        const serviceFee = basePrice * 0.1;
        const taxes = basePrice * 0.08;
        return basePrice + serviceFee + taxes;
    }

    // تهيئة التقويم
    document.addEventListener('DOMContentLoaded', function() {
        // تحديث التواريخ في نموذج الحجز
        const today = new Date().toISOString().split('T')[0];
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const tomorrowStr = tomorrow.toISOString().split('T')[0];

        document.querySelector('input[name="check_in"]').min = today;
        document.querySelector('input[name="check_out"]').min = tomorrowStr;

        // عند تغيير تاريخ الدخول
        document.querySelector('input[name="check_in"]').addEventListener('change', function() {
            const checkIn = new Date(this.value);
            const checkOut = new Date(checkIn);
            checkOut.setDate(checkOut.getDate() + 1);
            document.querySelector('input[name="check_out"]').min = checkOut.toISOString().split('T')[0];
        });

        // تأثيرات التمرير للعلامات
        const tabs = document.querySelectorAll('.nav-tabs-luxury .nav-link');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('fade-in');
                    void pane.offsetWidth; // Trigger reflow
                    pane.classList.add('fade-in');
                });
            });
        });

        // عرض رسالة عند محاولة الحجز
        document.querySelector('.booking-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const checkIn = document.querySelector('input[name="check_in"]').value;
            const guests = document.querySelector('select[name="guests"]').value;

            if (!checkIn || !guests) {
                alert('Please fill all required fields');
                return;
            }

            // محاكاة عملية الحجز
            const btn = document.querySelector('.btn-book-now');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Booking request submitted successfully! We will contact you shortly.');
            }, 2000);
        });
    });
</script>
@endsection --}}
