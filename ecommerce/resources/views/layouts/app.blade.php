<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'ShopMart')) | {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Your one-stop shop for everything')">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root { --primary: #0d6efd; --secondary: #6c757d; }
        body { font-family: 'Segoe UI', sans-serif; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .product-card { transition: transform .2s, box-shadow .2s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,.15); }
        .btn-cart { background: var(--primary); color: white; border: none; padding: 8px 20px; border-radius: 25px; }
        .hero-section { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0; }
        .category-card { border-radius: 15px; overflow: hidden; }
        .badge-sale { background: #dc3545; color: white; position: absolute; top: 10px; left: 10px; padding: 3px 10px; border-radius: 20px; font-size: .75rem; }
        .star { color: #ffc107; }
        .footer { background: #2d3436; color: #b2bec3; }
        .footer a { color: #b2bec3; text-decoration: none; }
        .footer a:hover { color: white; }
        .cart-badge { background: #dc3545; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; position: absolute; top: -8px; right: -8px; color: white; }
        .sidebar-filter .form-check-label { cursor: pointer; }
    </style>
    @stack('styles')
</head>
<body>
{{-- Topbar --}}
<div class="bg-dark text-white py-1 small">
    <div class="container d-flex justify-content-between">
        <span><i class="fas fa-phone me-1"></i> +1 (800) 555-0100</span>
        <div>
            @guest
                <a href="{{ route('login') }}" class="text-white me-2">Sign In</a>
                <a href="{{ route('register') }}" class="text-white">Register</a>
            @else
                <span class="me-2">Hello, {{ auth()->user()->name }}</span>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="text-warning me-2">Admin Panel</a>
                @elseif(auth()->user()->isVendor())
                    <a href="{{ route('vendor.dashboard') }}" class="text-warning me-2">Vendor Dashboard</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-link text-white p-0" style="font-size: inherit;">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</div>

{{-- Main Navbar --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand text-primary" href="{{ route('home') }}">
            <i class="fas fa-shopping-bag me-2"></i>ShopMart
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search --}}
            <form class="d-flex mx-auto" style="width:40%;" action="{{ route('search') }}">
                <div class="input-group">
                    <input class="form-control" type="search" name="q" placeholder="Search products..." value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('shop') }}">Shop</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
                    <ul class="dropdown-menu">
                        @foreach(\App\Models\Category::whereNull('parent_id')->where('is_active', true)->get() as $cat)
                            <li><a class="dropdown-item" href="{{ route('category.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span class="cart-badge">0</span>
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.wishlist.index') }}"><i class="fas fa-heart fa-lg text-danger"></i></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=30&background=0d6efd&color=ffffff&rounded=true" class="rounded-circle" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}"><i class="fas fa-box me-2"></i>My Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert">
        <div class="container">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="footer pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-white fw-bold"><i class="fas fa-shopping-bag me-2"></i>ShopMart</h5>
                <p>Your premier destination for quality products at unbeatable prices. Shop with confidence.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="text-white fw-bold">Shop</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('shop') }}">All Products</a></li>
                    <li><a href="{{ route('vendors.index') }}">Vendors</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="text-white fw-bold">Account</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h6 class="text-white fw-bold">Contact</h6>
                <p><i class="fas fa-envelope me-2"></i>support@shopmart.com</p>
                <p><i class="fas fa-phone me-2"></i>+1 (800) 555-0100</p>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center small">
            <p class="mb-0">&copy; {{ date('Y') }} ShopMart. All rights reserved. Built with Laravel 11.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
