@extends('layouts.admin')
@section('title', 'تقارير الإيرادات')
@section('page-title', 'تقارير الإيرادات')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">التقارير</a></li>
    <li class="breadcrumb-item active">تقارير الإيرادات</li>
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">من تاريخ</label>
                <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">إلى تاريخ</label>
                <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-filter me-1"></i>تطبيق الفلتر</button>
                <a href="{{ route('admin.reports.revenue') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h3 class="fw-bold text-warning mb-1">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p class="text-muted small mb-0">إجمالي الإيرادات</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h3 class="fw-bold text-success mb-1">${{ number_format($totalPaid ?? 0, 2) }}</h3>
                <p class="text-muted small mb-0">إجمالي المدفوع</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h3 class="fw-bold text-danger mb-1">${{ number_format($totalBalance ?? 0, 2) }}</h3>
                <p class="text-muted small mb-0">الرصيد المستحق</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">بيانات الإيرادات</h6>
        <a href="{{ route('admin.reports.revenue') }}?{{ http_build_query(array_merge(request()->query(), ['export'=>'csv'])) }}" class="btn btn-sm btn-outline-success">
            <i class="fas fa-download me-1"></i>تصدير
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>المريض</th>
                        <th>الإجمالي الكلي</th>
                        <th>المبلغ المدفوع</th>
                        <th>الرصيد المستحق</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices ?? [] as $invoice)
                    @php
                        $statusColors = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger'];
                        $statusBadge = $statusColors[$invoice->status] ?? 'secondary';
                    @endphp
                    <tr>
                        <td><span class="fw-semibold text-primary">{{ $invoice->invoice_number }}</span></td>
                        <td>{{ $invoice->patient->name ?? 'N/A' }}</td>
                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                        <td class="text-success">${{ number_format($invoice->paid_amount, 2) }}</td>
                        <td class="{{ $invoice->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">${{ number_format($invoice->remaining_amount, 2) }}</td>
                        <td><span class="badge bg-{{ $statusBadge }}">{{ ucfirst($invoice->status) }}</span></td>
                        <td><small>{{ $invoice->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">لا توجد بيانات للعرض</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(isset($invoices) && $invoices->hasPages())
    <div class="card-footer">{{ $invoices->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
