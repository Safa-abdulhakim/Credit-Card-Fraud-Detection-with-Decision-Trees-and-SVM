@extends('layouts.admin')
@section('title','Order Details')
@section('page-title','Order #{{ $order->order_number }}')
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3">Items</h6>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light"><tr><th>Product</th><th>Vendor</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><div class="fw-semibold">{{ $item->product_name }}</div></td>
                            <td class="small text-muted">{{ $item->vendor->store_name }}</td>
                            <td>${{ number_format($item->price,2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-bold">${{ number_format($item->total,2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table-card">
            <h6 class="fw-bold mb-3">Update Status</h6>
            <form action="{{ route('admin.orders.status',$order) }}" method="POST" class="d-flex gap-3">
                @csrf @method('PATCH')
                <select name="status" class="form-select" style="width:200px;">
                    @foreach(['pending','paid','processing','shipped','delivered','cancelled','refunded'] as $s)
                    <option value="{{$s}}" {{ $order->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
                <a href="{{ route('admin.orders.invoice',$order) }}" class="btn btn-outline-secondary"><i class="fas fa-download me-1"></i>Invoice</a>
            </form>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3">Summary</h6>
            <div class="d-flex justify-content-between mb-1 small"><span>Subtotal</span><span>${{ number_format($order->subtotal,2) }}</span></div>
            <div class="d-flex justify-content-between mb-1 small text-muted"><span>Tax</span><span>${{ number_format($order->tax_amount,2) }}</span></div>
            <div class="d-flex justify-content-between mb-1 small text-muted"><span>Shipping</span><span>${{ number_format($order->shipping_amount,2) }}</span></div>
            @if($order->discount_amount>0)<div class="d-flex justify-content-between mb-1 small text-success"><span>Discount</span><span>-${{ number_format($order->discount_amount,2) }}</span></div>@endif
            <hr>
            <div class="d-flex justify-content-between fw-bold"><span>Total</span><span>${{ number_format($order->total,2) }}</span></div>
            <hr>
            <small><strong>Customer:</strong> {{ $order->user->name }}</small><br>
            <small><strong>Payment:</strong> {{ strtoupper($order->payment_method) }}</small><br>
            <small><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</small>
        </div>
        @if($order->shippingAddress)
        <div class="table-card">
            <h6 class="fw-bold mb-2">Shipping To</h6>
            <small>{{ $order->shippingAddress->full_name }}<br>{{ $order->shippingAddress->address_line1 }}<br>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->country }}</small>
        </div>
        @endif
    </div>
</div>
@endsection
