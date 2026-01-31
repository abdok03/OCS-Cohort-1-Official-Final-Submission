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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary: rgb(59, 42, 42);
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #10b981;
            --secondary-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --border-radius: 0.75rem;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 40px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary) 0%, #8b5cf6 100%);
            color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30%, -30%);
        }

        /* الألوان الناعمة للخلفيات (Soft Backgrounds) */
        .bg-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bg-warning-light {
            background-color: rgba(255, 193, 7, 0.15);
        }

        .bg-info-light {
            background-color: rgba(13, 202, 240, 0.15);
        }

        /* دعم الوضع الليلي إذا كان مفعلاً */
        .dark-mode .card {
            background-color: #1e293b;
            color: #f8fafc;
        }

        .dark-mode .card-header {
            border-bottom: 1px solid #334155;
            color: #f8fafc;
            background: transparent !important;
        }

        .dark-mode .dark-mode-bg-soft {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #fff;
        }

        .dark-mode .form-control,
        .dark-mode .form-select {
            background-color: #0f172a;
            border-color: #334155;
            color: #fff;
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
