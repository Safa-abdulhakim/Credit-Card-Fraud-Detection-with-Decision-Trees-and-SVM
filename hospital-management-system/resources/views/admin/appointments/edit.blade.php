@extends('layouts.admin')
@section('title', 'Edit Appointment')
@section('page-title', 'Edit Appointment')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold"><i class="fas fa-calendar-edit me-2 text-primary"></i>Edit Appointment</h6>
        <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Patient <span class="text-danger">*</span></label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }} ({{ $patient->phone }})
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
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name ?? 'N/A' }} - {{ $doctor->specialization }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Appointment Date <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}" required>
                    @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Appointment Time <span class="text-danger">*</span></label>
                    <input type="time" name="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" value="{{ old('appointment_time', $appointment->appointment_time) }}" required>
                    @error('appointment_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $appointment->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Type</label>
                    <select name="type" class="form-select">
                        <option value="consultation" {{ old('type', $appointment->type) == 'consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="follow-up" {{ old('type', $appointment->type) == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                        <option value="emergency" {{ old('type', $appointment->type) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        <option value="routine" {{ old('type', $appointment->type) == 'routine' ? 'selected' : '' }}>Routine Checkup</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Reason / Chief Complaint</label>
                    <textarea name="reason" class="form-control" rows="3">{{ old('reason', $appointment->reason) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $appointment->notes) }}</textarea>
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Appointment</button>
                    <a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
