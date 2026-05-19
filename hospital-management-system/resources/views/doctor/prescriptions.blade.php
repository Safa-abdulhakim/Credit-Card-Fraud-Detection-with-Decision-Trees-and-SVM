@extends('layouts.doctor')
@section('title', 'Prescriptions')
@section('page-title', 'Prescriptions I Wrote')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Patient</th><th>Medicine</th><th>Dosage</th><th>Frequency</th><th>Duration</th><th>Date</th></tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                    <tr>
                        <td>{{ $rx->patient->name ?? 'N/A' }}</td>
                        <td><strong>{{ $rx->medicine_name }}</strong></td>
                        <td>{{ $rx->dosage }}</td>
                        <td>{{ $rx->frequency }}</td>
                        <td>{{ $rx->duration_days }} days</td>
                        <td><small>{{ $rx->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No prescriptions found</td></tr>
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
