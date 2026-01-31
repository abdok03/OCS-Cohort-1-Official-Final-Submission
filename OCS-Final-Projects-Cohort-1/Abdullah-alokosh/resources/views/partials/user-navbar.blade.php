<style>
    /* متغيرات التصميم */
    :root {
        --nav-gold: #D4AF37;
        --nav-gold-light: #F4E4B5;
        --nav-dark: #1A1A1A;
        --nav-light: #FFFFFF;
        --nav-shadow: rgba(0, 0, 0, 0.1);
        --nav-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* تصميم النافبار الرئيسي */
    .luxury-navbar {
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        padding: 0.8rem 0;
        transition: var(--nav-transition);
    }

    .luxury-navbar.scrolled {
        padding: 0.5rem 0;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        border-bottom: 2px solid var(--nav-gold);
    }

    /* اللوجو */
    .luxury-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--nav-dark);
        transition: var(--nav-transition);
    }

    .luxury-logo:hover {
        transform: scale(1.02);
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--nav-gold), #E6B325);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .logo-text {
        background: linear-gradient(90deg, var(--nav-dark), #333);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Playfair Display', serif;
        letter-spacing: 0.5px;
    }

    /* زر الموبايل */
    .nav-toggle {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 2px solid rgba(212, 175, 55, 0.2);
        background: transparent;
        color: var(--nav-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--nav-transition);
    }

    .nav-toggle:hover {
        background: rgba(212, 175, 55, 0.1);
        border-color: var(--nav-gold);
        transform: rotate(90deg);
    }

    /* عناصر القائمة */
    .nav-menu-center {
        gap: 1.5rem;
    }

    .nav-link-luxury {
        color: var(--nav-dark) !important;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.5rem 1rem !important;
        border-radius: 10px;
        position: relative;
        transition: var(--nav-transition);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .nav-link-luxury:hover {
        color: var(--nav-gold) !important;
        background: rgba(212, 175, 55, 0.08);
    }

    .nav-link-luxury.active {
        color: var(--nav-gold) !important;
        font-weight: 700;
    }

    .nav-link-luxury.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 6px;
        height: 6px;
        background: var(--nav-gold);
        border-radius: 50%;
        animation: navDot 0.3s ease;
    }

    @keyframes navDot {
        from {
            transform: translateX(-50%) scale(0);
        }

        to {
            transform: translateX(-50%) scale(1);
        }
    }

    /* الأيقونات */
    .icon-btn-luxury {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: transparent;
        border: none;
        color: var(--nav-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--nav-transition);
        position: relative;
    }

    .icon-btn-luxury:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--nav-gold);
        transform: translateY(-2px);
    }

    .notif-dot {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 8px;
        height: 8px;
        background: linear-gradient(45deg, #FF4757, #FF3838);
        border-radius: 50%;
        border: 2px solid white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    /* زر المستخدم */
    .user-btn-luxury {
        display: flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        border: 2px solid rgba(212, 175, 55, 0.2);
        border-radius: 12px;
        padding: 8px 16px;
        color: var(--nav-dark);
        font-weight: 600;
        transition: var(--nav-transition);
        min-height: 44px;
    }

    .user-btn-luxury:hover {
        border-color: var(--nav-gold);
        background: rgba(212, 175, 55, 0.08);
        transform: translateY(-2px);
    }

    .user-avatar-luxury {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid var(--nav-gold);
    }

    /* Dropdown */
    .dropdown-menu-luxury {
        background: white;
        border: 1px solid rgba(212, 175, 55, 0.15);
        border-radius: 16px;
        padding: 0.5rem;
        margin-top: 10px !important;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        min-width: 240px;
        animation: dropdownFade 0.2s ease;
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item-luxury {
        padding: 0.75rem 1rem;
        border-radius: 10px;
        color: var(--nav-dark);
        font-weight: 500;
        transition: var(--nav-transition);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dropdown-item-luxury:hover {
        background: rgba(212, 175, 55, 0.1);
        color: var(--nav-gold);
        transform: translateX(5px);
    }

    .dropdown-divider-luxury {
        border-color: rgba(212, 175, 55, 0.1);
        margin: 0.5rem 0;
    }

    /* الأزرار */
    .btn-auth-outline {
        border: 2px solid var(--nav-gold);
        color: var(--nav-gold);
        background: transparent;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: var(--nav-transition);
    }

    .btn-auth-outline:hover {
        background: var(--nav-gold);
        color: white;
        transform: translateY(-2px);
    }

    .btn-auth-primary {
        background: linear-gradient(45deg, var(--nav-gold), #E6B325);
        color: var(--nav-dark);
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-weight: 700;
        transition: var(--nav-transition);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-auth-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    }

    /* القائمة المنسدلة للموبايل */
    @media (max-width: 991px) {
        .luxury-navbar {
            background: white !important;
        }

        .nav-menu-center {
            background: white;
            padding: 1rem;
            border-radius: 16px;
            margin: 1rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .user-btn-luxury {
            justify-content: center;
            margin-top: 1rem;
        }
    }

    /* تأثيرات التمرير */
    @media (max-width: 768px) {
        .luxury-navbar {
            padding: 0.5rem 0;
        }
    }
</style>

<nav class="navbar navbar-expand-lg luxury-navbar fixed-top">
    <div class="container-fluid px-lg-5 px-3">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <div class="luxury-logo">
                <div class="logo-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <span class="logo-text">WeddingHalls</span>
            </div>
        </a>

        <!-- Mobile Toggle -->
        <button class="nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#luxuryNavbar"
            aria-controls="luxuryNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Nav Content -->
        <div class="collapse navbar-collapse" id="luxuryNavbar">
            <!-- Center Menu -->
            <ul class="navbar-nav mx-auto nav-menu-center">
                <li class="nav-item">
                    <a class="nav-link nav-link-luxury {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">
                        <i class="fas fa-home d-lg-none me-2"></i>
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link nav-link-luxury {{ request()->routeIs('explore') ? 'active' : '' }}"
                        href="{{ route('explore') }}">
                        <i class="fas fa-search d-lg-none me-2"></i>
                        Explore
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link nav-link-luxury {{ request()->routeIs('user.bookings') ? 'active' : '' }}"
                            href="{{ route('user.bookings') }}"></a>
                    </li>
                @endauth
            </ul>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-2">
                <!-- Notifications -->
                <button class="icon-btn-luxury position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="notif-dot"></span>
                </button>

                <!-- User -->
                @auth
                    <div class="dropdown">
                        <button class="user-btn-luxury dropdown-toggle d-flex align-items-center gap-2" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                alt="{{ auth()->user()->first_name }}" class="user-avatar-luxury">
                            <span class="d-none d-lg-inline">
                                {{ auth()->user()->first_name }}
                            </span>
                            <i class="fas fa-chevron-down ms-1 fs-xs"></i>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-luxury">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                                        alt="{{ auth()->user()->first_name }}" class="user-avatar-luxury"
                                        style="width: 40px; height: 40px;">
                                    <div>
                                        <div class="fw-bold">{{ auth()->user()->first_name }}
                                            {{ auth()->user()->last_name }}</div>
                                        <small class="text-muted">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider-luxury">
                            </li>

                            <li>
                                <a class="dropdown-item dropdown-item-luxury" href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle" style="color: var(--nav-gold);"></i>
                                    <span>Profile</span>
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item dropdown-item-luxury" href="{{ route('settings') }}">
                                    <i class="fas fa-cog" style="color: var(--nav-gold);"></i>
                                    <span>Settings</span>
                                </a>
                            </li>

                            @if (auth()->user()->is_venue_owner)
                                <li>
                                    <a class="dropdown-item dropdown-item-luxury" href="{{ route('venue.dashboard') }}">
                                        <i class="fas fa-building" style="color: var(--nav-gold);"></i>
                                        <span>Venue Dashboard</span>
                                    </a>
                                </li>
                            @endif

                            <li>
                                <hr class="dropdown-divider-luxury">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item dropdown-item-luxury text-danger">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-auth-outline">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            <span class="d-none d-md-inline">Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-auth-primary">
                            <i class="fas fa-user-plus me-1"></i>
                            <span class="d-none d-md-inline">Sign Up</span>
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div style="height:80px"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.luxury-navbar');

        // تأثير التمرير
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // إغلاق القائمة المنسدلة عند النقر على رابط
        const navLinks = document.querySelectorAll('.nav-link-luxury');
        const navbarCollapse = document.querySelector('.navbar-collapse');

        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });

        // تأثيرات الدخول
        setTimeout(() => {
            navbar.style.opacity = '0';
            navbar.style.transform = 'translateY(-20px)';

            setTimeout(() => {
                navbar.style.transition = 'all 0.5s ease';
                navbar.style.opacity = '1';
                navbar.style.transform = 'translateY(0)';
            }, 100);
        }, 100);
    });
</script>
