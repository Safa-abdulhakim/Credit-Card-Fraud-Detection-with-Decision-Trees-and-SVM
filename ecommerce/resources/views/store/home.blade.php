@extends('layouts.app')
@section('title', 'Home - Best Online Shop')

@section('content')
{{-- Hero Section --}}
<section class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3">Discover Amazing Products</h1>
        <p class="lead mb-4">Shop from thousands of products from top vendors worldwide.</p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('shop') }}" class="btn btn-light btn-lg px-5">Shop Now <i class="fas fa-arrow-right ms-2"></i></a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">Join Free</a>
            @endguest
        </div>
    </div>
</section>

{{-- Categories --}}
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Shop by Category</h2>
        <div class="row g-3">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('category.show', $category->slug) }}" class="text-decoration-none">
                    <div class="card text-center category-card border-0 shadow-sm h-100 p-3">
                        <div class="display-4 mb-2">
                            @switch($category->name)
                                @case('Electronics') 📱 @break
                                @case('Fashion') 👗 @break
                                @case('Home & Living') 🏠 @break
                                @case('Sports') ⚽ @break
                                @case('Books') 📚 @break
                                @default 🛍️
                            @endswitch
                        </div>
                        <h6 class="fw-semibold text-dark">{{ $category->name }}</h6>
                        <small class="text-muted">{{ $category->products_count }} items</small>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Products --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Featured Products</h2>
            <a href="{{ route('shop') }}" class="btn btn-outline-primary">View All</a>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-sm-6 col-lg-3">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Best Selling --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0"><i class="fas fa-fire text-warning me-2"></i>Best Sellers</h2>
            <a href="{{ route('shop') }}?sort=popular" class="btn btn-outline-warning">View All</a>
        </div>
        <div class="row g-4">
            @foreach($bestSelling as $product)
            <div class="col-sm-6 col-lg-3">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Latest Products --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">New Arrivals</h2>
            <a href="{{ route('shop') }}?sort=newest" class="btn btn-outline-primary">View All</a>
        </div>
        <div class="row g-4">
            @foreach($latestProducts as $product)
            <div class="col-sm-6 col-lg-3">
                @include('components.product-card', ['product' => $product])
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Become Vendor Banner --}}
@guest
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Sell on ShopMart</h2>
        <p class="lead mb-4">Join thousands of vendors and start earning today!</p>
        <a href="{{ route('vendor.register') }}" class="btn btn-light btn-lg px-5">Start Selling</a>
    </div>
</section>
@endguest
@endsection
