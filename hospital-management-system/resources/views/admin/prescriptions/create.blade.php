@extends('layouts.admin')
@section('title', 'إنشاء وصفة طبية')
@section('page-title', 'إنشاء وصفة طبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prescriptions.index') }}">الوصفات الطبية</a></li>
    <li class="breadcrumb-item active">إنشاء</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-prescription-bottle-alt me-2 text-info"></i>تفاصيل الوصفة الطبية</h6></div>
    <div class="card-body">
        <form action="{{ route('admin.prescriptions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الطبيب <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">اختر الطبيب</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', request('doctor_id')) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @if(isset($medicalRecords))
                <div class="col-md-6">
                    <label class="form-label fw-semibold">السجل الطبي</label>
                    <select name="medical_record_id" class="form-select @error('medical_record_id') is-invalid @enderror">
                        <option value="">اختر السجل</option>
                        @foreach($medicalRecords as $mr)
                            <option value="{{ $mr->id }}" {{ old('medical_record_id', request('medical_record_id')) == $mr->id ? 'selected' : '' }}>
                                #{{ $mr->id }} - {{ $mr->diagnosis }} ({{ $mr->record_date->format('M d, Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('medical_record_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endif
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اسم الدواء <span class="text-danger">*</span></label>
                    <input type="text" name="medicine_name" class="form-control @error('medicine_name') is-invalid @enderror" value="{{ old('medicine_name') }}" placeholder="أدخل اسم الدواء" required>
                    @error('medicine_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الجرعة <span class="text-danger">*</span></label>
                    <input type="text" name="dosage" class="form-control @error('dosage') is-invalid @enderror" value="{{ old('dosage') }}" placeholder="مثال: 500mg" required>
                    @error('dosage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">التكرار <span class="text-danger">*</span></label>
                    <input type="text" name="frequency" class="form-control @error('frequency') is-invalid @enderror" value="{{ old('frequency') }}" placeholder="مثال: مرتين يومياً" required>
                    @error('frequency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">المدة (أيام) <span class="text-danger">*</span></label>
                    <input type="number" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror" value="{{ old('duration_days') }}" placeholder="عدد الأيام" min="1" required>
                    @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">التعليمات</label>
                    <textarea name="instructions" class="form-control @error('instructions') is-invalid @enderror" rows="3" placeholder="تعليمات الاستخدام...">{{ old('instructions') }}</textarea>
                    @error('instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>إنشاء وصفة طبية</button>
                    <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
