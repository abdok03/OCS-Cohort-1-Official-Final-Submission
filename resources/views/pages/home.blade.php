@extends('layouts.user')

@section('title', 'WeddingHalls - Discover Your Dream Venue')

@section('content')
<!-- Luxury Hero Section -->
<section class="luxury-hero reveal" style="background-image: url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Where Everlasting <br> <span style="color: var(--royal-gold);">Memories</span> Begin</h1>
        <p class="lead mb-5 opacity-75 fs-4">Curated collection of the most prestigious wedding and event venues.</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('explore') }}" class="btn-gold">Explore Collection</a>
            <a href="#featured" class="btn-royal" style="background: transparent; border-color: white; color: white;">View Featured</a>
        </div>
    </div>
</section>

<!-- Premium Search Bar -->
<div class="container d-none d-lg-block">
    <form action="{{ route('explore') }}" method="GET" class="search-container-premium">
        <div class="search-field d-flex align-items-center">
            <i class="bi bi-geo-alt text-muted me-2"></i>
            <input type="text" name="location" class="w-100 border-0 outline-none" placeholder="Where is your event?">
        </div>
        <div class="vr mx-2 my-auto" style="height: 30px;"></div>
        <div class="search-field d-flex align-items-center">
            <i class="bi bi-calendar3 text-muted me-2"></i>
            <input type="text" class="w-100 border-0 outline-none" placeholder="Select Preferred Date">
        </div>
        <button type="submit" class="btn-gold px-5">Search Venues</button>
    </form>
</div>

<!-- Category Showcase -->
<section class="py-5 mt-lg-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="text-uppercase tracking-widest small fw-bold text-muted mb-2 d-block" style="letter-spacing: 0.2em;">Collections</span>
            <h2 class="display-5 mb-4">Choose Your Ceremony Style</h2>
            <div class="mx-auto" style="width: 80px; height: 3px; background: var(--royal-gold);"></div>
        </div>

        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-3">
                <a href="{{ route('explore', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="premium-card text-center p-4">
                        <div class="mx-auto bg-light rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                             <i class="bi bi-star text-gold fs-3"></i>
                        </div>
                        <h4 class="text-dark mb-1">{{ $category->name }}</h4>
                        <p class="small text-muted">{{ $category->halls_count ?? 0 }} Available Venues</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Venues -->
<section id="featured" class="py-5 bg-white">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="text-uppercase tracking-widest small fw-bold text-muted mb-2 d-block" style="letter-spacing: 0.2em;">Exquisite Selection</span>
                <h2 class="display-5">Featured Venues</h2>
            </div>
            <a href="{{ route('explore') }}" class="btn-royal mb-1">View All Collection <i class="bi bi-arrow-right ms-2"></i></a>
        </div>

        <div class="row g-4">
            @foreach($featuredHalls as $hall)
            <div class="col-lg-4 col-md-6">
                <div class="premium-card venue-hover-card">
                    <div class="card-img-wrapper position-relative overflow-hidden">
                        <img src="{{ $hall['image'] }}" class="venue-main-img w-100" alt="{{ $hall['name'] }}">
                        
                        @if($hall['video'])
                        <div class="venue-video-preview opacity-0">
                            <video loop playsinline preload="metadata">
                                <source src="{{ $hall['video'] }}" type="video/mp4">
                            </video>
                            <div class="video-sound-indicator">
                                <i class="bi bi-volume-up-fill"></i>
                            </div>
                        </div>
                        @endif

                        <div class="card-badge">Starting ${{ number_format($hall['price_per_day'], 0) }}</div>
                    </div>
                    <div class="card-luxury-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="h4 text-dark mb-0">{{ $hall['name'] }}</h3>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-star-fill text-gold me-1" style="font-size: 0.8rem; color: #D4AF37;"></i>
                                <span class="small fw-bold">4.9</span>
                            </div>
                        </div>
                        <p class="text-muted small mb-4"><i class="bi bi-geo-alt me-1"></i> {{ $hall['location'] }}</p>
                        
                        <div class="d-flex gap-2">
                             <a href="{{ route('venue.details', $hall['id']) }}" class="btn btn-midnight flex-grow-1 py-2 rounded-4 fw-bold small">View Details</a>
                             <a href="{{ route('bookings.create', $hall['id']) }}" class="btn btn-gold px-3 py-2 rounded-4 fw-bold small shadow-sm d-flex align-items-center gap-2">
                                 <i class="bi bi-calendar3"></i> BOOK NOW
                             </a>
                         </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Luxury Brand Promise -->
<section class="py-5" style="background: #ffffff url('https://www.transparenttextures.com/patterns/cubes.png');">
    <div class="container py-5 text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="display-4 mb-5">The WeddingHalls Experience</h2>
                <div class="row g-5 mt-2">
                    <div class="col-md-4">
                        <div class="mb-4 text-gold fs-1"><i class="bi bi-patch-check"></i></div>
                        <h4 class="mb-3">Verified Luxury</h4>
                        <p class="text-muted small">Every venue in our collection must pass a 50-point luxury inspection by our experts.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4 text-gold fs-1"><i class="bi bi-calendar-heart"></i></div>
                        <h4 class="mb-3">Seamless Booking</h4>
                        <p class="text-muted small">Real-time availability and transparent pricing. No hidden fees, ever.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4 text-gold fs-1"><i class="bi bi-headset"></i></div>
                        <h4 class="mb-3">Concierge Support</h4>
                        <p class="text-muted small">Dedicated wedding concierge to help you with every detail of your venue selection.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Final Call to Action -->
<section class="py-5 bg-dark text-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 mb-4 luxury-text">Ready to say "I do" to the perfect venue?</h2>
                <p class="lead opacity-75 mb-0">Join 5,000+ couples who found their dream location with us.</p>
            </div>
            <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                <a href="{{ route('register', ['role' => 'owner']) }}" class="btn-royal btn-lg rounded-pill px-5">Start Planning Now</a>
            </div>
        </div>
    </div>
</section>

<style>
    .text-gold { color: var(--royal-gold); }
    .transition-opacity { transition: opacity 0.5s ease; }
    
    .card-img-wrapper {
        position: relative;
    }
    
    .venue-video-preview { 
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2; 
        pointer-events: none;
        background: #000;
        transition: opacity 0.5s ease;
    }
    
    .venue-video-preview video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .venue-main-img {
        position: relative;
        z-index: 1;
        transition: opacity 0.5s ease;
    }
    
    .venue-hover-card:hover .venue-video-preview { 
        opacity: 1 !important;
    }
    
    .venue-hover-card:hover .venue-main-img {
        opacity: 0;
    }
    
    /* Video Sound Indicator */
    .video-sound-indicator {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(212, 175, 55, 0.95);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        z-index: 10;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s ease;
        pointer-events: none;
    }
    
    .venue-hover-card:hover .video-sound-indicator {
        opacity: 1;
        transform: scale(1);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.venue-hover-card');
    
    cards.forEach(card => {
        const video = card.querySelector('video');
        if (!video) return;

        card.addEventListener('mouseenter', () => {
            video.currentTime = 0;
            video.muted = false; // Try with sound first
            const playPromise = video.play();
            
            if (playPromise !== undefined) {
                playPromise.catch(error => {
                    // If unmuted autoplay fails, try muted
                    console.log('Unmuted autoplay blocked, trying muted:', error);
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
});
</script>
@endsection
