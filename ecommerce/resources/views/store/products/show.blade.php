@extends('layouts.app')
@section('title', $product->name)
@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category?->name }}</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($product->name,40) }}</li>
        </ol>
    </nav>
    <div class="row g-5">
        <div class="col-md-6">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/'.$product->images->first()->image_path) }}" class="img-fluid rounded shadow" alt="{{ $product->name }}" id="mainImg" style="width:100%;max-height:450px;object-fit:contain;">
                @if($product->images->count()>1)
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->image_path) }}" width="70" height="70" class="rounded border cursor-pointer" style="object-fit:cover;cursor:pointer;" onclick="document.getElementById('mainImg').src=this.src">
                    @endforeach
                </div>
                @endif
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px;"><i class="fas fa-image fa-5x text-muted"></i></div>
            @endif
        </div>
        <div class="col-md-6">
            <div class="small text-muted mb-2">{{ $product->brand?->name }} | {{ $product->category?->name }}</div>
            <h2 class="fw-bold mb-2">{{ $product->name }}</h2>
            <div class="mb-3 text-warning">
                @for($i=1;$i<=5;$i++)<i class="fa{{ $i<=round($product->rating_avg)?'s':'r' }} fa-star"></i>@endfor
                <span class="text-muted ms-2 small">{{ $product->rating_avg }}/5 ({{ $product->rating_count }} reviews)</span>
            </div>
            <div class="mb-3">
                @if($product->discount_price)
                    <span class="display-6 fw-bold text-primary">${{ number_format($product->discount_price,2) }}</span>
                    <span class="text-muted text-decoration-line-through ms-2 fs-5">${{ number_format($product->price,2) }}</span>
                    <span class="badge bg-danger ms-2">{{ round((($product->price-$product->discount_price)/$product->price)*100) }}% OFF</span>
                @else
                    <span class="display-6 fw-bold text-primary">${{ number_format($product->price,2) }}</span>
                @endif
            </div>
            <p class="text-muted mb-3">{{ $product->short_description }}</p>
            <div class="mb-3">
                @if($product->isInStock())
                    <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>In Stock ({{ $product->available_quantity }} available)</span>
                @else
                    <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>Out of Stock</span>
                @endif
            </div>
            <div class="d-flex gap-3 mb-4">
                <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->available_quantity }}" class="form-control" style="width:80px;">
                    <button class="btn btn-primary btn-lg px-4" {{ !$product->isInStock()?'disabled':'' }}>
                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                    </button>
                </form>
                @auth
                <form action="{{ route('customer.wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    <button class="btn btn-outline-danger btn-lg"><i class="fas fa-heart"></i></button>
                </form>
                @endauth
            </div>
            <div class="border rounded p-3 small text-muted">
                <div><i class="fas fa-store me-2 text-primary"></i>Sold by: <strong>{{ $product->vendor->store_name }}</strong></div>
                <div class="mt-1"><i class="fas fa-truck me-2 text-success"></i>Free shipping on orders over $100</div>
                <div class="mt-1"><i class="fas fa-undo me-2 text-warning"></i>30-day returns</div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-8">
            <ul class="nav nav-tabs mb-4" id="productTabs">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#desc">Description</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#reviews">Reviews ({{ $product->reviews->count() }})</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="desc">
                    <div class="prose">{{ $product->description ?? 'No description available.' }}</div>
                </div>
                <div class="tab-pane fade" id="reviews">
                    @auth
                    <div class="card border-0 bg-light p-3 mb-4">
                        <h6 class="fw-bold mb-3">Write a Review</h6>
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="mb-2">
                                <label class="form-label small">Rating</label>
                                <select name="rating" class="form-select form-select-sm" style="width:auto;" required>
                                    <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                    <option value="4">⭐⭐⭐⭐ Good</option>
                                    <option value="3">⭐⭐⭐ Average</option>
                                    <option value="2">⭐⭐ Poor</option>
                                    <option value="1">⭐ Terrible</option>
                                </select>
                            </div>
                            <div class="mb-2"><input type="text" name="title" class="form-control form-control-sm" placeholder="Review title"></div>
                            <div class="mb-2"><textarea name="body" class="form-control form-control-sm" rows="3" placeholder="Share your experience..."></textarea></div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit Review</button>
                        </form>
                    </div>
                    @endauth
                    @forelse($product->reviews as $review)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $review->user->name }}</strong>
                            <span class="text-muted small">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="text-warning small mb-1">@for($i=1;$i<=5;$i++)<i class="fa{{ $i<=$review->rating?'s':'r' }} fa-star"></i>@endfor</div>
                        @if($review->title)<strong class="small">{{ $review->title }}</strong>@endif
                        <p class="small text-muted mb-0">{{ $review->body }}</p>
                    </div>
                    @empty
                    <p class="text-muted">No reviews yet. Be the first to review!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @if($related->isNotEmpty())
    <div class="mt-5">
        <h4 class="fw-bold mb-4">Related Products</h4>
        <div class="row g-4">
            @foreach($related as $p)
            <div class="col-sm-6 col-lg-3">@include('components.product-card',['product'=>$p])</div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
