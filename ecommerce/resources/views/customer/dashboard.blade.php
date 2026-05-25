@extends('layouts.app')
@section('title','My Dashboard')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm mb-3 text-center p-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=80&background=0d6efd&color=ffffff&rounded=true" class="rounded-circle mx-auto mb-3" width="80">
                <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>
            <div class="list-group shadow-sm">
                <a href="{{ route('customer.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.dashboard')?'active':'' }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="{{ route('customer.orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('customer.orders.*')?'active':'' }}"><i class="fas fa-box me-2"></i>My Orders</a>
                <a href="{{ route('customer.wishlist.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-heart me-2"></i>Wishlist</a>
                <a href="{{ route('customer.addresses.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-map-marker-alt me-2"></i>Addresses</a>
                <a href="{{ route('customer.profile.edit') }}" class="list-group-item list-group-item-action"><i class="fas fa-user me-2"></i>Profile</a>
                <a href="{{ route('customer.notifications.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-bell me-2"></i>Notifications</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3"><div class="card border-0 shadow-sm text-center p-3 bg-primary text-white"><div class="h3 mb-0">{{ $stats['total_orders'] }}</div><small>Orders</small></div></div>
                <div class="col-6 col-md-3"><div class="card border-0 shadow-sm text-center p-3 bg-warning text-dark"><div class="h3 mb-0">{{ $stats['pending_orders'] }}</div><small>Pending</small></div></div>
                <div class="col-6 col-md-3"><div class="card border-0 shadow-sm text-center p-3 bg-success text-white"><div class="h3 mb-0">{{ $stats['delivered_orders'] }}</div><small>Delivered</small></div></div>
                <div class="col-6 col-md-3"><div class="card border-0 shadow-sm text-center p-3 bg-danger text-white"><div class="h3 mb-0">{{ $stats['wishlist_count'] }}</div><small>Wishlist</small></div></div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                    Recent Orders
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light"><tr><th>Order #</th><th>Items</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td><a href="{{ route('customer.orders.show',$order) }}" class="fw-semibold text-decoration-none">{{ $order->order_number }}</a></td>
                                <td>{{ $order->items->count() }} items</td>
                                <td>${{ number_format($order->total,2) }}</td>
                                <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                                <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                                <td><a href="{{ route('customer.orders.show',$order) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No orders yet. <a href="{{ route('shop') }}">Shop now!</a></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
