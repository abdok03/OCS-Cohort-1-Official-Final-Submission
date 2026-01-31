<!-- resources/views/pages/my-bookings.blade.php -->
@extends('layouts.user')

@section('title', 'My Bookings')

@section('content')
<div class="container-custom py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="mb-2">My Bookings</h1>
                    <p class="text-muted mb-0">Manage your wedding and engagement hall bookings</p>
                </div>
                <a href="{{ route('explore') }}" class="btn btn-primary btn-icon">
                    <i class="fas fa-plus me-2"></i> New Booking
                </a>
            </div>

            <!-- Booking Stats -->
            <div class="row g-4 mb-5">
                <div class="col-md-3 col-6">
                    <div class="stat-card shadow-hover">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="stat-number">8</h3>
                        <p class="stat-label">Total Bookings</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card shadow-hover">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3 class="stat-number">5</h3>
                        <p class="stat-label">Confirmed</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card shadow-hover">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="stat-number">2</h3>
                        <p class="stat-label">Pending</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card shadow-hover">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444, #f87171);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <h3 class="stat-number">1</h3>
                        <p class="stat-label">Cancelled</p>
                    </div>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="booking-table shadow-soft rounded-xl overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Venue</th>
                                <th>Event Type</th>
                                <th>Dates</th>
                                <th>Guests</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $bookings = [
                                    [
                                        'id' => 'BK-001',
                                        'venue' => 'Grand Ballroom Palace',
                                        'event_type' => 'Wedding',
                                        'start_date' => '2024-06-15',
                                        'end_date' => '2024-06-17',
                                        'guests' => 250,
                                        'amount' => 13500,
                                        'status' => 'confirmed',
                                        'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-002',
                                        'venue' => 'Garden View Mansion',
                                        'event_type' => 'Engagement',
                                        'start_date' => '2024-07-22',
                                        'end_date' => '2024-07-22',
                                        'guests' => 150,
                                        'amount' => 3200,
                                        'status' => 'confirmed',
                                        'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-003',
                                        'venue' => 'Modern Skyline Venue',
                                        'event_type' => 'Wedding',
                                        'start_date' => '2024-08-10',
                                        'end_date' => '2024-08-12',
                                        'guests' => 180,
                                        'amount' => 12300,
                                        'status' => 'pending',
                                        'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-004',
                                        'venue' => 'Oceanfront Elegance',
                                        'event_type' => 'Anniversary',
                                        'start_date' => '2024-09-05',
                                        'end_date' => '2024-09-05',
                                        'guests' => 100,
                                        'amount' => 5200,
                                        'status' => 'confirmed',
                                        'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-005',
                                        'venue' => 'Royal Heritage Hall',
                                        'event_type' => 'Wedding',
                                        'start_date' => '2024-05-20',
                                        'end_date' => '2024-05-22',
                                        'guests' => 200,
                                        'amount' => 11400,
                                        'status' => 'completed',
                                        'image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-006',
                                        'venue' => 'Victorian Manor',
                                        'event_type' => 'Engagement',
                                        'start_date' => '2024-04-10',
                                        'end_date' => '2024-04-10',
                                        'guests' => 120,
                                        'amount' => 2900,
                                        'status' => 'cancelled',
                                        'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-007',
                                        'venue' => 'Downtown Loft',
                                        'event_type' => 'Wedding',
                                        'start_date' => '2024-10-15',
                                        'end_date' => '2024-10-17',
                                        'guests' => 200,
                                        'amount' => 11100,
                                        'status' => 'pending',
                                        'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                    [
                                        'id' => 'BK-008',
                                        'venue' => 'Mountain View Lodge',
                                        'event_type' => 'Wedding',
                                        'start_date' => '2024-11-08',
                                        'end_date' => '2024-11-10',
                                        'guests' => 180,
                                        'amount' => 8400,
                                        'status' => 'confirmed',
                                        'image' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80'
                                    ],
                                ];
                            @endphp

                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $booking['image'] }}"
                                                 alt="{{ $booking['venue'] }}"
                                                 class="rounded me-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                            <div>
                                                <div class="fw-medium">{{ $booking['venue'] }}</div>
                                                <small class="text-muted">{{ $booking['id'] }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($booking['event_type'] == 'Wedding')
                                                <i class="fas fa-ring text-primary me-2"></i>
                                            @elseif($booking['event_type'] == 'Engagement')
                                                <i class="fas fa-gem text-warning me-2"></i>
                                            @else
                                                <i class="fas fa-calendar text-info me-2"></i>
                                            @endif
                                            <span>{{ $booking['event_type'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium">{{ date('M d, Y', strtotime($booking['start_date'])) }}</div>
                                        <small class="text-muted">
                                            @if($booking['start_date'] != $booking['end_date'])
                                                to {{ date('M d, Y', strtotime($booking['end_date'])) }}
                                            @else
                                                Single day
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-users text-gray me-2"></i>
                                            <span>{{ number_format($booking['guests']) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">${{ number_format($booking['amount']) }}</div>
                                        <small class="text-muted">Paid in full</small>
                                    </td>
                                    <td>
                                        @if($booking['status'] == 'confirmed')
                                            <span class="status-badge status-confirmed">
                                                <i class="fas fa-check-circle"></i>
                                                Confirmed
                                            </span>
                                        @elseif($booking['status'] == 'pending')
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        @elseif($booking['status'] == 'completed')
                                            <span class="status-badge status-completed">
                                                <i class="fas fa-check-double"></i>
                                                Completed
                                            </span>
                                        @elseif($booking['status'] == 'cancelled')
                                            <span class="status-badge status-cancelled">
                                                <i class="fas fa-times"></i>
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="tooltip"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($booking['status'] == 'pending')
                                                <button class="btn btn-sm btn-outline-success"
                                                        onclick="confirmBooking('{{ $booking['id'] }}')"
                                                        data-bs-toggle="tooltip"
                                                        title="Confirm Payment">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if(in_array($booking['status'], ['pending', 'confirmed']))
                                                <button class="btn btn-sm btn-outline-danger"
                                                        onclick="cancelBooking('{{ $booking['id'] }}')"
                                                        data-bs-toggle="tooltip"
                                                        title="Cancel Booking">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer bg-light p-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing 1 to 8 of 8 bookings
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary disabled">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-sm btn-primary">1</button>
                        <button class="btn btn-sm btn-outline-secondary disabled">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State (Hidden by default) -->
            <div class="empty-state d-none">
                <div class="text-center py-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <h3 class="empty-state-title mb-3">No Bookings Yet</h3>
                    <p class="empty-state-text mb-4">
                        You haven't made any bookings yet. Start exploring our beautiful wedding halls and book your dream venue.
                    </p>
                    <a href="{{ route('explore') }}" class="btn btn-primary btn-icon">
                        <i class="fas fa-search me-2"></i> Explore Halls
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmBooking(bookingId) {
    showConfirmation(
        'Confirm Payment',
        'Are you sure you want to confirm payment for booking ' + bookingId + '?',
        function() {
            showToast('Payment confirmed for booking ' + bookingId, 'success');
            // In a real app, you would make an API call here
        }
    );
}

function cancelBooking(bookingId) {
    showConfirmation(
        'Cancel Booking',
        'Are you sure you want to cancel booking ' + bookingId + '? This action cannot be undone.',
        function() {
            showToast('Booking ' + bookingId + ' has been cancelled', 'info');
            // In a real app, you would make an API call here
        }
    );
}
</script>
@endsection
