@extends('layouts.admin')
@section('title', 'Payment Details')
@section('page-title', 'Payment Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">Payments</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Payment Receipt</h6>
                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit me-1"></i>Edit</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded">
                            <p class="text-muted small mb-1">Invoice Number</p>
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="fw-bold text-primary">
                                {{ $payment->invoice->invoice_number ?? 'N/A' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-success bg-opacity-10 rounded">
                            <p class="text-muted small mb-1">Amount Paid</p>
                            <h4 class="fw-bold text-success mb-0">${{ number_format($payment->amount, 2) }}</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Patient</p>
                        <p class="fw-semibold mb-0">{{ $payment->invoice->patient->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Payment Date</p>
                        <p class="fw-semibold mb-0">{{ $payment->payment_date->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Payment Method</p>
                        <span class="badge bg-primary fs-6">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">Transaction ID</p>
                        <p class="fw-semibold mb-0">{{ $payment->transaction_id ?? '-' }}</p>
                    </div>
                    @if($payment->notes)
                    <div class="col-12">
                        <p class="text-muted small mb-1">Notes</p>
                        <p class="mb-0">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
                <hr>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Back to Payments</a>
                    <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="btn btn-outline-primary">View Invoice</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
