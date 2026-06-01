@extends('layouts.app')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@section('title', $isAr ? 'طلباتي' : 'My Orders')
@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4">{{ $isAr ? 'طلباتي' : 'My Orders' }}</h3>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light"><tr>
                    <th>{{ $isAr ? 'رقم الطلب' : 'Order #' }}</th>
                    <th>{{ $isAr ? 'التاريخ' : 'Date' }}</th>
                    <th>{{ $isAr ? 'المنتجات' : 'Items' }}</th>
                    <th>{{ $isAr ? 'الإجمالي' : 'Total' }}</th>
                    <th>{{ $isAr ? 'الدفع' : 'Payment' }}</th>
                    <th>{{ $isAr ? 'الحالة' : 'Status' }}</th>
                    <th>{{ $isAr ? 'الإجراءات' : 'Actions' }}</th>
                </tr></thead>
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
                                <a href="{{ route('customer.orders.show',$order) }}" class="btn btn-sm btn-outline-primary">{{ $isAr ? 'عرض' : 'View' }}</a>
                                <a href="{{ route('customer.orders.invoice',$order) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                                @if($order->canBeCancelled())
                                <form action="{{ route('customer.orders.cancel',$order) }}" method="POST" onsubmit="return confirm('{{ $isAr ? 'هل تريد إلغاء هذا الطلب؟' : 'Cancel this order?' }}')">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-5"><i class="fas fa-box-open fa-3x d-block mb-3"></i>{{ $isAr ? 'لا توجد طلبات.' : 'No orders found.' }} <a href="{{ route('shop') }}">{{ $isAr ? 'ابدأ التسوق!' : 'Start shopping!' }}</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())<div class="card-footer bg-white d-flex justify-content-end">{{ $orders->links() }}</div>@endif
    </div>
</div>
@endsection
