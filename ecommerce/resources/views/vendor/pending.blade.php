@extends('layouts.app')
@section('title','Application Pending')
@section('content')
<div class="container py-5 text-center" style="max-width:500px;margin:auto;">
    <div class="display-1 mb-4">⏳</div>
    <h2 class="fw-bold mb-3">Application Under Review</h2>
    <p class="text-muted mb-4">Thank you for applying to become a vendor! Our team is reviewing your application. You'll receive an email notification once approved.</p>
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h6 class="fw-bold mb-3">Your Store: {{ auth()->user()->vendor->store_name }}</h6>
        <div class="badge bg-warning fs-6 py-2 px-3">⏳ Pending Approval</div>
        <p class="text-muted small mt-3 mb-0">Applied on {{ auth()->user()->vendor->created_at->format('M d, Y') }}</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-outline-primary me-2"><i class="fas fa-home me-2"></i>Back to Home</a>
    <p class="text-muted small mt-4">Questions? Contact us at <a href="mailto:vendors@shop.com">vendors@shop.com</a></p>
</div>
@endsection
