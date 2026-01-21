<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="
    background: linear-gradient(135deg, rgba(15,23,42,0.95) 0%, rgba(30,41,59,0.98) 100%);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(148,163,184,0.2);
">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-4 text-white shadow-sm" href="{{ route('dashboard') }}" style="
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 20px rgba(59,130,246,0.5);
        ">
            <i class="bi bi-file-earmark-text-fill me-2"></i>Dynamic Forms
        </a>

        <button class="navbar-toggler border-0 p-2 rounded" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item position-relative">
                    <a class="nav-link fs-6 px-3 py-2 rounded-pill {{ request()->routeIs('dashboard') ? 'active-nav' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link fs-6 px-3 py-2 rounded-pill {{ request()->routeIs('forms.*') ? 'active-nav' : '' }}"
                        href="{{ route('forms.index') }}">
                        <i class="bi bi-file-earmark-text me-2"></i>Forms
                    </a>
                </li>
                <li class="nav-item position-relative">
                    <a class="nav-link fs-6 px-3 py-2 rounded-pill" href="#">
                        <i class="bi bi-headset me-2"></i>Support
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .navbar-nav .nav-link::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(-50%);
    }

    .navbar-nav .nav-link:hover::before,
    .navbar-nav .nav-link.active-nav::before {
        width: 80%;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active-nav {
        color: #3b82f6 !important;
        background: rgba(59, 130, 246, 0.1) !important;
        transform: translateY(-1px);
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    }

    .dropdown-menu {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>