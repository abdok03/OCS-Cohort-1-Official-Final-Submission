@extends('layouts.venue')

@section('title', 'Booking Details: #' . $booking->id)

@section('content')
<div class="container py-4">
    <!-- Header -->
    <nav class="mb-4">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item small"><a href="{{ route('venue.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('venue.bookings.index') }}" class="text-decoration-none text-muted">Bookings</a></li>
            <li class="breadcrumb-item small active fw-bold text-primary">Booking Details</li>
        </ol>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark mb-0">Booking #{{ $booking->id }}</h2>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm py-2">
                    <i class="bi bi-printer me-2"></i>Print Invoice
                </button>
                @if($booking->status == 'pending')
                    <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-gold py-2 fw-bold">
                            <i class="bi bi-check2-circle me-2"></i>Confirm Booking
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </nav>

    <div class="row g-4">
        <!-- Left: Details -->
        <div class="col-lg-8">
            <!-- Event Timeline Card -->
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4 overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 m-4">
                     @if($booking->status == 'pending')
                        <span class="badge rounded-pill bg-soft-warning text-warning px-4 py-2 border border-warning-subtle fs-6">Pending Review</span>
                    @elseif($booking->status == 'confirmed')
                        <span class="badge rounded-pill bg-soft-success text-success px-4 py-2 border border-success-subtle fs-6">Confirmed & Paid</span>
                    @elseif($booking->status == 'approved')
                        <span class="badge rounded-pill bg-soft-info text-info px-4 py-2 border border-info-subtle fs-6">Approved</span>
                    @else
                        <span class="badge rounded-pill bg-soft-secondary text-secondary px-4 py-2 border fs-6">{{ ucfirst($booking->status) }}</span>
                    @endif
                </div>

                <h5 class="fw-bold text-dark mb-4">Event Overview</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-primary-light text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-calendar3 fs-4"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Event Date</div>
                                <div class="fs-5 fw-bold text-dark">{{ $booking->event_date->format('l, F d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="bg-info-light text-info rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-clock fs-4"></i>
                            </div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Time Schedule</div>
                                <div class="fs-5 fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                </div>
                                <div class="small text-muted">{{ $booking->duration }} Hours duration</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Requirements -->
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 h-100">
                        <h6 class="fw-bold text-dark mb-4 text-uppercase small">Customer Information</h6>
                        <div class="d-flex align-items-center mb-4">
                            <div class="user-avatar-xxl bg-gradient-gold text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 60px; height: 60px;">
                                {{ substr($booking->user->first_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-5">{{ $booking->user->name }}</div>
                                <div class="text-muted">{{ $booking->user->email }}</div>
                            </div>
                        </div>
                        <div class="vstack gap-3 border-top pt-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Phone Number</span>
                                <span class="fw-bold text-dark">{{ $booking->user->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Account Type</span>
                                <span class="badge bg-light text-muted fw-normal">Verified User</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 h-100">
                        <h6 class="fw-bold text-dark mb-4 text-uppercase small">Preference & Service</h6>
                        <div class="vstack gap-3">
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted small">Guest Count</span>
                                <span class="fw-bold text-dark"><i class="bi bi-people me-2"></i>{{ $booking->guests }} People</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted small">Mix Gender</span>
                                <span class="fw-bold text-dark">{{ $booking->is_mixed ? 'Yes (Mixed)' : 'No (Separate)' }}</span>
                            </div>
                            <div class="d-flex justify-content-between border-bottom pb-2">
                                <span class="text-muted small">Hospitality</span>
                                <span class="fw-bold text-dark">{{ ucfirst($booking->hospitality_package ?? 'None') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">Flowers</span>
                                <span class="fw-bold text-dark">{{ ucfirst($booking->flower_color ?? 'None') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Special Requests -->
            <div class="premium-card bg-light border-0 rounded-4 p-4 mt-4">
                <h6 class="fw-bold text-dark mb-3 text-uppercase small">Special Requests / Notes</h6>
                <div class="p-4 bg-white rounded-3 border-start border-4 border-primary">
                    <p class="mb-0 text-dark" style="line-height: 1.6;">
                        {{ $booking->special_requests ?: 'No special requests provided for this booking.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Right: Pricing Sidebar -->
        <div class="col-lg-4">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold text-dark mb-4">Financial Summary</h5>
                <div class="vstack gap-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Base Price ({{ $booking->duration }}h)</span>
                        <span class="fw-semibold text-dark">${{ number_format($booking->base_price, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Services</span>
                        <span class="fw-semibold text-dark">${{ number_format($booking->services_price, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Service Fee (10%)</span>
                        <span class="fw-semibold text-dark">${{ number_format($booking->service_fee, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Taxes (8%)</span>
                        <span class="fw-semibold text-dark">${{ number_format($booking->taxes, 2) }}</span>
                    </div>
                </div>
                <div class="bg-primary-light rounded-3 p-4 text-center border-dashed border-primary border-1">
                    <div class="text-muted small fw-bold text-uppercase mb-1">Grand Total</div>
                    <div class="display-5 fw-bold text-primary mb-0">${{ number_format($booking->total_price, 2) }}</div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center small mb-2">
                        <span class="text-muted">Payment Status</span>
                        @if($booking->payment_status == 'paid')
                            <span class="text-success fw-bold"><i class="bi bi-patch-check-fill me-1"></i>PAID</span>
                        @else
                            <span class="text-warning fw-bold"><i class="bi bi-hourglass-split me-1"></i>PENDING</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center small">
                        <span class="text-muted">Method</span>
                        <span class="text-dark fw-bold">{{ strtoupper($booking->payment_method ?? 'Not Set') }}</span>
                    </div>
                </div>
            </div>

            <!-- Management Actions -->
            <div class="premium-card bg-dark text-white shadow-lg border-0 rounded-4 p-4">
                <h6 class="fw-bold text-white mb-4 text-uppercase small">Management</h6>
                @if($booking->status == 'pending')
                    <p class="small text-white-50 mb-4">Review this request carefully before confirming. Once approved, the customer will be notified.</p>
                    <div class="d-grid gap-2">
                         <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Approve Request</button>
                        </form>
                        <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2 shadow-none" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject Booking</button>
                    </div>
                @else
                    <div class="p-3 bg-white-transparent rounded-3 mb-2">
                        <div class="small fw-bold opacity-75">Processed on:</div>
                        <div class="fw-bold">{{ $booking->approved_at ? $booking->approved_at->format('M d, Y') : $booking->updated_at->format('M d, Y') }}</div>
                    </div>
                    <div class="p-3 bg-white-transparent rounded-3">
                        <div class="small fw-bold opacity-75">Internal Notes:</div>
                        <div class="small italic">{{ $booking->admin_notes ?? 'No internal notes found.' }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal (Same as index but styled for details) -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header bg-danger text-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Reject Booking Request</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="status" value="rejected">
                    <p class="text-muted mb-4 small">Please provide a brief reason for rejecting this booking. This will NOT be sent to the customer in this version but will be logged in system.</p>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Reason / Notes</label>
                        <textarea name="notes" class="form-control rounded-3 border-light bg-light py-3" rows="4" required placeholder="e.g. Venue under maintenance on this date..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .bg-primary-light { background-color: rgba(212, 175, 55, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); }
    
    .bg-white-transparent { background-color: rgba(255, 255, 255, 0.1); }
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    
    @media print {
        .admin-sidebar, .admin-navbar, .breadcrumb, .btn, .management-actions { display: none !important; }
        .main-content { margin-left: 0 !important; }
        .premium-card { box-shadow: none !important; border: 1px solid #eee !important; }
    }
</style>
@endsection
