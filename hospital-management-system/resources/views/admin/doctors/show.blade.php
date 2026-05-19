@extends('layouts.admin')
@section('title', 'ملف الطبيب')
@section('page-title', $doctor->user->name ?? 'طبيب')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">الأطباء</a></li>
    <li class="breadcrumb-item active">{{ $doctor->user->name ?? 'N/A' }}</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>تعديل</a>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:90px;height:90px;font-size:2rem;font-weight:700;">{{ strtoupper(substr($doctor->user->name ?? 'DR', 0, 2)) }}</div>
                <h5 class="fw-bold mb-1">{{ $doctor->user->name ?? 'N/A' }}</h5>
                <p class="text-primary mb-1">{{ $doctor->specialization }}</p>
                @if($doctor->department)<p class="text-muted small mb-2"><i class="fas fa-building me-1"></i>{{ $doctor->department->name }}</p>@endif
                @if($doctor->is_available)<span class="badge bg-success">متاح</span>@else<span class="badge bg-secondary">غير متاح</span>@endif
            </div>
            <div class="card-body border-top pt-3">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex align-items-center mb-2"><i class="fas fa-envelope text-muted me-2" style="width:18px;"></i><span class="small">{{ $doctor->user->email ?? 'N/A' }}</span></li>
                    @if($doctor->phone)<li class="d-flex align-items-center mb-2"><i class="fas fa-phone text-muted me-2" style="width:18px;"></i><span class="small">{{ $doctor->phone }}</span></li>@endif
                    <li class="d-flex align-items-center mb-2"><i class="fas fa-briefcase text-muted me-2" style="width:18px;"></i><span class="small">{{ $doctor->experience_years }} سنوات خبرة</span></li>
                    <li class="d-flex align-items-center mb-2"><i class="fas fa-dollar-sign text-muted me-2" style="width:18px;"></i><span class="small">رسوم الاستشارة: ${{ number_format($doctor->consultation_fee, 2) }}</span></li>
                    @if($doctor->qualifications)<li class="d-flex align-items-start mb-2"><i class="fas fa-graduation-cap text-muted me-2 mt-1" style="width:18px;"></i><span class="small">{{ $doctor->qualifications }}</span></li>@endif
                </ul>
                @if($doctor->bio)<div class="mt-3 p-3 bg-light rounded"><p class="small mb-0 text-muted">{{ $doctor->bio }}</p></div>@endif
            </div>
        </div>
        <div class="card mt-3"><div class="card-body p-3"><div class="row text-center g-2"><div class="col-6"><div class="fw-bold fs-5 text-primary">{{ $doctor->appointments->count() }}</div><small class="text-muted">المواعيد</small></div><div class="col-6"><div class="fw-bold fs-5 text-info">{{ $doctor->appointments->where('status','completed')->count() }}</div><small class="text-muted">مكتمل</small></div></div></div></div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold">مواعيد الطبيب</h6><a href="{{ route('admin.appointments.create', ['doctor_id' => $doctor->id]) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus me-1"></i>حجز موعد</a></div>
            <div class="card-body p-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>التاريخ والوقت</th><th>المريض</th><th>النوع</th><th>الحالة</th><th></th></tr></thead><tbody>@forelse($doctor->appointments->sortByDesc('appointment_date')->take(15) as $appt)<tr><td><div class="small fw-semibold">{{ $appt->appointment_date->format('M d, Y') }}</div><small class="text-muted">{{ $appt->appointment_time }}</small></td><td><small>{{ $appt->patient->name ?? 'N/A' }}</small></td><td><span class="badge bg-light text-dark">{{ ucfirst($appt->type) }}</span></td><td>@php $colors=['pending'=>'warning','approved'=>'info','completed'=>'success','cancelled'=>'danger']; @endphp<span class="badge bg-{{ $colors[$appt->status] ?? 'secondary' }}">{{ ucfirst($appt->status) }}</span></td><td><a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a></td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">لا توجد مواعيد</td></tr>@endforelse</tbody></table></div></div>
        </div>
    </div>
</div>
@endsection
