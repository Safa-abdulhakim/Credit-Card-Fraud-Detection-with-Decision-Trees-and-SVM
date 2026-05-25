@extends('layouts.app')
@section('title','Track Order')
@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">Track Order #{{ $order->order_number }}</h3>
    <div class="card border-0 shadow-sm p-4">
        @if($order->shipment)
            <div class="mb-3"><strong>Tracking #:</strong> {{ $order->shipment->tracking_number ?? 'Not assigned yet' }}</div>
            <div class="mb-3"><strong>Carrier:</strong> {{ $order->shipment->shippingMethod?->carrier ?? 'N/A' }}</div>
            <div class="mb-4"><strong>Status:</strong> <span class="badge bg-info fs-6">{{ ucfirst(str_replace('_',' ',$order->shipment->status)) }}</span></div>
        @endif
        <div class="position-relative">
            @php $steps=['pending'=>'Order Placed','paid'=>'Payment Confirmed','processing'=>'Processing','shipped'=>'Shipped','delivered'=>'Delivered']; $statuses=array_keys($steps); $current=array_search($order->status,$statuses); @endphp
            <div class="d-flex justify-content-between mb-2">
                @foreach($steps as $key=>$label)
                @php $idx=array_search($key,$statuses); $done=$idx<=$current; @endphp
                <div class="text-center flex-fill">
                    <div class="rounded-circle mx-auto mb-1 d-flex align-items-center justify-content-center {{ $done?'bg-success text-white':'bg-light border' }}" style="width:40px;height:40px;">
                        <i class="fas fa-{{ ['shopping-cart','credit-card','cog','truck','check-circle'][$idx] }} small"></i>
                    </div>
                    <small class="{{ $done?'text-success fw-bold':'text-muted' }}">{{ $label }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="mt-3"><a href="{{ route('customer.orders.show',$order) }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back to Order</a></div>
</div>
@endsection
