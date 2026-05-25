@extends('layouts.admin')
@section('title','Orders')
@section('page-title','Order Management')
@section('content')
<div class="table-card">
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Order number..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach(['pending','paid','processing','shipped','delivered','cancelled','refunded'] as $s)
                <option value="{{$s}}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto"><button type="submit" class="btn btn-primary">Filter</button><a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary ms-2">Reset</a></div>
    </form>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light"><tr><th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('admin.orders.show',$order) }}" class="fw-bold text-decoration-none">{{ $order->order_number }}</a></td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->items->count() }}</td>
                    <td class="fw-bold">${{ number_format($order->total,2) }}</td>
                    <td><span class="badge bg-{{ $order->payment_status==='paid'?'success':'warning' }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                    <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.orders.show',$order) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.orders.invoice',$order) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-file-pdf"></i></a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">{{ $orders->links() }}</div>
</div>
@endsection
