@extends('layouts.admin')
@section('title', 'Doctor Profile')
@section('page-title', $doctor->user->name ?? 'Doctor Profile')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.doctors.index') }}">Doctors</a></li>
    <li class="breadcrumb-item active">Profile</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary"><i class="fas fa-edit me-2"></i>Edit Doctor</a>
@endsection
@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                @if($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" alt="Doctor Photo">
                @else
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:100px;height:100px;font-size:2.2rem;font-weight:700;">
                        {{ strtoupper(substr($doctor->user->name ?? 'D', 0, 2)) }}
                    </div>
                @endif
                <h5 class="fw-bold mb-1">{{ $doctor->user->name ?? 'N/A' }}</h5>
                <p class="text-primary mb-1">{{ $doctor->specialization }}</p>
                <p class="text-muted small mb-2">{{ $doctor->department->name ?? 'N/A' }}</p>
                <span class="badge bg-{{ $doctor->is_available ? 'success' : 'secondary' }} mb-2">
                    {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                </span>
            </div>
            <div class="card-footer bg-transparent">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fw-bold">{{ $doctor->experience_years }}</div>
                        <small class="text-muted">Yrs Exp.</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold">{{ $doctor->appointments->count() }}</div>
                        <small class="text-muted">Appts.</small>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold">${{ number_format($doctor->consultation_fee) }}</div>
                        <small class="text-muted">Fee</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">Contact Information</h6>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-envelope text-muted" style="width:16px;"></i>
                    <span>{{ $doctor->user->email ?? '-' }}</span>
                </div>
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-phone text-muted" style="width:16px;"></i>
                    <span>{{ $doctor->phone ?? '-' }}</span>
                </div>
                @if($doctor->license_number)
                <div class="mb-2 d-flex align-items-center gap-2">
                    <i class="fas fa-id-card text-muted" style="width:16px;"></i>
                    <span>{{ $doctor->license_number }}</span>
                </div>
                @endif
            </div>
        </div>

        @if($doctor->qualifications)
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Qualifications</h6>
                <p class="text-muted mb-0 small">{{ $doctor->qualifications }}</p>
            </div>
        </div>
        @endif

        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-primary flex-grow-1"><i class="fas fa-edit me-2"></i>Edit</a>
            <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        @if($doctor->bio)
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">About</h6></div>
            <div class="card-body text-muted">{{ $doctor->bio }}</div>
        </div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Recent Appointments</h6>
                <a href="{{ route('admin.appointments.index') }}?doctor={{ $doctor->id }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($doctor->appointments->take(10) as $appt)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $appt->patient->name ?? 'N/A' }}</div>
                                </td>
                                <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                                <td><small>{{ $appt->appointment_time }}</small></td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($appt->type ?? 'consultation') }}</span></td>
                                <td>
                                    @php
                                        $badgeMap = ['pending' => 'warning', 'approved' => 'info', 'completed' => 'success', 'cancelled' => 'danger'];
                                        $badge = $badgeMap[$appt->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst($appt->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2 d-block opacity-25"></i>
                                    No appointments yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
