<!-- resources/views/pages/explore.blade.php -->
@extends('layouts.user')

@section('title', 'Explore Wedding Halls')

@section('content')
<div class="container-custom py-5">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar shadow-soft">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="filter-header mb-0">Filters</h5>
                    <button class="btn btn-sm btn-link text-primary" onclick="resetFilters()">Clear All</button>
                </div>

                <!-- Location Filter -->
                <div class="filter-section">
                    <h6 class="filter-title">Location</h6>
                    <select class="form-select form-select-sm">
                        <option selected>All Cities</option>
                        <option>New York City</option>
                        <option>Los Angeles</option>
                        <option>Chicago</option>
                        <option>Miami</option>
                        <option>Houston</option>
                        <option>Phoenix</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="filter-section">
                    <h6 class="filter-title">Category</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat1" checked>
                        <label class="form-check-label" for="cat1">
                            Luxury
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat2">
                        <label class="form-check-label" for="cat2">
                            Garden
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat3" checked>
                        <label class="form-check-label" for="cat3">
                            Classic
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cat4">
                        <label class="form-check-label" for="cat4">
                            Modern
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="cat5">
                        <label class="form-check-label" for="cat5">
                            Beachfront
                        </label>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="filter-section">
                    <h6 class="filter-title">Price Range</h6>
                    <div class="mb-3">
                        <label class="form-label">$1,000 - $10,000</label>
                        <input type="range" class="form-range" min="1000" max="10000" step="500" value="5000">
                    </div>
                </div>

                <!-- Capacity -->
                <div class="filter-section">
                    <h6 class="filter-title">Capacity</h6>
                    <select class="form-select form-select-sm">
                        <option selected>Any Capacity</option>
                        <option>Up to 100 guests</option>
                        <option>100 - 200 guests</option>
                        <option>200 - 300 guests</option>
                        <option>300+ guests</option>
                    </select>
                </div>

                <!-- Features -->
                <div class="filter-section">
                    <h6 class="filter-title">Features</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="feature1">
                        <label class="form-check-label" for="feature1">
                            <i class="fas fa-utensils text-muted me-1"></i> Catering
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="feature2">
                        <label class="form-check-label" for="feature2">
                            <i class="fas fa-music text-muted me-1"></i> Sound System
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="feature3">
                        <label class="form-check-label" for="feature3">
                            <i class="fas fa-car text-muted me-1"></i> Parking
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="feature4">
                        <label class="form-check-label" for="feature4">
                            <i class="fas fa-wifi text-muted me-1"></i> Wi-Fi
                        </label>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mt-3" onclick="applyFilters()">
                    <i class="fas fa-filter me-2"></i> Apply Filters
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">Explore Wedding Halls</h1>
                    <p class="text-muted mb-0">Showing 24 venues</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i> Sort by: Recommended
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Recommended</a></li>
                            <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                            <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                            <li><a class="dropdown-item" href="#">Capacity</a></li>
                            <li><a class="dropdown-item" href="#">Rating</a></li>
                        </ul>
                    </div>
                    <div class="d-none d-md-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary active">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Halls Grid -->
            <div class="row g-4">
                @php
                    $halls = [
                        [
                            'id' => 1,
                            'name' => 'Grand Ballroom Palace',
                            'location' => 'New York City, NY',
                            'price' => 4500,
                            'capacity' => 300,
                            'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Luxury',
                            'rating' => 4.8,
                            'reviews' => 42,
                            'features' => ['Parking', 'Catering', 'Wi-Fi', 'Sound System']
                        ],
                        [
                            'id' => 2,
                            'name' => 'Garden View Mansion',
                            'location' => 'Los Angeles, CA',
                            'price' => 3200,
                            'capacity' => 200,
                            'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Garden',
                            'rating' => 4.6,
                            'reviews' => 38,
                            'features' => ['Garden', 'Outdoor', 'Catering']
                        ],
                        [
                            'id' => 3,
                            'name' => 'Royal Heritage Hall',
                            'location' => 'Chicago, IL',
                            'price' => 3800,
                            'capacity' => 250,
                            'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Classic',
                            'rating' => 4.9,
                            'reviews' => 56,
                            'features' => ['Historic', 'Sound System', 'Parking']
                        ],
                        [
                            'id' => 4,
                            'name' => 'Modern Skyline Venue',
                            'location' => 'Miami, FL',
                            'price' => 4100,
                            'capacity' => 180,
                            'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Modern',
                            'rating' => 4.7,
                            'reviews' => 31,
                            'features' => ['Roof Deck', 'Wi-Fi', 'Modern']
                        ],
                        [
                            'id' => 5,
                            'name' => 'Oceanfront Elegance',
                            'location' => 'Miami Beach, FL',
                            'price' => 5200,
                            'capacity' => 150,
                            'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Beachfront',
                            'rating' => 4.9,
                            'reviews' => 47,
                            'features' => ['Beachfront', 'Catering', 'Sound System']
                        ],
                        [
                            'id' => 6,
                            'name' => 'Victorian Manor',
                            'location' => 'San Francisco, CA',
                            'price' => 2900,
                            'capacity' => 120,
                            'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Historic',
                            'rating' => 4.5,
                            'reviews' => 29,
                            'features' => ['Historic', 'Garden', 'Parking']
                        ],
                        [
                            'id' => 7,
                            'name' => 'Downtown Loft',
                            'location' => 'New York City, NY',
                            'price' => 3700,
                            'capacity' => 220,
                            'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Modern',
                            'rating' => 4.4,
                            'reviews' => 33,
                            'features' => ['City View', 'Wi-Fi', 'Modern']
                        ],
                        [
                            'id' => 8,
                            'name' => 'Mountain View Lodge',
                            'location' => 'Denver, CO',
                            'price' => 2800,
                            'capacity' => 180,
                            'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                            'category' => 'Nature',
                            'rating' => 4.8,
                            'reviews' => 41,
                            'features' => ['Mountain View', 'Outdoor', 'Parking']
                        ]
                    ];
                @endphp

                @foreach($halls as $hall)
                    <div class="col-md-6 col-lg-4">
                        <div class="card hall-card shadow-hover h-100">
                            <div class="position-relative">
                                <img src="{{ $hall['image'] }}" class="card-img-top" alt="{{ $hall['name'] }}" style="height: 200px; object-fit: cover;">
                                <div class="hall-price">${{ number_format($hall['price']) }}/day</div>
                                <button class="hall-favorite" onclick="toggleFavorite({{ $hall['id'] }})">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge badge-primary">{{ $hall['category'] }}</span>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span class="fw-medium">{{ $hall['rating'] }}</span>
                                        <span class="text-muted ms-1">({{ $hall['reviews'] }})</span>
                                    </div>
                                </div>

                                <h5 class="card-title mb-2">{{ $hall['name'] }}</h5>

                                <p class="card-text text-muted mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $hall['location'] }}
                                </p>

                                <div class="hall-features mb-3">
                                    @foreach(array_slice($hall['features'], 0, 3) as $feature)
                                        <div class="feature-item">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            <span>{{ $feature }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="feature-item">
                                        <i class="fas fa-users text-primary"></i>
                                        <span>Up to {{ $hall['capacity'] }} guests</span>
                                    </div>
                                    <a href="{{ route('hall-details', ['id' => $hall['id']]) }}" class="btn btn-primary btn-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
function toggleFavorite(hallId) {
    const heart = event.currentTarget.querySelector('i');
    if (heart.classList.contains('fas')) {
        heart.classList.replace('fas', 'far');
        showToast('Removed from favorites', 'info');
    } else {
        heart.classList.replace('far', 'fas');
        showToast('Added to favorites', 'success');
    }
}

function applyFilters() {
    showToast('Filters applied successfully', 'success');
}

function resetFilters() {
    const checkboxes = document.querySelectorAll('.form-check-input');
    const selects = document.querySelectorAll('.form-select');
    const range = document.querySelector('.form-range');

    checkboxes.forEach(cb => cb.checked = false);
    selects.forEach(select => select.selectedIndex = 0);
    if (range) range.value = 5000;

    showToast('Filters cleared', 'info');
}
</script>
@endsection
