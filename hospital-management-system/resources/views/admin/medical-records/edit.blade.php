@extends('layouts.admin')
@section('title', 'تعديل السجل الطبي')
@section('page-title', 'تعديل السجل الطبي')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.medical-records.index') }}">السجلات الطبية</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="card"><div class="card-header d-flex align-items-center justify-content-between"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-medical me-2 text-primary"></i>تعديل السجل الطبي</h6><a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i>رجوع</a></div><div class="card-body">
<form action="{{ route('admin.medical-records.update', $record) }}" method="POST">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label><select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required><option value="">اختر المريض</option>@foreach($patients as $patient)<option value="{{ $patient->id }}" {{ old('patient_id', $record->patient_id) == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>@endforeach</select>@error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">الطبيب <span class="text-danger">*</span></label><select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required><option value="">اختر الطبيب</option>@foreach($doctors as $doctor)<option value="{{ $doctor->id }}" {{ old('doctor_id', $record->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization }}</option>@endforeach</select>@error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ الزيارة <span class="text-danger">*</span></label><input type="date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror" value="{{ old('visit_date', $record->visit_date->format('Y-m-d')) }}" required>@error('visit_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ المتابعة</label><input type="date" name="follow_up_date" class="form-control" value="{{ old('follow_up_date', $record->follow_up_date?->format('Y-m-d')) }}"></div>
<div class="col-12"><label class="form-label fw-semibold">الأعراض</label><textarea name="symptoms" class="form-control @error('symptoms') is-invalid @enderror" rows="3">{{ old('symptoms', $record->symptoms) }}</textarea>@error('symptoms')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">التشخيص <span class="text-danger">*</span></label><textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3" required>{{ old('diagnosis', $record->diagnosis) }}</textarea>@error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">خطة العلاج</label><textarea name="treatment" class="form-control" rows="3">{{ old('treatment', $record->treatment) }}</textarea></div>
<div class="col-md-6"><label class="form-label fw-semibold">ضغط الدم</label><input type="text" name="blood_pressure" class="form-control" value="{{ old('blood_pressure', $record->blood_pressure) }}"></div>
<div class="col-md-6"><label class="form-label fw-semibold">درجة الحرارة</label><input type="text" name="temperature" class="form-control" value="{{ old('temperature', $record->temperature) }}"></div>
<div class="col-md-6"><label class="form-label fw-semibold">الوزن</label><input type="text" name="weight" class="form-control" value="{{ old('weight', $record->weight) }}"></div>
<div class="col-md-6"><label class="form-label fw-semibold">معدل النبض</label><input type="text" name="pulse_rate" class="form-control" value="{{ old('pulse_rate', $record->pulse_rate) }}"></div>
<div class="col-12"><label class="form-label fw-semibold">ملاحظات إضافية</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $record->notes) }}</textarea></div>
<div class="col-12 d-flex gap-2 mt-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث السجل</button><a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-secondary">إلغاء</a></div>
</div></form></div></div>
@endsection
