@extends('layouts.venue')

@section('title', 'Bookings Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Bookings Management</h2>
            <p class="text-muted mb-0">Manage and track all venue reservations in one place.</p>
        </div>
        <div class="d-flex gap-3 align-items-center">
            <form action="{{ route('venue.bookings.index') }}" method="GET" class="d-flex gap-2 align-items-center">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-light small px-3">From</span>
                    <input type="date" name="from_date" class="form-control border-light shadow-none" value="{{ request('from_date') }}">
                </div>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-light small px-3">To</span>
                    <input type="date" name="to_date" class="form-control border-light shadow-none" value="{{ request('to_date') }}">
                </div>
                <select name="status" class="form-select form-select-sm border-light shadow-none" style="min-width: 120px;">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Apply</button>
                @if(request()->anyFilled(['from_date', 'to_date', 'status', 'search']))
                    <a href="{{ route('venue.bookings.index') }}" class="btn btn-light btn-sm rounded-pill"><i class="bi bi-x"></i></a>
                @endif
            </form>
            <button class="btn btn-white shadow-sm px-4 rounded-pill border-0 btn-sm">
                <i class="bi bi-download me-2"></i>Export
            </button>
        </div>
    </div>

    <!-- Stats Summary for Bookings -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="premium-card p-4 bg-white shadow-sm border-0 border-start border-primary border-4">
                <div class="small text-muted fw-bold text-uppercase mb-1">Total Bookings</div>
                <h3 class="fw-bold mb-0">{{ $bookings->total() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 bg-white shadow-sm border-0 border-start border-warning border-4">
                <div class="small text-muted fw-bold text-uppercase mb-1">Pending</div>
                <h3 class="fw-bold mb-0 text-warning">{{ $bookings->where('status', 'pending')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 bg-white shadow-sm border-0 border-start border-success border-4">
                <div class="small text-muted fw-bold text-uppercase mb-1">Confirmed</div>
                <h3 class="fw-bold mb-0 text-success">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="premium-card p-4 bg-white shadow-sm border-0 border-start border-info border-4">
                <div class="small text-muted fw-bold text-uppercase mb-1">This Month</div>
                <h3 class="fw-bold mb-0 text-info">{{ $bookings->where('event_date', '>=', now()->startOfMonth())->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Bookings Table Card -->
    <div class="premium-card bg-white shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4 border-0 py-3">REF #</th>
                        <th class="border-0 py-3">Venue</th>
                        <th class="border-0 py-3">Customer</th>
                        <th class="border-0 py-3">Event Date & Time</th>
                        <th class="border-0 py-3">Details</th>
                        <th class="border-0 py-3">Status</th>
                        <th class="pe-4 border-0 py-3 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $booking->id }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $booking->hall->name }}</div>
                                <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $booking->hall->city }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary-light text-primary rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ substr($booking->user->first_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $booking->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $booking->user->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark fw-medium small">{{ $booking->event_date->format('M d, Y') }}</div>
                                <div class="small text-muted">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - 
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                </div>
                            </td>
                            <td>
                                <div class="small text-dark">
                                    <span class="me-2"><i class="bi bi-people me-1"></i>{{ $booking->guests }}</span>
                                    @if($booking->is_mixed) <span class="badge bg-soft-purple text-purple border-purple-subtle">Mixed</span> @endif
                                </div>
                                <div class="mt-1">
                                    @if($booking->hospitality_package && $booking->hospitality_package !== 'none')
                                        <span class="badge bg-light text-muted fw-normal" style="font-size: 0.7rem;">Package: {{ ucfirst($booking->hospitality_package) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge rounded-pill bg-soft-warning text-warning px-3 border border-warning-subtle">Pending Review</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge rounded-pill bg-soft-success text-success px-3 border border-success-subtle">Paid & Confirmed</span>
                                @elseif($booking->status == 'approved_by_admin' || $booking->status == 'approved')
                                    <span class="badge rounded-pill bg-soft-info text-info px-3 border border-info-subtle">Approved</span>
                                @elseif($booking->status == 'rejected' || $booking->status == 'rejected_by_admin')
                                    <span class="badge rounded-pill bg-soft-danger text-danger px-3 border border-danger-subtle">Rejected</span>
                                @else
                                    <span class="badge rounded-pill bg-soft-secondary text-secondary px-3">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved_by_admin">
                                            <button class="btn btn-icon btn-soft-success rounded-circle" title="Approve">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-icon btn-soft-danger rounded-circle" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $booking->id }}" title="Reject">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('venue.bookings.show', $booking->id) }}" class="btn btn-icon btn-light rounded-circle" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal{{ $booking->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 text-start">
                                            <form action="{{ route('venue.bookings.update-status', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-header border-0 pt-4 px-4">
                                                    <h5 class="fw-bold mb-0">Reject Booking #{{ $booking->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="status" value="rejected_by_admin">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-muted text-uppercase">Reason for rejection</label>
                                                        <textarea name="notes" class="form-control rounded-3 bg-light border-0 py-3" rows="4" placeholder="Briefly explain why you're rejecting this request..." required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pb-4 px-4">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-toggle="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Reject Permanently</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-calendar-x display-4 text-muted opacity-25"></i>
                                    <p class="text-muted mt-3">No bookings have been made for your venues yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white py-4 px-4 border-0">
            {{ $bookings->links() }}
        </div>
    </div>
</div>

<style>
    /* Premium components for Bookings page */
    .premium-card { border-radius: 1.25rem; }
    .btn-white { background: white; color: #1e293b; font-weight: 500; }
    .bg-primary-light { background-color: rgba(212, 175, 55, 0.1); }
    
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-soft-purple { background-color: rgba(111, 66, 193, 0.1); }
    
    .text-purple { color: #6f42c1; }
    .border-purple-subtle { border: 1px solid rgba(111, 66, 193, 0.3); }

    .btn-icon {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .btn-soft-success { background: rgba(25, 135, 84, 0.1); color: #198754; border: none; }
    .btn-soft-success:hover { background: #198754; color: white; }
    
    .btn-soft-danger { background: rgba(220, 53, 69, 0.1); color: #dc3569; border: none; }
    .btn-soft-danger:hover { background: #dc3569; color: white; }

    .table thead th { letter-spacing: 0.05em; font-size: 0.75rem; }
</style>
@endsection
