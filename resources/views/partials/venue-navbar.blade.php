<nav class="navbar navbar-expand px-4 py-3 bg-white border-bottom border-light sticky-top">
    <div class="container-fluid p-0">
        <!-- Sidebar Toggle -->
        <button class="btn btn-icon btn-light rounded-circle d-lg-none me-3" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>

        <!-- Search Bar -->
        <div class="navbar-search flex-grow-1 d-none d-md-block" style="max-width: 400px;">
            <form action="{{ route('venue.bookings.index') }}" method="GET">
                <div class="input-group input-group-merge rounded-pill bg-light border-0">
                    <span class="input-group-text bg-transparent border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control bg-transparent border-0 py-2 ps-2 shadow-none" placeholder="Search for bookings, venues..." value="{{ request('search') }}">
                </div>
            </form>
        </div>

        <!-- Right Side -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-icon btn-light rounded-circle shadow-none position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New notifications</span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 py-3 rounded-4 px-3" style="min-width: 300px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Notifications</h6>
                        <a href="#" class="small text-decoration-none">Mark all as read</a>
                    </div>
                    <div class="py-2 text-center text-muted small">
                        No new notifications
                    </div>
                </div>
            </div>

            <!-- Vertical Divider -->
            <div class="vr mx-2 text-light" style="height: 24px;"></div>

            <!-- User Profile -->
            <div class="dropdown">
                <div class="user-dropdown d-flex align-items-center cursor-pointer p-1 rounded-pill hover-bg-light transition-all" data-bs-toggle="dropdown">
                    <div class="user-avatar-wrapper position-relative me-2">
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->first_name).'&background=D4AF37&color=fff' }}"
                            alt="{{ auth()->user()->first_name }}" class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-white border-2 rounded-circle"></span>
                    </div>
                    <div class="d-none d-lg-block me-2">
                        <div class="fw-bold text-dark small leading-tight">{{ auth()->user()->first_name }}</div>
                        <div class="text-muted" style="font-size: 0.7rem;">Manager Account</div>
                    </div>
                    <i class="bi bi-chevron-down small text-muted d-none d-lg-block"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2 mt-2">
                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>My Profile</a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i>Account Settings</a></li>
                    <li><hr class="dropdown-divider mx-2"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item rounded-3 py-2 text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    .navbar { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
    .btn-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
    .cursor-pointer { cursor: pointer; }
    .hover-bg-light:hover { background-color: #f8fafc; }
    .leading-tight { line-height: 1.2; }
    .hover-bg-light { padding-right: 1rem !important; }
</style>
