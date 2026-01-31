@extends('layouts.admin')

@section('title', 'Admin Overview')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Header -->
    <div class="row mb-5 animated-up">
        <div class="col-md-8">
            <h1 class="display-6 fw-800 text-dark mb-1" style="font-weight: 800;">Command Center</h1>
            <p class="text-muted lead fs-6">Welcome back, Admin. System performance is optimal today.</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end gap-2">
            <button class="btn btn-white shadow-sm rounded-pill px-4 border-0">
                <i class="bi bi-calendar3 me-2"></i> {{ now()->format('M d, Y') }}
            </button>
            <a href="{{ route('listings') }}" class="btn btn-premium rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i> New Launch
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6 animated-up staggered-1">
            <div class="stat-card h-100">
                <div class="stat-icon primary">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-value">${{ number_format($stats['total_revenue'], 0) }}</div>
                <div class="stat-label">Total Revenue</div>
                <div class="mt-3 fs-xs text-success fw-bold">
                    <i class="bi bi-arrow-up-short"></i> 12% vs last month
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 animated-up staggered-2">
            <div class="stat-card h-100">
                <div class="stat-icon success">
                    <i class="bi bi-building-check"></i>
                </div>
                <div class="stat-value">{{ $stats['total_halls'] }}</div>
                <div class="stat-label">Active Venues</div>
                <div class="mt-3 fs-xs text-muted">
                    Across 12 cities
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 animated-up staggered-3">
            <div class="stat-card h-100">
                <div class="stat-icon warning">
                    <i class="bi bi-journal-check"></i>
                </div>
                <div class="stat-value">{{ $stats['total_bookings'] }}</div>
                <div class="stat-label">Total Bookings</div>
                <div class="mt-3 fs-xs text-warning fw-bold">
                    {{ $stats['confirmed_bookings'] }} Completed
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 animated-up staggered-4">
            <div class="stat-card h-100" style="border-bottom: 4px solid var(--primary-gold);">
                <div class="stat-icon danger">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value">{{ $stats['pending_bookings'] }}</div>
                <div class="stat-label">Pending Review</div>
                <div class="mt-3">
                    <a href="{{ route('requests') }}" class="btn btn-sm btn-soft-danger rounded-pill px-3">Action Now</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4 mb-5">
        <!-- Growth Chart Placeholder -->
        <div class="col-xl-8 animated-up staggered-2">
            <div class="glass-panel h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0"><i class="bi bi-graph-up-arrow me-2 text-primary"></i>Revenue Analytics</h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-light text-dark active">Week</button>
                        <button class="btn btn-outline-light text-dark">Month</button>
                    </div>
                </div>
                <div class="chart-box py-5 d-flex align-items-center justify-content-center bg-light rounded-4 border-dashed" style="height: 350px;">
                    <div class="text-center text-muted">
                        <i class="bi bi-activity display-4 opacity-25"></i>
                        <p class="mt-2 small fw-medium">Live data feed active</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Alerts -->
        <div class="col-xl-4 animated-up staggered-3">
            <div class="glass-panel h-100">
                <h5 class="fw-bold mb-4"><i class="bi bi-shield-lock me-2 text-warning"></i>Security & Health</h5>
                <div class="alert-list">
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0 avatar rounded-pill bg-soft-success text-success d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-server"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Storage Optimization</div>
                            <p class="text-muted x-small mb-0">System cleanup ran successfully today at 04:00 AM.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0 avatar rounded-pill bg-soft-primary text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">New Owner Application</div>
                            <p class="text-muted x-small mb-0">"Grand Plaza" submitted verification documents.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0 avatar rounded-pill bg-soft-warning text-warning d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-patch-exclamation"></i>
                        </div>
                        <div>
                            <div class="fw-bold small">Version Update</div>
                            <p class="text-muted x-small mb-0">A new security patch (v2.1.2) is ready for deployment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="row animated-up staggered-4">
        <div class="col-12">
            <div class="glass-panel overflow-hidden p-0">
                <div class="px-4 py-4 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold m-0">Recent Transacions</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">Full Ledger <i class="bi bi-arrow-right small"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table premium-table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Hall Assignment</th>
                                <th>Date & Session</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Tracking</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->user->name) }}&background=D4AF37&color=fff" class="avatar rounded-circle me-3" style="width: 38px; height: 38px;">
                                        <div>
                                            <div class="fw-bold text-dark small">{{ $booking->user->name }}</div>
                                            <div class="text-muted x-small">{{ $booking->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="small fw-medium text-muted">
                                    <i class="bi bi-building-fill me-1"></i> {{ $booking->hall->name }}
                                </td>
                                <td>
                                    <div class="fw-bold small">{{ $booking->event_date->format('M d, Y') }}</div>
                                    <div class="text-muted x-small">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} session</div>
                                </td>
                                <td>
                                    <span class="fw-800 text-dark">${{ number_format($booking->total_price, 2) }}</span>
                                </td>
                                <td>
                                    @php 
                                        $badgeClass = match($booking->status) {
                                            'pending' => 'bg-soft-warning text-warning border-warning-subtle',
                                            'confirmed' => 'bg-soft-success text-success border-success-subtle',
                                            'approved', 'approved_by_admin' => 'bg-soft-info text-info border-info-subtle',
                                            default => 'bg-soft-secondary text-secondary'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill border {{ $badgeClass }} px-3">
                                        {{ ucfirst($booking->status == 'approved_by_admin' ? 'Approved' : $booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 6px; width: 80px;">
                                        <div class="progress-bar bg-primary-gold" style="width: {{ $booking->status == 'confirmed' ? '100' : '60' }}%"></div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-soft-primary rounded-circle" style="width:34px; height:34px; padding:0; display:inline-flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-arrow-right-short"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No recent operations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-800 { font-weight: 800; }
    .x-small { font-size: 0.75rem; }
    .fs-xs { font-size: 0.7rem; }
    .btn-soft-primary { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: none; }
    .btn-soft-primary:hover { background: #3b82f6; color: white; }
    .btn-soft-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: none; }
    .btn-soft-danger:hover { background: #ef4444; color: white; }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-primary { background: rgba(59, 130, 246, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
    .border-dashed { border: 2px dashed #e2e8f0; }
</style>
@endsection
