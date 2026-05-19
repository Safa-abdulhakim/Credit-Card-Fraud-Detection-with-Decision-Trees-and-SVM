@extends('layouts.doctor')
@section('title', 'مرضاي')
@section('page-title', 'مرضاي')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>المريض</th><th>العمر/الجنس</th><th>الهاتف</th><th>فصيلة الدم</th></tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;font-size:0.8rem;font-weight:700;">
                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $patient->name }}</div>
                                    <small class="text-muted">{{ $patient->email ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $patient->age }} سنة / {{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ $patient->blood_group ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">لا يوجد مرضى بعد</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($patients->hasPages())
    <div class="card-footer">{{ $patients->links() }}</div>
    @endif
</div>
@endsection
