@extends('layouts.admin')
@section('title', 'Appointments')
@section('page-title', 'Appointments')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Appointments</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Book Appointment
    </a>
@endsection
@section('content')
<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search patient or doctor..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" placeholder="Filter by date">
            </div>
            <div class="col-md-2">
                <select name="doctor_id" class="form-select form-select-sm">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->user->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> Filter</button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Status Summary -->
<div class="row g-2 mb-3">
    @php
        $statusColors = ['pending' => 'warning', 'approved' => 'info', 'completed' => 'success', 'cancelled' => 'danger'];
    @endphp
    @foreach(['pending', 'approved', 'completed', 'cancelled'] as $status)
    <div class="col-6 col-md-3">
        <div class="card text-center py-2">
            <div class="card-body p-2">
                <div class="fw-bold fs-5 text-{{ $statusColors[$status] }}">
                    {{ $statusCounts[$status] ?? 0 }}
                </div>
                <small class="text-muted text-capitalize">{{ $status }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td>{{ $appointments->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold">{{ $appt->patient->name }}</div>
                            <small class="text-muted">{{ $appt->patient->phone }}</small>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $appt->doctor->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $appt->doctor->specialization ?? '' }}</small>
                        </td>
                        <td><small>{{ $appt->doctor->department->name ?? '-' }}</small></td>
                        <td>
                            <div class="fw-semibold small">{{ $appt->appointment_date->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $appt->appointment_time }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusColors[$appt->status] ?? 'secondary' }}">
                                {{ ucfirst($appt->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.appointments.show', $appt) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.appointments.edit', $appt) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.appointments.destroy', $appt) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this appointment?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-calendar-times fa-2x mb-2 d-block opacity-25"></i>
                            No appointments found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($appointments->hasPages())
    <div class="card-footer">{{ $appointments->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
