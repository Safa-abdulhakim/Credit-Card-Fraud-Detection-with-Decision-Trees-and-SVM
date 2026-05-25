@extends('layouts.app')
@section('title','My Orders')
@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">My Orders</h3>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light"><tr><th>Order #</th><th>Date</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><a href="{{ route('customer.orders.show',$order) }}" class="fw-bold text-decoration-none">{{ $order->order_number }}</a></td>
                        <td class="small">{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->count() }}</td>
                        <td class="fw-bold">${{ number_format($order->total,2) }}</td>
                        <td><span class="badge bg-{{ $order->payment_status==='paid'?'success':'warning' }}">{{ ucfirst($order->payment_status) }}</span></td>
                        <td><span class="badge bg-{{ $order->status_badge['class'] }}">{{ $order->status_badge['label'] }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('customer.orders.show',$order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('customer.orders.invoice',$order) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                                @if($order->canBeCancelled())
                                <form action="{{ route('customer.orders.cancel',$order) }}" method="POST" onsubmit="return confirm('Cancel this order?')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-5"><i class="fas fa-box-open fa-3x d-block mb-3"></i>No orders found. <a href="{{ route('shop') }}">Start shopping!</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())<div class="card-footer bg-white d-flex justify-content-end">{{ $orders->links() }}</div>@endif
    </div>
</div>
@endsection
