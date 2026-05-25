@extends('layouts.app')
@section('title','Shipment Details')
@section('content')
<div class="container py-5" style="max-width:700px;">
    <h2 class="fw-bold mb-4">Shipment Details</h2>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Order Information</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="small mb-1"><strong>Order #:</strong> {{ $shipment->order->order_number }}</div>
                    <div class="small mb-1"><strong>Customer:</strong> {{ $shipment->order->user->name }}</div>
                    <div class="small mb-1"><strong>Phone:</strong> {{ $shipment->order->user->phone ?? 'N/A' }}</div>
                    <div class="small"><strong>Order Date:</strong> {{ $shipment->order->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small mb-1"><strong>Tracking #:</strong> <span class="font-monospace">{{ $shipment->tracking_number ?? 'Not assigned' }}</span></div>
                    <div class="small mb-1">
                        <strong>Status:</strong>
                        @php $colors = ['pending'=>'warning','picked_up'=>'info','in_transit'=>'primary','delivered'=>'success','failed'=>'danger']; @endphp
                        <span class="badge bg-{{ $colors[$shipment->status] ?? 'secondary' }}">
                            {{ ucfirst(str_replace('_',' ',$shipment->status)) }}
                        </span>
                    </div>
                    <div class="small"><strong>Method:</strong> {{ $shipment->shippingMethod?->name ?? 'Standard' }}</div>
                </div>
            </div>
        </div>
    </div>
    @if($shipment->order->shippingAddress)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">📍 Delivery Address</div>
        <div class="card-body">
            <strong>{{ $shipment->order->shippingAddress->full_name }}</strong><br>
            {{ $shipment->order->shippingAddress->address_line1 }}<br>
            @if($shipment->order->shippingAddress->address_line2)
            {{ $shipment->order->shippingAddress->address_line2 }}<br>
            @endif
            {{ $shipment->order->shippingAddress->city }}, {{ $shipment->order->shippingAddress->state }} {{ $shipment->order->shippingAddress->postal_code }}<br>
            {{ $shipment->order->shippingAddress->country }}<br>
            <i class="fas fa-phone me-1 text-muted"></i><strong>{{ $shipment->order->shippingAddress->phone }}</strong>
        </div>
    </div>
    @endif
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Items</div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light"><tr><th>Product</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($shipment->order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->total,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if(!in_array($shipment->status,['delivered','failed']))
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Update Status</div>
        <div class="card-body">
            <form action="{{ route('delivery.shipments.update',$shipment) }}" method="POST" class="d-flex gap-3 flex-wrap">
                @csrf @method('PATCH')
                @if($shipment->status==='pending')
                <button name="status" value="picked_up" class="btn btn-success">
                    <i class="fas fa-box me-2"></i>Mark as Picked Up
                </button>
                @elseif($shipment->status==='picked_up')
                <button name="status" value="in_transit" class="btn btn-info text-white">
                    <i class="fas fa-truck me-2"></i>Mark In Transit
                </button>
                @elseif($shipment->status==='in_transit')
                <button name="status" value="delivered" class="btn btn-success" onclick="return confirm('Confirm delivery?')">
                    <i class="fas fa-check-circle me-2"></i>Mark Delivered
                </button>
                <button name="status" value="failed" class="btn btn-danger" onclick="return confirm('Mark as failed delivery?')">
                    <i class="fas fa-times me-2"></i>Failed Delivery
                </button>
                @endif
            </form>
        </div>
    </div>
    @endif
    <a href="{{ route('delivery.shipments.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Shipments
    </a>
</div>
@endsection
