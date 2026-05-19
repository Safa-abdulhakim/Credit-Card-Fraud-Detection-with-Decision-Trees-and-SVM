@extends('layouts.admin')
@section('title', 'تعديل الوصفة الطبية')
@section('page-title', 'تعديل الوصفة الطبية')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.prescriptions.index') }}">الوصفات الطبية</a></li>
    <li class="breadcrumb-item active">تعديل</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-prescription-bottle-alt me-2 text-primary"></i>تعديل الوصفة الطبية</h6>
        <a href="{{ route('admin.prescriptions.show', $prescription) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>رجوع
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.prescriptions.update', $prescription) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">المريض <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">اختر المريض</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $prescription->patient_id) == $patient->id ? 'selected' : '' }}>
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
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $prescription->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                            <option value="{{ $mr->id }}" {{ old('medical_record_id', $prescription->medical_record_id) == $mr->id ? 'selected' : '' }}>
                                #{{ $mr->id }} - {{ $mr->diagnosis }} ({{ $mr->record_date->format('M d, Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('medical_record_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endif
                <div class="col-md-6">
                    <label class="form-label fw-semibold">اسم الدواء <span class="text-danger">*</span></label>
                    <input type="text" name="medicine_name" class="form-control @error('medicine_name') is-invalid @enderror" value="{{ old('medicine_name', $prescription->medicine_name) }}" required>
                    @error('medicine_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">الجرعة <span class="text-danger">*</span></label>
                    <input type="text" name="dosage" class="form-control @error('dosage') is-invalid @enderror" value="{{ old('dosage', $prescription->dosage) }}" required>
                    @error('dosage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">التكرار <span class="text-danger">*</span></label>
                    <input type="text" name="frequency" class="form-control @error('frequency') is-invalid @enderror" value="{{ old('frequency', $prescription->frequency) }}" required>
                    @error('frequency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">المدة (أيام) <span class="text-danger">*</span></label>
                    <input type="number" name="duration_days" class="form-control @error('duration_days') is-invalid @enderror" value="{{ old('duration_days', $prescription->duration_days) }}" min="1" required>
                    @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">التعليمات</label>
                    <textarea name="instructions" class="form-control @error('instructions') is-invalid @enderror" rows="3">{{ old('instructions', $prescription->instructions) }}</textarea>
                    @error('instructions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>تحديث الوصفة الطبية</button>
                    <a href="{{ route('admin.prescriptions.show', $prescription) }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
