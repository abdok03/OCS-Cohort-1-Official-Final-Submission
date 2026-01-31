<!-- resources/views/layouts/user.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Wedding Hall Booking')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray-light: #e2e8f0;
            --gray: #94a3b8;
            --gray-dark: #475569;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    @livewireStyles
</head>


<body>
    <div id="app" x-data="{
        mobileMenuOpen: false,
        userDropdownOpen: false,
        notificationCount: 3,
        darkMode: false
    }" x-cloak>

        @include('partials.user-navbar')

        <main class="main-content">
            @yield('content')

        </main>

        @include('partials.user-footer')

        <!-- Notification Toast -->
        <div class="notification-toast" id="notificationToast" style="display: none;">
            <div class="toast-content">
                <i class="fas fa-check-circle text-success me-2"></i>
                <span class="toast-message">Action completed successfully!</span>
                <button class="toast-close" onclick="this.parentElement.parentElement.style.display='none'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Confirm Action</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalBody">
                        Are you sure you want to proceed?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="modalConfirmBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Navbar shadow on scroll
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar');
                if (window.scrollY > 10) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });

        function showToast(message, type = 'success') {
            const toast = document.getElementById('notificationToast');
            const messageEl = toast.querySelector('.toast-message');
            const icon = toast.querySelector('i');

            messageEl.textContent = message;

            // Set icon based on type
            if (type === 'success') {
                icon.className = 'fas fa-check-circle text-success me-2';
            } else if (type === 'error') {
                icon.className = 'fas fa-times-circle text-danger me-2';
            } else if (type === 'warning') {
                icon.className = 'fas fa-exclamation-triangle text-warning me-2';
            }

            toast.style.display = 'block';

            // Auto hide after 3 seconds
            setTimeout(() => {
                toast.style.display = 'none';
            }, 3000);
        }

        function showConfirmation(title, message, confirmCallback) {
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalBody').textContent = message;

            const confirmBtn = document.getElementById('modalConfirmBtn');
            const newConfirmBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

            newConfirmBtn.addEventListener('click', function() {
                if (confirmCallback) confirmCallback();
                modal.hide();
            });

            modal.show();
        }
    </script>

    @yield('scripts')
    @livewireScripts 
</body>

</html>
