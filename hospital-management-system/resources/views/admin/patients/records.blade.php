@extends('layouts.admin')
@section('title', 'السجلات الطبية - ' . $patient->name)
@section('page-title', 'السجلات الطبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.patients.index') }}">المرضى</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.patients.show', $patient) }}">{{ $patient->name }}</a></li>
    <li class="breadcrumb-item active">السجلات الطبية</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.medical-records.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i>إضافة سجل
    </a>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-body text-center p-3">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" style="width:60px;height:60px;font-size:1.4rem;font-weight:700;">
                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                </div>
                <h6 class="fw-bold mb-1">{{ $patient->name }}</h6>
                <small class="text-muted">{{ ucfirst($patient->gender) }}، {{ $patient->age }} سنة</small>
                @if($patient->blood_group)
                    <div class="mt-1"><span class="badge bg-danger">{{ $patient->blood_group }}</span></div>
                @endif
                <hr>
                @if($patient->allergies)
                <div class="text-start">
                    <p class="small fw-semibold text-danger mb-1"><i class="fas fa-exclamation-triangle me-1"></i>الحساسية</p>
                    <p class="small mb-2">{{ $patient->allergies }}</p>
                </div>
                @endif
                @if($patient->medical_history)
                <div class="text-start">
                    <p class="small fw-semibold text-info mb-1"><i class="fas fa-history me-1"></i>التاريخ المرضي</p>
                    <p class="small mb-0">{{ Str::limit($patient->medical_history, 100) }}</p>
                </div>
                @endif
                <div class="mt-3">
                    <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="fas fa-user me-1"></i>الملف الكامل
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-9">
        @forelse($records as $record)
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info rounded d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $record->visit_date->format('F d, Y') }}</div>
                        <small class="text-muted">
                            د. {{ $record->doctor->user->name ?? 'N/A' }}
                            @if($record->doctor->department)
                                &middot; {{ $record->doctor->department->name }}
                            @endif
                        </small>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-sm btn-outline-info" title="عرض"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('admin.medical-records.edit', $record) }}" class="btn btn-sm btn-outline-primary" title="تعديل"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.medical-records.destroy', $record) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا السجل الطبي؟')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="fw-semibold small text-uppercase text-muted mb-1">التشخيص</div>
                        <p class="mb-0">{{ $record->diagnosis }}</p>
                    </div>
                    @if($record->symptoms)
                    <div class="col-md-6">
                        <div class="fw-semibold small text-uppercase text-muted mb-1">الأعراض</div>
                        <p class="mb-0">{{ $record->symptoms }}</p>
                    </div>
                    @endif
                    @if($record->treatment)
                    <div class="col-md-6">
                        <div class="fw-semibold small text-uppercase text-muted mb-1">العلاج</div>
                        <p class="mb-0">{{ $record->treatment }}</p>
                    </div>
                    @endif
                    @if($record->notes)
                    <div class="col-md-6">
                        <div class="fw-semibold small text-uppercase text-muted mb-1">الملاحظات</div>
                        <p class="mb-0 text-muted">{{ $record->notes }}</p>
                    </div>
                    @endif
                    @if($record->follow_up_date)
                    <div class="col-12">
                        <span class="badge bg-warning text-dark"><i class="fas fa-calendar me-1"></i>المتابعة: {{ $record->follow_up_date->format('M d, Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-file-medical fa-3x mb-3 text-muted opacity-25"></i>
                <h6 class="text-muted">لا توجد سجلات طبية لهذا المريض</h6>
                <a href="{{ route('admin.medical-records.create', ['patient_id' => $patient->id]) }}" class="btn btn-primary mt-2"><i class="fas fa-plus me-2"></i>إضافة أول سجل</a>
            </div>
        </div>
        @endforelse
        @if($records->hasPages())
        <div class="mt-3">{{ $records->links() }}</div>
        @endif
    </div>
</div>
@endsection
