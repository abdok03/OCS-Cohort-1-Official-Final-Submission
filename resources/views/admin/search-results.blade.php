@extends('layouts.admin')

@section('title', 'Global Search Results')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Search Results for: <span class="text-primary">"{{ $query }}"</span></h2>
            <p class="text-muted">Explore matching records across the platform.</p>
        </div>
    </div>

    <!-- Halls Results -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <h4 class="fw-bold"><i class="bi bi-building me-2"></i> Venues ({{ $halls->count() }})</h4>
        </div>
        @forelse($halls as $hall)
        <div class="col-md-4 mb-4">
            <div class="stat-card p-0 overflow-hidden shadow-sm" style="border: 1px solid #eee;">
                <img src="{{ $hall->primaryImage ? asset('storage/' . $hall->primaryImage->image_path) : 'https://via.placeholder.com/400x200' }}" class="w-100" style="height: 180px; object-fit: cover;">
                <div class="p-3">
                    <h5 class="fw-bold mb-1">{{ $hall->name }}</h5>
                    <div class="x-small text-muted mb-3"><i class="bi bi-geo-alt me-1"></i> {{ $hall->city }}, {{ $hall->address }}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-soft-primary text-primary border border-primary-subtle rounded-pill">Active</span>
                        <a href="{{ route('halls.show', $hall->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Manage</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-light border shadow-none text-muted">No halls matched your query.</div>
        </div>
        @endforelse
    </div>

    <!-- Users Results -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <h4 class="fw-bold"><i class="bi bi-people me-2"></i> Users & Vendors ({{ $users->count() }})</h4>
        </div>
        <div class="col-12">
            <div class="glass-panel p-0 overflow-hidden">
                <table class="table premium-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>User Profile</th>
                            <th>Email Address</th>
                            <th>System Role</th>
                            <th>Phone</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=D4AF37&color=fff" class="avatar rounded-circle me-3" style="width: 36px; height: 36px;">
                                    <div class="fw-bold small text-dark">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="small text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge rounded-pill bg-soft-info text-info border border-info-subtle text-uppercase fw-bold" style="font-size: 0.65rem;">{{ $user->role }}</span>
                            </td>
                            <td class="small text-muted">{{ $user->phone ?? 'Not provided' }}</td>
                            <td class="text-end">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-soft-primary rounded-circle" style="width:32px; height:32px; padding:0; display:inline-flex; align-items:center; justify-content:center;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No users matched your query.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bookings Results -->
    <div class="row mb-5">
        <div class="col-12 mb-3">
            <h4 class="fw-bold"><i class="bi bi-calendar-check me-2"></i> Bookings ({{ $bookings->count() }})</h4>
        </div>
        <div class="col-12">
            <div class="glass-panel p-0 overflow-hidden">
                <table class="table premium-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Hall</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th class="text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->hall->name }}</td>
                            <td>{{ $booking->event_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge rounded-pill bg-soft-warning text-warning border border-warning-subtle">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-link text-primary text-decoration-none">View <i class="bi bi-arrow-right small"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No bookings matched your query.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
