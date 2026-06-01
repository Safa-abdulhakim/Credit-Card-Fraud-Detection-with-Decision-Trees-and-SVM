@extends('layouts.app')
@php $isAr = app()->getLocale() === 'ar'; @endphp
@section('title', $isAr ? 'تم تقديم الطلب!' : 'Order Placed!')
@section('content')
<div class="container py-5 text-center">
    <div class="display-1 text-success mb-3">✅</div>
    <h2 class="fw-bold mb-2">{{ $isAr ? 'تم تقديم الطلب بنجاح!' : 'Order Placed Successfully!' }}</h2>
    <p class="text-muted mb-1">{{ $isAr ? 'شكراً لشرائك.' : 'Thank you for your purchase.' }}</p>
    <p class="fs-5 mb-4">{{ $isAr ? 'رقم الطلب:' : 'Order Number:' }} <strong class="text-primary">{{ $order->order_number }}</strong></p>
    <div class="card border-0 shadow-sm mx-auto p-4 mb-4" style="max-width:450px;">
        <div class="d-flex justify-content-between mb-2"><span>{{ $isAr ? 'المبلغ الإجمالي' : 'Total Amount' }}</span><strong>${{ number_format($order->total,2) }}</strong></div>
        <div class="d-flex justify-content-between mb-2"><span>{{ $isAr ? 'طريقة الدفع' : 'Payment Method' }}</span><strong>{{ strtoupper($order->payment_method) }}</strong></div>
        <div class="d-flex justify-content-between"><span>{{ $isAr ? 'الحالة' : 'Status' }}</span><span class="badge bg-warning">{{ $order->status_badge['label'] }}</span></div>
    </div>
    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ route('customer.orders.show',$order) }}" class="btn btn-primary px-4">{{ $isAr ? 'عرض الطلب' : 'View Order' }}</a>
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary px-4">{{ $isAr ? 'مواصلة التسوق' : 'Continue Shopping' }}</a>
    </div>
</div>
@endsection
