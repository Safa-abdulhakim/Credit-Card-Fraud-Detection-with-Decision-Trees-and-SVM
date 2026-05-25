@extends('layouts.app')
@section('title','Checkout')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4"><i class="fas fa-lock me-2 text-success"></i>Secure Checkout</h2>
    <form action="{{ route('customer.checkout.place') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-map-marker-alt me-2 text-primary"></i>Delivery Address</span>
                        <a href="{{ route('customer.addresses.create') }}" class="btn btn-sm btn-outline-primary">+ Add</a>
                    </div>
                    <div class="card-body">
                        @forelse($addresses as $address)
                        <div class="form-check mb-3 p-3 border rounded {{ $address->is_default?'border-primary bg-primary bg-opacity-5':'' }}">
                            <input class="form-check-input" type="radio" name="address_id" value="{{ $address->id }}" id="addr{{$address->id}}" {{ $address->is_default?'checked':'' }} required>
                            <label class="form-check-label ms-2" for="addr{{$address->id}}">
                                <strong>{{ $address->full_name }}</strong> @if($address->is_default)<span class="badge bg-primary ms-1">Default</span>@endif<br>
                                <span class="text-muted small">{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->country }}</span>
                            </label>
                        </div>
                        @empty
                        <p class="text-muted">No addresses found. <a href="{{ route('customer.addresses.create') }}">Add one</a>.</p>
                        @endforelse
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold"><i class="fas fa-truck me-2 text-success"></i>Shipping Method</div>
                    <div class="card-body">
                        @foreach($shippingMethods as $method)
                        <div class="form-check mb-2 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="shipping_method_id" value="{{ $method->id }}" id="ship{{$method->id}}" {{ $loop->first?'checked':'' }}>
                            <label class="form-check-label ms-2 d-flex justify-content-between w-100" for="ship{{$method->id}}">
                                <span><strong>{{ $method->name }}</strong> <small class="text-muted ms-2">{{ $method->estimated_days }} days</small></span>
                                <strong>{{ $method->base_cost>0?'$'.number_format($method->base_cost,2):'FREE' }}</strong>
                            </label>
                        </div>
                        @endforeach
                        <input type="hidden" name="shipping_cost" value="{{ $shippingMethods->first()?->base_cost ?? 0 }}">
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold"><i class="fas fa-credit-card me-2 text-warning"></i>Payment</div>
                    <div class="card-body">
                        <div class="form-check mb-2 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" id="cod" checked required>
                            <label class="form-check-label ms-2" for="cod"><i class="fas fa-money-bill-wave me-2 text-success"></i><strong>Cash on Delivery</strong></label>
                        </div>
                        <div class="form-check mb-2 p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="stripe" id="stripe">
                            <label class="form-check-label ms-2" for="stripe"><i class="fab fa-stripe me-2 text-primary"></i><strong>Credit/Debit Card</strong></label>
                        </div>
                        <div class="form-check p-3 border rounded">
                            <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal">
                            <label class="form-check-label ms-2" for="paypal"><i class="fab fa-paypal me-2 text-info"></i><strong>PayPal</strong></label>
                        </div>
                    </div>
                </div>
                <textarea name="notes" class="form-control" rows="2" placeholder="Order notes (optional)"></textarea>
                <input type="hidden" name="coupon_code" value="{{ session('coupon.code') }}">
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top:80px;">
                    <div class="card-header bg-white fw-bold">Order Summary</div>
                    <div class="card-body">
                        @foreach($cart->items as $item)
                        <div class="d-flex justify-content-between mb-1 small">
                            <span>{{ Str::limit($item->product->name,25) }} ×{{ $item->quantity }}</span>
                            <span>${{ number_format($item->subtotal,2) }}</span>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between mb-1 small"><span>Subtotal</span><span>${{ number_format($cart->total,2) }}</span></div>
                        <div class="d-flex justify-content-between mb-1 small text-muted"><span>Tax (15%)</span><span>${{ number_format($cart->total*0.15,2) }}</span></div>
                        @if(session('coupon'))<div class="d-flex justify-content-between mb-1 small text-success"><span>Discount</span><span>-${{ number_format(session('coupon.discount'),2) }}</span></div>@endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-3"><span>Total</span><span class="text-primary">${{ number_format($cart->total*1.15+9.99,2) }}</span></div>
                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold"><i class="fas fa-lock me-2"></i>Place Order</button>
                        <small class="text-muted d-block text-center mt-2"><i class="fas fa-shield-alt me-1"></i>SSL Secured</small>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
