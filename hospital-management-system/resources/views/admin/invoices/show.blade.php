@extends('layouts.admin')
@section('title', 'تفاصيل الفاتورة')
@section('page-title', 'فاتورة ' . $invoice->invoice_number)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
    <li class="breadcrumb-item active">{{ $invoice->invoice_number }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.invoices.print', $invoice) }}" class="btn btn-outline-secondary" target="_blank"><i class="fas fa-print me-2"></i>طباعة</a>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>تعديل</a>
    </div>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <!-- Invoice Card -->
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">رقم الفاتورة #{{ $invoice->invoice_number }}</h6>
                @php
                    $statusMap = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger'];
                    $badge = $statusMap[$invoice->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badge }} fs-6">{{ ucfirst($invoice->status) }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="text-muted small mb-1">المريض</p>
                        <p class="fw-semibold mb-0">{{ $invoice->patient->name ?? 'N/A' }}</p>
                        <p class="text-muted small mb-0">{{ $invoice->patient->phone ?? '' }}</p>
                        @if($invoice->patient->address ?? false)
                            <p class="text-muted small mb-0">{{ $invoice->patient->address }}</p>
                        @endif
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="text-muted small mb-1">تاريخ الفاتورة</p>
                        <p class="fw-semibold mb-1">{{ $invoice->created_at->format('M d, Y') }}</p>
                        @if($invoice->due_date)
                        <p class="text-muted small mb-1">تاريخ الاستحقاق</p>
                        <p class="fw-semibold mb-0">{{ $invoice->due_date->format('M d, Y') }}</p>
                        @endif
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr><th>الوصف</th><th class="text-end">المبلغ</th></tr>
                    </thead>
                    <tbody>
                        @if($invoice->consultation_fee > 0)
                        <tr><td>رسوم الاستشارة</td><td class="text-end">${{ number_format($invoice->consultation_fee, 2) }}</td></tr>
                        @endif
                        @if($invoice->medicine_fee > 0)
                        <tr><td>الأدوية / الصيدلية</td><td class="text-end">${{ number_format($invoice->medicine_fee, 2) }}</td></tr>
                        @endif
                        @if($invoice->test_fee > 0)
                        <tr><td>المختبر / الفحوصات</td><td class="text-end">${{ number_format($invoice->test_fee, 2) }}</td></tr>
                        @endif
                        @if($invoice->other_fee > 0)
                        <tr><td>رسوم أخرى</td><td class="text-end">${{ number_format($invoice->other_fee, 2) }}</td></tr>
                        @endif
                        @if($invoice->discount > 0)
                        <tr class="text-danger"><td>الخصم</td><td class="text-end">-${{ number_format($invoice->discount, 2) }}</td></tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold table-light">
                            <td>إجمالي المبلغ</td>
                            <td class="text-end fs-5">${{ number_format($invoice->total_amount, 2) }}</td>
                        </tr>
                        <tr class="text-success">
                            <td>المبلغ المدفوع</td>
                            <td class="text-end">${{ number_format($invoice->paid_amount, 2) }}</td>
                        </tr>
                        @if($invoice->remaining_amount > 0)
                        <tr class="text-danger fw-bold">
                            <td>الرصيد المستحق</td>
                            <td class="text-end">${{ number_format($invoice->remaining_amount, 2) }}</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>

                @if($invoice->notes)
                <div class="mt-3 p-3 bg-light rounded">
                    <h6 class="text-muted small mb-1">الملاحظات</h6>
                    <p class="mb-0 small">{{ $invoice->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment History -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-money-bill-wave me-2 text-success"></i>سجل المدفوعات</h6>
                @if($invoice->status != 'paid')
                    <a href="{{ route('admin.payments.create') }}?invoice={{ $invoice->id }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus me-1"></i>تسجيل دفعة
                    </a>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>التاريخ</th><th>المبلغ</th><th>الطريقة</th><th>رقم المعاملة</th><th>الإجراءات</th></tr>
                        </thead>
                        <tbody>
                            @forelse($invoice->payments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td class="text-success fw-semibold">${{ number_format($payment->amount, 2) }}</td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                                <td><small class="text-muted">{{ $payment->transaction_id ?? '-' }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الدفعة؟')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">لا توجد مدفوعات مسجلة بعد</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card sticky-top" style="top:80px;">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">ملخص</h6>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">رقم الفاتورة</span><strong>{{ $invoice->invoice_number }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">إجمالي المبلغ</span><strong>${{ number_format($invoice->total_amount, 2) }}</strong>
                </div>
                <div class="mb-2 d-flex justify-content-between text-success">
                    <span>المبلغ المدفوع</span><strong>${{ number_format($invoice->paid_amount, 2) }}</strong>
                </div>
                @if($invoice->remaining_amount > 0)
                <div class="mb-2 d-flex justify-content-between text-danger">
                    <span>الرصيد المستحق</span><strong>${{ number_format($invoice->remaining_amount, 2) }}</strong>
                </div>
                @endif
                @if($invoice->due_date)
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">تاريخ الاستحقاق</span>
                    <strong class="{{ $invoice->due_date->isPast() && $invoice->status != 'paid' ? 'text-danger' : '' }}">
                        {{ $invoice->due_date->format('M d, Y') }}
                    </strong>
                </div>
                @endif
                @if($invoice->appointment)
                <div class="mb-2 d-flex justify-content-between">
                    <span class="text-muted">الموعد</span>
                    <a href="{{ route('admin.appointments.show', $invoice->appointment) }}" class="small">عرض</a>
                </div>
                @endif
                <hr>
                <div class="d-grid gap-2">
                    @if($invoice->status != 'paid')
                    <a href="{{ route('admin.payments.create') }}?invoice={{ $invoice->id }}" class="btn btn-success">
                        <i class="fas fa-money-bill-wave me-2"></i>تسجيل دفعة
                    </a>
                    @endif
                    <a href="{{ route('admin.invoices.print', $invoice) }}" class="btn btn-outline-secondary" target="_blank">
                        <i class="fas fa-print me-2"></i>طباعة الفاتورة
                    </a>
                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">رجوع إلى الفواتير</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
