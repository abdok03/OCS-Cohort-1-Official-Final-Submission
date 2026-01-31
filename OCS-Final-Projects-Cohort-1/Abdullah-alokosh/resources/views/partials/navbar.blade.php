<!-- resources/views/partials/navbar.blade.php -->
<nav class="admin-navbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-link p-0 d-lg-none" id="sidebarToggle">
            <i class="bi bi-list" style="font-size: 1.5rem;"></i>
        </button>

        <div class="navbar-search">
            <i class="bi bi-search search-icon"></i>
            <input type="search" class="form-control" placeholder="Search users, halls, reports...">
        </div>
    </div>

    <div class="navbar-actions">
        <button class="action-btn" id="themeToggle" data-bs-toggle="tooltip" title="Toggle theme">
            <i class="bi bi-moon"></i>
        </button>

        <div class="dropdown">
            <button class="action-btn" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="notification-badge"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                <div class="p-3 border-bottom">
                    <h6 class="mb-0">Notifications</h6>
                    <small class="text-muted">3 new notifications</small>
                </div>
                <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                    <a href="#" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div
                                    class="avatar-sm bg-primary-light text-primary rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-plus"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">New user registered</h6>
                                <p class="mb-0 text-muted small">Sarah Johnson just created an account</p>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div
                                    class="avatar-sm bg-success-light text-success rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-credit-card"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Payment received</h6>
                                <p class="mb-0 text-muted small">New booking payment of $4,200</p>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div
                                    class="avatar-sm bg-warning-light text-warning rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">New review</h6>
                                <p class="mb-0 text-muted small">Michael left a 5-star review</p>
                                <small class="text-muted">3 hours ago</small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="p-2 border-top">
                    <a href="#" class="btn btn-link w-100 text-center">View all notifications</a>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <div class="user-dropdown" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                    alt="{{ auth()->user()->first_name }}" class="user-avatar">



                <div class="fw-medium">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>

                <i class="bi bi-chevron-down text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i> Profile</a>
                </li>
                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i> Settings</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
