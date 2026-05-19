@extends('layouts.admin')
@section('title', 'تقارير المواعيد')
@section('page-title', 'تقارير المواعيد')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">التقارير</a></li>
    <li class="breadcrumb-item active">تقارير المواعيد</li>
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
                <a href="{{ route('admin.reports.appointments') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h3 class="fw-bold text-success mb-1">{{ $totalAppointments ?? 0 }}</h3>
                <p class="text-muted small mb-0">إجمالي المواعيد</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">بيانات المواعيد</h6>
        <a href="{{ route('admin.reports.appointments') }}?{{ http_build_query(array_merge(request()->query(), ['export'=>'csv'])) }}" class="btn btn-sm btn-outline-success">
            <i class="fas fa-download me-1"></i>تصدير
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments ?? [] as $appointment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->doctor->user->name ?? 'N/A' }}</td>
                        <td><small>{{ $appointment->appointment_date->format('M d, Y') }}</small></td>
                        <td><span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">لا توجد بيانات للعرض</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(isset($appointments) && $appointments->hasPages())
    <div class="card-footer">{{ $appointments->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
