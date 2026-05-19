@extends('layouts.admin')

@section('title', 'Dashboard - HMS')
@section('page-title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Total Patients</p>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['total_patients']) }}</h3>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>Active Records</small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-procedures"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Total Doctors</p>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['total_doctors']) }}</h3>
                        <small class="text-info"><i class="fas fa-stethoscope me-1"></i>Medical Staff</small>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Today's Appointments</p>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['today_appointments']) }}</h3>
                        <small class="text-warning"><i class="fas fa-clock me-1"></i>{{ $stats['pending_appointments'] }} Pending</small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted small mb-1">Monthly Revenue</p>
                        <h3 class="fw-bold mb-0">${{ number_format($stats['monthly_revenue'], 2) }}</h3>
                        <small class="text-success"><i class="fas fa-dollar-sign me-1"></i>Total: ${{ number_format($stats['total_revenue'], 2) }}</small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Appointments Overview (Last 6 Months)</h6>
                <span class="badge bg-primary">Monthly</span>
            </div>
            <div class="card-body">
                <canvas id="appointmentsChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold">Appointment Status</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="statusChart" height="200"></canvas>
                <div class="mt-3 w-100">
                    @foreach($appointmentsByStatus as $status => $count)
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="badge bg-{{ match($status) { 'pending' => 'warning', 'approved' => 'info', 'completed' => 'success', 'cancelled' => 'danger', default => 'secondary' } }}">{{ ucfirst($status) }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Revenue Overview (Last 6 Months)</h6>
                <a href="{{ route('admin.reports.revenue') }}" class="btn btn-sm btn-outline-primary">View Report</a>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="70"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="row g-3">
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Recent Appointments</h6>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appt)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px;font-size:0.75rem;font-weight:700;">
                                            {{ strtoupper(substr($appt->patient->name, 0, 2)) }}
                                        </div>
                                        {{ $appt->patient->name }}
                                    </div>
                                </td>
                                <td>{{ $appt->doctor->user->name ?? 'N/A' }}</td>
                                <td>
                                    <small class="text-muted">{{ $appt->appointment_date->format('M d, Y') }}</small>
                                    <br><small class="text-muted">{{ $appt->appointment_time }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $appt->status_badge }}">{{ ucfirst($appt->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">No appointments yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">Recent Patients</h6>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($recentPatients as $patient)
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:42px;height:42px;font-size:0.85rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($patient->name, 0, 2)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold small">{{ $patient->name }}</div>
                        <div class="text-muted" style="font-size:0.78rem;">
                            {{ ucfirst($patient->gender) }} · Age {{ $patient->age }}
                            @if($patient->blood_group)
                                · {{ $patient->blood_group }}
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
                @empty
                    <p class="text-muted text-center">No patients yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const labels = @json($monthlyLabels);
const appointmentsData = @json($monthlyAppointments);
const revenueData = @json($monthlyRevenue);
const statusData = @json($appointmentsByStatus);

// Appointments Chart
new Chart(document.getElementById('appointmentsChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Appointments',
            data: appointmentsData,
            backgroundColor: 'rgba(44, 123, 229, 0.7)',
            borderColor: '#2c7be5',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});

// Status Pie Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        datasets: [{
            data: Object.values(statusData),
            backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a', '#e74a3b'],
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        cutout: '60%',
    }
});

// Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Revenue ($)',
            data: revenueData,
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
