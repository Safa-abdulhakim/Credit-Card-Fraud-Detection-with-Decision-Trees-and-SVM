@extends('layouts.app')
@section('title','Shopping Cart')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-shopping-cart me-2"></i>Shopping Cart</h2>
    @if($cart->items->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-cart-shopping fa-4x text-muted mb-4 d-block"></i>
            <h4>Your cart is empty</h4>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-3 px-5">Start Shopping</a>
        </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                @foreach($cart->items as $item)
                <div class="d-flex align-items-center p-3 border-bottom">
                    <div class="me-3" style="width:80px;flex-shrink:0;">
                        @if($item->product->images->isNotEmpty())
                            <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}" class="img-fluid rounded" style="height:80px;object-fit:cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:80px;height:80px;"><i class="fas fa-image text-muted"></i></div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-0">{{ $item->product->name }}</h6>
                        <small class="text-muted">{{ $item->product->vendor->store_name }}</small>
                    </div>
                    <div class="mx-3">
                        <form action="{{ route('cart.update',$item) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="{{ $item->product->available_quantity }}" class="form-control form-control-sm text-center" style="width:65px;" onchange="this.form.submit()">
                        </form>
                    </div>
                    <div class="text-end me-3">
                        <span class="fw-bold text-primary">${{ number_format($item->subtotal,2) }}</span>
                        <div class="small text-muted">${{ number_format($item->price,2) }} each</div>
                    </div>
                    <form action="{{ route('cart.remove',$item) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                <div class="card-body">
                    <h5 class="fw-bold border-bottom pb-3">Summary</h5>
                    <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span>${{ number_format($cart->total,2) }}</span></div>
                    <div class="d-flex justify-content-between mb-2 text-muted small"><span>Tax (15%)</span><span>${{ number_format($cart->total*0.15,2) }}</span></div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold mb-3"><span>Est. Total</span><span class="text-primary">${{ number_format($cart->total*1.15+5.99,2) }}</span></div>
                    <form action="{{ route('cart.coupon.apply') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input type="text" name="coupon_code" class="form-control" placeholder="Coupon code">
                            <button class="btn btn-outline-success">Apply</button>
                        </div>
                    </form>
                    @auth
                        <a href="{{ route('customer.checkout.index') }}" class="btn btn-primary w-100 py-2 fw-bold"><i class="fas fa-lock me-2"></i>Checkout</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 py-2"><i class="fas fa-sign-in-alt me-2"></i>Login to Checkout</a>
                    @endauth
                    <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2"><i class="fas fa-arrow-left me-2"></i>Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
