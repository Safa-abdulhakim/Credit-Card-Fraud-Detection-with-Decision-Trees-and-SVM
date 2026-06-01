@extends('layouts.app')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@section('title', ($isAr ? 'طلب #' : 'Order #').$order->order_number)
@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">{{ $isAr ? 'طلب #' : 'Order #' }}{{ $order->order_number }}</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('customer.orders.invoice',$order) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-download me-1"></i>{{ $isAr ? 'فاتورة' : 'Invoice' }}</a>
            <a href="{{ route('customer.orders.track',$order) }}" class="btn btn-outline-info btn-sm"><i class="fas fa-map-marker-alt me-1"></i>{{ $isAr ? 'تتبع' : 'Track' }}</a>
            @if($order->canBeCancelled())
            <form action="{{ route('customer.orders.cancel',$order) }}" method="POST" onsubmit="return confirm('{{ $isAr ? 'هل تريد إلغاء هذا الطلب؟' : 'Cancel this order?' }}')">
                @csrf
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-times me-1"></i>{{ $isAr ? 'إلغاء' : 'Cancel' }}</button>
            </form>
            @endif
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">{{ $isAr ? 'المنتجات المطلوبة' : 'Items Ordered' }}</div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light"><tr>
                            <th>{{ $isAr ? 'المنتج' : 'Product' }}</th>
                            <th>{{ $isAr ? 'السعر' : 'Price' }}</th>
                            <th>{{ $isAr ? 'الكمية' : 'Qty' }}</th>
                            <th>{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                        </tr></thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item->product_name }}</div>
                                    <small class="text-muted">{{ $item->vendor->store_name }}</small>
                                </td>
                                <td>${{ number_format($item->price,2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="fw-bold">${{ number_format($item->total,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white fw-bold">{{ $isAr ? 'ملخص الطلب' : 'Order Summary' }}</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-1 small"><span>{{ $isAr ? 'المجموع الفرعي' : 'Subtotal' }}</span><span>${{ number_format($order->subtotal,2) }}</span></div>
                    <div class="d-flex justify-content-between mb-1 small text-muted"><span>{{ $isAr ? 'الضريبة' : 'Tax' }}</span><span>${{ number_format($order->tax_amount,2) }}</span></div>
                    <div class="d-flex justify-content-between mb-1 small text-muted"><span>{{ $isAr ? 'الشحن' : 'Shipping' }}</span><span>${{ number_format($order->shipping_amount,2) }}</span></div>
                    @if($order->discount_amount>0)<div class="d-flex justify-content-between mb-1 small text-success"><span>{{ $isAr ? 'الخصم' : 'Discount' }}</span><span>-${{ number_format($order->discount_amount,2) }}</span></div>@endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold"><span>{{ $isAr ? 'الإجمالي' : 'Total' }}</span><span class="text-primary">${{ number_format($order->total,2) }}</span></div>
                    <hr>
                    <div class="small"><strong>{{ $isAr ? 'الحالة:' : 'Status:' }}</strong> <span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></div>
                    <div class="small mt-1"><strong>{{ $isAr ? 'الدفع:' : 'Payment:' }}</strong> {{ strtoupper($order->payment_method) }}</div>
                    <div class="small mt-1"><strong>{{ $isAr ? 'التاريخ:' : 'Placed:' }}</strong> {{ $order->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
            @if($order->shippingAddress)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">{{ $isAr ? 'عنوان الشحن' : 'Shipping Address' }}</div>
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
</div>
@endsection
