@extends('layouts.venue')

@section('title', 'Venue Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Welcome back, {{ Auth::user()->first_name }}! 👋</h2>
            <p class="text-muted mb-0">Here's what's happening with your venues today.</p>
        </div>
        <div>
            <a href="{{ route('venue.halls.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Add New Hall
            </a>
        </div>
    </div>

    <!-- Enhanced Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="premium-card p-4 h-100 bg-gradient-gold text-white shadow-lg border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-icon-wrapper bg-white-transparent rounded-circle">
                        <i class="bi bi-calendar-check fs-4"></i>
                    </div>
                </div>
                <h6 class="text-uppercase small fw-bold opacity-75 mb-1">Total Bookings</h6>
                <div class="d-flex align-items-end gap-2">
                    <h2 class="display-6 fw-bold mb-0">{{ $stats['active_bookings'] }}</h2>
                    <span class="small mb-2 fw-semibold"><i class="bi bi-arrow-up"></i> 12%</span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-card p-4 h-100 bg-white shadow-sm border-0 border-top-warning">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-icon-wrapper bg-warning-light rounded-circle text-warning">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <span class="badge bg-soft-warning text-warning rounded-pill px-3">Review Needed</span>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted mb-1">Pending Requests</h6>
                <h2 class="display-6 fw-bold mb-0 text-dark">{{ $stats['pending_requests'] }}</h2>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-card p-4 h-100 bg-white shadow-sm border-0 border-top-success">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-icon-wrapper bg-success-light rounded-circle text-success">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <span class="badge bg-soft-success text-success rounded-pill px-3">+24% MoM</span>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted mb-1">Total Revenue</h6>
                <h2 class="display-6 fw-bold mb-0 text-dark">${{ number_format($stats['total_revenue']) }}</h2>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="premium-card p-4 h-100 bg-white shadow-sm border-0 border-top-info">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="card-icon-wrapper bg-info-light rounded-circle text-info">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                </div>
                <h6 class="text-uppercase small fw-bold text-muted mb-1">Managed Halls</h6>
                <h2 class="display-6 fw-bold mb-0 text-dark">{{ $stats['total_halls'] }}</h2>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Bookings Table -->
        <div class="col-lg-8">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center border-0">
                    <h5 class="fw-bold text-dark mb-0">Recent Activity</h5>
                    <a href="{{ route('venue.bookings.index') }}" class="btn btn-link text-primary fw-semibold p-0 text-decoration-none">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 px-4">
                        <thead class="bg-light-subtle text-muted small text-uppercase fw-bold">
                            <tr>
                                <th class="ps-4 border-0 py-3">Reference</th>
                                <th class="border-0 py-3">Venue / Customer</th>
                                <th class="border-0 py-3">Date</th>
                                <th class="border-0 py-3 text-center">Status</th>
                                <th class="pe-4 border-0 py-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">#{{ $booking->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="venue-thumb rounded-2 me-3 bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $booking->hall->name }}</div>
                                                <div class="small text-muted">{{ $booking->user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium small">{{ $booking->event_date->format('M d, Y') }}</div>
                                        <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($booking->status == 'pending')
                                            <span class="badge rounded-pill bg-soft-warning text-warning px-3 border border-warning-subtle">Pending Review</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge rounded-pill bg-soft-success text-success px-3 border border-success-subtle">Confirmed</span>
                                        @elseif($booking->status == 'approved_by_admin')
                                            <span class="badge rounded-pill bg-soft-info text-info px-3 border border-info-subtle">Approved</span>
                                        @else
                                            <span class="badge rounded-pill bg-soft-secondary text-secondary px-3">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <div class="dropdown">
                                            <button class="btn btn-icon btn-light rounded-circle shadow-none" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                                <li><a class="dropdown-item rounded-2" href="{{ route('venue.bookings.show', $booking->id) }}"><i class="bi bi-eye me-2"></i>Details</a></li>
                                                @if($booking->status == 'pending')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button class="dropdown-item rounded-2 text-success"><i class="bi bi-check2 me-2"></i>Approve</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button class="dropdown-item rounded-2 text-danger"><i class="bi bi-x-circle me-2"></i>Reject</button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="{{ asset('img/empty-state.svg') }}" alt="Empty" class="mb-3" style="width: 120px; opacity: 0.5;">
                                        <p class="text-muted">No recent bookings found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="col-lg-4">
            <div class="premium-card bg-dark text-white shadow-lg border-0 rounded-4 p-4 mb-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <h5 class="fw-bold mb-4">Venue Performance</h5>
                <div class="mb-4">
                    <div class="d-flex justify-content-between small text-white-50 mb-2">
                        <span>Capacity Utilization</span>
                        <span>78%</span>
                    </div>
                    <div class="progress bg-white-transparent" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 78%"></div>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between small text-white-50 mb-2">
                        <span>Customer Satisfaction</span>
                        <span>4.8/5</span>
                    </div>
                    <div class="progress bg-white-transparent" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 90%"></div>
                    </div>
                </div>
                <div class="mt-2 pt-2 border-top border-secondary">
                    <p class="small text-white-50 mb-0">Total earnings this month: <strong class="text-white">$12,450</strong></p>
                </div>
            </div>

            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4">Quick Links</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('venue.bookings.index') }}" class="btn btn-light text-start p-3 rounded-3 border-0 transition-all hover-translate-x">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-primary-light text-primary rounded-3 p-2 me-3">
                                <i class="bi bi-calendar4-week fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Schedule</div>
                                <div class="small text-muted">View all reservations</div>
                            </div>
                            <i class="bi bi-chevron-right ms-auto opacity-50"></i>
                        </div>
                    </a>
                    <a href="{{ route('venue.profile') }}" class="btn btn-light text-start p-3 rounded-3 border-0 transition-all hover-translate-x">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-success-light text-success rounded-3 p-2 me-3">
                                <i class="bi bi-gear fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">Settings</div>
                                <div class="small text-muted">Configure your account</div>
                            </div>
                            <i class="bi bi-chevron-right ms-auto opacity-50"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Design System */
    .premium-card {
        border-radius: 1.25rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .premium-card:hover {
        transform: translateY(-5px);
    }
    .bg-gradient-gold {
        background: linear-gradient(135deg, #D4AF37 0%, #b5952f 100%);
    }
    .bg-white-transparent {
        background-color: rgba(255, 255, 255, 0.2);
    }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); }
    
    .bg-warning-light { background-color: #fff9db; }
    .bg-success-light { background-color: #ebfbee; }
    .bg-info-light { background-color: #e3fafc; }
    .bg-primary-light { background-color: #fff4e6; } /* Adjusted for gold theme */
    
    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .border-top-warning { border-top: 5px solid #ffc107 !important; }
    .border-top-success { border-top: 5px solid #198754 !important; }
    .border-top-info { border-top: 5px solid #0dcaf0 !important; }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .hover-translate-x:hover {
        transform: translateX(5px);
        background-color: #f8f9fa !important;
    }
    .transition-all { transition: all 0.2s ease; }
    
    .venue-thumb i { font-size: 1.25rem; }
    
    .progress-bar { border-radius: 6px; }
    
    .display-6 { font-size: 2.25rem; }
    
    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .display-6 { font-size: 1.75rem; }
    }
</style>
@endsection
