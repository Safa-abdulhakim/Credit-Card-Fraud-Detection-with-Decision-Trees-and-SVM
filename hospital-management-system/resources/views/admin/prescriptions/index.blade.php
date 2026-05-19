@extends('layouts.admin')
@section('title', 'الوصفات الطبية')
@section('page-title', 'الوصفات الطبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">الوصفات الطبية</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.prescriptions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة وصفة طبية
    </a>
@endsection
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="البحث عن مريض أو دواء..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="doctor_id" class="form-select form-select-sm">
                    <option value="">جميع الأطباء</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->user->name ?? 'N/A' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> تصفية</button>
                <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary btn-sm">إعادة تعيين</a>
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
                        <th>#</th>
                        <th>المريض</th>
                        <th>الطبيب</th>
                        <th>الدواء</th>
                        <th>التاريخ</th>
                        <th>المدة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                    <tr>
                        <td>{{ $prescriptions->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $rx->patient->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $rx->patient ? $rx->patient->age . ' yrs, ' . ucfirst($rx->patient->gender) : '' }}</small>
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $rx->doctor->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $rx->doctor->specialization ?? '' }}</small>
                        </td>
                        <td>
                            <strong class="text-primary">{{ $rx->medicine_name }}</strong>
                            <small class="text-muted d-block">{{ $rx->dosage }} — {{ $rx->frequency }}</small>
                        </td>
                        <td><small>{{ $rx->created_at->format('M d, Y') }}</small></td>
                        <td>
                            <span class="badge bg-light text-dark">{{ $rx->duration_days }} يوم</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.prescriptions.show', $rx) }}" class="btn btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.prescriptions.edit', $rx) }}" class="btn btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.prescriptions.destroy', $rx) }}" method="POST" class="d-inline" onsubmit="return confirm('هل تريد حذف هذه الوصفة؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-prescription-bottle-alt fa-2x mb-2 d-block opacity-25"></i>
                            لا توجد وصفات طبية.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($prescriptions->hasPages())
    <div class="card-footer">{{ $prescriptions->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
