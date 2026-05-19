@extends('layouts.admin')
@section('title', 'إنشاء موعد')
@section('page-title', 'إنشاء موعد')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">المواعيد</a></li>
    <li class="breadcrumb-item active">إنشاء</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-calendar-plus me-2 text-primary"></i>تفاصيل الموعد</h6></div>
    <div class="card-body">
        <form action="{{ route('admin.appointments.store') }}" method="POST">
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
                <div class="col-md-4">
                    <label class="form-label fw-semibold">تاريخ الموعد <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">وقت الموعد <span class="text-danger">*</span></label>
                    <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time') }}" required>
                    @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">النوع</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="consultation" {{ old('type') == 'consultation' ? 'selected' : '' }}>استشارة</option>
                        <option value="follow-up" {{ old('type') == 'follow-up' ? 'selected' : '' }}>متابعة</option>
                        <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>طارئ</option>
                        <option value="routine" {{ old('type') == 'routine' ? 'selected' : '' }}>فحص روتيني</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">السبب / الشكوى الرئيسية</label>
                    <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="3" placeholder="صف سبب الموعد...">{{ old('reason') }}</textarea>
                    @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">الملاحظات</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="ملاحظات إضافية...">{{ old('notes') }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calendar-check me-2"></i>إنشاء موعد</button>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
