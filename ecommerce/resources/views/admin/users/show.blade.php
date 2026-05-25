@extends('layouts.admin')
@section('title','User Details')
@section('page-title','User Details')
@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="table-card text-center">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=100&background=0d6efd&color=ffffff&rounded=true" class="rounded-circle mb-3" width="100">
            <h5 class="fw-bold">{{ $user->name }}</h5>
            <p class="text-muted">{{ $user->email }}</p>
            <span class="badge bg-{{ $user->is_active?'success':'danger' }} mb-2">{{ $user->is_active?'Active':'Inactive' }}</span><br>
            <span class="badge bg-secondary">{{ $user->role?->display_name }}</span>
            <div class="mt-3 d-grid gap-2">
                <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-primary btn-sm">Edit User</a>
                <form action="{{ route('admin.users.toggle',$user) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="btn btn-{{ $user->is_active?'warning':'success' }} btn-sm w-100">{{ $user->is_active?'Deactivate':'Activate' }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="table-card mb-4">
            <h6 class="fw-bold mb-3">Recent Orders ({{ $user->orders->count() }})</h6>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($user->orders->take(5) as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show',$order) }}">{{ $order->order_number }}</a></td>
                            <td>${{ number_format($order->total,2) }}</td>
                            <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                            <td class="small">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-muted text-center">No orders</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($user->vendor)
        <div class="table-card">
            <h6 class="fw-bold mb-3">Vendor Store</h6>
            <p><strong>Store:</strong> {{ $user->vendor->store_name }}</p>
            <p><strong>Status:</strong> <span class="badge bg-{{ $user->vendor->status==='approved'?'success':'warning' }}">{{ ucfirst($user->vendor->status) }}</span></p>
            <p><strong>Products:</strong> {{ $user->vendor->products->count() }}</p>
            <a href="{{ route('admin.vendors.show',$user->vendor) }}" class="btn btn-sm btn-outline-primary">View Store</a>
        </div>
        @endif
    </div>
</div>
@endsection
