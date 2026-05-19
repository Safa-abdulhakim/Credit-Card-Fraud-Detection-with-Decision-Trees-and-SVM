<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hospital Management System')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2c7be5;
            --sidebar-bg: #12263f;
            --sidebar-text: #d2ddec;
        }
        body { background: #f5f7fb; font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            transition: all 0.3s;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h5 { color: #fff; margin: 0; font-weight: 700; }
        .sidebar-brand small { color: var(--sidebar-text); font-size: 0.75rem; }
        .sidebar-nav { padding: 1rem 0; }
        .sidebar-heading {
            color: rgba(255,255,255,0.4);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.75rem 1.5rem 0.25rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.875rem;
            border-left: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--primary);
        }
        .sidebar-link i { width: 20px; margin-right: 10px; font-size: 0.95rem; }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e3ebf6;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .page-header { padding: 1.5rem 1.5rem 0; }
        .page-content { padding: 1.5rem; }
        .card { border: none; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-radius: 0.75rem; }
        .card-header { background: #fff; border-bottom: 1px solid #e3ebf6; padding: 1rem 1.25rem; }
        .stat-card { border-radius: 0.75rem; border: none; overflow: hidden; }
        .stat-card .card-body { padding: 1.5rem; }
        .stat-icon {
            width: 56px; height: 56px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .badge-pill { border-radius: 50rem; }
        .table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; color: #95aac9; }
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <div class="me-2"><i class="fas fa-hospital-alt fa-2x text-primary"></i></div>
                <div>
                    <h5 class="mb-0">MediCare HMS</h5>
                    <small>Patient Portal</small>
                </div>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-heading">Main</div>
            <a href="{{ route('patient.dashboard') }}" class="sidebar-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <div class="sidebar-heading">My Health</div>
            <a href="{{ route('patient.appointments') }}" class="sidebar-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> My Appointments
            </a>
            <a href="{{ route('patient.medical-records') }}" class="sidebar-link {{ request()->routeIs('patient.medical-records*') ? 'active' : '' }}">
                <i class="fas fa-file-medical"></i> Medical Records
            </a>
            <a href="{{ route('patient.prescriptions') }}" class="sidebar-link {{ request()->routeIs('patient.prescriptions*') ? 'active' : '' }}">
                <i class="fas fa-prescription-bottle-alt"></i> Prescriptions
            </a>

            <div class="sidebar-heading">Billing</div>
            <a href="{{ route('patient.invoices') }}" class="sidebar-link {{ request()->routeIs('patient.invoices*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> My Invoices
            </a>

            <div class="sidebar-heading">Actions</div>
            <a href="{{ route('patient.appointments.book') }}" class="sidebar-link {{ request()->routeIs('patient.appointments.book') ? 'active' : '' }}">
                <i class="fas fa-calendar-plus"></i> Book Appointment
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <nav class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm me-3 d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <h6 class="mb-0 text-muted">@yield('page-title', 'Dashboard')</h6>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;font-size:0.85rem;font-weight:700;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-dark fw-semibold d-none d-md-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ auth()->user()->getRoleNames()->first() }}</h6></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1 fw-bold">@yield('page-title', 'Dashboard')</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 small">@yield('breadcrumb')</ol>
                    </nav>
                </div>
                <div>@yield('page-actions')</div>
            </div>
        </div>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
