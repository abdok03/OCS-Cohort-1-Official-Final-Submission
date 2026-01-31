<!-- resources/views/partials/sidebar.blade.php -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <i class="bi bi-heart-fill text-primary"></i>
            <span>WeddingHalls</span>
        </a>
        <button class="btn btn-link p-0 d-lg-none" id="sidebarToggle">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('listings') }}">
                    <i class="bi bi-building"></i>
                    <span>Listings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('requests') }}">
                    <i class="bi bi-inbox"></i>
                    <span>Requests</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">
                    <i class="bi bi-tags"></i>
                    <span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('reports') }}">
                    <i class="bi bi-bar-chart"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('settings') }}">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item mt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger bg-transparent border-0 w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>


        </ul>
    </div>

    <div class="sidebar-footer p-3 border-top">
        <div class="d-flex align-items-center">
            <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" alt="User"
                class="avatar rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;">
            <div>
                <div class="fw-medium">
                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                </div>
                <small class="text-muted">
                    {{ auth()->user()->role ?? 'User' }}
                </small>
            </div>
        </div>
    </div>

</aside>
