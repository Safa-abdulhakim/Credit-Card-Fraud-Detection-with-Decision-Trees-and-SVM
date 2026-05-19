@extends('layouts.admin')
@section('title', 'تفاصيل القسم')
@section('page-title', $department->name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.departments.index') }}">الأقسام</a></li>
    <li class="breadcrumb-item active">{{ $department->name }}</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit me-1"></i>تعديل بيانات القسم
    </a>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px;height:80px;font-size:2rem;">
                    <i class="fas fa-building"></i>
                </div>
                <h5 class="fw-bold">{{ $department->name }}</h5>
                <p class="text-muted">{{ $department->description ?? 'لا يوجد وصف.' }}</p>
                <span class="badge bg-{{ $department->is_active ? 'success' : 'danger' }} mb-2">
                    {{ $department->is_active ? 'نشط' : 'غير نشط' }}
                </span>
                @if($department->head_doctor)
                    <div class="mt-2">
                        <small class="text-muted"><i class="fas fa-user-md me-1"></i>الرئيس: {{ $department->head_doctor }}</small>
                    </div>
                @endif
                <hr>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="fw-bold fs-4 text-primary">{{ $department->doctors->count() }}</div>
                        <small class="text-muted">الأطباء</small>
                    </div>
                    <div class="col-6">
                        <div class="fw-bold fs-4 text-success">{{ $department->doctors->where('is_available', true)->count() }}</div>
                        <small class="text-muted">متاح</small>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2 justify-content-center">
                    <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>تعديل
                    </a>
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary btn-sm">رجوع</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-user-md me-2 text-primary"></i>أطباء قسم {{ $department->name }}
                </h6>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus me-1"></i>إضافة طبيب
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>طبيب</th>
                                <th>التخصص</th>
                                <th>الخبرة</th>
                                <th>رسوم الاستشارة</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($department->doctors as $doc)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width:34px;height:34px;font-size:0.8rem;font-weight:700;">
                                            {{ strtoupper(substr($doc->user->name ?? 'DR', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">{{ $doc->user->name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $doc->user->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doc->specialization }}</td>
                                <td>{{ $doc->experience_years }} سنة</td>
                                <td>${{ number_format($doc->consultation_fee, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $doc->is_available ? 'success' : 'secondary' }}">
                                        {{ $doc->is_available ? 'متاح' : 'غير متاح' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.doctors.show', $doc) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-user-md fa-2x mb-2 d-block opacity-25"></i>
                                    لا يوجد أطباء مضافون لهذا القسم بعد.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
