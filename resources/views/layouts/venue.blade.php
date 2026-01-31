<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Venue Dashboard') - WidingHall</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Outfit for a more modern premium feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #D4AF37;
            --primary-dark: #b5952f;
            --bg-body: #f8fafc;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-body);
            color: #1e293b;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            background-color: var(--bg-body);
        }

        /* Sidebar Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -280px;
                z-index: 1050;
                transition: transform 0.3s ease;
                width: 280px;
            }
            .sidebar.active {
                transform: translateX(280px);
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                backdrop-filter: blur(4px);
                z-index: 1040;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .main-content {
                margin-left: 0 !important;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        /* Shared Global Styles */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .text-primary { color: var(--primary) !important; }
        
        .page-transition {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @livewireStyles
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        @include('partials.venue-sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            @include('partials.venue-navbar') 

            <!-- Page Content -->
            <main class="container-fluid py-4 px-lg-5">
                <div class="page-transition">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Init Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @livewireScripts
</body>
</html>
