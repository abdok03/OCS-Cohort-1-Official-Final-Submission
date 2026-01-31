<!-- resources/views/partials/navbar.blade.php -->
<nav class="admin-navbar">
    <div class="d-flex align-items-center gap-4">
        <button class="action-btn d-lg-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <div class="navbar-search d-none d-md-block">
            <form action="{{ route('admin.search') }}" method="GET">
                <i class="bi bi-search search-icon"></i>
                <input type="search" name="query" class="form-control shadow-none" placeholder="Global search for halls, users, data..." value="{{ request('query') }}">
            </form>
        </div>
    </div>

    <div class="navbar-actions">
        <div class="d-none d-sm-flex gap-2">
            <button class="action-btn" id="themeToggle" data-bs-toggle="tooltip" title="Switch Theme">
                <i class="bi bi-moon-stars"></i>
            </button>
            <div class="dropdown">
                <button class="action-btn" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-0" style="width: 350px; border-radius: 18px;">
                    <div class="p-4 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold luxury-text">Live Notifications</h6>
                            <span class="badge bg-soft-gold text-gold rounded-pill">3 New</span>
                        </div>
                    </div>
                    <div class="list-group list-group-flush" style="max-height: 350px; overflow-y: auto;">
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0">
                            <div class="d-flex gap-3">
                                <div class="avatar-sm bg-soft-success text-success rounded-circle d-flex align-items-center justify-content-center" style="width:45px; height:45px; flex-shrink:0;">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-dark">Payout Completed</div>
                                    <p class="mb-1 text-muted x-small">The reservation #8822 payment has been processed.</p>
                                    <small class="text-gold fw-bold" style="font-size: 0.65rem;">JUST NOW</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 border-0">
                            <div class="d-flex gap-3">
                                <div class="avatar-sm bg-soft-warning text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:45px; height:45px; flex-shrink:0;">
                                    <i class="bi bi-shield-exclamation fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small text-dark">New Vendor Alert</div>
                                    <p class="mb-1 text-muted x-small">A new owner requested access to the dashboard.</p>
                                    <small class="text-muted" style="font-size: 0.65rem;">14 MINUTES AGO</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-3 text-center border-top">
                        <a href="#" class="text-gold small fw-bold text-decoration-none uppercase-wide">Intelligence Center <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown">
            <div class="user-dropdown" data-bs-toggle="dropdown">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=D4AF37&color=fff' }}"
                    alt="{{ auth()->user()->first_name }}" class="user-avatar">
                <div class="d-none d-lg-block me-1">
                    <div class="fw-bold text-dark lh-1 mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.6rem; letter-spacing: 0.05em;">{{ auth()->user()->role }}</small>
                </div>
                <i class="bi bi-chevron-down small text-muted"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 mt-2" style="border-radius: 16px; min-width: 200px;">
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i> My Account</a></li>
                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider opacity-50"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item rounded-3 py-2 text-danger fw-bold">
                            <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
