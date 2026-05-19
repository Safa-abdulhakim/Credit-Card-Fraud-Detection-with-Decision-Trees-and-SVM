@extends('layouts.admin')
@section('title', 'تفاصيل القسم')
@section('page-title', $department->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active">{{ $department->name }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>تعديل</a>
        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا القسم؟')">@csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>حذف</button></form>
    </div>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:70px;height:70px;font-size:1.5rem;"><i class="fas fa-building"></i></div>
                    <h5 class="fw-bold mb-1">{{ $department->name }}</h5>
                    @if($department->is_active)<span class="badge bg-success">نشط</span>@else<span class="badge bg-secondary">غير نشط</span>@endif
                </div>
                @if($department->description)<div class="p-3 bg-light rounded"><p class="text-muted small mb-0">{{ $department->description }}</p></div>@endif
                <div class="row text-center g-2 mt-3">
                    <div class="col-6"><div class="fw-bold fs-5 text-primary">{{ $department->doctors->count() }}</div><small class="text-muted">أطباء</small></div>
                    <div class="col-6"><div class="fw-bold fs-5 text-info">{{ $department->doctors->sum(fn($d) => $d->appointments->count()) }}</div><small class="text-muted">مواعيد</small></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold">أطباء القسم</h6><a href="{{ route('admin.doctors.create') }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus me-1"></i>إضافة طبيب</a></div>
            <div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>الطبيب</th><th>التخصص</th><th>الخبرة</th><th>الرسوم</th><th>الحالة</th><th></th></tr></thead><tbody>@forelse($department->doctors as $doctor)<tr><td><div class="d-flex align-items-center"><div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:0.75rem;font-weight:700;">{{ strtoupper(substr($doctor->user->name ?? 'DR', 0, 2)) }}</div><span class="fw-semibold small">{{ $doctor->user->name ?? 'N/A' }}</span></div></td><td><small>{{ $doctor->specialization }}</small></td><td><small>{{ $doctor->experience_years }} سنوات</small></td><td><small>${{ number_format($doctor->consultation_fee, 2) }}</small></td><td>@if($doctor->is_available)<span class="badge bg-success">متاح</span>@else<span class="badge bg-secondary">غير متاح</span>@endif</td><td><a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a></td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">لا يوجد أطباء في هذا القسم</td></tr>@endforelse</tbody></table></div></div>
        </div>
    </div>
</div>
@endsection
