<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Vendor Dashboard') | ShopMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .vendor-sidebar { width: 240px; min-height: 100vh; background: #198754; position: fixed; top: 0; left: 0; z-index: 1000; }
        .vendor-sidebar .brand { padding: 20px; background: #157347; }
        .vendor-sidebar .nav-link { color: rgba(255,255,255,.8); padding: 10px 20px; display: flex; align-items: center; gap: 10px; }
        .vendor-sidebar .nav-link:hover, .vendor-sidebar .nav-link.active { color: white; background: rgba(255,255,255,.15); }
        .vendor-main { margin-left: 240px; }
        .vendor-topbar { background: white; border-bottom: 1px solid #dee2e6; padding: 12px 24px; }
        .vendor-content { padding: 24px; }
    </style>
</head>
<body>
<div class="d-flex">
<nav class="vendor-sidebar">
    <div class="brand">
        <h5 class="text-white mb-0 fw-bold"><i class="fas fa-store me-2"></i>Vendor Panel</h5>
        <small class="text-white-50">{{ auth()->user()->vendor?->store_name }}</small>
    </div>
    <div class="py-3">
        <a href="{{ route('vendor.dashboard') }}" class="nav-link {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt fa-fw"></i> Dashboard</a>
        <a href="{{ route('vendor.products.index') }}" class="nav-link {{ request()->routeIs('vendor.products.*') ? 'active' : '' }}"><i class="fas fa-box fa-fw"></i> Products</a>
        <a href="{{ route('vendor.orders.index') }}" class="nav-link {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}"><i class="fas fa-shopping-cart fa-fw"></i> Orders</a>
        <a href="{{ route('vendor.earnings') }}" class="nav-link {{ request()->routeIs('vendor.earnings') ? 'active' : '' }}"><i class="fas fa-dollar-sign fa-fw"></i> Earnings</a>
        <a href="{{ route('vendor.analytics') }}" class="nav-link {{ request()->routeIs('vendor.analytics') ? 'active' : '' }}"><i class="fas fa-chart-line fa-fw"></i> Analytics</a>
        <a href="{{ route('vendor.settings') }}" class="nav-link {{ request()->routeIs('vendor.settings') ? 'active' : '' }}"><i class="fas fa-cog fa-fw"></i> Store Settings</a>
        <hr class="border-light mx-3">
        <a href="{{ route('home') }}" class="nav-link" target="_blank"><i class="fas fa-external-link-alt fa-fw"></i> View Store</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link w-100 text-start border-0 bg-transparent"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</button>
        </form>
    </div>
</nav>
<div class="vendor-main w-100">
    <div class="vendor-topbar d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">@yield('page-title')</h6>
        <span class="text-muted small">{{ auth()->user()->name }}</span>
    </div>
    <div class="vendor-content">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        @yield('content')
    </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
