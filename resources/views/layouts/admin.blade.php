<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - WeddingHalls</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <style>
        :root {
            --royal-gold: #D4AF37;
            --royal-gold-dark: #B5952F;
            --royal-gold-light: rgba(212, 175, 55, 0.1);
            --midnight: #1A1A1A;
            --slate-gray: #4A4A4A;
            --premium-cream: #FAF9F6;
            --ivory-white: #FDFCF0;
            
            --primary: var(--royal-gold);
            --primary-dark: var(--royal-gold-dark);
            --primary-light: var(--royal-gold-light);
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: var(--midnight);
            --light: var(--premium-cream);
            
            --border-radius: 1.25rem;
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.08);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .luxury-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }

        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.03);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary {
            background-color: var(--midnight);
            border-color: var(--midnight);
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .btn-primary:hover {
            background-color: var(--royal-gold);
            border-color: var(--royal-gold);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .btn-outline-primary {
            color: var(--midnight);
            border-color: var(--midnight);
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background-color: var(--midnight);
            border-color: var(--midnight);
            color: white;
            transform: translateY(-2px);
        }

        .stat-card {
            background: white;
            color: var(--midnight);
            border-radius: var(--border-radius);
            padding: 1.75rem;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--royal-gold);
        }

        .stat-label {
            color: var(--slate-gray);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--midnight);
            margin-bottom: 0.5rem;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: var(--royal-gold-light);
            color: var(--royal-gold);
        }

        /* Sidebar Styles Overrides */
        #sidebar {
            background: var(--midnight) !important;
            border-right: none;
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 2rem 1.5rem !important;
        }

        .nav-link {
            border-radius: 12px !important;
            margin: 0.2rem 1rem !important;
            padding: 0.8rem 1.2rem !important;
            color: rgba(255, 255, 255, 0.6) !important;
            font-weight: 500 !important;
            transition: var(--transition) !important;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--royal-gold) !important;
            color: white !important;
            transform: translateX(5px);
        }

        .nav-link i {
            font-size: 1.2rem !important;
            margin-right: 12px !important;
        }

        .main-content {
            background-color: var(--premium-cream);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            padding: 1rem 1.5rem !important;
        }

        .avatar-lg {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="light-mode">
    <!-- Sidebar Toggle for Mobile -->
    <div class="sidebar-overlay"></div>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            @include('partials.navbar')

            <!-- Page Content -->
            <main class="container-fluid py-4">
                <div class="page-transition">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="admin-footer py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        &copy; 2024 WeddingHalls Admin. All rights reserved.
                    </div>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted text-decoration-none">Privacy Policy</a>
                        <a href="#" class="text-muted text-decoration-none">Terms of Service</a>
                        <span class="text-muted">v2.1.0</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Theme Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const body = document.body;

            // Check for saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            body.classList.toggle('dark-mode', savedTheme === 'dark');
            body.classList.toggle('light-mode', savedTheme === 'light');

            themeToggle.addEventListener('click', function() {
                const isDark = body.classList.contains('dark-mode');
                body.classList.toggle('dark-mode', !isDark);
                body.classList.toggle('light-mode', isDark);
                localStorage.setItem('theme', isDark ? 'light' : 'dark');
            });

            // Sidebar Toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');

            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                sidebarOverlay.classList.toggle('active');
            });

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.add('collapsed');
                sidebarOverlay.classList.remove('active');
            });

            // Active Menu Item
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.sidebar-nav .nav-link');

            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href && currentPath.includes(href.replace('/', ''))) {
                    item.classList.add('active');
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Show toast function
            window.showToast = function(message, type = 'success') {
                const toastEl = document.querySelector('.toast');
                const toastBody = toastEl.querySelector('.toast-body');

                // Set background color based on type
                toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning');
                if (type === 'success') toastEl.classList.add('bg-success');
                if (type === 'error') toastEl.classList.add('bg-danger');
                if (type === 'warning') toastEl.classList.add('bg-warning');

                toastBody.textContent = message;

                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            };

            // Confirmation modal
            window.showConfirm = function(title, message, confirmCallback) {
                // Create modal HTML
                const modalHTML = `
                    <div class="modal fade" id="confirmModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">${title}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>${message}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-danger" id="confirmButton">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Remove existing modal
                const existingModal = document.getElementById('confirmModal');
                if (existingModal) existingModal.remove();

                // Add new modal
                document.body.insertAdjacentHTML('beforeend', modalHTML);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                modal.show();

                // Add confirm handler
                document.getElementById('confirmButton').addEventListener('click', function() {
                    if (confirmCallback) confirmCallback();
                    modal.hide();
                });
            };
        });
    </script>

    @yield('scripts')
</body>

</html>
