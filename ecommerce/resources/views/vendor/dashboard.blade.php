@extends('layouts.vendor')
@section('title','Vendor Dashboard')
@section('page-title','Dashboard')
@section('content')
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-success text-white">
            <div class="h3 mb-0">{{ $stats['total_products'] }}</div>
            <small>Products</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-primary text-white">
            <div class="h3 mb-0">{{ $stats['total_orders'] }}</div>
            <small>Orders</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-warning text-dark">
            <div class="h3 mb-0">{{ $stats['pending_orders'] }}</div>
            <small>Pending</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3 bg-info text-white">
            <div class="h3 mb-0">${{ number_format($stats['total_earnings'],2) }}</div>
            <small>Earnings</small>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                Recent Orders
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-sm btn-outline-success">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light"><tr><th>Order #</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><a href="{{ route('vendor.orders.show',$order) }}" class="fw-semibold text-decoration-none">{{ $order->order_number }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td class="fw-bold">${{ number_format($order->items->where('vendor_id',auth()->user()->vendor->id)->sum('total'),2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                            <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No orders yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Low Stock Alert</div>
            <div class="card-body">
                @forelse($lowStockProducts as $product)
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="small fw-semibold">{{ Str::limit($product->name,30) }}</span>
                    <span class="badge bg-danger">{{ $product->available_quantity }} left</span>
                </div>
                @empty
                <p class="text-muted small text-center py-2">All products are well stocked!</p>
                @endforelse
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Quick Actions</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('vendor.products.create') }}" class="btn btn-success"><i class="fas fa-plus me-2"></i>Add Product</a>
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-primary"><i class="fas fa-box me-2"></i>View Orders</a>
                <a href="{{ route('vendor.earnings.index') }}" class="btn btn-outline-info"><i class="fas fa-dollar-sign me-2"></i>View Earnings</a>
            </div>
        </div>
    </div>
</div>
@endsection
