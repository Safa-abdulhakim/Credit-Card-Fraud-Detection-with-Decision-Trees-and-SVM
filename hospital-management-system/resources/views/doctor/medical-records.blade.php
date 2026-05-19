@extends('layouts.doctor')
@section('title', 'Medical Records')
@section('page-title', 'My Medical Records')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Patient</th><th>Diagnosis</th><th>Treatment</th><th>Date</th><th>Prescriptions</th></tr>
                </thead>
                <tbody>
                    @forelse($records as $rec)
                    <tr>
                        <td>{{ $records->firstItem() + $loop->index }}</td>
                        <td><div class="fw-semibold">{{ $rec->patient->name ?? 'N/A' }}</div><small class="text-muted">{{ $rec->patient->phone ?? '' }}</small></td>
                        <td>{{ Str::limit($rec->diagnosis, 60) }}</td>
                        <td>{{ Str::limit($rec->treatment, 60) }}</td>
                        <td>{{ $rec->record_date->format('M d, Y') }}</td>
                        <td><span class="badge bg-info">{{ $rec->prescriptions->count() }} medicines</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No medical records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($records->hasPages())
    <div class="card-footer">{{ $records->links() }}</div>
    @endif
</div>
@endsection
