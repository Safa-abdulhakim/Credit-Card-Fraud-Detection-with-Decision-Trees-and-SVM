@extends('layouts.vendor')
@section('title','Order Details')
@section('page-title','Order #{{ $order->order_number }}')
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">My Items in This Order</div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @php $myItems = $order->items->where('vendor_id',auth()->user()->vendor->id); @endphp
                        @foreach($myItems as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->product_name }}</div>
                                @if($item->product)
                                <a href="{{ route('vendor.products.edit',$item->product) }}" class="small text-muted">Edit Product</a>
                                @endif
                            </td>
                            <td>${{ number_format($item->price,2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-bold">${{ number_format($item->total,2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">My Revenue:</td>
                            <td class="fw-bold text-success">${{ number_format($myItems->sum('total'),2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Order Info</div>
            <div class="card-body">
                <div class="small mb-1"><strong>Order #:</strong> {{ $order->order_number }}</div>
                <div class="small mb-1"><strong>Customer:</strong> {{ $order->user->name }}</div>
                <div class="small mb-1"><strong>Status:</strong> <span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></div>
                <div class="small mb-1"><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</div>
                <div class="small"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</div>
            </div>
        </div>
        @if($order->shippingAddress)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Ship To</div>
            <div class="card-body small">
                <strong>{{ $order->shippingAddress->full_name }}</strong><br>
                {{ $order->shippingAddress->address_line1 }}<br>
                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->country }}<br>
                <i class="fas fa-phone me-1"></i>{{ $order->shippingAddress->phone }}
            </div>
        </div>
        @endif
    </div>
</div>
<div class="mt-3">
    <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Orders
    </a>
</div>
@endsection
