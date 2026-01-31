@extends(auth()->check() && auth()->user()->role === 'owner' ? 'layouts.venue' : 'layouts.user')

@section('title', ($venue['name'] ?? 'Venue Details') . ' - Royal Wedding Collection')

@section('content')
    <div class="bg-white">
        <!-- Premium Breadcrumb -->
        <div class="container py-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('explore') }}"
                            class="text-muted text-decoration-none">Venues</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $venue['name'] }}</li>
                </ol>
            </nav>
        </div>

        <!-- Luxury Gallery System -->
        <div class="container mb-5">
            <!-- Luxury Image Gallery Slider -->
            <div id="venueCarousel" class="carousel slide rounded-4 overflow-hidden shadow-lg mb-5" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @if ($venue['video_path'])
                        <button type="button" data-bs-target="#venueCarousel" data-bs-slide-to="0" class="active"
                            aria-current="true"></button>
                    @endif
                    @foreach ($venue['images'] as $index => $image)
                        <button type="button" data-bs-target="#venueCarousel"
                            data-bs-slide-to="{{ $venue['video_path'] ? $index + 1 : $index }}"
                            class="{{ !$venue['video_path'] && $index == 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner" style="max-height: 450px;">
                    @if ($venue['video_path'])
                        <div class="carousel-item active">
                            <video class="d-block w-100 object-fit-cover" style="height: 450px;" controls autoplay loop
                                playsinline>
                                <source src="{{ asset('storage/' . $venue['video_path']) }}" type="video/mp4">
                            </video>
                        </div>
                    @endif

                    @foreach ($venue['images'] as $index => $image)
                        <div class="carousel-item {{ !$venue['video_path'] && $index == 0 ? 'active' : '' }}">
                            <img src="{{ $image }}" class="d-block w-100 object-fit-cover" style="height: 450px;"
                                alt="Venue Image {{ $index + 1 }}">
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#venueCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon p-3 bg-dark bg-opacity-25 rounded-circle"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#venueCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon p-3 bg-dark bg-opacity-25 rounded-circle"
                        aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="row g-5">
                <!-- Venue Content -->
                <div class="col-lg-8">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="display-4 luxury-text mb-2">{{ $venue['name'] }}</h1>
                            <p class="text-muted mb-0"><i class="bi bi-geo-alt me-2 text-gold"></i>{{ $venue['location'] }}
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-star-fill text-gold"></i>
                                <span class="fw-bold fs-5">{{ $venue['rating'] }}</span>
                            </div>
                            <p class="small text-muted">{{ $venue['reviews'] }} Guest Reviews</p>
                        </div>
                    </div>

                    <!-- Quick Specs -->
                    <div class="glass-panel p-4 mb-5 border-0 shadow-sm"
                        style="background: var(--premium-cream); border-radius: 20px;">
                        <div class="row text-center">
                            <div class="col-md-3 border-end">
                                <i class="bi bi-people fs-3 text-gold mb-2 d-block"></i>
                                <span class="small text-muted d-block">Capacity</span>
                                <span class="fw-bold text-dark">{{ $venue['capacity'] }}</span>
                            </div>
                            <div class="col-md-3 border-end">
                                <i class="bi bi-arrows-fullscreen fs-3 text-gold mb-2 d-block"></i>
                                <span class="small text-muted d-block">Venue Type</span>
                                <span class="fw-bold text-dark">{{ $venue['category'] }}</span>
                            </div>
                            <div class="col-md-3 border-end">
                                <i class="bi bi-shield-check fs-3 text-gold mb-2 d-block"></i>
                                <span class="small text-muted d-block">Status</span>
                                <span
                                    class="fw-bold text-success border border-success-subtle px-2 rounded-pill small">Verified</span>
                            </div>
                            <div class="col-md-3">
                                <i class="bi bi-currency-dollar fs-3 text-gold mb-2 d-block"></i>
                                <span class="small text-muted d-block">Price Level</span>
                                <span class="fw-bold text-dark">Luxury</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Management -->
                    <ul class="nav nav-pills mb-4 gap-3" id="venueDetailsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom active border-0" data-bs-toggle="pill"
                                data-bs-target="#desc">Overview</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom border-0" data-bs-toggle="pill"
                                data-bs-target="#amen">Amenities</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom border-0" data-bs-toggle="pill" data-bs-target="#pricing">Pricing
                                Policy</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent"
                        style="box-shadow: none; padding: 0; background: transparent;">
                        <div class="tab-pane fade show active" id="desc">
                            <h4 class="luxury-text mb-3">About the Hall</h4>
                            <p class="lead text-muted mb-4">{{ $venue['description'] }}</p>
                            <h5 class="luxury-text mb-3">Key Highlights</h5>
                            <ul class="list-unstyled">
                                @foreach ($venue['highlights'] as $highlight)
                                    <li class="mb-2 d-flex gap-2">
                                        <i class="bi bi-check2-circle text-gold"></i>
                                        <span>{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="amen">
                            <div class="row g-4 mt-1">
                                @foreach ($venue['amenities'] as $amenity)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-4">
                                            <i class="bi bi-{{ $amenity['icon'] }} fs-4 text-gold"></i>
                                            <span class="fw-medium">{{ $amenity['text'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pricing">
                            <div class="premium-card p-4">
                                <h5 class="luxury-text mb-4">Detailed Price List</h5>
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom text-muted">
                                    <span>Peak Season Rate</span>
                                    <span
                                        class="fw-bold text-dark">${{ number_format($venue['pricing']['peak_season'], 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom text-muted">
                                    <span>Off-Season Rate</span>
                                    <span
                                        class="fw-bold text-dark">${{ number_format($venue['pricing']['off_season'], 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom text-muted">
                                    <span>Weekend Surcharge</span>
                                    <span
                                        class="fw-bold text-dark">+${{ number_format($venue['pricing']['weekend_surcharge'], 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between text-muted">
                                    <span>Minimum Hours Required</span>
                                    <span class="fw-bold text-dark">{{ $venue['pricing']['minimum_hours'] }} Hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Sticky Card -->
                <div class="col-lg-4">
                    <div class="sticky-booking-card">
                        <div class="price-tag-luxury">
                            ${{ number_format($venue['price'], 0) }} <span>/ night</span>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-calendar3 text-gold"></i>
                                <span class="fw-bold">Select Date</span>
                            </div>
                            <input type="date" class="form-control form-control-lg rounded-pill border-light bg-light"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <a href="{{ route('bookings.create', $venue['id']) }}" class="btn-royal w-100 py-3 mb-3">Check
                            Availability</a>
                        <p class="text-center small text-muted mb-4">You won't be charged yet</p>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Booking Fee</span>
                            <span>$0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total Estimated</span>    
                            <span class="fw-bold">${{ number_format($venue['price'], 0) }}</span>
                        </div>


                        <p class="text-center small text-muted">
                            Secure payment • Sandbox mode
                        </p>


                        <div class="p-3 bg-light rounded-4 text-center">
                            <p class="small text-muted mb-2">Managed by professional host</p>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Admin&background=D4AF37&color=fff"
                                    class="rounded-circle" style="width: 40px; height: 40px;">
                                <a href="#" class="text-gold fw-bold text-decoration-none small">MESSAGE HOST</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-gold {
            color: var(--royal-gold) !important;
        }

        .nav-link-custom {
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: var(--slate-gray);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link-custom.active {
            color: var(--royal-gold);
            border-bottom: 2px solid var(--royal-gold) !important;
        }
    </style>
@endsection
