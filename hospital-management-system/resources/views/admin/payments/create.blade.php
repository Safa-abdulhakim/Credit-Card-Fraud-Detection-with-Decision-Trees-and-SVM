@extends('layouts.admin')
@section('title', 'تسجيل دفعة')
@section('page-title', 'تسجيل دفعة')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
    @if(isset($invoice))<li class="breadcrumb-item"><a href="{{ route('admin.invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></li>@endif
    <li class="breadcrumb-item active">تسجيل دفعة</li>
@endsection
@section('content')
<div class="row g-3">
    @if(isset($invoice))
    <div class="col-12 col-lg-4">
        <div class="card"><div class="card-header"><h6 class="mb-0 fw-semibold">تفاصيل الفاتورة</h6></div><div class="card-body">
            <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">رقم الفاتورة:</span><strong>{{ $invoice->invoice_number }}</strong></div>
            <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">المريض:</span><span>{{ $invoice->patient->name ?? 'N/A' }}</span></div>
            <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">إجمالي الفاتورة:</span><strong class="text-primary">${{ number_format($invoice->total_amount, 2) }}</strong></div>
            <div class="mb-2 d-flex justify-content-between"><span class="text-muted small">المدفوع:</span><span class="text-success">${{ number_format($invoice->payments->sum('amount'), 2) }}</span></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold"><span>المتبقي:</span><span class="text-danger">${{ number_format($invoice->total_amount - $invoice->payments->sum('amount'), 2) }}</span></div>
        </div></div>
    </div>
    @endif
    <div class="col-12 col-lg-{{ isset($invoice) ? '8' : '6' }}">
        <div class="card"><div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-dollar-sign me-2 text-success"></i>تفاصيل الدفعة</h6></div><div class="card-body">
        <form action="{{ route('admin.payments.store') }}" method="POST">@csrf
        <div class="row g-3">
            @if(!isset($invoice))
            <div class="col-12"><label class="form-label fw-semibold">الفاتورة <span class="text-danger">*</span></label><select name="invoice_id" class="form-select @error('invoice_id') is-invalid @enderror" required><option value="">اختر الفاتورة</option>@foreach($invoices as $inv)<option value="{{ $inv->id }}" {{ old('invoice_id', request('invoice_id')) == $inv->id ? 'selected' : '' }}>{{ $inv->invoice_number }} - {{ $inv->patient->name ?? 'N/A' }} (${{ number_format($inv->total_amount, 2) }})</option>@endforeach</select>@error('invoice_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            @else
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
            @endif
            <div class="col-md-6"><label class="form-label fw-semibold">المبلغ <span class="text-danger">*</span></label><div class="input-group"><span class="input-group-text">$</span><input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', isset($invoice) ? ($invoice->total_amount - $invoice->payments->sum('amount')) : '') }}" min="0.01" required></div>@error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label fw-semibold">تاريخ الدفع <span class="text-danger">*</span></label><input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', date('Y-m-d')) }}" required>@error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label fw-semibold">طريقة الدفع <span class="text-danger">*</span></label><select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required><option value="">اختر...</option><option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدًا</option><option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>بطاقة</option><option value="insurance" {{ old('payment_method') == 'insurance' ? 'selected' : '' }}>تأمين</option><option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option></select>@error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label fw-semibold">رقم المعاملة</label><input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id') }}" placeholder="اختياري"></div>
            <div class="col-12"><label class="form-label fw-semibold">ملاحظات</label><textarea name="notes" class="form-control" rows="3" placeholder="ملاحظات اختيارية...">{{ old('notes') }}</textarea></div>
            <div class="col-12 d-flex gap-2"><button type="submit" class="btn btn-success"><i class="fas fa-dollar-sign me-2"></i>تسجيل الدفعة</button>@if(isset($invoice))<a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-secondary">إلغاء</a>@else<a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">إلغاء</a>@endif</div>
        </div></form></div></div>
    </div>
</div>
@endsection
