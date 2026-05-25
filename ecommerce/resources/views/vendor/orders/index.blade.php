@extends('layouts.vendor')
@section('title','Orders')
@section('page-title','My Orders')
@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['pending','paid','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4"><input type="text" name="search" class="form-control" placeholder="Search order #..." value="{{ request('search') }}"></div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Order #</th><th>Customer</th><th>Items</th><th>My Revenue</th><th>Status</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><a href="{{ route('vendor.orders.show',$order) }}" class="fw-bold text-decoration-none">{{ $order->order_number }}</a></td>
                    <td>{{ $order->user->name }}</td>
                    <td>
                        @php $myItems = $order->items->where('vendor_id',auth()->user()->vendor->id); @endphp
                        {{ $myItems->count() }} items
                    </td>
                    <td class="fw-bold">${{ number_format($myItems->sum('total'),2) }}</td>
                    <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                    <td class="small text-muted">{{ $order->created_at->format('M d, Y') }}</td>
                    <td><a href="{{ route('vendor.orders.show',$order) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-box-open fa-3x d-block mb-3"></i>No orders yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white d-flex justify-content-end">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
