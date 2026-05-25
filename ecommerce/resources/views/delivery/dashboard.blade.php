@extends('layouts.app')
@section('title','Delivery Dashboard')
@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold mb-0">🚚 Delivery Dashboard</h2>
            <p class="text-muted mb-0">Welcome, {{ auth()->user()->name }}</p>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 bg-warning text-dark">
                <div class="h3 mb-0">{{ $stats['pending'] ?? 0 }}</div>
                <small>Pending Pickups</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 bg-info text-white">
                <div class="h3 mb-0">{{ $stats['in_transit'] ?? 0 }}</div>
                <small>In Transit</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 bg-success text-white">
                <div class="h3 mb-0">{{ $stats['delivered_today'] ?? 0 }}</div>
                <small>Delivered Today</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-4 bg-primary text-white">
                <div class="h3 mb-0">{{ $stats['total_delivered'] ?? 0 }}</div>
                <small>Total Delivered</small>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
            Assigned Shipments
            <a href="{{ route('delivery.shipments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Order #</th><th>Customer</th><th>Address</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($shipments ?? [] as $shipment)
                    <tr>
                        <td class="fw-bold">{{ $shipment->order->order_number }}</td>
                        <td>{{ $shipment->order->user->name }}</td>
                        <td class="small text-muted">
                            @if($shipment->order->shippingAddress)
                            {{ $shipment->order->shippingAddress->city }}, {{ $shipment->order->shippingAddress->country }}
                            @endif
                        </td>
                        <td>
                            @php
                            $colors = ['pending'=>'warning','picked_up'=>'info','in_transit'=>'primary','delivered'=>'success','failed'=>'danger'];
                            @endphp
                            <span class="badge bg-{{ $colors[$shipment->status] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_',' ',$shipment->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('delivery.shipments.show',$shipment) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i>Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No shipments assigned yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
