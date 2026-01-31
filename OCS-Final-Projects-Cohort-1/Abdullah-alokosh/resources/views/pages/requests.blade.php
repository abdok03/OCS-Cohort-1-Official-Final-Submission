<!-- resources/views/pages/requests.blade.php -->
@extends('layouts.admin')

@section('title', 'Requests Management')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1">Booking Requests</h1>
                <p class="text-muted mb-0">Manage user booking requests and inquiries</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="showToast('Export started', 'info')">
                    <i class="bi bi-download me-2"></i> Export CSV
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterRequestsModal">
                    <i class="bi bi-funnel me-2"></i> Filter Requests
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Total Requests</div>
                    <div class="stat-value">1,842</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+18.3%</span>
                    </div>
                </div>
                <div class="stat-icon primary">
                    <i class="bi bi-inbox"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">1,428</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+12.7%</span>
                    </div>
                </div>
                <div class="stat-icon success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value">284</div>
                    <div class="stat-trend trend-down">
                        <i class="bi bi-arrow-down-right"></i>
                        <span>-8.5%</span>
                    </div>
                </div>
                <div class="stat-icon warning">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">130</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-arrow-up-right"></i>
                        <span>+5.2%</span>
                    </div>
                </div>
                <div class="stat-icon danger">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Requests Table -->
