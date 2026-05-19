@extends('layouts.admin')
@section('title', 'المدفوعات')
@section('page-title', 'المدفوعات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">المدفوعات</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>إضافة دفعة</a>
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="رقم الفاتورة أو اسم المريض..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="method" class="form-select form-select-sm">
                    <option value="">كل الطرق</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>نقداً</option>
                    <option value="credit_card" {{ request('method') == 'credit_card' ? 'selected' : '' }}>بطاقة ائتمانية</option>
                    <option value="bank_transfer" {{ request('method') == 'bank_transfer' ? 'selected' : '' }}>تحويل بنكي</option>
                    <option value="insurance" {{ request('method') == 'insurance' ? 'selected' : '' }}>تأمين</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> بحث</button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>المريض</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>تاريخ الدفع</th>
                        <th>رقم المعاملة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="fw-semibold text-primary">
                                {{ $payment->invoice->invoice_number ?? 'N/A' }}
                            </a>
                        </td>
                        <td>{{ $payment->invoice->patient->name ?? 'N/A' }}</td>
                        <td class="text-success fw-semibold">${{ number_format($payment->amount, 2) }}</td>
                        <td><span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span></td>
                        <td><small>{{ $payment->payment_date->format('M d, Y') }}</small></td>
                        <td><small class="text-muted">{{ $payment->transaction_id ?? '-' }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الدفعة؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-money-bill-wave fa-2x mb-2 d-block opacity-25"></i>
                            لا توجد مدفوعات
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer">{{ $payments->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
