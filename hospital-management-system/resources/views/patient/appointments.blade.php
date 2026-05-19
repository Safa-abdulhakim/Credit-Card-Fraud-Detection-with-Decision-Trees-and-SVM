@extends('layouts.patient')
@section('title', 'My Appointments')
@section('page-title', 'My Appointments')
@section('page-actions')
    <a href="{{ route('patient.appointments.book') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Book New</a>
@endsection
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
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i></button>
                <a href="{{ route('patient.appointments') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Doctor</th><th>Specialization</th><th>Date</th><th>Time</th><th>Type</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td><div class="fw-semibold">{{ $appt->doctor->user->name ?? 'N/A' }}</div></td>
                        <td><small class="text-muted">{{ $appt->doctor->specialization ?? '' }}</small></td>
                        <td>{{ $appt->appointment_date->format('M d, Y') }}</td>
                        <td>{{ $appt->appointment_time }}</td>
                        <td><span class="badge bg-light text-dark">{{ ucfirst($appt->type) }}</span></td>
                        <td><span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No appointments yet. <a href="{{ route('patient.appointments.book') }}">Book one now!</a></td></tr>
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
