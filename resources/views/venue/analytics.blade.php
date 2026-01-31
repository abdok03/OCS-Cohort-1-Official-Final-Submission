@extends('layouts.venue')

@section('title', 'Business Analytics')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Business Analytics</h2>
            <p class="text-muted mb-0">Track your venue performance and financial growth.</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-white shadow-sm rounded-pill px-4 py-2 border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-calendar-event me-2"></i>
                @switch($period)
                    @case('month') This Month @break
                    @case('3months') Last 3 Months @break
                    @case('year') Full Year @break
                    @default Last 6 Months
                @endswitch
            </button>
            <ul class="dropdown-menu border-0 shadow rounded-3">
                <li><a class="dropdown-item" href="{{ route('venue.analytics', ['period' => 'month']) }}">This Month</a></li>
                <li><a class="dropdown-item" href="{{ route('venue.analytics', ['period' => '3months']) }}">Last 3 Months</a></li>
                <li><a class="dropdown-item" href="{{ route('venue.analytics', ['period' => '6months']) }}">Last 6 Months</a></li>
                <li><a class="dropdown-item" href="{{ route('venue.analytics', ['period' => 'year']) }}">Full Year</a></li>
            </ul>
        </div>
    </div>

    <!-- Revenue Chart Card -->
    <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h5 class="fw-bold text-dark mb-1">Monthly Revenue</h5>
                <p class="small text-muted mb-0">Total earnings aggregated by month.</p>
            </div>
            <div class="text-end">
                <div class="fs-3 fw-bold text-primary">${{ number_format($bookingsOverTime->sum('revenue'), 2) }}</div>
                <div class="small text-success fw-bold"><i class="bi bi-arrow-up"></i> 14.2% Since last period</div>
            </div>
        </div>

        <!-- Custom HTML Chart (Bar Representation) -->
        <div class="chart-container py-3" style="height: 300px;">
            <div class="d-flex align-items-end justify-content-between h-100 gap-3 px-4">
                @forelse($bookingsOverTime as $data)
                    <div class="chart-bar-wrapper flex-grow-1 text-center">
                        <div class="chart-bar bg-primary rounded-top-3 position-relative transition-all" 
                             style="height: {{ max(20, ($data->revenue / max(1, $bookingsOverTime->max('revenue'))) * 100) }}%;"
                             data-bs-toggle="tooltip" title="${{ number_format($data->revenue) }}">
                            <div class="bar-value position-absolute top-0 start-50 translate-middle-x mt-n4 small fw-bold text-dark">${{ number_format($data->revenue / 1000, 1) }}k</div>
                        </div>
                        <div class="mt-3 small text-muted fw-bold text-uppercase" style="font-size: 0.65rem;">{{ $data->month }}</div>
                    </div>
                @empty
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center border border-dashed rounded-4">
                        <div class="text-center">
                            <i class="bi bi-bar-chart display-4 text-muted opacity-25"></i>
                            <p class="text-muted small mt-2">Not enough booking data to generate chart yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Breakdown Stats -->
        <div class="col-lg-7">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold text-dark mb-4">Performance Metrics</h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border-0 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary-light text-primary rounded-circle p-2">
                                    <i class="bi bi-ticket-perforated fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark">Average Booking</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">${{ number_format($bookingsOverTime->sum('revenue') / max(1, $bookingsOverTime->sum('count')), 2) }}</h3>
                            <p class="small text-muted mb-0">Per successful event</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border-0 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success-light text-success rounded-circle p-2">
                                    <i class="bi bi-check-all fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark">Success Rate</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ number_format($successRate, 1) }}%</h3>
                            <p class="small text-muted mb-0">Total vs Approved requests</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border-0 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-info-light text-info rounded-circle p-2">
                                    <i class="bi bi-chat-heart fs-5"></i>
                                </div>
                                <span class="fw-bold text-dark">Popular Package</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">{{ ucfirst($popularHospitality->hospitality_package ?? 'None') }}</h3>
                            <p class="small text-muted mb-0">Most selected hospitality</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 bg-light rounded-4 border-0 h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-dark text-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="bi bi-star-fill small"></i>
                                </div>
                                <span class="fw-bold text-dark">Avg. Rating</span>
                            </div>
                            <h3 class="fw-bold text-dark mb-1">4.92 / 5</h3>
                            <p class="small text-muted mb-0">Based on 128 reviews</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback & Top Halls -->
        <div class="col-lg-5">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 h-100">
                <h5 class="fw-bold text-dark mb-4">Venue Distribution</h5>
                <div class="vstack gap-4">
                    @php
                        $userHalls = auth()->user()->halls()->withCount('bookings')->get()->sortByDesc('bookings_count');
                    @endphp
                    @foreach($userHalls as $hall)
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="fw-bold text-dark small">{{ $hall->name }}</div>
                                <div class="small fw-bold text-muted">{{ $hall->bookings_count }} Bookings</div>
                            </div>
                            <div class="progress rounded-pill bg-light" style="height: 8px;">
                                <div class="progress-bar bg-primary rounded-pill transition-all" 
                                     style="width: {{ ($hall->bookings_count / max(1, $userHalls->max('bookings_count'))) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 p-4 bg-dark rounded-4 text-white">
                    <h6 class="fw-bold mb-3">Pro Insight 💡</h6>
                    <p class="small text-white-50 mb-0 leading-relaxed">
                        Your venues are most popular on <strong>Fridays</strong> and <strong>Saturdays</strong>. Consider offering a 10% discount on weekdays to increase occupancy rates.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .bg-primary-light { background-color: rgba(212, 175, 55, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    
    .chart-bar { min-width: 40px; max-width: 60px; margin: 0 auto; opacity: 0.8; }
    .chart-bar:hover { opacity: 1; transform: scaleX(1.1); box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4); }
    
    .btn-white { background: white; color: #1e293b; font-weight: 500; }
    .leading-relaxed { line-height: 1.6; }
    .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
</style>
@endsection
