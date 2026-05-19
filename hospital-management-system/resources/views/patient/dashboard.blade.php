@extends('layouts.patient')
@section('title', 'Patient Dashboard')
@section('page-title', 'My Health Dashboard')
@section('content')
<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted small mb-1">Total Appointments</p>
                <h3 class="fw-bold mb-0">{{ $stats['total_appointments'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted small mb-1">Upcoming</p>
                <h3 class="fw-bold mb-0 text-primary">{{ $stats['upcoming_appointments'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted small mb-1">Prescriptions</p>
                <h3 class="fw-bold mb-0 text-info">{{ $stats['total_prescriptions'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <p class="text-muted small mb-1">Pending Invoices</p>
                <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending_invoices'] }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Patient Profile -->
<div class="row g-3">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:80px;height:80px;font-size:1.8rem;font-weight:700;">
                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                </div>
                <h5 class="fw-bold">{{ $patient->name }}</h5>
                <p class="text-muted">{{ ucfirst($patient->gender) }} &middot; Age {{ $patient->age }}</p>
                @if($patient->blood_group)
                <span class="badge bg-danger mb-2">Blood: {{ $patient->blood_group }}</span>
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <div class="small text-muted mb-1"><i class="fas fa-phone me-2"></i>{{ $patient->phone }}</div>
                @if($patient->email)<div class="small text-muted mb-1"><i class="fas fa-envelope me-2"></i>{{ $patient->email }}</div>@endif
                @if($patient->address)<div class="small text-muted"><i class="fas fa-map-marker-alt me-2"></i>{{ $patient->address }}</div>@endif
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('patient.appointments.book') }}" class="btn btn-primary w-100 mb-2"><i class="fas fa-calendar-plus me-2"></i>Book New Appointment</a>
        </div>
    </div>
    <div class="col-12 col-lg-8">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Recent Appointments</h6>
                <a href="{{ route('patient.appointments') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Doctor</th><th>Date</th><th>Type</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appt)
                            <tr>
                                <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                                <td>{{ ucfirst($appt->type) }}</td>
                                <td><span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No appointments yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0">Recent Prescriptions</h6>
                <a href="{{ route('patient.prescriptions') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentPrescriptions as $rx)
                            <tr>
                                <td><strong>{{ $rx->medicine_name }}</strong></td>
                                <td>{{ $rx->dosage }}</td>
                                <td>{{ $rx->frequency }}</td>
                                <td>{{ $rx->duration_days }} days</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No prescriptions yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
