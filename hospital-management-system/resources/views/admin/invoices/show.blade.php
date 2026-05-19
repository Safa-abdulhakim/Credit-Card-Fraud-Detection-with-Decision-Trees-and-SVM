@extends('layouts.admin')
@section('title', 'تفاصيل الفاتورة')
@section('page-title', 'الفاتورة {{ $invoice->invoice_number }}')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">الفواتير</a></li>
    <li class="breadcrumb-item active">{{ $invoice->invoice_number }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.invoices.print', $invoice) }}" class="btn btn-secondary btn-sm" target="_blank"><i class="fas fa-print me-1"></i>طباعة</a>
        <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>تعديل</a>
        @if($invoice->status != 'paid')
        <a href="{{ route('admin.payments.create', ['invoice_id' => $invoice->id]) }}" class="btn btn-success btn-sm"><i class="fas fa-dollar-sign me-1"></i>تسجيل دفعة</a>
        @endif
    </div>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card mb-3"><div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>بنود الفاتورة</h6><span class="badge bg-{{ ['unpaid'=>'warning','paid'=>'success','partial'=>'info','cancelled'=>'danger'][$invoice->status] ?? 'secondary' }} fs-6">{{ ucfirst($invoice->status) }}</span></div><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>الوصف</th><th class="text-center">الكمية</th><th class="text-end">سعر الوحدة</th><th class="text-end">الإجمالي</th></tr></thead><tbody>@foreach($invoice->items as $item)<tr><td>{{ $item->description }}</td><td class="text-center">{{ $item->quantity }}</td><td class="text-end">${{ number_format($item->unit_price, 2) }}</td><td class="text-end">${{ number_format($item->total, 2) }}</td></tr>@endforeach</tbody><tfoot class="table-light"><tr><td colspan="3" class="text-end fw-semibold">المجموع الفرعي:</td><td class="text-end">${{ number_format($invoice->subtotal, 2) }}</td></tr>@if($invoice->discount_amount > 0)<tr><td colspan="3" class="text-end">الخصم:</td><td class="text-end text-danger">-${{ number_format($invoice->discount_amount, 2) }}</td></tr>@endif@if($invoice->tax_rate > 0)<tr><td colspan="3" class="text-end">ضريبة {{ $invoice->tax_rate }}%:</td><td class="text-end">${{ number_format($invoice->tax_amount, 2) }}</td></tr>@endif<tr><td colspan="3" class="text-end fw-bold fs-5">الإجمالي:</td><td class="text-end fw-bold fs-5 text-success">${{ number_format($invoice->total_amount, 2) }}</td></tr></tfoot></table></div></div></div>
        @if($invoice->notes)<div class="card mb-3"><div class="card-header"><h6 class="mb-0">ملاحظات</h6></div><div class="card-body"><p class="text-muted mb-0">{{ $invoice->notes }}</p></div></div>@endif
        @if($invoice->payments->count())
        <div class="card"><div class="card-header d-flex justify-content-between align-items-center"><h6 class="mb-0 fw-semibold">سجل الدفعات</h6></div><div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>التاريخ</th><th>المبلغ</th><th>طريقة الدفع</th><th>ملاحظات</th></tr></thead><tbody>@foreach($invoice->payments as $payment)<tr><td>{{ $payment->payment_date->format('M d, Y') }}</td><td class="fw-semibold text-success">${{ number_format($payment->amount, 2) }}</td><td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td><td><small class="text-muted">{{ $payment->notes ?? '-' }}</small></td></tr>@endforeach</tbody><tfoot class="table-light"><tr><td colspan="1" class="fw-semibold">إجمالي المدفوع:</td><td colspan="3" class="fw-bold text-success">${{ number_format($invoice->payments->sum('amount'), 2) }}</td></tr></tfoot></table></div></div></div>
        @endif
    </div>
    <div class="col-12 col-lg-4">
        <div class="card mb-3"><div class="card-header"><h6 class="mb-0">تفاصيل الفاتورة</h6></div><div class="card-body"><div class="mb-2 d-flex justify-content-between"><span class="text-muted small">رقم الفاتورة:</span><strong>{{ $invoice->invoice_number }}</strong></div><div class="mb-2 d-flex justify-content-between"><span class="text-muted small">تاريخ الإصدار:</span><span>{{ $invoice->invoice_date->format('M d, Y') }}</span></div>@if($invoice->due_date)<div class="mb-2 d-flex justify-content-between"><span class="text-muted small">تاريخ الاستحقاق:</span><span class="{{ $invoice->due_date->isPast() && $invoice->status != 'paid' ? 'text-danger fw-bold' : '' }}">{{ $invoice->due_date->format('M d, Y') }}</span></div>@endif@if($invoice->payment_method)<div class="mb-2 d-flex justify-content-between"><span class="text-muted small">طريقة الدفع:</span><span>{{ ucfirst(str_replace('_',' ',$invoice->payment_method)) }}</span></div>@endif</div></div>
        <div class="card mb-3"><div class="card-header"><h6 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>المريض</h6></div><div class="card-body"><div class="d-flex align-items-center mb-2"><div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">{{ strtoupper(substr($invoice->patient->name ?? 'P', 0, 2)) }}</div><div><div class="fw-bold">{{ $invoice->patient->name ?? 'N/A' }}</div>@if($invoice->patient)<small class="text-muted">{{ $invoice->patient->phone }}</small>@endif</div></div>@if($invoice->patient)<a href="{{ route('admin.patients.show', $invoice->patient) }}" class="btn btn-sm btn-outline-primary w-100">عرض الملف</a>@endif</div></div>
        @if($invoice->doctor)
        <div class="card"><div class="card-header"><h6 class="mb-0"><i class="fas fa-user-md me-2 text-info"></i>الطبيب</h6></div><div class="card-body"><div class="d-flex align-items-center mb-2"><div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">{{ strtoupper(substr($invoice->doctor->user->name ?? 'DR', 0, 2)) }}</div><div><div class="fw-bold">{{ $invoice->doctor->user->name ?? 'N/A' }}</div><small class="text-primary">{{ $invoice->doctor->specialization }}</small></div></div><a href="{{ route('admin.doctors.show', $invoice->doctor) }}" class="btn btn-sm btn-outline-info w-100">عرض الملف</a></div></div>
        @endif
    </div>
</div>
@endsection
