@extends('layouts.admin')
@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.appointments.index') }}">Appointments</a></li>
    <li class="breadcrumb-item active">#{{ $appointment->id }}</li>
@endsection
@section('page-actions')
    <div class="d-flex gap-2">
        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('Delete this appointment?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Delete</button>
        </form>
    </div>
@endsection
@section('content')
@php
    $statusColors = ['pending' => 'warning', 'approved' => 'info', 'completed' => 'success', 'cancelled' => 'danger'];
@endphp
<div class="row g-3">
    <!-- Main Info -->
    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Appointment Information</h6>
                <span class="badge bg-{{ $statusColors[$appointment->status] ?? 'secondary' }} px-3 py-2">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Date</div>
                        <div class="fw-semibold"><i class="fas fa-calendar text-primary me-2"></i>{{ $appointment->appointment_date->format('l, F d, Y') }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Time</div>
                        <div class="fw-semibold"><i class="fas fa-clock text-primary me-2"></i>{{ $appointment->appointment_time }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Type</div>
                        <div class="fw-semibold">{{ ucfirst($appointment->type ?? 'Consultation') }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Booked On</div>
                        <div class="fw-semibold">{{ $appointment->created_at->format('M d, Y H:i') }}</div>
                    </div>
                    @if($appointment->reason)
                    <div class="col-12">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Reason / Chief Complaint</div>
                        <div class="p-3 bg-light rounded">{{ $appointment->reason }}</div>
                    </div>
                    @endif
                    @if($appointment->notes)
                    <div class="col-12">
                        <div class="text-muted small text-uppercase fw-semibold mb-1">Notes</div>
                        <div class="p-3 bg-light rounded text-muted">{{ $appointment->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold">Update Status</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.appointments.update', $appointment) }}" method="POST" class="d-flex gap-2 align-items-center flex-wrap">
                    @csrf @method('PUT')
                    <input type="hidden" name="patient_id" value="{{ $appointment->patient_id }}">
                    <input type="hidden" name="doctor_id" value="{{ $appointment->doctor_id }}">
                    <input type="hidden" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}">
                    <input type="hidden" name="appointment_time" value="{{ $appointment->appointment_time }}">
                    <select name="status" class="form-select form-select-sm w-auto">
                        @foreach(['pending', 'approved', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" {{ $appointment->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <!-- Patient Card -->
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user me-2 text-primary"></i>Patient</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;font-size:1.1rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($appointment->patient->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $appointment->patient->name }}</div>
                        <div class="small text-muted">{{ ucfirst($appointment->patient->gender) }}, {{ $appointment->patient->age }} yrs</div>
                        @if($appointment->patient->blood_group)
                            <span class="badge bg-danger bg-opacity-10 text-danger small">{{ $appointment->patient->blood_group }}</span>
                        @endif
                    </div>
                </div>
                <div class="small">
                    <div class="mb-1"><i class="fas fa-phone text-muted me-2"></i>{{ $appointment->patient->phone }}</div>
                    @if($appointment->patient->email)
                    <div><i class="fas fa-envelope text-muted me-2"></i>{{ $appointment->patient->email }}</div>
                    @endif
                </div>
                <a href="{{ route('admin.patients.show', $appointment->patient) }}" class="btn btn-sm btn-outline-primary mt-3 w-100">
                    View Patient Profile
                </a>
            </div>
        </div>

        <!-- Doctor Card -->
        <div class="card">
            <div class="card-header"><h6 class="mb-0 fw-semibold"><i class="fas fa-user-md me-2 text-info"></i>Doctor</h6></div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;font-size:1.1rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($appointment->doctor->user->name ?? 'DR', 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-bold">{{ $appointment->doctor->user->name ?? 'N/A' }}</div>
                        <div class="small text-primary">{{ $appointment->doctor->specialization }}</div>
                        @if($appointment->doctor->department)
                            <div class="small text-muted">{{ $appointment->doctor->department->name }}</div>
                        @endif
                    </div>
                </div>
                <div class="small">
                    <div class="mb-1"><i class="fas fa-dollar-sign text-muted me-2"></i>Fee: ${{ number_format($appointment->doctor->consultation_fee, 2) }}</div>
                    <div><i class="fas fa-phone text-muted me-2"></i>{{ $appointment->doctor->phone ?? 'N/A' }}</div>
                </div>
                <a href="{{ route('admin.doctors.show', $appointment->doctor) }}" class="btn btn-sm btn-outline-info mt-3 w-100">
                    View Doctor Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
