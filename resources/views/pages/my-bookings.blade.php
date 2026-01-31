@extends('layouts.user')

@section('title', 'My Royal Reservations')

@section('content')
<div class="bookings-page py-4">
    <div class="container">
        <!-- Compact Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 reveal-up">
            <div>
                <h1 class="h3 luxury-text mb-1">My Reservations</h1>
                <p class="text-muted small mb-0">Track and manage your hall bookings.</p>
            </div>
            <a href="{{ route('explore') }}" class="btn-new-res">
                <i class="bi bi-plus-lg"></i> <span>New Booking</span>
            </a>
        </div>

        <!-- Tight Filter Pills -->
        <div class="d-flex gap-2 mb-4 reveal-up" style="animation-delay: 0.1s;">
            <button class="filter-pill active" data-filter="all">All</button>
            <button class="filter-pill" data-filter="upcoming">Upcoming</button>
            <button class="filter-pill" data-filter="past">Completed</button>
        </div>

        <!-- Compact Bookings List -->
        <div class="row g-3" id="bookings-container">
            @forelse($bookings as $booking)
            @php
                $isUpcoming = $booking->event_date->isFuture() || $booking->event_date->isToday();
                $filterClass = $isUpcoming ? 'upcoming' : 'past';
                $imageUrl = $booking->hall && $booking->hall->images->first() 
                    ? asset('storage/' . $booking->hall->images->first()->image_path) 
                    : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80';
                
                $statusColor = match($booking->status) {
                    'pending' => '#F59E0B',
                    'approved', 'approved_by_admin' => '#10B981',
                    'confirmed' => '#6366F1',
                    'cancelled', 'rejected_by_admin' => '#EF4444',
                    default => '#6B7280'
                };
            @endphp
            <div class="col-12 booking-item {{ $filterClass }} reveal-up" style="animation-delay: {{ 0.1 + ($loop->index * 0.05) }}s;">
                <div class="booking-card-ultra-compact">
                    <div class="d-flex align-items-center gap-3 p-2">
                        <!-- Tiny Image Thumbnail -->
                        <div class="thumb-container">
                            <img src="{{ $imageUrl }}" alt="Venue">
                            <div class="status-dot" style="background: {{ $statusColor }};"></div>
                        </div>

                        <!-- Main Info -->
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge-mini" style="background: {{ $statusColor }}15; color: {{ $statusColor }};">
                                    {{ strtoupper($booking->status) }}
                                </span>
                                <span class="text-muted xx-small">#WH-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h4 class="venue-name-compact mb-0 text-truncate">{{ $booking->hall->name ?? 'Venue Archive' }}</h4>
                            <div class="d-flex flex-wrap gap-x-3 gap-y-1 mt-1">
                                <span class="info-tag"><i class="bi bi-calendar-event"></i> {{ $booking->event_date->format('d M, Y') }}</span>
                                <span class="info-tag"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</span>
                                <span class="info-tag"><i class="bi bi-people"></i> {{ $booking->guests }}</span>
                            </div>
                        </div>

                        <!-- Price and Action -->
                        <div class="text-end ps-3 border-start d-flex flex-column justify-content-center" style="min-width: 140px;">
                            <div class="price-compact mb-2">${{ number_format($booking->total_price, 0) }}</div>
                            <div class="d-flex flex-column gap-1">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn-action-sm outline" title="View Details">
                                    <i class="bi bi-eye"></i> <span>Details</span>
                                </a>
                                @if($booking->status == 'approved')
                                    <a href="{{ route('bookings.checkout', $booking->id) }}" class="btn-action-sm gold" title="Complete Payment">
                                        <i class="bi bi-credit-card"></i> <span>Pay Now</span>
                                    </a>
                                @endif
                                @if($booking->status == 'pending')
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="w-100">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action-sm danger w-100" onclick="return confirm('Cancel request?')">
                                            <i class="bi bi-x-lg"></i> <span>Cancel</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center">
                <i class="bi bi-calendar-x h1 text-muted mb-3 d-block"></i>
                <h5 class="text-muted">No reservations found</h5>
                <a href="{{ route('explore') }}" class="btn btn-sm btn-dark mt-2 px-4 rounded-pill">Explore Venues</a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    :root {
        --royal-gold: #D4AF37;
        --midnight: #1A1A1A;
        --bg-color: #F8FAFC;
    }

    .bookings-page { background: var(--bg-color); min-height: 100vh; font-family: 'Inter', sans-serif; }
    .luxury-text { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--midnight); }

    /* Compact Header UI */
    .btn-new-res {
        background: var(--midnight); color: white; border-radius: 8px; padding: 8px 16px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: 0.3s;
    }
    .btn-new-res:hover { background: var(--royal-gold); color: white; transform: translateY(-1px); }

    /* Filter Pills - Slim */
    .filter-pill {
        background: white; border: 1px solid #E2E8F0; padding: 6px 18px; border-radius: 50px; font-size: 0.8rem; font-weight: 600; color: #64748B; transition: 0.3s; cursor: pointer;
    }
    .filter-pill.active { background: var(--midnight); color: white; border-color: var(--midnight); }

    /* Ultra Compact Card */
    .booking-card-ultra-compact {
        background: white; border-radius: 12px; border: 1px solid #E2E8F0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: 0.2s;
    }
    .booking-card-ultra-compact:hover { border-color: var(--royal-gold); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }

    .thumb-container { position: relative; width: 70px; height: 70px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .thumb-container img { width: 100%; height: 100%; object-fit: cover; }
    .status-dot { position: absolute; bottom: 5px; right: 5px; width: 10px; height: 10px; border-radius: 50%; border: 2px solid white; }

    .venue-name-compact { font-size: 1.1rem; color: var(--midnight); font-weight: 700; }
    .badge-mini { font-size: 0.6rem; font-weight: 800; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.05em; }
    .xx-small { font-size: 0.65rem; }

    .info-tag { font-size: 0.75rem; color: #64748B; display: flex; align-items: center; gap: 4px; }
    .info-tag i { color: var(--royal-gold); font-size: 0.85rem; }

    /* Price and Action Unit */
    .price-compact { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--midnight); line-height: 1; }
    
    /* Action Buttons - Clear & Compact */
    .btn-action-sm {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    
    .btn-action-sm.outline { 
        background: #F8FAFC; 
        color: #64748B; 
        border-color: #E2E8F0; 
    }
    .btn-action-sm.outline:hover { 
        background: #F1F5F9; 
        color: var(--midnight); 
        border-color: #CBD5E1; 
    }

    .btn-action-sm.gold { 
        background: #FEF9C3; 
        color: var(--royal-gold); 
        border-color: #FEF08A; 
    }
    .btn-action-sm.gold:hover { 
        background: var(--royal-gold); 
        color: white; 
        border-color: var(--royal-gold); 
    }

    .btn-action-sm.danger { 
        background: #FEE2E2; 
        color: #EF4444; 
        border-color: #FECACA; 
    }
    .btn-action-sm.danger:hover { 
        background: #EF4444; 
        color: white; 
        border-color: #EF4444; 
    }

    .gap-x-3 { column-gap: 1rem; }

    @keyframes revealUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .reveal-up { animation: revealUp 0.4s ease-out both; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filters = document.querySelectorAll('.filter-pill');
    const items = document.querySelectorAll('.booking-item');

    filters.forEach(btn => {
        btn.addEventListener('click', function() {
            filters.forEach(f => f.classList.remove('active'));
            this.classList.add('active');

            const filterType = this.getAttribute('data-filter');
            items.forEach(item => {
                if (filterType === 'all' || item.classList.contains(filterType)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
