@extends('layouts.admin')
@section('title', 'تفاصيل السجل الطبي')
@section('page-title', 'السجل الطبي')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.medical-records.index') }}">السجلات الطبية</a></li>
    <li class="breadcrumb-item active">#{{ $record->id }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.medical-records.edit', $record) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>تعديل
        </a>
        <form action="{{ route('admin.medical-records.destroy', $record) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا السجل الطبي؟')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>حذف</button>
        </form>
    </div>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <!-- Record Details -->
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-file-medical me-2 text-info"></i>تفاصيل الزيارة</h6>
                <small class="text-muted">{{ $record->visit_date->format('l, F d, Y') }}</small>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @if($record->symptoms)
                    <div class="col-12">
                        <div class="fw-semibold small text-uppercase text-muted mb-2">الأعراض</div>
                        <div class="p-3 bg-light rounded">{{ $record->symptoms }}</div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="fw-semibold small text-uppercase text-muted mb-2">التشخيص</div>
                        <div class="p-3 bg-warning bg-opacity-10 rounded border-start border-warning border-3">
                            {{ $record->diagnosis }}
                        </div>
                    </div>
                    @if($record->treatment)
                    <div class="col-12">
                        <div class="fw-semibold small text-uppercase text-muted mb-2">خطة العلاج</div>
                        <div class="p-3 bg-success bg-opacity-10 rounded">{{ $record->treatment }}</div>
                    </div>
                    @endif
                    @if($record->notes)
                    <div class="col-12">
                        <div class="fw-semibold small text-uppercase text-muted mb-2">الملاحظات</div>
                        <p class="text-muted mb-0">{{ $record->notes }}</p>
                    </div>
                    @endif
                    @if($record->follow_up_date)
                    <div class="col-12">
                        <div class="alert alert-{{ $record->follow_up_date->isPast() ? 'danger' : 'info' }} mb-0">
                            <i class="fas fa-calendar-check me-2"></i>
                            <strong>موعد المتابعة:</strong> {{ $record->follow_up_date->format('l, F d, Y') }}
                            @if($record->follow_up_date->isPast())
                                <span class="badge bg-danger ms-2">متأخر</span>
                            @else
                                <span class="badge bg-info ms-2">{{ $record->follow_up_date->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Vitals -->
        @if($record->blood_pressure || $record->temperature || $record->weight || $record->pulse_rate)
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-heartbeat me-2 text-danger"></i>العلامات الحيوية</h6></div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    @if($record->blood_pressure)
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-danger bg-opacity-10 rounded">
                            <i class="fas fa-heart text-danger mb-2 fa-lg"></i>
                            <div class="fw-bold">{{ $record->blood_pressure }}</div>
                            <small class="text-muted">ضغط الدم</small>
                        </div>
                    </div>
                    @endif
                    @if($record->temperature)
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-warning bg-opacity-10 rounded">
                            <i class="fas fa-thermometer-half text-warning mb-2 fa-lg"></i>
                            <div class="fw-bold">{{ $record->temperature }}</div>
                            <small class="text-muted">درجة الحرارة</small>
                        </div>
                    </div>
                    @endif
                    @if($record->pulse_rate)
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-primary bg-opacity-10 rounded">
                            <i class="fas fa-stethoscope text-primary mb-2 fa-lg"></i>
                            <div class="fw-bold">{{ $record->pulse_rate }}</div>
                            <small class="text-muted">معدل النبض</small>
                        </div>
                    </div>
                    @endif
                    @if($record->weight)
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-success bg-opacity-10 rounded">
                            <i class="fas fa-weight text-success mb-2 fa-lg"></i>
                            <div class="fw-bold">{{ $record->weight }}</div>
                            <small class="text-muted">الوزن</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user me-2 text-primary"></i>المريض</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($record->patient->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $record->patient->name }}</div>
                        <small class="text-muted">{{ ucfirst($record->patient->gender) }}, {{ $record->patient->age }} yrs</small>
                    </div>
                </div>
                @if($record->patient->blood_group)
                    <span class="badge bg-danger mb-2">{{ $record->patient->blood_group }}</span>
                @endif
                <a href="{{ route('admin.patients.show', $record->patient) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">عرض الملف</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-md me-2 text-info"></i>الطبيب المعالج</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($record->doctor->user->name ?? 'DR', 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $record->doctor->user->name ?? 'N/A' }}</div>
                        <small class="text-primary">{{ $record->doctor->specialization }}</small>
                    </div>
                </div>
                @if($record->doctor->department)
                    <div class="small text-muted mb-2"><i class="fas fa-building me-1"></i>{{ $record->doctor->department->name }}</div>
                @endif
                <a href="{{ route('admin.doctors.show', $record->doctor) }}" class="btn btn-sm btn-outline-info w-100 mt-2">عرض الملف</a>
            </div>
        </div>
    </div>
</div>
@endsection
