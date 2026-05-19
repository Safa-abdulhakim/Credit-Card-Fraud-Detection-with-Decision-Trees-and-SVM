@extends('layouts.doctor')
@section('title', 'My Appointments')
@section('page-title', 'My Appointments')
@section('content')
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i></button>
                <a href="{{ route('doctor.appointments') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Patient</th><th>Date</th><th>Time</th><th>Type</th><th>Symptoms</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $appt->patient->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $appt->patient->phone ?? '' }}</small>
                        </td>
                        <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                        <td>{{ $appt->appointment_time }}</td>
                        <td>{{ ucfirst($appt->type) }}</td>
                        <td><small>{{ $appt->symptoms ? Str::limit($appt->symptoms, 40) : '-' }}</small></td>
                        <td><span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if(in_array($appt->status, ['pending','approved']))
                                <a href="{{ route('doctor.appointments.record', $appt) }}" class="btn btn-outline-success" title="Add Medical Record"><i class="fas fa-file-medical"></i></a>
                                @endif
                                @if($appt->status == 'pending')
                                <form action="{{ route('doctor.appointments.status', $appt) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="btn btn-outline-primary" title="Approve"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                                @if(in_array($appt->status, ['pending','approved']))
                                <form action="{{ route('doctor.appointments.status', $appt) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn btn-outline-danger" title="Cancel" onclick="return confirm('Cancel appointment?')"><i class="fas fa-times"></i></button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No appointments found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer">{{ $appointments->links() }}</div>
    @endif
</div>
@endsection
