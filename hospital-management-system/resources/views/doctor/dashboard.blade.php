@extends('layouts.doctor')
@section('title', 'Doctor Dashboard')
@section('page-title', 'Doctor Dashboard')
@section('content')
<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Today's Appointments</p>
                        <h3 class="fw-bold mb-0">{{ $stats['today_appointments'] }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.2rem;">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Total Patients</p>
                        <h3 class="fw-bold mb-0">{{ $stats['total_patients'] }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.2rem;">
                        <i class="fas fa-procedures"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Pending</p>
                        <h3 class="fw-bold mb-0">{{ $stats['pending_appointments'] }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.2rem;">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Completed Today</p>
                        <h3 class="fw-bold mb-0">{{ $stats['completed_today'] }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;font-size:1.2rem;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Today's Appointments -->
    <div class="col-12 col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Today's Schedule</h6>
                <a href="{{ route('doctor.appointments') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Time</th><th>Patient</th><th>Type</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @forelse($todayAppointments as $appt)
                            <tr>
                                <td>{{ $appt->appointment_time }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $appt->patient->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $appt->symptoms ? Str::limit($appt->symptoms, 30) : 'No symptoms' }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark">{{ ucfirst($appt->type) }}</span></td>
                                <td><span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span></td>
                                <td>
                                    @if(in_array($appt->status, ['pending','approved']))
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('doctor.appointments.record', $appt) }}" class="btn btn-outline-success btn-sm" title="Add Record"><i class="fas fa-file-medical"></i></a>
                                        <form action="{{ route('doctor.appointments.status', $appt) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            @if($appt->status == 'pending')
                                            <button class="btn btn-outline-primary btn-sm" title="Approve"><i class="fas fa-check"></i></button>
                                            @endif
                                        </form>
                                    </div>
                                    @else
                                        <span class="text-muted small">{{ ucfirst($appt->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No appointments today</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Upcoming -->
    <div class="col-12 col-lg-5">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold">Upcoming Appointments</h6>
            </div>
            <div class="card-body">
                @forelse($upcomingAppointments as $appt)
                <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($appt->patient->name ?? 'P', 0, 2)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $appt->patient->name ?? 'N/A' }}</div>
                        <small class="text-muted">{{ $appt->appointment_date->format('M d') }} at {{ $appt->appointment_time }}</small>
                    </div>
                    <span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span>
                </div>
                @empty
                <p class="text-muted text-center py-3">No upcoming appointments</p>
                @endforelse
            </div>
        </div>
        <!-- Doctor Info Card -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">My Profile</h6>
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;font-size:1.1rem;font-weight:700;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">{{ $doctor->specialization }} · {{ $doctor->department->name ?? 'N/A' }}</small>
                        <div><small class="text-muted">{{ $doctor->experience_years }} years experience</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
