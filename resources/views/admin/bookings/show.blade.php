@extends('layouts.admin')

@section('title', 'Booking Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 card-title float-start">Booking Information</h5>
                <span class="float-end">Reference: #{{ $booking->id }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Status</label>
                        <div>
                            @if($booking->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($booking->status == 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif($booking->status == 'approved_by_admin')
                                <span class="badge bg-info">Approved</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @elseif($booking->status == 'rejected_by_admin')
                                <span class="badge bg-dark">Rejected</span>
                            @else
                                <span class="badge bg-secondary">{{ $booking->status }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Created At</label>
                        <div>{{ $booking->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="fw-bold">Venue Details</h6>
                        <p class="mb-1">{{ $booking->hall->name }}</p>
                        <p class="text-muted small">{{ $booking->hall->address ?? 'No address provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">User Information</h6>
                        <p class="mb-1">{{ $booking->user->name }}</p>
                        <p class="text-muted small">{{ $booking->user->email }}</p>
                        <p class="text-muted small">{{ $booking->user->phone ?? 'No phone' }}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-3">Event Details</h6>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label class="text-muted small">Event Date</label>
                        <div>{{ $booking->event_date->format('l, M d, Y') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Time</label>
                        <div>
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - 
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Guests</label>
                        <div>{{ $booking->guests }} People</div>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="text-muted small">Special Requests</label>
                    <div class="p-3 bg-light rounded">
                        {{ $booking->special_requests ?? 'No special requests.' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 card-title">Payment Breakdown</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless booking-table">
                        <tbody>
                            <tr>
                                <td>Venue Rental</td>
                                <td class="text-end fw-bold">${{ number_format($booking->total_price, 2) }}</td>
                            </tr>
                            @foreach($booking->services as $service)
                                <tr>
                                    <td>{{ $service->service_name }}</td>
                                    <td class="text-end fw-bold">${{ number_format($service->service_price, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="border-top">
                                <td class="pt-3 h5">Total Amount</td>
                                <td class="pt-3 h5 text-end text-primary">${{ number_format($booking->total_price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Actions -->
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 card-title">Actions</h5>
            </div>
            <div class="card-body">
                @if($booking->status == 'pending')
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved_by_admin">
                            <button class="btn btn-success w-100 mb-2">
                                <i class="bi bi-check-circle me-2"></i> Approve Request
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected_by_admin">
                            <div class="mb-3">
                                <textarea name="notes" class="form-control" placeholder="Reason for rejection (optional)" rows="2"></textarea>
                            </div>
                            <button class="btn btn-danger w-100">
                                <i class="bi bi-x-circle me-2"></i> Reject Request
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-secondary mb-0">
                        This booking is currently <strong>{{ $booking->status }}</strong>.
                    </div>
                    @if(in_array($booking->status, ['approved_by_admin']))
                         <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-cash-coin me-2"></i> Mark as Paid (Confirm)
                            </button>
                        </form>
                    @endif
                @endif
                
                <hr>
                
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this booking?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i> Delete Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
