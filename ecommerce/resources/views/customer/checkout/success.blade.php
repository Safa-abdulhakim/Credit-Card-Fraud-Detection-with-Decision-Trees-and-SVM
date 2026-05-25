@extends('layouts.app')
@section('title','Order Placed!')
@section('content')
<div class="container py-5 text-center">
    <div class="display-1 text-success mb-3">✅</div>
    <h2 class="fw-bold mb-2">Order Placed Successfully!</h2>
    <p class="text-muted mb-1">Thank you for your purchase.</p>
    <p class="fs-5 mb-4">Order Number: <strong class="text-primary">{{ $order->order_number }}</strong></p>
    <div class="card border-0 shadow-sm mx-auto p-4 mb-4" style="max-width:450px;">
        <div class="d-flex justify-content-between mb-2"><span>Total Amount</span><strong>${{ number_format($order->total,2) }}</strong></div>
        <div class="d-flex justify-content-between mb-2"><span>Payment Method</span><strong>{{ strtoupper($order->payment_method) }}</strong></div>
        <div class="d-flex justify-content-between"><span>Status</span><span class="badge bg-warning">{{ $order->status_badge['label'] }}</span></div>
    </div>
    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ route('customer.orders.show',$order) }}" class="btn btn-primary px-4">View Order</a>
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary px-4">Continue Shopping</a>
    </div>
</div>
@endsection
