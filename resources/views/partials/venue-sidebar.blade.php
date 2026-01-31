<nav id="sidebar" class="sidebar">
    <div class="sidebar-header border-0 py-4 px-4 mb-3">
        <div class="logo d-flex align-items-center">
            <div class="logo-icon bg-gradient-gold text-white rounded-3 p-2 me-2">
                <i class="bi bi-heart-fill fs-5"></i>
            </div>
            <span class="fs-5 fw-bold text-dark tracking-tight">Widing<span class="text-primary">Hall</span></span>
        </div>
        <button id="sidebarToggle" class="btn btn-link d-md-none text-muted p-0">
            <i class="bi bi-list fs-3"></i>
        </button>
    </div>

    <div class="sidebar-content px-3">
        <ul class="nav flex-column gap-1">
            <li class="nav-label small text-uppercase text-muted fw-bold px-3 mb-2 opacity-50">Main Menu</li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.dashboard') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.dashboard') }}">
                    <i class="bi bi-grid-1x2 me-3 fs-5"></i>
                    <span class="fw-semibold">Dashboard</span>
                </a>
            </li>

            <li class="nav-label small text-uppercase text-muted fw-bold px-3 mt-4 mb-2 opacity-50">Management</li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.halls.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.halls.index') }}">
                    <i class="bi bi-building me-3 fs-5"></i>
                    <span class="fw-semibold">My Halls</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.bookings.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.bookings.index') }}">
                    <i class="bi bi-calendar-check me-3 fs-5"></i>
                    <span class="fw-semibold">Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.analytics') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.analytics') }}">
                    <i class="bi bi-graph-up me-3 fs-5"></i>
                    <span class="fw-semibold">Analytics</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.service-categories.*') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.service-categories.index') }}">
                    <i class="bi bi-tags me-3 fs-5"></i>
                    <span class="fw-semibold">Service Categories</span>
                </a>
            </li>

            <li class="nav-label small text-uppercase text-muted fw-bold px-3 mt-4 mb-2 opacity-50">Account</li>
            <li class="nav-item">
                <a class="nav-link py-3 px-3 rounded-3 d-flex align-items-center transition-all {{ request()->routeIs('venue.profile') ? 'active bg-primary text-white shadow-sm' : 'text-secondary' }}" href="{{ route('venue.profile') }}">
                    <i class="bi bi-person me-3 fs-5"></i>
                    <span class="fw-semibold">Profile Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="sidebar-footer mt-auto p-4">
        <div class="user-card bg-light rounded-4 p-3 mb-3 d-flex align-items-center">
            <div class="user-avatar bg-gradient-gold text-white rounded-circle me-3 d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                {{ substr(Auth::user()->first_name, 0, 1) }}
            </div>
            <div class="user-info">
                <div class="fw-bold text-dark small">{{ Auth::user()->first_name }}</div>
                <div class="text-muted" style="font-size: 0.7rem;">Verified Partner</div>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger w-100 rounded-3 d-flex align-items-center justify-content-center py-2">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </form>
    </div>
</nav>

<style>
    .sidebar {
        background-color: white;
        height: 100vh;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #f1f5f9;
        position: sticky;
        top: 0;
    }
    .logo-icon.bg-gradient-gold {
        background: linear-gradient(135deg, #D4AF37 0%, #b5952f 100%);
    }
    .nav-link.text-secondary:hover {
        background-color: #f8fafc;
        color: #D4AF37 !important;
    }
    .nav-link.active i {
        color: white !important;
    }
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    .tracking-tight {
        letter-spacing: -0.025em;
    }
    .sidebar-footer {
        padding-top: 2rem;
    }
</style>
