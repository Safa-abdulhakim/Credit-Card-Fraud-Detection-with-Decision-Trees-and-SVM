@extends('layouts.doctor')
@section('title', 'الوصفات الطبية')
@section('page-title', 'الوصفات التي كتبتها')
@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>المريض</th><th>الدواء</th><th>الجرعة</th><th>التكرار</th><th>المدة</th><th>التاريخ</th></tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                    <tr>
                        <td>{{ $rx->patient->name ?? 'N/A' }}</td>
                        <td><strong>{{ $rx->medicine_name }}</strong></td>
                        <td>{{ $rx->dosage }}</td>
                        <td>{{ $rx->frequency }}</td>
                        <td>{{ $rx->duration_days }} أيام</td>
                        <td><small>{{ $rx->created_at->format('M d, Y') }}</small></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">لا توجد وصفات</td></tr>
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
