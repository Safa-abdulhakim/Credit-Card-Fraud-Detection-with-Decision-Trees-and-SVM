@extends('layouts.admin')
@section('title', 'تعديل الدفعة')
@section('page-title', 'تعديل الدفعة')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.payments.index') }}">المدفوعات</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-7">
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-money-bill-wave me-2 text-primary"></i>تفاصيل الدفعة</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">الفاتورة <span class="text-danger">*</span></label>
                            <select name="invoice_id" class="form-select @error('invoice_id') is-invalid @enderror" required>
                                <option value="">اختر الفاتورة</option>
                                @foreach($invoices as $inv)
                                    <option value="{{ $inv->id }}" {{ old('invoice_id', $payment->invoice_id) == $inv->id ? 'selected' : '' }}>
                                        {{ $inv->invoice_number }} - {{ $inv->patient->name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('invoice_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">المبلغ ($) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount', $payment->amount) }}" min="0.01" step="0.01" required>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">تاريخ الدفع <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror"
                                value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" required>
                            @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">طريقة الدفع <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">اختر الطريقة</option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>نقداً</option>
                                <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>بطاقة ائتمانية</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                                <option value="insurance" {{ old('payment_method', $payment->payment_method) == 'insurance' ? 'selected' : '' }}>تأمين</option>
                            </select>
                            @error('payment_method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رقم المعاملة</label>
                            <input type="text" name="transaction_id" class="form-control" value="{{ old('transaction_id', $payment->transaction_id) }}" placeholder="اختياري">
                        </div>
                        <div class="col-12">
                            <label class="form-label">الملاحظات</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات اختيارية...">{{ old('notes', $payment->notes) }}</textarea>
                        </div>
                        <div class="col-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث الدفعة</button>
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-secondary">إلغاء</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
