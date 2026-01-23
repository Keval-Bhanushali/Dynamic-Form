<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --alert-success-bg: rgba(34, 197, 94, 0.1);
            --alert-error-bg: rgba(239, 68, 68, 0.1);
            --alert-border: 1px solid rgba(148, 163, 184, 0.2);
            --sidebar-bg: rgba(255, 255, 255, 0.9);
            --sidebar-width: 280px;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            color: #1e293b;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            backdrop-filter: blur(10px);
            border-right: 1px solid var(--alert-border);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--alert-border);
            text-align: center;
        }

        .sidebar-header h4 {
            margin: 0;
            color: #1e293b;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-item {
            margin: 0.25rem 0;
        }

        .sidebar-nav .nav-link {
            color: #475569;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin: 0 0.5rem;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .sidebar-nav .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .content-wrapper {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid var(--alert-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin: 2rem auto;
            max-width: 1400px;
        }

        .alert {
            border: none;
            border-radius: 16px;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: var(--alert-success-bg);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #16a34a;
        }

        .alert-danger {
            background: var(--alert-error-bg);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #dc2626;
        }

        .alert i {
            font-size: 1.5rem;
        }

        .alert .alert-text {
            color: #1e293b;
        }

        .btn-close-white {
            opacity: 0.8;
        }

        .toggle-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            background: var(--primary-gradient);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            transform: scale(1.1);
        }

        /* Faster dropdown animation */
        .dropdown-menu {
            animation-duration: 0.2s !important;
            /* Reduce from default ~0.3s */
            transition: opacity 0.2s ease, transform 0.2s ease !important;
        }

        /* Position dropdown to expand to the right (avoiding sidebar overflow) */
        .sidebar .dropdown-menu {
            position: absolute;
            left: 100%;
            /* Expand to the right */
            top: 0;
            margin-left: 0.5rem;
            border-radius: 8px;
            background: var(--sidebar-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--alert-border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .sidebar .dropdown-item {
            color: #cbd5e1;
            padding: 0.5rem 1rem;
            transition: background 0.2s ease;
        }

        .sidebar .dropdown-item:hover {
            background: var(--primary-gradient);
            color: #fff;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-wrapper {
                margin: 0 1rem;
                padding: 1.5rem;
                border-radius: 16px;
            }

            .toggle-btn {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .toggle-btn {
                display: none;
            }
        }
    </style>

    <title>@yield('title', 'Dynamic Forms - Dashboard')</title>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>Dynamic Forms</h4>
        </div>
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('forms.*') ? 'active' : '' }}" href="#"
                    id="formsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-text"></i> Forms
                </a>
                <ul class="dropdown-menu" aria-labelledby="formsDropdown">
                    <li><a class="dropdown-item text-dark" href="{{ route('forms.index') }}">
                            <i class="bi bi-list-ul me-2"></i>View All Forms
                        </a></li>
                    <li><a class="dropdown-item text-dark" href="{{ route('forms.create') }}">
                            <i class="bi bi-plus-circle me-2"></i>Create New Form
                        </a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') ? 'active' : '' }}" href="#"
                    id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-file-earmark-text"></i> Products
                </a>
                <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                    <li><a class="dropdown-item text-dark" href="{{ route('products.index') }}">
                            <i class="bi bi-list-ul me-2"></i>View All Products
                        </a></li>
                    {{-- <li><a class="dropdown-item text-dark" href="{{ route('products.create') }}">
                            <i class="bi bi-plus-circle me-2"></i>Create New Form
                        </a></li> --}}
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Toggle Button for Mobile -->
    <button class="toggle-btn d-md-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <main class="main-container">
            <div class="container-fluid">
                <div class="content-wrapper">
                    <!-- Success Alert -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4"
                        role="alert">
                        <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                        <span class="alert-text">{{ session('success') }}</span>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Error Alert -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4"
                        role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-danger"></i>
                        <strong>Validation Error:</strong> Please check the form and try again.
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script>
        // Sidebar Toggle Functionality
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('expanded');
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
                mainContent.classList.remove('expanded');
            }
        });
    </script>
</body>

</html>