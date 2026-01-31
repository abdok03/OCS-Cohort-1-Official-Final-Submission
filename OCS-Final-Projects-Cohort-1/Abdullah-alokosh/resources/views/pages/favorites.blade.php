<!-- resources/views/pages/favorites.blade.php -->
@extends('layouts.user')

@section('title', 'My Favorites')

@section('content')
<div class="container-custom py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="mb-2">My Favorites</h1>
                    <p class="text-muted mb-0">Your saved wedding and engagement halls</p>
                </div>
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-primary" onclick="shareFavorites()">
                        <i class="fas fa-share-alt me-2"></i> Share List
                    </button>
                    <button class="btn btn-outline-danger" onclick="clearAllFavorites()">
                        <i class="fas fa-trash-alt me-2"></i> Clear All
                    </button>
                </div>
            </div>

            <!-- Favorites Grid -->
            <div class="row g-4" id="favoritesGrid">
                @php
                    $favorites = [
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
                            'added_date' => '2024-01-15'
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
                            'added_date' => '2024-01-10'
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
                            'added_date' => '2024-01-08'
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
                            'added_date' => '2024-01-05'
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
                            'added_date' => '2024-01-03'
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
                            'added_date' => '2024-01-02'
                        ],
                    ];
                @endphp

                @foreach($favorites as $favorite)
                    <div class="col-md-6 col-lg-4" id="favorite-{{ $favorite['id'] }}">
                        <div class="card hall-card shadow-hover h-100">
                            <div class="position-relative">
                                <img src="{{ $favorite['image'] }}" class="card-img-top" alt="{{ $favorite['name'] }}" style="height: 200px; object-fit: cover;">
                                <div class="hall-price">${{ number_format($favorite['price']) }}/day</div>
                                <button class="hall-favorite active" onclick="removeFavorite({{ $favorite['id'] }})">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge badge-primary">{{ $favorite['category'] }}</span>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-1"></i>
                                        <span class="fw-medium">{{ $favorite['rating'] }}</span>
                                        <span class="text-muted ms-1">({{ $favorite['reviews'] }})</span>
                                    </div>
                                </div>

                                <h5 class="card-title mb-2">{{ $favorite['name'] }}</h5>

                                <p class="card-text text-muted mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $favorite['location'] }}
                                </p>

                                <div class="hall-features mb-3">
                                    <div class="feature-item">
                                        <i class="fas fa-users text-primary"></i>
                                        <span>Up to {{ $favorite['capacity'] }} guests</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <span>Added {{ date('M d, Y', strtotime($favorite['added_date'])) }}</span>
                                    </div>
                                </div>

                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('hall-details', ['id' => $favorite['id']]) }}"
                                       class="btn btn-primary flex-grow-1">
                                        View Details
                                    </a>
                                    <button class="btn btn-outline-primary"
                                            onclick="checkAvailability({{ $favorite['id'] }})"
                                            data-bs-toggle="tooltip"
                                            title="Check Availability">
                                        <i class="fas fa-calendar-check"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State (Hidden by default) -->
            <div id="emptyFavorites" class="empty-state d-none">
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                    <h3 class="empty-state-title mb-3">No Favorites Yet</h3>
                    <p class="empty-state-text mb-4">
                        You haven't added any halls to your favorites yet. Start exploring and save your favorite venues for later.
                    </p>
                    <a href="{{ route('explore') }}" class="btn btn-primary btn-icon">
                        <i class="fas fa-search me-2"></i> Explore Halls
                    </a>
                </div>
            </div>

            <!-- Compare Section -->
            <div class="mt-5" id="compareSection">
                <div class="card shadow-soft">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="mb-1">Compare Favorites</h5>
                                <p class="text-muted mb-0">Select halls to compare features and pricing</p>
                            </div>
                            <button class="btn btn-primary" onclick="compareSelected()">
                                <i class="fas fa-exchange-alt me-2"></i> Compare Selected
                            </button>
                        </div>

                        <div class="row g-3" id="compareSelection">
                            @foreach(array_slice($favorites, 0, 3) as $favorite)
                                <div class="col-md-4">
                                    <div class="form-check card-checkbox">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="compare-{{ $favorite['id'] }}"
                                               value="{{ $favorite['id'] }}">
                                        <label class="form-check-label w-100" for="compare-{{ $favorite['id'] }}">
                                            <div class="d-flex align-items-center p-2 rounded border">
                                                <img src="{{ $favorite['image'] }}"
                                                     alt="{{ $favorite['name'] }}"
                                                     class="rounded me-3"
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-medium">{{ $favorite['name'] }}</div>
                                                    <small class="text-muted">${{ number_format($favorite['price']) }}/day</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeFavorite(hallId) {
    const card = document.getElementById(`favorite-${hallId}`);
    if (card) {
        card.style.opacity = '0.5';
        card.style.transform = 'scale(0.95)';

        setTimeout(() => {
            card.remove();
            updateEmptyState();
            showToast('Removed from favorites', 'info');
        }, 300);
    }
}

function clearAllFavorites() {
    showConfirmation(
        'Clear All Favorites',
        'Are you sure you want to remove all halls from your favorites? This action cannot be undone.',
        function() {
            const favoritesGrid = document.getElementById('favoritesGrid');
            const cards = favoritesGrid.querySelectorAll('.col-md-6.col-lg-4');

            cards.forEach(card => {
                card.style.opacity = '0.5';
                card.style.transform = 'scale(0.95)';

                setTimeout(() => {
                    card.remove();
                }, 300);
            });

            setTimeout(() => {
                updateEmptyState();
                showToast('All favorites cleared', 'info');
            }, 500);
        }
    );
}

function shareFavorites() {
    const favorites = @json($favorites);
    const favoriteNames = favorites.map(f => f.name).join(', ');

    // In a real app, this would trigger a share dialog
    showToast('Favorites list copied to clipboard!', 'success');

    // Simulate copying to clipboard
    navigator.clipboard.writeText(`My favorite wedding halls: ${favoriteNames}`);
}

function checkAvailability(hallId) {
    showToast('Checking availability for hall...', 'info');
    // In a real app, this would open a calendar modal
}

function compareSelected() {
    const checkboxes = document.querySelectorAll('#compareSelection input[type="checkbox"]:checked');
    if (checkboxes.length < 2) {
        showToast('Please select at least 2 halls to compare', 'warning');
        return;
    }

    const selectedIds = Array.from(checkboxes).map(cb => cb.value);
    showToast(`Comparing ${selectedIds.length} halls...`, 'info');
    // In a real app, this would open a comparison modal
}

function updateEmptyState() {
    const favoritesGrid = document.getElementById('favoritesGrid');
    const emptyState = document.getElementById('emptyFavorites');
    const compareSection = document.getElementById('compareSection');

    if (favoritesGrid.children.length === 0) {
        emptyState.classList.remove('d-none');
        compareSection.classList.add('d-none');
    } else {
        emptyState.classList.add('d-none');
        compareSection.classList.remove('d-none');
    }
}
</script>

<style>
.card-checkbox .form-check-input {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1;
}

.card-checkbox .form-check-label {
    cursor: pointer;
    transition: all 0.2s ease;
}

.card-checkbox .form-check-input:checked + .form-check-label > div {
    border-color: var(--primary);
    background-color: rgba(99, 102, 241, 0.05);
}

.card-checkbox .form-check-label:hover > div {
    border-color: var(--primary);
}
</style>
@endsection
