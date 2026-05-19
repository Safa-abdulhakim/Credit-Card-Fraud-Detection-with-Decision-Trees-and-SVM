@extends('layouts.admin')
@section('title', 'إضافة سجل طبي')
@section('page-title', 'إضافة سجل طبي')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.medical-records.index') }}">السجلات الطبية</a></li>
    <li class="breadcrumb-item active">إضافة</li>
@endsection
@section('content')
<div class="card"><div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-file-medical me-2 text-info"></i>معلومات السجل الطبي</h6></div><div class="card-body">
<form action="{{ route('admin.medical-records.store') }}" method="POST">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label><select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required><option value="">اختر المريض</option>@foreach($patients as $patient)<option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>@endforeach</select>@error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">الطبيب <span class="text-danger">*</span></label><select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required><option value="">اختر الطبيب</option>@foreach($doctors as $doctor)<option value="{{ $doctor->id }}" {{ old('doctor_id', request('doctor_id')) == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization }}</option>@endforeach</select>@error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ الزيارة <span class="text-danger">*</span></label><input type="date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror" value="{{ old('visit_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>@error('visit_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">تاريخ المتابعة</label><input type="date" name="follow_up_date" class="form-control @error('follow_up_date') is-invalid @enderror" value="{{ old('follow_up_date') }}" min="{{ date('Y-m-d') }}">@error('follow_up_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">الأعراض <span class="text-danger">*</span></label><textarea name="symptoms" class="form-control @error('symptoms') is-invalid @enderror" rows="3" placeholder="صف الأعراض...">{{ old('symptoms') }}</textarea>@error('symptoms')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">التشخيص <span class="text-danger">*</span></label><textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3" placeholder="تشخيص الطبيب..." required>{{ old('diagnosis') }}</textarea>@error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-12"><label class="form-label fw-semibold">خطة العلاج</label><textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror" rows="3" placeholder="خطة العلاج أو الإجراءات...">{{ old('treatment') }}</textarea>@error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
<div class="col-md-6"><label class="form-label fw-semibold">ضغط الدم</label><input type="text" name="blood_pressure" class="form-control" value="{{ old('blood_pressure') }}" placeholder="مثال: 120/80 mmHg"></div>
<div class="col-md-6"><label class="form-label fw-semibold">درجة الحرارة</label><input type="text" name="temperature" class="form-control" value="{{ old('temperature') }}" placeholder="مثال: 98.6°F"></div>
<div class="col-md-6"><label class="form-label fw-semibold">الوزن</label><input type="text" name="weight" class="form-control" value="{{ old('weight') }}" placeholder="مثال: 70 kg"></div>
<div class="col-md-6"><label class="form-label fw-semibold">معدل النبض</label><input type="text" name="pulse_rate" class="form-control" value="{{ old('pulse_rate') }}" placeholder="مثال: 72 bpm"></div>
<div class="col-12"><label class="form-label fw-semibold">ملاحظات إضافية</label><textarea name="notes" class="form-control" rows="2" placeholder="أي ملاحظات إضافية...">{{ old('notes') }}</textarea></div>
<div class="col-12 d-flex gap-2 mt-2"><button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>حفظ السجل</button><a href="{{ route('admin.medical-records.index') }}" class="btn btn-secondary">إلغاء</a></div>
</div></form></div></div>
@endsection
