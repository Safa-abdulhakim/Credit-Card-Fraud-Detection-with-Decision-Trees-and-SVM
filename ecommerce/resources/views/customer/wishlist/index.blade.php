@extends('layouts.app')
@section('title','My Wishlist')
@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4"><i class="fas fa-heart text-danger me-2"></i>My Wishlist</h3>
    @if($wishlists->isEmpty())
        <div class="text-center py-5"><i class="fas fa-heart fa-4x text-muted mb-4 d-block"></i><h5>Your wishlist is empty</h5><a href="{{ route('shop') }}" class="btn btn-primary mt-3">Browse Products</a></div>
    @else
        <div class="row g-4">
            @foreach($wishlists as $wishlist)
            <div class="col-sm-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <a href="{{ route('product.show',$wishlist->product->slug) }}">
                        @if($wishlist->product->images->isNotEmpty())
                            <img src="{{ asset('storage/'.$wishlist->product->images->first()->image_path) }}" class="card-img-top" style="height:200px;object-fit:cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;"><i class="fas fa-image fa-3x text-muted"></i></div>
                        @endif
                    </a>
                    <div class="card-body">
                        <h6 class="fw-semibold">{{ Str::limit($wishlist->product->name,40) }}</h6>
                        <div class="fw-bold text-primary mb-2">${{ number_format($wishlist->product->effective_price,2) }}</div>
                        <div class="d-flex gap-2">
                            <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                                <button class="btn btn-primary btn-sm w-100"><i class="fas fa-cart-plus me-1"></i>Add to Cart</button>
                            </form>
                            <form action="{{ route('customer.wishlist.toggle',$wishlist->product) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
