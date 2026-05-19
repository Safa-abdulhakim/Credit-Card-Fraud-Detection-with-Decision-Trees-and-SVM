@extends('layouts.admin')
@section('title', 'تقارير المرضى')
@section('page-title', 'تقارير المرضى')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">التقارير</a></li>
    <li class="breadcrumb-item active">تقارير المرضى</li>
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
                <a href="{{ route('admin.reports.patients') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body py-3">
                <h3 class="fw-bold text-primary mb-1">{{ $totalPatients ?? 0 }}</h3>
                <p class="text-muted small mb-0">إجمالي المرضى</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">بيانات المرضى</h6>
        <a href="{{ route('admin.reports.patients') }}?{{ http_build_query(array_merge(request()->query(), ['export'=>'csv'])) }}" class="btn btn-sm btn-outline-success">
            <i class="fas fa-download me-1"></i>تصدير
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>الهاتف</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients ?? [] as $patient)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ $patient->email ?? '-' }}</td>
                        <td>{{ $patient->phone ?? '-' }}</td>
                        <td><small>{{ $patient->created_at->format('M d, Y') }}</small></td>
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
    @if(isset($patients) && $patients->hasPages())
    <div class="card-footer">{{ $patients->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
