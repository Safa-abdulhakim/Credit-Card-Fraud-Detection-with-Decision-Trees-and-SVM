<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام إدارة المستشفى')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #2c7be5;
            --sidebar-bg: #12263f;
            --sidebar-text: #d2ddec;
        }
        body { background: #f5f7fb; font-family: 'Cairo', sans-serif; text-align: right; }
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0; right: 0;
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
            border-right: 3px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-right-color: var(--primary);
        }
        .sidebar-link i { width: 20px; margin-left: 10px; font-size: 0.95rem; }
        .main-content {
            margin-right: var(--sidebar-width);
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
            .sidebar { transform: translateX(100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-right: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- الشريط الجانبي -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <div class="ms-2"><i class="fas fa-hospital-alt fa-2x text-primary"></i></div>
                <div>
                    <h5 class="mb-0">MediCare HMS</h5>
                    <small>إدارة المستشفى</small>
                </div>
            </div>
        </div>
        <div class="sidebar-nav">
            <div class="sidebar-heading">الرئيسية</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> لوحة التحكم
            </a>

            <div class="sidebar-heading">الإدارة</div>
            <a href="{{ route('admin.departments.index') }}" class="sidebar-link {{ request()->routeIs('admin.departments*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> الأقسام
            </a>
            <a href="{{ route('admin.doctors.index') }}" class="sidebar-link {{ request()->routeIs('admin.doctors*') ? 'active' : '' }}">
                <i class="fas fa-user-md"></i> الأطباء
            </a>
            <a href="{{ route('admin.patients.index') }}" class="sidebar-link {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                <i class="fas fa-procedures"></i> المرضى
            </a>

            <div class="sidebar-heading">السريري</div>
            <a href="{{ route('admin.appointments.index') }}" class="sidebar-link {{ request()->routeIs('admin.appointments*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> المواعيد
            </a>
            <a href="{{ route('admin.medical-records.index') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records*') ? 'active' : '' }}">
                <i class="fas fa-file-medical"></i> السجلات الطبية
            </a>
            <a href="{{ route('admin.prescriptions.index') }}" class="sidebar-link {{ request()->routeIs('admin.prescriptions*') ? 'active' : '' }}">
                <i class="fas fa-prescription-bottle-alt"></i> الوصفات الطبية
            </a>

            <div class="sidebar-heading">الفواتير والمدفوعات</div>
            <a href="{{ route('admin.invoices.index') }}" class="sidebar-link {{ request()->routeIs('admin.invoices*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> الفواتير
            </a>
            <a href="{{ route('admin.payments.index') }}" class="sidebar-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> المدفوعات
            </a>

            <div class="sidebar-heading">التحليلات</div>
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> التقارير
            </a>
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- شريط التنقل العلوي -->
        <nav class="topbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <button class="btn btn-sm ms-3 d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <h6 class="mb-0 text-muted">@yield('page-title', 'لوحة التحكم')</h6>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center ms-2" style="width:36px;height:36px;font-size:0.85rem;font-weight:700;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="text-dark fw-semibold d-none d-md-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-start">
                        <li><h6 class="dropdown-header">{{ auth()->user()->getRoleNames()->first() }}</h6></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user ms-2"></i>الملف الشخصي</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt ms-2"></i>تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- محتوى الصفحة -->
        <div class="page-header">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1 fw-bold">@yield('page-title', 'لوحة التحكم')</h4>
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
                    <i class="fas fa-check-circle ms-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle ms-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle ms-2"></i>
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
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
