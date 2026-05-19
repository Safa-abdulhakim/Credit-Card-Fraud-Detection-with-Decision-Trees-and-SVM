@extends('layouts.admin')
@section('title', 'الفواتير')
@section('page-title', 'الفواتير')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item active">الفواتير</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>إنشاء فاتورة</a>
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="رقم الفاتورة أو اسم المريض..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">كل الحالات</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>غير مدفوع</option>
                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>مدفوع جزئياً</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>مدفوع</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> بحث</button>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
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
                        <th>الإجمالي</th>
                        <th>مدفوع</th>
                        <th>الرصيد المتبقي</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    <tr>
                        <td><span class="fw-semibold text-primary">{{ $inv->invoice_number }}</span></td>
                        <td>{{ $inv->patient->name ?? 'N/A' }}</td>
                        <td>${{ number_format($inv->total_amount, 2) }}</td>
                        <td class="text-success">${{ number_format($inv->paid_amount, 2) }}</td>
                        <td class="{{ $inv->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">${{ number_format($inv->remaining_amount, 2) }}</td>
                        <td>
                            @php
                                $statusMap = ['paid'=>'success','partial'=>'warning','unpaid'=>'danger'];
                                $statusBadge = $statusMap[$inv->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $statusBadge }}">{{ ucfirst($inv->status) }}</span>
                        </td>
                        <td><small>{{ $inv->created_at->format('M d, Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.invoices.show', $inv) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.invoices.print', $inv) }}" class="btn btn-outline-secondary" title="طباعة" target="_blank"><i class="fas fa-print"></i></a>
                                <a href="{{ route('admin.invoices.edit', $inv) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.invoices.destroy', $inv) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الفاتورة؟')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="fas fa-file-invoice fa-2x mb-2 d-block opacity-25"></i>
                            لا توجد فواتير
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($invoices->hasPages())
    <div class="card-footer">{{ $invoices->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
