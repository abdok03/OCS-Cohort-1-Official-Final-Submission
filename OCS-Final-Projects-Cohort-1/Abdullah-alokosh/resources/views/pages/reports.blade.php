<!-- resources/views/pages/reports.blade.php -->
@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Reports & Analytics</h1>
                <p class="text-muted mb-0">Comprehensive insights and performance metrics</p>
            </div>
            <div class="d-flex gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-calendar me-2"></i> Last 30 Days
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                        <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                        <li><a class="dropdown-item" href="#">Last Quarter</a></li>
                        <li><a class="dropdown-item" href="#">Last Year</a></li>
                        <li><a class="dropdown-item" href="#">Custom Range</a></li>
                    </ul>
                </div>
                <button class="btn btn-primary" onclick="showToast('Report generated', 'success')">
                    <i class="bi bi-download me-2"></i> Export Report
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Date Range Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Report Type</label>
                            <select class="form-select">
                                <option>Revenue Report</option>
                                <option>User Growth</option>
                                <option>Booking Analysis</option>
                                <option>Venue Performance</option>
                                <option>Customer Satisfaction</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" value="2024-01-01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" value="2024-03-31">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="button" class="btn btn-primary w-100" onclick="showToast('Report updated', 'success')">
                                <i class="bi bi-filter me-2"></i> Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">$189,450</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+24.3%</span>
                    </div>
                </div>
                <div class="stat-icon success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Bookings</div>
                    <div class="stat-value">842</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+18.7%</span>
                    </div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Avg. Booking Value</div>
                    <div class="stat-value">$225</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+5.2%</span>
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Conversion Rate</div>
                    <div class="stat-value">4.8%</div>
                    <div class="stat-trend trend-down">
                        <i class="bi bi-arrow-down-right"></i>
                        <span>-1.3%</span>
                    </div>
                </div>
                <div class="stat-icon danger">
                    <i class="bi bi-percent"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Revenue Overview</h3>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Monthly
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Daily</a></li>
                        <li><a class="dropdown-item" href="#">Weekly</a></li>
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                        <li><a class="dropdown-item" href="#">Quarterly</a></li>
                    </ul>
                </div>
            </div>
            <div class="chart-placeholder" style="height: 350px;">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-bar-chart display-4 text-muted mb-3"></i>
                        <div class="fw-medium">Revenue Chart</div>
                        <small class="text-muted">Monthly revenue trends and comparisons</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Top Categories</h3>
            </div>
            <div class="chart-placeholder" style="height: 350px;">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-pie-chart display-4 text-muted mb-3"></i>
                        <div class="fw-medium">Category Distribution</div>
                        <small class="text-muted">Revenue by venue category</small>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Luxury</span>
                    <span class="fw-medium">42%</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: 42%"></div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Garden</span>
                    <span class="fw-medium">28%</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 28%"></div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Modern</span>
                    <span class="fw-medium">18%</span>
                </div>
                <div class="progress mb-3" style="height: 8px;">
                    <div class="progress-bar bg-info" style="width: 18%"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Others</span>
                    <span class="fw-medium">12%</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-warning" style="width: 12%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="row g-3 mb-4">
    <div class="col-xl-6">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">User Growth</h3>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Quarterly
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                        <li><a class="dropdown-item" href="#">Quarterly</a></li>
                        <li><a class="dropdown-item" href="#">Yearly</a></li>
                    </ul>
                </div>
            </div>
            <div class="chart-placeholder" style="height: 300px;">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-people display-4 text-muted mb-3"></i>
                        <div class="fw-medium">User Growth Chart</div>
                        <small class="text-muted">New user registrations and growth rate</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Booking Sources</h3>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        This Month
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">This Week</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Quarter</a></li>
                    </ul>
                </div>
            </div>
            <div class="chart-placeholder" style="height: 300px;">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center">
                        <i class="bi bi-pie-chart-fill display-4 text-muted mb-3"></i>
                        <div class="fw-medium">Booking Sources</div>
                        <small class="text-muted">Where bookings are coming from</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Table -->
<div class="row">
    <div class="col-12">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Venue Performance</h3>
                <button class="btn btn-sm btn-outline-primary" onclick="showToast('Detailed venue report generated', 'success')">
                    <i class="bi bi-download me-2"></i> Export Data
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Venue</th>
                            <th>Category</th>
                            <th>Bookings</th>
                            <th>Revenue</th>
                            <th>Avg. Rating</th>
                            <th>Occupancy Rate</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-medium">Grand Ballroom Palace</div>
                                <small class="text-muted">New York City</small>
                            </td>
                            <td><span class="badge badge-primary">Luxury</span></td>
                            <td>42</td>
                            <td>$189,000</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    4.8
                                </div>
                            </td>
                            <td>92%</td>
                            <td>
                                <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>+15%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-medium">Garden View Mansion</div>
                                <small class="text-muted">Los Angeles</small>
                            </td>
                            <td><span class="badge badge-success">Garden</span></td>
                            <td>38</td>
                            <td>$121,600</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    4.6
                                </div>
                            </td>
                            <td>85%</td>
                            <td>
                                <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>+8%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-medium">Royal Heritage Hall</div>
                                <small class="text-muted">Chicago</small>
                            </td>
                            <td><span class="badge badge-warning">Classic</span></td>
                            <td>56</td>
                            <td>$212,800</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    4.9
                                </div>
                            </td>
                            <td>95%</td>
                            <td>
                                <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>+22%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-medium">Modern Skyline Venue</div>
                                <small class="text-muted">Miami</small>
                            </td>
                            <td><span class="badge badge-info">Modern</span></td>
                            <td>31</td>
                            <td>$127,100</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    4.7
                                </div>
                            </td>
                            <td>78%</td>
                            <td>
                                <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>+12%</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="fw-medium">Oceanfront Elegance</div>
                                <small class="text-muted">Miami Beach</small>
                            </td>
                            <td><span class="badge badge-danger">Beachfront</span></td>
                            <td>47</td>
                            <td>$244,400</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    4.9
                                </div>
                            </td>
                            <td>88%</td>
                            <td>
                                <div class="stat-trend trend-up">
                                    <i class="bi bi-arrow-up-right"></i>
                                    <span>+18%</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Report Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Report Actions</h5>
                        <p class="text-muted mb-0">Additional reporting options and settings</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="showToast('Scheduled report', 'success')">
                            <i class="bi bi-clock me-2"></i> Schedule Report
                        </button>
                        <button class="btn btn-outline-primary" onclick="showToast('Report shared', 'success')">
                            <i class="bi bi-share me-2"></i> Share Report
                        </button>
                        <button class="btn btn-primary" onclick="showToast('Advanced analytics generated', 'success')">
                            <i class="bi bi-graph-up-arrow me-2"></i> Advanced Analytics
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