<div class="row">
    <div class="col-12">
        <div class="data-table">
            <div class="table-header">
                <div>
                    <h3 class="table-title">Recent Booking Requests</h3>
                    <p class="text-muted mb-0">Showing 1-8 of 1,842 requests</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <input type="search" class="form-control" placeholder="Search requests...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Venue</th>
                            <th>Event Type</th>
                            <th>Dates</th>
                            <th>Guests</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Request 1 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-001</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="Sarah Chen" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Sarah Chen</div>
                                        <small class="text-muted">sarah@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Grand Ballroom Palace</div>
                                <small class="text-muted">New York City</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Wedding</span>
                            </td>
                            <td>
                                <div>Jun 15-17, 2024</div>
                                <small class="text-muted">3 days</small>
                            </td>
                            <td>250</td>
                            <td>
                                <div class="fw-medium">$13,500</div>
                            </td>
                            <td>
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Confirmed
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details" onclick="showRequestDetails('REQ-001')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action" data-bs-toggle="tooltip" title="Edit" onclick="showToast('Edit request', 'info')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action text-success" data-bs-toggle="tooltip" title="Confirm" onclick="showConfirm('Confirm Request', 'Confirm this booking request?', function() { showToast('Request confirmed', 'success') })">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Request 2 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-002</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="Michael Rodriguez" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Michael Rodriguez</div>
                                        <small class="text-muted">michael@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Garden View Mansion</div>
                                <small class="text-muted">Los Angeles</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Engagement</span>
                            </td>
                            <td>
                                <div>Jul 22, 2024</div>
                                <small class="text-muted">Single day</small>
                            </td>
                            <td>150</td>
                            <td>
                                <div class="fw-medium">$3,200</div>
                            </td>
                            <td>
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Pending
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action text-success" data-bs-toggle="tooltip" title="Approve" onclick="showConfirm('Approve Request', 'Approve this booking request?', function() { showToast('Request approved', 'success') })">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button class="btn-action text-danger" data-bs-toggle="tooltip" title="Reject" onclick="showConfirm('Reject Request', 'Reject this booking request?', function() { showToast('Request rejected', 'info') })">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Request 3 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-003</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="Emma Wilson" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Emma Wilson</div>
                                        <small class="text-muted">emma@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Modern Skyline Venue</div>
                                <small class="text-muted">Miami</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Wedding</span>
                            </td>
                            <td>
                                <div>Aug 10-12, 2024</div>
                                <small class="text-muted">3 days</small>
                            </td>
                            <td>180</td>
                            <td>
                                <div class="fw-medium">$12,300</div>
                            </td>
                            <td>
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock me-1"></i>
                                    Pending
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action text-success" data-bs-toggle="tooltip" title="Approve">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
                                    <button class="btn-action text-danger" data-bs-toggle="tooltip" title="Reject">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Request 4 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-004</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="James Thompson" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">James Thompson</div>
                                        <small class="text-muted">james@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Oceanfront Elegance</div>
                                <small class="text-muted">Miami Beach</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Anniversary</span>
                            </td>
                            <td>
                                <div>Sep 5, 2024</div>
                                <small class="text-muted">Single day</small>
                            </td>
                            <td>100</td>
                            <td>
                                <div class="fw-medium">$5,200</div>
                            </td>
                            <td>
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Confirmed
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-action text-danger" data-bs-toggle="tooltip" title="Cancel" onclick="showConfirm('Cancel Booking', 'Cancel this confirmed booking?', function() { showToast('Booking cancelled', 'info') })">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Request 5 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-005</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="Lisa Park" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">Lisa Park</div>
                                        <small class="text-muted">lisa@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Royal Heritage Hall</div>
                                <small class="text-muted">Chicago</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Wedding</span>
                            </td>
                            <td>
                                <div>May 20-22, 2024</div>
                                <small class="text-muted">3 days</small>
                            </td>
                            <td>200</td>
                            <td>
                                <div class="fw-medium">$11,400</div>
                            </td>
                            <td>
                                <span class="badge badge-primary">
                                    <i class="bi bi-check-all me-1"></i>
                                    Completed
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action" data-bs-toggle="tooltip" title="Invoice" onclick="showToast('Invoice generated', 'success')">
                                        <i class="bi bi-receipt"></i>
                                    </button>
                                    <button class="btn-action" data-bs-toggle="tooltip" title="Review" onclick="showToast('Review added', 'info')">
                                        <i class="bi bi-star"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Request 6 -->
                        <tr>
                            <td>
                                <span class="fw-medium">REQ-006</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                         alt="David Kim" class="avatar rounded-circle me-2">
                                    <div>
                                        <div class="fw-medium">David Kim</div>
                                        <small class="text-muted">david@example.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-medium">Victorian Manor</div>
                                <small class="text-muted">San Francisco</small>
                            </td>
                            <td>
                                <span class="badge badge-light">Engagement</span>
                            </td>
                            <td>
                                <div>Apr 10, 2024</div>
                                <small class="text-muted">Single day</small>
                            </td>
                            <td>120</td>
                            <td>
                                <div class="fw-medium">$2,900</div>
                            </td>
                            <td>
                                <span class="badge badge-danger">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Cancelled
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn-action" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-action" data-bs-toggle="tooltip" title="Restore" onclick="showConfirm('Restore Request', 'Restore this cancelled request?', function() { showToast('Request restored', 'success') })">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button class="btn-action text-danger" data-bs-toggle="tooltip" title="Delete" onclick="showConfirm('Delete Request', 'Permanently delete this request?', function() { showToast('Request deleted', 'success') })">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="table-footer p-3 border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button class="btn btn-sm btn-outline-primary" onclick="showBulkActionModal()">
                            <i class="bi bi-three-dots me-1"></i> Bulk Actions
                        </button>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterRequestsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Requests</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Event Type</label>
                        <select class="form-select">
                            <option value="">All Types</option>
                            <option value="wedding">Wedding</option>
                            <option value="engagement">Engagement</option>
                            <option value="anniversary">Anniversary</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="date" class="form-control" placeholder="From">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="To">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Range</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Min">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Max">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="showToast('Filters applied', 'success')">Apply Filters</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showRequestDetails(requestId) {
    // Create modal HTML
    const modalHTML = `
        <div class="modal fade" id="requestDetailsModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Details - ${requestId}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Request ID</label>
                                <div class="form-control bg-light">${requestId}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-control bg-light">
                                    <span class="badge badge-success">Confirmed</span>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">User Information</label>
                                <div class="p-3 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-1.2.1&auto=format&fit=crop&w=50&q=80"
                                             alt="User" class="avatar rounded-circle me-3">
                                        <div>
                                            <div class="fw-medium">Sarah Chen</div>
                                            <div class="text-muted">sarah@example.com</div>
                                            <div class="text-muted">+1 (555) 123-4567</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Venue</label>
                                <div class="form-control bg-light">Grand Ballroom Palace</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Event Type</label>
                                <div class="form-control bg-light">Wedding</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>
                                <div class="form-control bg-light">June 15, 2024</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <div class="form-control bg-light">June 17, 2024</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Number of Guests</label>
                                <div class="form-control bg-light">250</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Amount</label>
                                <div class="form-control bg-light">$13,500</div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Special Requests</label>
                                <div class="form-control bg-light" style="height: 100px;">
                                    Would like floral arrangements in white and gold colors. Need sound system setup.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="showToast('Request updated', 'success')">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Remove existing modal
    const existingModal = document.getElementById('requestDetailsModal');
    if (existingModal) existingModal.remove();

    // Add new modal
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('requestDetailsModal'));
    modal.show();
}

function showBulkActionModal() {
    showToast('Bulk actions modal would open', 'info');
}
</script>
@endsection
