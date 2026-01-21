<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6, #1d4ed8);
            --glass-bg: rgba(15, 23, 42, 0.95);
            --alert-success-bg: rgba(34, 197, 94, 0.2);
            --alert-error-bg: rgba(239, 68, 68, 0.2);
            --alert-border: 1px solid rgba(148, 163, 184, 0.2);
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            color: #f8fafc;
            font-family: 'Roboto', sans-serif;
        }

        .main-container {
            min-height: calc(100vh - 80px);
            padding: 2rem 0;
        }

        .content-wrapper {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid var(--alert-border);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2.5rem;
            margin: 0 auto;
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
        color: #34D399; /* Custom text color for success alerts */
        }
        
        .alert-danger {
        background: var(--alert-error-bg);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #F87171; /* Custom text color for error alerts */
        }
        
        .alert i {
        font-size: 1.5rem;
        }
        
        .alert .alert-text {
        color: #F8FAFC; /* Ensure the text inside alert has good contrast */
        }

        .btn-close-white {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin: 0 1rem;
                padding: 1.5rem;
                border-radius: 16px;
            }
        }
    </style>

    <title>@yield('title', 'Dynamic Forms - Dashboard')</title>
</head>

<body>
    @include('partials.navbar')

    <main class="main-container">
        <div class="container-fluid">
            <div class="content-wrapper">
                <!-- Success Alert -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
                    <span class="alert-text">{{ session('success') }}</span>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Error Alert -->
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>