@extends('layouts.admin')
@section('title', 'تفاصيل الوصفة الطبية')
@section('page-title', 'تفاصيل الوصفة الطبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prescriptions.index') }}">الوصفات الطبية</a></li>
    <li class="breadcrumb-item active">#{{ $prescription->id }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.prescriptions.edit', $prescription) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>تعديل
        </a>
        <form action="{{ route('admin.prescriptions.destroy', $prescription) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذه الوصفة؟')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>حذف</button>
        </form>
    </div>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold"><i class="fas fa-prescription-bottle-alt me-2 text-info"></i>تفاصيل الوصفة الطبية</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">اسم الدواء</div>
                        <div class="fw-semibold fs-5 text-primary">{{ $prescription->medicine_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">الجرعة</div>
                        <div class="fw-semibold">{{ $prescription->dosage }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">التكرار</div>
                        <div class="fw-semibold">{{ $prescription->frequency }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">المدة (أيام)</div>
                        <div class="fw-semibold">{{ $prescription->duration_days }} يوم</div>
                    </div>
                    @if($prescription->instructions)
                    <div class="col-12">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">التعليمات</div>
                        <div class="p-3 bg-light rounded">{{ $prescription->instructions }}</div>
                    </div>
                    @endif
                    @if($prescription->medicalRecord)
                    <div class="col-12">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">السجل المرتبط</div>
                        <a href="{{ route('admin.medical-records.show', $prescription->medicalRecord) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-file-medical me-1"></i>عرض السجل الطبي #{{ $prescription->medicalRecord->id }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user me-2 text-primary"></i>المريض</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($prescription->patient->name ?? 'P', 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $prescription->patient->name ?? 'N/A' }}</div>
                        @if($prescription->patient)
                        <small class="text-muted">{{ ucfirst($prescription->patient->gender) }}, {{ $prescription->patient->age }} yrs</small>
                        @endif
                    </div>
                </div>
                @if($prescription->patient)
                <a href="{{ route('admin.patients.show', $prescription->patient) }}" class="btn btn-sm btn-outline-primary w-100 mt-2">عرض الملف</a>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-md me-2 text-info"></i>الطبيب</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-2" style="width:42px;height:42px;font-size:0.9rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($prescription->doctor->user->name ?? 'DR', 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $prescription->doctor->user->name ?? 'N/A' }}</div>
                        <small class="text-primary">{{ $prescription->doctor->specialization ?? '' }}</small>
                    </div>
                </div>
                @if($prescription->doctor)
                <a href="{{ route('admin.doctors.show', $prescription->doctor) }}" class="btn btn-sm btn-outline-info w-100 mt-2">عرض الملف</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
