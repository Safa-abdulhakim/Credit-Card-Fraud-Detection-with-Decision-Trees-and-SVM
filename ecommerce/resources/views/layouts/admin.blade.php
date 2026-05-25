<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | ShopMart Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root { --sidebar-width: 260px; --sidebar-bg: #1e2a3a; --sidebar-text: #8899aa; --sidebar-active: #0d6efd; }
        body { background: #f0f2f5; }
        .admin-sidebar { width: var(--sidebar-width); min-height: 100vh; background: var(--sidebar-bg); position: fixed; top: 0; left: 0; z-index: 1000; transition: all .3s; overflow-y: auto; }
        .admin-sidebar .brand { background: #162032; padding: 20px; border-bottom: 1px solid #2d3f50; }
        .admin-sidebar .brand h4 { color: white; margin: 0; font-weight: 700; }
        .sidebar-nav { padding: 15px 0; }
        .sidebar-nav .nav-section { color: #4a6080; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 5px; }
        .sidebar-nav .nav-link { color: var(--sidebar-text); padding: 10px 20px; display: flex; align-items: center; gap: 10px; border-radius: 0; transition: all .2s; font-size: .9rem; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { color: white; background: rgba(13,110,253,.15); border-left: 3px solid var(--sidebar-active); }
        .sidebar-nav .nav-link i { width: 20px; text-align: center; }
        .admin-main { margin-left: var(--sidebar-width); min-height: 100vh; }
        .admin-topbar { background: white; border-bottom: 1px solid #e9ecef; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 999; }
        .admin-content { padding: 24px; }
        .stat-card { border-radius: 16px; border: none; overflow: hidden; }
        .stat-card .card-body { padding: 24px; }
        .stat-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .table-card { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: .78rem; font-weight: 600; }
        .page-header { background: white; padding: 20px 24px; margin: -24px -24px 24px; border-bottom: 1px solid #e9ecef; }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
{{-- Sidebar --}}
<nav class="admin-sidebar">
    <div class="brand">
        <h4><i class="fas fa-shopping-bag me-2 text-primary"></i>ShopMart</h4>
        <small class="text-muted">Admin Panel</small>
    </div>
    <div class="sidebar-nav">
        <span class="nav-section">Main</span>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

        <span class="nav-section">Catalog</span>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fas fa-box"></i> Products</a>
        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-tags"></i> Categories</a>
        <a href="{{ route('admin.brands.index') }}" class="nav-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}"><i class="fas fa-trademark"></i> Brands</a>

        <span class="nav-section">Commerce</span>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> Orders</a>
        <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}"><i class="fas fa-ticket-alt"></i> Coupons</a>
        <a href="{{ route('admin.shipping-methods.index') }}" class="nav-link {{ request()->routeIs('admin.shipping-methods.*') ? 'active' : '' }}"><i class="fas fa-truck"></i> Shipping</a>

        <span class="nav-section">Users</span>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users"></i> Users</a>
        <a href="{{ route('admin.vendors.index') }}" class="nav-link {{ request()->routeIs('admin.vendors.*') ? 'active' : '' }}"><i class="fas fa-store"></i> Vendors</a>
        <a href="{{ route('admin.withdrawals.index') }}" class="nav-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}"><i class="fas fa-money-bill"></i> Withdrawals</a>

        <span class="nav-section">Moderation</span>
        <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"><i class="fas fa-star"></i> Reviews</a>

        <span class="nav-section">Reports</span>
        <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Reports</a>
        <a href="{{ route('admin.logs') }}" class="nav-link {{ request()->routeIs('admin.logs') ? 'active' : '' }}"><i class="fas fa-history"></i> Activity Logs</a>
        <a href="{{ route('admin.inventory-logs') }}" class="nav-link {{ request()->routeIs('admin.inventory-logs') ? 'active' : '' }}"><i class="fas fa-warehouse"></i> Inventory Logs</a>

        <span class="nav-section">System</span>
        <a href="{{ route('admin.settings') }}" class="nav-link"><i class="fas fa-cog"></i> Settings</a>
        <a href="{{ route('home') }}" class="nav-link" target="_blank"><i class="fas fa-external-link-alt"></i> View Store</a>
    </div>
</nav>

{{-- Main Content --}}
<div class="admin-main w-100">
    <div class="admin-topbar">
        <div>
            <h6 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary position-relative">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:9px;">
                    {{ \App\Models\Order::where('status','pending')->count() }}
                </span>
            </a>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=36&background=0d6efd&color=ffffff&rounded=true" class="rounded-circle" width="36" height="36">
                    <div class="d-none d-md-block">
                        <div class="fw-semibold small">{{ auth()->user()->name }}</div>
                        <div class="text-muted" style="font-size:11px;">Administrator</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="admin-content">
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

        @yield('content')
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
