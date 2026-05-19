@extends('layouts.admin')
@section('title', 'Patients')
@section('page-title', 'Patients')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Patients</li>
@endsection
@section('page-actions')
    <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add Patient
    </a>
@endsection
@section('content')
<!-- Search/Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name, phone, email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select form-select-sm">
                    <option value="">All Genders</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="blood_group" class="form-select form-select-sm">
                    <option value="">All Blood Groups</option>
                    @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                        <option value="{{ $bg }}" {{ request('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm me-1"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Patient</th>
                        <th>Age / Gender</th>
                        <th>Phone</th>
                        <th>Blood Group</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patients->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} bg-opacity-10 text-{{ $patient->gender == 'male' ? 'primary' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $patient->name }}</div>
                                    <small class="text-muted">{{ $patient->email ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $patient->age }} yrs / {{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            @if($patient->blood_group)
                                <span class="badge bg-danger bg-opacity-10 text-danger">{{ $patient->blood_group }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td><small>{{ $patient->created_at->format('M d, Y') }}</small></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-outline-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this patient? This action cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="fas fa-procedures fa-2x mb-2 d-block opacity-25"></i>
                            No patients found.
                            <a href="{{ route('admin.patients.create') }}">Add the first patient</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($patients->hasPages())
    <div class="card-footer">
        {{ $patients->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
