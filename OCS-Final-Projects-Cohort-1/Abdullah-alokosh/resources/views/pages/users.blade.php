<!-- resources/views/pages/users.blade.php -->
@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">Users Management</h1>
                    <p class="text-muted mb-0">Manage all user accounts and permissions</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-funnel me-2"></i> Filter
                    </button>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        <i class="bi bi-plus-lg me-2"></i> Add User
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
                        <div class="stat-value">total Users</div>
                        <div class="stat-value">{{ $totalUsers }} </div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+8.2%</span>
                        </div>
                    </div>
                    <div class="stat-icon primary">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">active Users</div>
                        <div class="stat-value">{{ $activeUsers }} </div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+5.3%</span>
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
                        <div class="stat-value">pending Users</div>
                        <div class="stat-value">{{ $pendingUsers }}</div>
                        <div class="stat-trend trend-down">
                            <i class="bi bi-arrow-down-right"></i>
                            <span>-12.1%</span>
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
                        <div class="stat-label">Suspended</div>
                        <div class="stat-value">28</div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+3.4%</span>
                        </div>
                    </div>
                    <div class="stat-icon danger">
                        <i class="bi bi-slash-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="data-table">
                <div class="table-header">
                    <div>
                        <h3 class="table-title">All Users</h3>
                        <div class="text-muted">
                            {{-- هنا جعلنا الأرقام ديناميكية لتفهم ما يحدث --}}
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <form method="GET">
                            <input type="search" name="search" class="form-control" placeholder="Search users..."
                                value="{{ request('search') }}">
                        </form>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Last Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                                alt="{{ $user->first_name }}" class="user-avatar">


                                            <div>
                                                <div class="fw-medium">{{ $user->name }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $user->email }}</td>

                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $user->role ?? 'User' }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->active ?? true)
                                            <span class="badge badge-success">
                                                <i class="bi bi-circle-fill me-1" style="font-size:6px"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="bi bi-circle-fill me-1" style="font-size:6px"></i>
                                                Suspended
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $user->last_login_at ?? '—' }}</td>

                                    <td>
                                        <div class="d-flex gap-1">
                                            <!-- View -->
                                            <a href="{{ route('users.show', $user->id) }}" class="btn-action"
                                                title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn-action"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <!-- Delete -->
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-action text-danger"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer p-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary"
                                onclick="showConfirm('Bulk Action', 'Apply action to selected users?', function() { showToast('Action applied', 'success') })">
                                Apply Action
                            </button>
                            <span class="text-muted">3 users selected</span>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('users.index') }}">
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator
                                </option>
                                <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        onclick="showToast('Filters applied', 'success')">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Empty State Example -->
    <div class="row d-none" id="emptyState">
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="empty-state-title">No Users Found</h3>
                <p class="empty-state-text">Try adjusting your filters or create a new user.</p>
                <button class="btn btn-primary" onclick="showCreateUserModal()">
                    <i class="bi bi-plus-lg me-2"></i> Create First User
                </button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-select">
                                    <option value="">All Roles</option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                                        Administrator</option>
                                    <option value="editor" {{ request('role') == 'editor' ? 'selected' : '' }}>Editor
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="active" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Pending</option>
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Create User</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
