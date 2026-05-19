@extends('layouts.admin')
@section('title', 'Edit Medical Record')
@section('page-title', 'Edit Medical Record')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.medical-records.index') }}">Medical Records</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-file-medical me-2 text-primary"></i>Edit Medical Record</h6>
        <a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.medical-records.update', $record) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Patient <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $record->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Doctor <span class="text-danger">*</span></label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $record->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Visit Date <span class="text-danger">*</span></label>
                    <input type="date" name="visit_date" class="form-control @error('visit_date') is-invalid @enderror" value="{{ old('visit_date', $record->visit_date->format('Y-m-d')) }}" required>
                    @error('visit_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="form-control" value="{{ old('follow_up_date', $record->follow_up_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Symptoms</label>
                    <textarea name="symptoms" class="form-control @error('symptoms') is-invalid @enderror" rows="3">{{ old('symptoms', $record->symptoms) }}</textarea>
                    @error('symptoms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Diagnosis <span class="text-danger">*</span></label>
                    <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="3" required>{{ old('diagnosis', $record->diagnosis) }}</textarea>
                    @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Treatment Plan</label>
                    <textarea name="treatment" class="form-control" rows="3">{{ old('treatment', $record->treatment) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Blood Pressure</label>
                    <input type="text" name="blood_pressure" class="form-control" value="{{ old('blood_pressure', $record->blood_pressure) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Temperature</label>
                    <input type="text" name="temperature" class="form-control" value="{{ old('temperature', $record->temperature) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Weight</label>
                    <input type="text" name="weight" class="form-control" value="{{ old('weight', $record->weight) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Pulse Rate</label>
                    <input type="text" name="pulse_rate" class="form-control" value="{{ old('pulse_rate', $record->pulse_rate) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Additional Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $record->notes) }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Record</button>
                    <a href="{{ route('admin.medical-records.show', $record) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
