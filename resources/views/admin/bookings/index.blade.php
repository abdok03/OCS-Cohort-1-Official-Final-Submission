@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">Bookings</h1>
            <div class="btn-group">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="btn btn-outline-success {{ request('status') == 'confirmed' ? 'active' : '' }}">Confirmed</a>
                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}" class="btn btn-outline-danger {{ request('status') == 'cancelled' ? 'active' : '' }}">Cancelled</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Hall</th>
                                <th>Event Date</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>#{{ $booking->id }}</td>
                                    <td>
                                        <div>{{ $booking->user->name }}</div>
                                        <small class="text-muted">{{ $booking->user->email }}</small>
                                    </td>
                                    <td>{{ $booking->hall->name }}</td>
                                    <td>
                                        <div>{{ $booking->event_date->format('Y-m-d') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge bg-success">Paid & Confirmed</span>
                                        @elseif($booking->status == 'approved_by_admin')
                                            <span class="badge bg-info">Approved (Unpaid)</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @elseif($booking->status == 'rejected_by_admin')
                                            <span class="badge bg-dark">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($booking->total_price, 2) }}</td>
                                    <td>{{ $booking->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @if($booking->status == 'pending')
                                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved_by_admin">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected_by_admin">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-info ms-1" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $booking->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>

                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="bookingModal{{ $booking->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Booking #{{ $booking->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Special Requests:</strong> {{ $booking->special_requests ?? 'None' }}</p>
                                                        <p><strong>Guests:</strong> {{ $booking->guests }}</p>
                                                        <p><strong>Services:</strong></p>
                                                        <ul>
                                                            @foreach($booking->services as $service)
                                                                <li>{{ $service->service_name }} (${{ $service->service_price }})</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
