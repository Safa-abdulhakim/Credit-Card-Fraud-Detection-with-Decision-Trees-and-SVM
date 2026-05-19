@extends('layouts.admin')
@section('title', 'Add Doctor')
@section('page-title', 'Add New Doctor')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Doctors</a></li>
    <li class="breadcrumb-item active">Add</li>
@endsection
@section('content')
<div class="card">
    <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-md me-2 text-info"></i>Doctor Information</h6></div>
    <div class="card-body">
        <form action="{{ route('admin.doctors.store') }}" method="POST">
            @csrf
            <h6 class="fw-semibold mb-3 text-muted">Account Details</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <h6 class="fw-semibold mb-3 text-muted">Professional Details</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Specialization <span class="text-danger">*</span></label>
                    <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization') }}" placeholder="e.g., Cardiology, Orthopedics" required>
                    @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Department</label>
                    <select name="department_id" class="form-select @error('department_id') is-invalid @enderror">
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Years of Experience</label>
                    <input type="number" name="experience_years" class="form-control @error('experience_years') is-invalid @enderror" value="{{ old('experience_years', 0) }}" min="0" max="60">
                    @error('experience_years')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Consultation Fee ($) <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror" value="{{ old('consultation_fee', 0) }}" min="0" required>
                    @error('consultation_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Qualifications</label>
                    <textarea name="qualifications" class="form-control @error('qualifications') is-invalid @enderror" rows="2" placeholder="MBBS, MD, FRCS, etc.">{{ old('qualifications') }}</textarea>
                    @error('qualifications')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Bio / About</label>
                    <textarea name="bio" class="form-control" rows="3" placeholder="Brief introduction...">{{ old('bio') }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" class="form-check-input" id="is_available" value="1" checked>
                        <label class="form-check-label" for="is_available">Available for Appointments</label>
                    </div>
                </div>
                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Doctor</button>
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
