<!-- resources/views/pages/dashboard.blade.php -->
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Page Header -->
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Dashboard Overview</h1>
                <p class="text-muted mb-0">Welcome back, Alex. Here's what's happening today.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i> Export Report
                </button>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i> New Listing
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">$42,589</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+12.5%</span>
                    </div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-currency-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Active Users</div>
                    <div class="stat-value">3,842</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+8.2%</span>
                    </div>
                </div>
                <div class="stat-icon success">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">New Listings</div>
                    <div class="stat-value">127</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+23.1%</span>
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-building"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Pending Requests</div>
                    <div class="stat-value">18</div>
                    <div class="stat-trend trend-down">
                        <i class="bi bi-arrow-down-right"></i>
                        <span>-3.4%</span>
                    </div>
                </div>
                <div class="stat-icon danger">
                    <i class="bi bi-inbox"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-8">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Users Growth</h3>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Last 30 days
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Last 7 days</a></li>
                        <li><a class="dropdown-item" href="#">Last 30 days</a></li>
                        <li><a class="dropdown-item" href="#">Last quarter</a></li>
                        <li><a class="dropdown-item" href="#">Last year</a></li>
                    </ul>
                </div>
            </div>
            <div class="chart-placeholder">
                <i class="bi bi-bar-chart me-2"></i>
                Users Growth Chart
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Listing Status</h3>
            </div>
            <div class="chart-placeholder d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <i class="bi bi-pie-chart me-2"></i>
                    <div>Donut Chart</div>
                </div>
            </div>
            <div class="row text-center mt-3">
                <div class="col-4">
                    <div class="fw-bold text-primary">65%</div>
                    <small class="text-muted">Active</small>
                </div>
                <div class="col-4">
                    <div class="fw-bold text-warning">15%</div>
                    <small class="text-muted">Pending</small>
                </div>
                <div class="col-4">
                    <div class="fw-bold text-success">20%</div>
                    <small class="text-muted">Booked</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-12">
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">Recent Activity</h3>
                <a href="#" class="btn btn-sm btn-link text-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Target</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="User" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Sarah Chen</div>
                                        <small class="text-muted">Administrator</small>
                                    </div>
                                </div>
                            </td>
                            <td>Approved new listing</td>
                            <td>Grand Ballroom Palace</td>
                            <td>2 minutes ago</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="User" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Michael Rodriguez</div>
                                        <small class="text-muted">Editor</small>
                                    </div>
                                </div>
                            </td>
                            <td>Updated pricing</td>
                            <td>Garden View Mansion</td>
                            <td>15 minutes ago</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="User" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Emma Wilson</div>
                                        <small class="text-muted">Viewer</small>
                                    </div>
                                </div>
                            </td>
                            <td>Created new category</td>
                            <td>Beachfront Venues</td>
                            <td>1 hour ago</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="User" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">James Thompson</div>
                                        <small class="text-muted">Administrator</small>
                                    </div>
                                </div>
                            </td>
                            <td>Flagged suspicious activity</td>
                            <td>User #4289</td>
                            <td>3 hours ago</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="User" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Lisa Park</div>
                                        <small class="text-muted">Editor</small>
                                    </div>
                                </div>
                            </td>
                            <td>Exported monthly reports</td>
                            <td>All Data</td>
                            <td>5 hours ago</td>
                            <td><span class="badge badge-success">Completed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
