@extends('layouts.patient')
@section('title', 'My Prescriptions')
@section('page-title', 'My Prescriptions')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>#</th><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Doctor</th><th>Instructions</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                    <tr>
                        <td>{{ $prescriptions->firstItem() + $loop->index }}</td>
                        <td><strong class="text-primary">{{ $rx->medicine_name }}</strong></td>
                        <td>{{ $rx->dosage }}</td>
                        <td>{{ $rx->frequency }}</td>
                        <td><span class="badge bg-light text-dark">{{ $rx->duration_days }} days</span></td>
                        <td>{{ $rx->doctor->user->name ?? 'N/A' }}</td>
                        <td><small class="text-muted">{{ $rx->instructions ?? '-' }}</small></td>
                        <td><small>{{ $rx->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No prescriptions found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($prescriptions->hasPages())
    <div class="card-footer">{{ $prescriptions->links() }}</div>
    @endif
</div>
@endsection
