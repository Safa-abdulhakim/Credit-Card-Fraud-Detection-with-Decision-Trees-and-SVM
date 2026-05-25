@extends('layouts.app')
@section('title','My Shipments')
@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">My Shipments</h2>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        @foreach(['pending','picked_up','in_transit','delivered','failed'] as $s)
                        <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('delivery.shipments.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                </div>
            </form>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Order #</th><th>Tracking #</th><th>Customer</th><th>Address</th><th>Status</th><th>Date</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                    @php
                    $colors = ['pending'=>'warning','picked_up'=>'info','in_transit'=>'primary','delivered'=>'success','failed'=>'danger'];
                    @endphp
                    <tr>
                        <td class="fw-bold">{{ $shipment->order->order_number }}</td>
                        <td class="font-monospace small">{{ $shipment->tracking_number ?? '—' }}</td>
                        <td>{{ $shipment->order->user->name }}</td>
                        <td class="small text-muted">
                            @if($shipment->order->shippingAddress)
                            {{ $shipment->order->shippingAddress->address_line1 }}, {{ $shipment->order->shippingAddress->city }}
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $colors[$shipment->status] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_',' ',$shipment->status)) }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $shipment->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('delivery.shipments.show',$shipment) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(!in_array($shipment->status,['delivered','failed']))
                            <form action="{{ route('delivery.shipments.update',$shipment) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                @if($shipment->status==='pending')
                                <button name="status" value="picked_up" class="btn btn-sm btn-success">Pick Up</button>
                                @elseif($shipment->status==='picked_up')
                                <button name="status" value="in_transit" class="btn btn-sm btn-info text-white">In Transit</button>
                                @elseif($shipment->status==='in_transit')
                                <button name="status" value="delivered" class="btn btn-sm btn-success" onclick="return confirm('Mark as delivered?')">Delivered ✓</button>
                                @endif
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-truck fa-3x d-block mb-3 text-muted"></i>
                            No shipments assigned to you yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($shipments->hasPages())
        <div class="card-footer bg-white d-flex justify-content-end">{{ $shipments->links() }}</div>
        @endif
    </div>
</div>
@endsection
