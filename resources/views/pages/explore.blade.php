@extends('layouts.user')

@section('title', 'Explore the Royal Collection - Find Your Venue')

@section('content')
<div class="py-5" style="background: var(--ivory-white); min-height: 100vh;">
    <!-- Page Header -->
    <div class="container mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="text-uppercase tracking-widest small fw-bold text-muted mb-2 d-block" style="letter-spacing: 0.2em;">The Curated Collection</span>
                <h1 class="display-4 luxury-text mb-0">Discover Exclusive <span class="text-gold">Venues</span></h1>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="small text-muted">
                    Showing <span id="resultsCount" class="fw-bold text-dark">{{ $halls->total() }}</span> exceptional properties
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-5">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="sticky-top" style="top: 120px;">
                    <div class="filter-panel p-4 bg-white rounded-5 shadow-sm border-0">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="luxury-text mb-0">Filter By</h5>
                            <button class="btn btn-link text-gold p-0 small text-decoration-none fw-bold" onclick="clearAllFilters()">RESET</button>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-5">
                            <label class="small fw-bold text-muted text-uppercase mb-3 d-block">Investment Cap</label>
                            <input type="range" class="form-range custom-range" id="priceRange" min="0" max="5000" value="{{ request('max_price', 5000) }}" oninput="updatePriceDisplay()">
                            <div class="d-flex justify-content-between mt-2">
                                <span class="small text-muted">$0</span>
                                <span class="small fw-bold text-dark" id="maxPriceDisplay">$5000+</span>
                            </div>
                        </div>

                        <!-- Locations -->
                        <div class="mb-5">
                             <label class="small fw-bold text-muted text-uppercase mb-3 d-block">Geography</label>
                             <div class="filter-scrollable pe-2" style="max-height: 180px; overflow-y: auto;">
                                @php
                                    $cities = \App\Models\Hall::select('city')->whereNotNull('city')->distinct()->pluck('city')->toArray();
                                @endphp
                                @foreach($cities as $city)
                                <div class="form-check custom-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="city[]" value="{{ $city }}" id="city-{{ $loop->index }}" onchange="updateFilters(); applyFilters();">
                                    <label class="form-check-label small" for="city-{{ $loop->index }}">{{ $city }}</label>
                                </div>
                                @endforeach
                             </div>
                        </div>

                        <!-- Collections/Categories -->
                        <div class="mb-5">
                            <label class="small fw-bold text-muted text-uppercase mb-3 d-block">Ceremony Type</label>
                            @foreach($categories as $category)
                            <div class="form-check custom-check mb-2">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}" {{ request('category') == $category->id ? 'checked' : '' }} onchange="updateFilters(); applyFilters();">
                                <label class="form-check-label small" for="cat-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <!-- Capacity -->
                        <div class="mb-4">
                            <label class="small fw-bold text-muted text-uppercase mb-3 d-block">Guest Integrity</label>
                            @foreach ([['label' => 'Boutique (<100)', 'min' => 0, 'max' => 100, 'val' => '0-100'], ['label' => 'Grand (100-500)', 'min' => 100, 'max' => 500, 'val' => '100-500'], ['label' => 'Royal (500+)', 'min' => 500, 'max' => 10000, 'val' => '500-10000']] as $capacity)
                            <div class="form-check custom-check mb-2">
                                <input class="form-check-input" type="checkbox" name="capacity[]" value="{{ $capacity['val'] }}" id="cap-{{ $loop->index }}" onchange="updateFilters(); applyFilters();">
                                <label class="form-check-label small" for="cap-{{ $loop->index }}">{{ $capacity['label'] }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Results -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-end align-items-center mb-4">
                    <div class="dropdown">
                        <button class="btn btn-white bg-white shadow-sm border-0 rounded-pill btn-sm px-4 py-2 fw-bold" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-sort-down me-2 text-gold"></i> <span id="sortLabel">Select Sort</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                            <li><a class="dropdown-item rounded-3" href="#" onclick="setSort('recommended')">Recommended</a></li>
                            <li><a class="dropdown-item rounded-3" href="#" onclick="setSort('price_low')">Price: Low to High</a></li>
                            <li><a class="dropdown-item rounded-3" href="#" onclick="setSort('price_high')">Price: High to Low</a></li>
                            <li><a class="dropdown-item rounded-3" href="#" onclick="setSort('newest')">Newest Arrivals</a></li>
                        </ul>
                    </div>
                </div>

                <div id="venuesGrid" class="row g-4 row-cols-md-2 row-cols-xl-3">
                    @foreach($halls as $hall)
                    <div class="col reveal">
                        <div class="modern-luxury-card">
                            <div class="modern-card-media">
                                @php
                                    $img = $hall->images->first() ? asset('storage/' . $hall->images->first()->image_path) : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3';
                                @endphp
                                <img src="{{ $img }}" class="venue-main-img" alt="{{ $hall->name }}">

                                @if($hall->video_path)
                                <div class="venue-video-preview opacity-0">
                                    <video loop playsinline preload="metadata">
                                        <source src="{{ asset('storage/' . $hall->video_path) }}" type="video/mp4">
                                    </video>
                                    <div class="video-sound-indicator">
                                        <i class="bi bi-volume-up-fill"></i>
                                    </div>
                                </div>
                                @endif

                                <div class="floating-price-tag">${{ number_format($hall->price_per_day, 0) }}</div>
                                <div class="floating-rating"><i class="bi bi-star-fill text-gold"></i> 4.9</div>
                            </div>
                            <div class="modern-card-content">
                                <h3 class="modern-title">{{ $hall->name }}</h3>
                                <div class="modern-meta">
                                    <span><i class="bi bi-geo-alt text-gold pe-1"></i> {{ $hall->city }}</span>
                                    <span><i class="bi bi-people text-gold pe-1"></i> {{ $hall->capacity_max }} Guests</span>
                                </div>

                                <div class="modern-action-group">
                                    <a href="{{ route('bookings.create', $hall->id) }}" class="btn-modern-primary">Reserve Now</a>
                                    <a href="{{ route('venue.details', $hall->id) }}" class="btn-modern-outline-text" title="View Details">
                                        <span>View</span>
                                        <i class="bi bi-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Luxury Pagination -->
                <div class="mt-5 pt-4 d-flex justify-content-center">
                    {{ $halls->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: var(--royal-gold) !important; }
    .btn-midnight { background: var(--midnight); color: white; border: none; transition: all 0.3s ease; }
    .btn-midnight:hover { background: #000; transform: translateY(-2px); }
    .btn-outline-gold { border: 1px solid var(--royal-gold); color: var(--royal-gold); transition: all 0.3s ease; }
    .btn-outline-gold:hover { background: var(--royal-gold); color: #fff; transform: translateY(-2px); }

    .filter-panel { border-radius: 30px; }
    .custom-range::-webkit-slider-thumb { background: var(--royal-gold); cursor: pointer; height: 20px; width: 20px; border: 3px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .custom-check .form-check-input:checked { background-color: var(--royal-gold); border-color: var(--royal-gold); }
    .filter-scrollable::-webkit-scrollbar { width: 4px; }
    .filter-scrollable::-webkit-scrollbar-thumb { background: var(--royal-gold-light); border-radius: 10px; }

    .x-small { font-size: 0.65rem; letter-spacing: 0.05em; font-weight: 700; }
    .venue-video-preview { transition: opacity 0.5s ease; pointer-events: none; background: #000; }
    .venue-hover-card { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
    .venue-hover-card:hover { transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.1) !important; }
    .venue-hover-card:hover .venue-video-preview { opacity: 1; }
    .venue-hover-card:hover .venue-main-img { opacity: 0.2; }
</style>

@endsection

@section('scripts')
<script>
    let currentFilters = {
        cities: [],
        priceRange: {{ request('max_price', 5000) }},
        capacities: [],
        categories: {{ json_encode(request('category') ? [(string)request('category')] : []) }},
        sort: 'recommended'
    };

    document.addEventListener('DOMContentLoaded', function() {
        initVideoLogic();
        updatePriceDisplay();

        // Match checkboxes with state
        document.querySelectorAll('input[name="categories[]"]').forEach(cb => {
            if (currentFilters.categories.includes(cb.value)) cb.checked = true;
        });
    });

    function updatePriceDisplay() {
        const val = document.getElementById('priceRange').value;
        const display = document.getElementById('maxPriceDisplay');
        display.textContent = val == 5000 ? '$5000+' : `$${val}`;
        currentFilters.priceRange = val;
    }

    function updateFilters() {
        currentFilters.cities = Array.from(document.querySelectorAll('input[name="city[]"]:checked')).map(c => c.value);
        currentFilters.categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked')).map(c => c.value);
        currentFilters.capacities = Array.from(document.querySelectorAll('input[name="capacity[]"]:checked')).map(c => c.value);
    }

    function setSort(type) {
        currentFilters.sort = type;
        document.getElementById('sortLabel').textContent = type.replace('_', ' ').charAt(0).toUpperCase() + type.replace('_', ' ').slice(1);
        applyFilters();
    }

    function applyFilters() {
        const grid = document.getElementById('venuesGrid');
        grid.style.opacity = '0.5';

        const params = new URLSearchParams();
        if (currentFilters.cities.length) params.append('cities', currentFilters.cities.join(','));
        if (currentFilters.priceRange < 5000) params.append('max_price', currentFilters.priceRange);
        if (currentFilters.categories.length) params.append('categories', currentFilters.categories.join(','));
        if (currentFilters.capacities.length) params.append('capacities', currentFilters.capacities.join(','));
        params.append('sort', currentFilters.sort);

        fetch(`/explore/filter?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
                renderGrid(data.halls);
                document.getElementById('resultsCount').textContent = data.total;
                grid.style.opacity = '1';
            });
    }

    function renderGrid(halls) {
        const grid = document.getElementById('venuesGrid');
        if (!halls.length) {
            grid.innerHTML = '<div class="col-12 py-5 text-center my-5"><i class="bi bi-search display-1 text-muted opacity-25"></i><h3 class="luxury-text mt-4">No Matches Found</h3><p class="text-muted">Adjust your filters to discover more venues</p></div>';
            return;
        }

        grid.innerHTML = halls.map(hall => `
            <div class="col reveal">
                <div class="modern-luxury-card">
                    <div class="modern-card-media">
                        <img src="${hall.image}" class="venue-main-img" alt="${hall.name}">
                        ${hall.video ? `
                            <div class="venue-video-preview opacity-0">
                                <video loop playsinline preload="metadata">
                                    <source src="${hall.video}" type="video/mp4">
                                </video>
                                <div class="video-sound-indicator">
                                    <i class="bi bi-volume-up-fill"></i>
                                </div>
                            </div>
                        ` : ''}
                        <div class="floating-price-tag">$${hall.price.toLocaleString()}</div>
                        <div class="floating-rating"><i class="bi bi-star-fill text-gold"></i> ${hall.rating}</div>
                    </div>
                    <div class="modern-card-content">
                        <h3 class="modern-title">${hall.name}</h3>
                        <div class="modern-meta">
                            <span><i class="bi bi-geo-alt text-gold pe-1"></i> ${hall.location}</span>
                            <span><i class="bi bi-people text-gold pe-1"></i> ${hall.capacity} Guests</span>
                        </div>
                        <div class="modern-action-group">
                            <a href="/bookings/create/${hall.id}" class="btn-modern-primary">Reserve Now</a>
                            <a href="/venue/${hall.id}" class="btn-modern-outline-text" title="View Details">
                                <span>View</span>
                                <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        initVideoLogic();
    }

    function initVideoLogic() {
        const cards = document.querySelectorAll('.modern-luxury-card');
        cards.forEach(card => {
            const video = card.querySelector('video');
            if (!video) return;

            card.addEventListener('mouseenter', () => {
                video.currentTime = 0;
                video.muted = false; // Try with sound first
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(e => {
                        // If unmuted autoplay fails, try muted
                        console.log('Unmuted autoplay blocked, trying muted:', e);
                        video.muted = true;
                        video.play().catch(err => console.log('Muted play also failed:', err));
                    });
                }
            });

            card.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
            });
        });
    }
</script>
@endsection
